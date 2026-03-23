<?php
require_once ("./funciones/funciones.php");
require_once ("./funciones/fbd.php");


function iniciarCarrito()
{
    if (!isset($_SESSION['carrito'])) {

        if (isset($_COOKIE['usuariopedidos'])) {
            $cookieCarrito = 'carrito' . $_COOKIE['usuariopedidos'];

            if (isset($_COOKIE[$cookieCarrito])) {
                $_SESSION['carrito'] = unserialize($_COOKIE[$cookieCarrito]);
                return;
            }
        }

        $_SESSION['carrito'] = [];
    }
}


function cerrarSesion($cookie_name){
    if (isset($_SESSION['carrito'])) {
        $carrito = $_SESSION['carrito'];
    } else {
        $carrito = [];
    }

    // Nombre de la cookie del carrito
    if (isset($_COOKIE[$cookie_name])) {
        $carritoCookieName = 'carrito' . $_COOKIE[$cookie_name];

        // Guardar carrito antes de cerrar sesión
        setcookie(
            $carritoCookieName,
            serialize($carrito),
            time() + (86400 * 30),
            "/"
        );
    }

    // Destruir sesión
    if (isset($_COOKIE['PHPSESSID'])) {
        session_destroy();
        setcookie("PHPSESSID", "", time() - 3600, "/");
    }

    // Eliminar cookie del usuario
    setcookie($cookie_name, "", time() - 3600, "/");

    header("Location: ./pe_login.php");
    exit();
}



function agregarProducto($id, $cantidad) {

    $cantidad = (int) $cantidad;

    if ($cantidad <= 0) {
        echo '<span style="color:red;">Introduce un número</span>';
        return;
    }

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    if (isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id] += $cantidad;
    } else {
        $_SESSION['carrito'][$id] = $cantidad;
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

function eliminarProducto($id, $cantidad) {
    $cantidad = (int) $cantidad;

    if ($cantidad <= 0) {
        echo '<span style="color:red;">Introduce un número válido</span>';
        return;
    }

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    if (isset($_SESSION['carrito'][$id])) {
        // Restamos la cantidad
        $_SESSION['carrito'][$id] -= $cantidad;

        // Si llega a 0 o menos, eliminamos el producto
        if ($_SESSION['carrito'][$id] <= 0) {
            unset($_SESSION['carrito'][$id]);
        }
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


function comprobarCarrito($conn){
    $flag = true;
    foreach ($_SESSION['carrito'] as $producto => $cantidad){
        $cotejar =  selectCol("SELECT QUANTITYINSTOCK FROM PRODUCTS WHERE PRODUCTCODE = '$producto'", $conn);
        if ($cantidad > $cotejar){
            $nombre = selectCol("SELECT PRODUCTNAME FROM PRODUCTS WHERE PRODUCTCODE = '$producto'", $conn);
            echo ("La cantidad seleccionada del articulo $nombre no existe");
            $flag = false;
        }
    }
    return $flag;
}


function realizarCompra($conn, $pago){
    $fecha = date("Y-m-d H:i:s");
    $numero = selectCol("SELECT ORDERNUMBER FROM ORDERS ORDER BY ORDERNUMBER DESC LIMIT 1", $conn);
    $numero += 1;
    $status = "Unshipped";
    $total = 0;
    $orderlinenumber = 1;
    
    try{
        $conn->beginTransaction();
        $stmt = $conn->prepare("INSERT INTO ORDERS(ORDERNUMBER, ORDERDATE, REQUIREDDATE, SHIPPEDDATE, `STATUS`, COMMENTS, CUSTOMERNUMBER) VALUES (:ORDERNUMBER,:ORDERDATE,:REQUIREDDATE,NULL,:STATUS,NULL,:CUSTOMERNUMBER)");
        $stmt->bindParam(':ORDERNUMBER', $numero);
        $stmt->bindParam(':ORDERDATE', $fecha);
        $stmt->bindParam(':REQUIREDDATE', $fecha);
        $stmt->bindParam(':STATUS', $status);
        $stmt->bindParam(':CUSTOMERNUMBER', $_COOKIE['usuariopedidos']);
        $stmt->execute();
    
    
    foreach ($_SESSION['carrito'] as $producto => $cantidad){
        $precio = selectCOL("SELECT BUYPRICE FROM PRODUCTS WHERE PRODUCTCODE = '$producto'",$conn);
        $precioTotal = $precio * $cantidad;
        $total += $precioTotal;

            $stmt = $conn->prepare("UPDATE PRODUCTS SET QUANTITYINSTOCK = QUANTITYINSTOCK - :cantidad WHERE PRODUCTCODE = :producto");
            $stmt->bindParam(':producto', $producto);
            $stmt->bindParam(':cantidad', $cantidad);
            $stmt->execute();
       

            $stmt = $conn->prepare("INSERT INTO ORDERDETAILS(ORDERNUMBER, PRODUCTCODE, QUANTITYORDERED, PRICEEACH, ORDERLINENUMBER) VALUES (:ORDERNUMBER,:PRODUCTCODE,:QUANTITYORDERED,:PRICEEACH, :ORDERLINENUMBER)");
            $stmt->bindParam(':ORDERNUMBER', $numero);
            $stmt->bindParam(':PRODUCTCODE', $producto);
            $stmt->bindParam(':QUANTITYORDERED', $cantidad);
            $stmt->bindParam(':PRICEEACH', $precio);
            $stmt->bindParam(':ORDERLINENUMBER', $orderlinenumber);
            $stmt->execute();
            $orderlinenumber +=1;
    }

        $stmt = $conn->prepare("INSERT INTO PAYMENTS(CUSTOMERNUMBER, CHECKNUMBER, PAYMENTDATE, AMOUNT) VALUES (:CUSTOMERNUMBER,:CHECKNUMBER,:PAYMENTDATE,:AMOUNT)");
        $stmt->bindParam(':CUSTOMERNUMBER', $_COOKIE['usuariopedidos']);
        $stmt->bindParam(':CHECKNUMBER', $pago);
        $stmt->bindParam(':PAYMENTDATE', $fecha);
        $stmt->bindParam(':AMOUNT', $total);
        $stmt->execute();
        $conn->commit(); 
        if (isset($_COOKIE['carrito' . $_COOKIE['usuariopedidos']])) {
               setcookie('carrito' . $_COOKIE['usuariopedidos'], "", time() - 3600, "/");
            }
    }
    catch(PDOException $e){
        if ($conn && $conn->inTransaction()) {
            $conn->rollback();
        }
        echo "Connection failed: " . $e->getMessage();
        echo "C贸digo de error: " . $e->getCode() . "<br>";
    }
}

function createUser(PDO $conn, string $nombre, string $email, string $password, int $tipo): array {
    // 1️⃣ Calcular ID y tabla
    $id = getNextUserId($conn);
    $tabla = generateUserTableName($id);

    // 2️⃣ Hashear contraseña
    $passHash = password_hash($password, PASSWORD_DEFAULT);

    // 3️⃣ Insertar en USUARIOS
    $sql = "INSERT INTO USUARIOS (ID, email, NOMBRE, CONTRASENA, TIPO, TABLA) 
            VALUES (:id, :email, :nombre, :contrasena, :tipo, :tabla)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':id' => $id,
        ':email' => $email,
        ':nombre' => $nombre,
        ':contrasena' => $passHash,
        ':tipo' => $tipo,
        ':tabla' => $tabla
    ]);

    // 4️⃣ Crear tabla propia del usuario
    $sqlTabla = "CREATE TABLE `$tabla` (
        id INT AUTO_INCREMENT PRIMARY KEY,

        na_100 DECIMAL(10,2),
        ca_100 DECIMAL(10,2),
        k_100 DECIMAL(10,2),

        energia_kcal DECIMAL(10,2),
        proteinas_g DECIMAL(10,2),
        grasas_g DECIMAL(10,2),

        ags_g DECIMAL(10,2),
        agm_g DECIMAL(10,2),
        agp_g DECIMAL(10,2),

        colesterol_mg DECIMAL(10,2),
        hc_g DECIMAL(10,2),
        fibra_g DECIMAL(10,2),

        vit_c_mg DECIMAL(10,2),
        vit_b6_mg DECIMAL(10,2),
        vit_e_mg DECIMAL(10,2),

        hierro_mg DECIMAL(10,2),
        sodio_mg DECIMAL(10,2),
        calcio_mg DECIMAL(10,2),
        potasio_mg DECIMAL(10,2),

        porcentaje_energia_total DECIMAL(5,2)
    )";
    $conn->exec($sqlTabla);

    return ['id' => $id, 'tabla' => $tabla];
}
function generateUserTableName(int $userId): string {
    return "t-" . $userId;
}
function getNextUserId(PDO $conn): int {
    $stmt = $conn->query("SELECT MAX(ID) AS max_id FROM USUARIOS");
    $maxId = $stmt->fetch(PDO::FETCH_ASSOC)['max_id'];
    return $maxId ? $maxId + 1 : 1;
}
?>
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

function createUser(PDO $conn,  $nombre, string $email, string $password, int $tipo): array {
    // 1️⃣ Calcular ID y tabla
    $id = getNextUserId($conn);
    $tabla = generateUserTableName($id);

    $passHash = $password;

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
        alimento VARCHAR(25),
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
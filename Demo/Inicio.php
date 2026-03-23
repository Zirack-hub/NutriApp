<?php
    require_once ("./funciones/funciones.php");
    require_once ("./funciones/fbd.php");
    require_once ("./funciones/fcompras.php");
    $conn = openBD();

    $cookie_name = "usuariopedidos";

    if ($_SERVER["REQUEST_METHOD"] == "POST"
    && isset($_POST["submit"])
    && $_POST["submit"] == "Cerrar Sesión") {

    cerrarSesion($cookie_name);
}
 if(!isset($_COOKIE['usuarioNutricion'])) {
        
     if ($_SERVER["REQUEST_METHOD"] == "POST") {
         $eleccion = limpiar_campos($_POST["submit"]);
         if ($eleccion == "Iniciar Sesión") {
             $usuario = limpiar_campos($_POST["usuario"]);
            $clave = limpiar_campos($_POST["clave"]);
            
            $registro = selectCOL("SELECT CUSTOMERNUMBER FROM CUSTOMERS WHERE CONTACTLASTNAME = '$clave' AND CUSTOMERNUMBER = '$usuario'",$conn);
            
            if ($registro != null) {
                $name = selectCol("SELECT CUSTOMERNAME FROM CUSTOMERS WHERE CUSTOMERNUMBER = '$usuario'",$conn);
                setcookie($cookie_name, $registro, time() + (86400 * 30), "/");
                echo "Has iniciado sesión como $name <br>";
                echo "COMPRAS: <br>";
                echo "<a href='./pe_altaped.php'> Ver compras</a><br>";
                echo "HISTORIAL: <br>";
                echo "<a href='./pe_consped.php'> Ver historial</a><br>";
                echo "STOCK: <br>";
                echo "<a href='./pe_consprodstock.php'> Ver historial</a><br>";
                echo "STOCK LINEAS PRODUCCION: <br>";
                echo "<a href='./pe_constock.php'> Ver historial</a><br>";
                echo "BUSQUEDA POR FECHAS: <br>";
                echo "<a href='./pe_todprod.php'> Ver historial</a><br>";
                echo "BUSQUEDA POR CLIENTES: <br>";
                echo "<a href='./pe_todprod.php'> Ver historial</a><br>";
                
                echo '
                <form name="alta" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post">
                <br><br>
                <input type="submit" name="submit" value="Cerrar Sesión">
                </form>';
                
                
            }
            else {
                echo "El usuario y la contraseña no coinciden<br>";
                echo "<a href='./pe_login.php'> Volver login</a><br>";
            }
        }
        elseif ($eleccion == "Cerrar Sesión") {
            cerrarSesion($cookie_name);
        }
     }
    }else{
        $id = (int)$_COOKIE['usuariopedidos'];
        $name = selectCol("SELECT CUSTOMERNAME FROM CUSTOMERS WHERE CUSTOMERNUMBER =$id",$conn);
                echo "Has iniciado sesión como $name <br>";
                echo "COMPRAS: <br>";
                echo "<a href='./pe_altaped.php'> Ver compras</a><br>";
                echo "HISTORIAL: <br>";
                echo "<a href='./pe_consped.php'> Ver historial</a><br>";
                echo "STOCK: <br>";
                echo "<a href='./pe_consprodstock.php'> Ver historial</a><br>";
                echo "STOCK LINEAS PRODUCCION: <br>";
                echo "<a href='./pe_constock.php'> Ver historial</a><br>";
                echo "BUSQUEDA POR FECHAS: <br>";
                echo "<a href='./pe_todprod.php'> Ver historial</a><br>";
                echo "BUSQUEDA POR CLIENTES: <br>";
                echo "<a href='./pe_todprod.php'> Ver historial</a><br>";
                
                echo '
                <form name="alta" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post">
                <br><br>
                <input type="submit" name="submit" value="Cerrar Sesión">
                </form>';
    }
    ?>
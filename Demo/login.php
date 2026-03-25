<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login cliente</title>
</head>
<body>
    <h1>LOGIN</h1>
		<div class="card-body">
		<form name="alta" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <?php
                $cookie_name = "usuarioNutricion";
                require_once("./funciones/funciones.php");
                require_once("./funciones/fbd.php");
                require_once("./funciones/fcompras.php");

                $conn = openBD("nutriapp");

                if(!isset($_COOKIE[$cookie_name])) {
                ?>
                    Usuario: <input type="text" name="usuario">
                    Contraseña: <input type="text" name="clave">
                    <input type="submit" name="submit" value="Iniciar Sesión">
                <?php
                } 
                else {
                    header("Location: ./inicio");
                }
            ?>
        </form>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = limpiar_campos($_POST["usuario"]);
        $clave = limpiar_campos($_POST["clave"]);

        $registro = selectCOL("SELECT EMAIL FROM USUARIOS WHERE CONTRASENA = '$clave' AND EMAIL = '$usuario'",$conn);
            
        if ($registro != null) {
            setcookie($cookie_name, $registro, time() + (86400 * 30), "/");
            header("Location: ./inicio");
        }
        else {
            echo "El usuario y la contraseña no coinciden";
        }
}
?>
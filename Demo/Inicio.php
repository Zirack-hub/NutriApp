<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inicio</title>
</head>
<body>
    <h1>Inicio</h1>
		<div class="card-body">
		<form name="alta" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <?php
                $cookie_name = "usuarioNutricion";
                require_once ("./funciones/funciones.php");
                require_once ("./funciones/fbd.php");
                require_once ("./funciones/fcompras.php");

                $conn = openBD("nutriapp");

                if(!isset($_COOKIE[$cookie_name])) {
                    header("Location: ./login");
                } 
                else {
                    $name = selectCol("SELECT NOMBRE FROM USUARIOS WHERE EMAIL = '$_COOKIE[$cookie_name]'",$conn);
                    $tipo = selectCol("SELECT TIPO FROM USUARIOS WHERE EMAIL = '$_COOKIE[$cookie_name]'",$conn);
                    echo "Has iniciado sesión como $name<br>";
                    if ($tipo == 0 || $tipo == 1) {
                        echo "USUARIOS: <br>";
                        echo "<a href='./usuarios.php'> Ver usuarios</a><br>";
                    }
                    echo "BBDD: <br>";
                    echo "<a href='./bbdd.php'> Ver bbdd</a><br>";
                    echo "</br></br><input type='submit' name='logout' value='Cerrar Sesión'>";
                }
            ?>
        </form>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['logout'])) {
        setcookie($cookie_name, "", time() - 3600, "/");
        header("Location: ./login");
        exit;
    }
}
?>

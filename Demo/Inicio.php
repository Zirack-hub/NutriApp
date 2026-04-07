<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>

    <link rel="stylesheet" href="css/inicio.css">
</head>
<body>

<div class="container">
    <div class="dashboard">

        <h1 class="title">Panel de control</h1>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

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

                    echo "<p class='welcome'>👋 Bienvenido, <strong>$name</strong></p>";

                    echo "<div class='grid'>";

                    if ($tipo == 0 || $tipo == 1) {
                        echo "
                        <a href='./usuarios.php' class='card'>
                            <h3>Usuarios</h3>
                            <p>Gestionar usuarios del sistema</p>
                        </a>
                        ";
                    }

                    echo "
                        <a href='./alimentos.php' class='card'>
                            <h3>Base de datos</h3>
                            <p>Explorar información almacenada</p>
                        </a>
                    ";

                    echo "</div>";

                    echo "<button type='submit' name='logout' class='logout'>Cerrar sesión</button>";
                }
            ?>

        </form>

    </div>
</div>

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
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login cliente</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body class="body-login">

<div class="login-container">
    <div class="login-card">
        <h1 class="login-title">Iniciar Sesión</h1>

        <form name="alta" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="login-form">
            
            <?php
                $cookie_name = "usuarioNutricion";
                require_once("./funciones/funciones.php");
                require_once("./funciones/fbd.php");
                require_once("./funciones/fcompras.php");

                $conn = openBD("nutriapp");

                if(!isset($_COOKIE[$cookie_name])) {
            ?>

                <div class="input-group">
                    <label>Usuario</label>
                    <input type="text" name="usuario" class="input-field" required>
                </div>

                <div class="input-group">
                    <label>Contraseña</label>
                    <input type="password" name="clave" class="input-field" required>
                </div>

                <button type="submit" name="submit" class="btn-login">Entrar</button>

            <?php
                } else {
                    header("Location: ./inicio");
                }
            ?>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario = limpiar_campos($_POST["usuario"]);
            $clave = limpiar_campos($_POST["clave"]);

            $registro = selectCOL("SELECT EMAIL FROM USUARIOS WHERE CONTRASENA = '$clave' AND EMAIL = '$usuario'",$conn);
                
            if ($registro != null) {
                setcookie($cookie_name, $registro, time() + (86400 * 30), "/");
                header("Location: ./inicio");
            } else {
                echo "<p class='error-msg'>El usuario y la contraseña no coinciden</p>";
            }
        }
        ?>

    </div>
</div>

</body>
</html>
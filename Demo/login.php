<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login cliente</title>
</head>
<body>
    <h1>Login cliente</h1>
		<p>Login clientes<p>
		<div class="card-body">
		<form name="alta" action="<?php echo htmlspecialchars('inicio.php'); ?>" method="post">


                    Email: <input type="text" name="usuario">
                    contraseña: <input type="text" name="clave">
                    <input type="submit" name="submit" value="Iniciar Sesión">

        </form>


</body>
</html>
<?php
require_once("./funciones/funciones.php");
require_once("./funciones/fbd.php");
require_once("./funciones/fcompras.php");

$conn = openBD();

$tiposStmt = $conn->query("SELECT id, nombre FROM tipos");
$tipos = $tiposStmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["crear"])) {
    $nombre = limpiar_campos($_POST["nombre"]);
    $email = limpiar_campos($_POST["email"]);
    $pass = limpiar_campos($_POST["contrasena"]);
    $tipo = (int)$_POST["tipo"];

    try {
        $res = createUser($conn, $nombre, $email, $pass, $tipo);
        echo "<p class='success'>Usuario creado correctamente con ID {$res['id']} y tabla {$res['tabla']}</p>";
    } catch (PDOException $e) {
        echo "<p class='error'>Error al crear el usuario: " . $e->getMessage() . "</p>";
    }
}

$sql = "SELECT ID, NOMBRE, email, TABLA FROM USUARIOS ORDER BY ID ASC";
$stmt = $conn->query($sql);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Usuarios</title>
<link rel="stylesheet" href="css/usuarios.css">
</head>

<body>

<div class="container">

    <div class="card">
        <h2>Crear usuario</h2>

        <div class="botonera">
            <a href="inicio.php" class="btn inicio">Volver al inicio</a>
        </div>

        <form method="POST">
            <label>Nombre</label>
            <input type="text" name="nombre" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Contraseña</label>
            <input type="password" name="contrasena" required>

            <label>Tipo</label>
            <select name="tipo" required>
                <option value="">-- Selecciona tipo --</option>
                <?php foreach($tipos as $t): ?>
                    <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['nombre']) ?></option>
                <?php endforeach; ?>
            </select>

            <input type="submit" name="crear" value="Crear usuario" class="btn">
        </form>
    </div>

    <div class="card">
        <h2>Lista de usuarios</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Tabla</th>
            </tr>

            <?php foreach ($usuarios as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row["ID"]) ?></td>
                <td><?= htmlspecialchars($row["NOMBRE"]) ?></td>
                <td><?= htmlspecialchars($row["email"]) ?></td>
                <td>
                    <a href="alimentos.php?tabla=<?= urlencode($row["TABLA"]) ?>">
                        <?= htmlspecialchars($row["TABLA"]) ?>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

    </div>

</div>

</body>
</html>
<?php
require_once("./funciones/funciones.php");
require_once("./funciones/fbd.php");
require_once("./funciones/fcompras.php");

$conn = openBD(); // tu función PDO

/* OBTENER TIPOS DE USUARIO PARA EL SELECT */
$tiposStmt = $conn->query("SELECT id, nombre FROM tipos");
$tipos = $tiposStmt->fetchAll(PDO::FETCH_ASSOC);

/* CREAR USUARIO */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["crear"])) {
    $nombre = limpiar_campos($_POST["nombre"]);
    $email = limpiar_campos($_POST["email"]);
    $pass = limpiar_campos($_POST["contrasena"]);
    $tipo = (int)$_POST["tipo"];

    // Llamada a la función modularizada
    try {
        $res = createUser($conn, $nombre, $email, $pass, $tipo);
        echo "Usuario creado correctamente con ID {$res['id']} y tabla {$res['tabla']}<br><br>";
    } catch (PDOException $e) {
        echo "Error al crear el usuario: " . $e->getMessage();
    }
}

/* LISTAR USUARIOS */
$sql = "SELECT ID, NOMBRE, email, TABLA FROM USUARIOS ORDER BY ID ASC";
$stmt = $conn->query($sql);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Crear usuario</h2>
<form method="POST">
Nombre<br>
<input type="text" name="nombre" required><br><br>

Email<br>
<input type="email" name="email" required><br><br>

Contraseña<br>
<input type="password" name="contrasena" required><br><br>

Tipo<br>
<select name="tipo" required>
    <option value="">-- Selecciona tipo --</option>
    <?php foreach($tipos as $t): ?>
        <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['nombre']) ?></option>
    <?php endforeach; ?>
</select><br><br>

Columna a crear<br>
<input type="text" name="columna" placeholder="Nombre de la columna" required><br><br>

<input type="submit" name="crear" value="Crear usuario">
</form>

<hr>

<h2>Lista de usuarios</h2>
<table border="1">
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
    <td><?= htmlspecialchars($row["TABLA"]) ?></td>
</tr>
<?php endforeach; ?>
</table>
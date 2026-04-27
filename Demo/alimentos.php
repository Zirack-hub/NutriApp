<?php
require_once("./funciones/funciones.php");
require_once("./funciones/fbd.php");

$conn = openBD();

if (isset($_GET['tabla'])) {
    $tabla = $_GET['tabla'];
    $ruta_salida = "usuarios.php";
} else {
    $tabla = selectCOL("SELECT TABLA FROM USUARIOS WHERE EMAIL = '$_COOKIE[usuarioNutricion]'", $conn);
    $ruta_salida = "inicio.php";
}

closeBD($conn);

function mostrarTabla($conn, $tabla) {
    $alimentos = selectASSOC("SELECT * FROM `$tabla`", $conn);

    if ($alimentos) {

        echo "<div class='table-container'>";
        echo "<table>";
        echo "<tr>";

        foreach(array_keys($alimentos[0]) as $col) {
            if ($col != 'id') {
                echo "<th>$col</th>";
            }
        }

        echo "</tr>";

        foreach($alimentos as $fila){
            echo "<tr>";
            foreach($fila as $col => $valor) {
                if ($col != 'id') {
                    echo "<td>$valor</td>";
                }
            }
            echo "</tr>";
        }

        echo "</table>";
        echo "</div>";

    } else {
        echo "<p class='mensaje'>No hay alimentos registrados todavía.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lista de Alimentos</title>
<link rel="stylesheet" href="css/alimentos.css">
</head>
<body>
<div class="container">
    <div class="dashboard">
        <h2 class="title">Lista de Alimentos</h2>

        <div class="botonera">
            <a href="agregar_alimentos.php" class="btn">Agregar alimento</a>
            <a href="<?php echo $ruta_salida; ?>" class="btn">Volver al inicio</a>
        </div>

        <?php
        $conn = openBD();
        mostrarTabla($conn, $tabla);
        closeBD($conn);
        ?>
    </div>
</div>
</body>
</html>
<?php
require_once("./funciones/funciones.php");
require_once("./funciones/fbd.php");

$conn = openBD("nutriapp");
$tabla = selectCOL("SELECT TABLA FROM USUARIOS WHERE EMAIL = '".$_COOKIE['usuarioNutricion']."'", $conn);
closeBD($conn); 

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn = openBD("nutriapp");
        $conn->beginTransaction();

        $campos = [
            'alimento','na_100','ca_100','k_100','energia_kcal','proteinas_g','grasas_g',
            'ags_g','agm_g','agp_g','colesterol_mg','hc_g','fibra_g','vit_c_mg',
            'vit_b6_mg','vit_e_mg','hierro_mg','sodio_mg','calcio_mg','potasio_mg',
            'porcentaje_energia_total'
        ];

        $campos_columnas = implode(",", $campos);
        $campos_params = implode(",:", $campos);
        $stmt_str = "INSERT INTO `$tabla` ($campos_columnas) VALUES (:$campos_params)";
        $stmt = $conn->prepare($stmt_str);

        foreach($campos as $campo){
            $stmt->bindValue(":$campo", limpiar_campos($_POST[$campo]));
        }

        $stmt->execute();
        $conn->commit();
        $mensaje = "Alimento agregado con éxito. <a href='alimentos.php'>Volver a la lista</a>";

    } catch(PDOException $e){
        $conn->rollBack();
        $mensaje = "Error al agregar alimento: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Agregar Alimento</title>
<link rel="stylesheet" href="css/agregar_alimentos.css">
</head>
<body>
<div class="container">
    <div class="dashboard">
        <h2 class="title">Agregar Alimento</h2>

        <?php if($mensaje) echo "<p class='mensaje'>$mensaje</p>"; ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="formulario-grande">
            <div class="form-group-grande alimento">
                <label for="alimento">Nombre del alimento:</label>
                <input type="text" name="alimento" id="alimento" class="input-grande" required>
            </div>

            <?php
            $campos_restantes = [
                'na_100'=>'Valor de Na','ca_100'=>'Valor de Ca','k_100'=>'Valor de K',
                'energia_kcal'=>'Energía (kcal)','proteinas_g'=>'Proteínas (g)','grasas_g'=>'Grasas (g)',
                'ags_g'=>'AGS (g)','agm_g'=>'AGM (g)','agp_g'=>'AGP (g)','colesterol_mg'=>'Colesterol (mg)',
                'hc_g'=>'Hc (g)','fibra_g'=>'Fibra (g)','vit_c_mg'=>'Vit C (mg)','vit_b6_mg'=>'Vit B6 (mg)',
                'vit_e_mg'=>'Vit E (mg)','hierro_mg'=>'Hierro (mg)','sodio_mg'=>'Sodio (mg)',
                'calcio_mg'=>'Calcio (mg)','potasio_mg'=>'Potasio (mg)','porcentaje_energia_total'=>'% Energía total'
            ];
            foreach($campos_restantes as $name=>$label): ?>
                <div class="form-group-grande">
                    <label for="<?php echo $name; ?>"><?php echo $label; ?>:</label>
                    <input type="number" step="0.01" name="<?php echo $name; ?>" id="<?php echo $name; ?>" class="input-grande" required>
                </div>
            <?php endforeach; ?>

            <input type="submit" value="Agregar" class="btn">
            <a href="alimentos.php" class="btn reset">Volver</a>
        </form>
    </div>
</div>
</body>
</html>
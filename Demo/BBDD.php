
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BBDD</title>

    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
<?php
require_once ("./funciones/funciones.php");
require_once ("./funciones/fbd.php");
require_once ("./funciones/fcompras.php");

$conn = openBD("nutriapp");
$tabla=mostrarTabla($conn);
closeBD($conn);

?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" style="border-style: groove; border-radius: 10px; border-color: black; padding: 20px; margin: 10px;">

    Nombre del alimento:
    <input type='text' name='alimento' value='' maxlength="50" size="5"><br><br>
    Valor de na
    <input type='number' name='na_100' value='' size=10 step="0.01"><br><br>
    Valor de ca
    <input type='number' name='ca_100' value='' size=10 step="0.01"><br><br>
    Valor de k
    <input type='number' name='k_100' value='' size=10 step="0.01"><br><br>
    Energia_kcal
    <input type='number' name='energias_kcal' value='' size=10 step="0.01"><br><br>
    Proteinas_g
    <input type='number' name='proteinas_g' value='' size=10 step="0.01"><br><br>
    Grasas_g
    <input type='number' name='grasas_g' value='' size=10 step="0.01"><br><br>
    Ags_g
    <input type='number' name='ags_g' value='' size=10 step="0.01"><br><br>
    Agm_g
    <input type='number' name='agm_g' value='' size=10 step="0.01"><br><br>
    Agp_g
    <input type='number' name='agp_g' value='' size=10 step="0.01"><br><br>
    Colesterol_mg
    <input type='number' name='colesterol_mg' value='' size=10 step="0.01"><br><br>
    Hc_g
    <input type='number' name='hc_g' value='' size=10 step="0.01"><br><br>
    Fibra_g
    <input type='number' name='fibra_g' value='' size=10 step="0.01"><br><br>
    Vit_c_mg
    <input type='number' name='vit_c_mg' value='' size=10 step="0.01"><br><br>
    Vit_b6_mg
    <input type='number' name='vit_b6_mg' value='' size=10 step="0.01"><br><br>
    Vit_e_mg
    <input type='number' name='vit_e_mg' value='' size=10 step="0.01"><br><br>
    Hierro_mg
    <input type='number' name='hierro_mg' value='' size=10 step="0.01"><br><br>
    Sodio_mg
    <input type='number' name='sodio_mg' value='' size=10 step="0.01"><br><br>
    Calcio_mg
    <input type='number' name='calcio_mg' value='' size=10 step="0.01"><br><br>
    Potasio_mg
    <input type='number' name='potasio_mg' value='' size=10 step="0.01"><br><br>
    Porcentaje_energia_total
    <input type='number' name='porcentaje_energia_total' value='' size=5 step="0.01"><br><br>
    <input type="submit" value="enviar">
    <input type="reset" value="borrar">
</form>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $alimento=limpiar_campos($_POST['alimento']);
    $na_100=limpiar_campos($_POST['na_100']);
    $ca_100=limpiar_campos($_POST['ca_100']);
    $k_100=limpiar_campos($_POST['k_100']);
    $energias_kcal=limpiar_campos($_POST['energias_kcal']);
    $proteinas_g=limpiar_campos($_POST['proteinas_g']);
    $grasas_g=limpiar_campos($_POST['grasas_g']);
    $ags_g=limpiar_campos($_POST['ags_g']);
    $agm_g=limpiar_campos($_POST['agm_g']);
    $agp_g=limpiar_campos($_POST['agp_g']);
    $colesterol_mg=limpiar_campos($_POST['colesterol_mg']);
    $hc_g=limpiar_campos($_POST['hc_g']);
    $fibra_g=limpiar_campos($_POST['fibra_g']);
    $vit_c_mg=limpiar_campos($_POST['vit_c_mg']);
    $vit_b6_mg=limpiar_campos($_POST['vit_b6_mg']);
    $vit_e_mg=limpiar_campos($_POST['vit_e_mg']);
    $hierro_mg=limpiar_campos($_POST['hierro_mg']);
    $sodio_mg=limpiar_campos($_POST['sodio_mg']);
    $calcio_mg=limpiar_campos($_POST['calcio_mg']);
    $potasio_mg=limpiar_campos($_POST['potasio_mg']);
    $porcentaje_energia_total=limpiar_campos($_POST['porcentaje_energia_total']);

    try 
    {
        $conn = openBD("nutriapp");
        $conn->beginTransaction();
        $stmt=$conn->prepare("INSERT INTO `$tabla` (alimento, 
    na_100,
    ca_100,
    k_100,
    energia_kcal,
    proteinas_g,
    grasas_g,
    ags_g,
    agm_g,
    agp_g,
    colesterol_mg,
    hc_g,
    fibra_g,
    vit_c_mg,
    vit_b6_mg,
    vit_e_mg,
    hierro_mg,
    sodio_mg,
    calcio_mg,
    potasio_mg,
    porcentaje_energia_total) VALUES (:alimento, 
    :na_100,
    :ca_100,
    :k_100,
    :energias_kcal,
    :proteinas_g,
    :grasas_g,
    :ags_g,
    :agm_g,
    :agp_g,
    :colesterol_mg,
    :hc_g,
    :fibra_g,
    :vit_c_mg,
    :vit_b6_mg,
    :vit_e_mg,
    :hierro_mg,
    :sodio_mg,
    :calcio_mg,
    :potasio_mg,
    :porcentaje_energia_total)");

    $stmt->bindParam(':alimento', $alimento);
    $stmt->bindParam(':na_100', $na_100);
    $stmt->bindParam(':ca_100', $ca_100);
    $stmt->bindParam(':k_100', $k_100);
    $stmt->bindParam(':energias_kcal', $energias_kcal);
    $stmt->bindParam(':proteinas_g', $proteinas_g);
    $stmt->bindParam(':grasas_g', $grasas_g);
    $stmt->bindParam(':ags_g', $ags_g);
    $stmt->bindParam(':agm_g', $agm_g);
    $stmt->bindParam(':agp_g', $agp_g);
    $stmt->bindParam(':colesterol_mg', $colesterol_mg);
    $stmt->bindParam(':hc_g', $hc_g);
    $stmt->bindParam(':fibra_g', $fibra_g);
    $stmt->bindParam(':vit_c_mg', $vit_c_mg);
    $stmt->bindParam(':vit_b6_mg', $vit_b6_mg);
    $stmt->bindParam(':vit_e_mg', $vit_e_mg);
    $stmt->bindParam(':hierro_mg', $hierro_mg);
    $stmt->bindParam(':sodio_mg', $sodio_mg);
    $stmt->bindParam(':calcio_mg', $calcio_mg);
    $stmt->bindParam(':potasio_mg', $potasio_mg);
    $stmt->bindParam(':porcentaje_energia_total', $porcentaje_energia_total);

    $stmt->execute();
    echo "Tabla introducida con éxito";
    $conn->commit();

    } 
    catch(PDOException $e)
        {
        echo "Error: " . $e->getMessage();

        echo "Código de error: " . $e->getCode() . "<br>";

        $conn->rollBack();
        }
    



}


function mostrarTabla($conn)
{
    $cookie_name = "usuarioNutricion";
    $tabla=selectCOL("SELECT TABLA FROM USUARIOS WHERE EMAIL = '$_COOKIE[$cookie_name]'", $conn);
    $alimentos=selectASSOC("SELECT
    alimento, 
    na_100,
    ca_100,
    k_100,
    energia_kcal,
    proteinas_g,
    grasas_g,
    ags_g,
    agm_g,
    agp_g,
    colesterol_mg,
    hc_g,
    fibra_g,
    vit_c_mg,
    vit_b6_mg,
    vit_e_mg,
    hierro_mg,
    sodio_mg,
    calcio_mg,
    potasio_mg,
    porcentaje_energia_total
    FROM `$tabla`", $conn);

    if($alimentos)
        {
            echo "<table style='border-style: groove; border-radius: 10px; border-color: black; padding: 10px; margin: 10px;'><tr>";
            foreach (array_keys($alimentos[0]) as $nombre) 
            {
                echo "<th>$nombre</th>";
            }
            echo "</tr>";

            foreach ($alimentos as $fila) 
            {
                echo "<tr>";
                foreach ($fila as $valor) {
                    echo "<th>$valor</th>";
                }
                echo "</tr>";
            }

        }
        else {
            echo "El alumno no ha introducido ningún alimento";
            
        }
        echo "</body>";
    return $tabla;
}

?>
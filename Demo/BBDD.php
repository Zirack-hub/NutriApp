<?php
require_once ("./funciones/funciones.php");
require_once ("./funciones/fbd.php");
require_once ("./funciones/fcompras.php");

$conn = openBD("nutriapp");
mostrarTabla($conn);
closeBD($conn);
function mostrarTabla($conn)
{
    $cookie_name = "usuarioNutricion";
    $tabla=selectCOL("SELECT TABLA FROM USUARIOS WHERE EMAIL = '$_COOKIE[$cookie_name]'", $conn);
    $alimentos=selectASSOC("SELECT 
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
            echo "<table><tr>";
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
}

?>
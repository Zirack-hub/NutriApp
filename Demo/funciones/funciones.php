<?php


function limpiar_campos($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function comprobarNumero($value) {
    return preg_match('/^[A-Z]{2}[0-9]{6}$/', $value);
}
?>
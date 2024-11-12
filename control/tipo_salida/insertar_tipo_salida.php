<?php
include("../../modelo/tipo_salida.php");

$nombre = utf8_decode($_POST[nombre]);

$tipo_salida = new tipo_salida();
$result = $tipo_salida->registrar_tipo_salida($nombre);
if($result)
{
    echo "Datos registrados.";
}
else
{
    echo "Ocuri&oacute; un Error. El estante ya existe.";
}

?>
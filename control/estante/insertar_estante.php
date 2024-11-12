<?php
include("../../modelo/estante.php");

$nro_estante = $_POST[nro_estante];
$nro_filas = $_POST[nro_filas];
$tipo_estante = intval($_POST[id_tipo_estante]);
$estado = 1;

$estante = new estante();
$result = $estante->registrar_estante($nro_estante, $nro_filas, $estado, $tipo_estante);
if($result)
{
    echo "Datos registrados.";
}
else
{
    echo "Ocuri&oacute; un Error. El estante ya existe.";
}

?>
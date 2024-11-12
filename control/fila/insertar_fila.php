<?php
include("../../modelo/fila.php");

$nro_fila = $_POST[nro_fila];
$estado = 1;
$id_estante = intval($_POST[id_estante]);

$fila = new fila();
$result = $fila->registrar_fila($nro_fila, $estado, $id_estante);
if($result)
{
    echo "Datos registrados.";
}
else
{
    echo "Ocuri&oacute; un Error. La fila ya existe.";
}

?>
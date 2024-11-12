<?php
include("../../modelo/caja.php");

$nro_caja = $_POST[nro_caja];
$estado = 1;
$id_fila= $_POST[id_fila];

$caja = new caja();
$result = $caja->registrar_caja($nro_caja, $estado, $id_fila);
if($result)
{
    echo "Datos registrados.";
}
else
{
    echo "Ocuri&oacute; un Error. La caja ya existe.";
}

?>
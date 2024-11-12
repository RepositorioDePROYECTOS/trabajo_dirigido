<?php
include("../../modelo/conexion.php");
include("../../modelo/funciones.php");

$id_detalle_servicio = $_GET[id_detalle_servicio];

$bd = new conexion();

$registros = $bd->Consulta("DELETE FROM detalle_servicio WHERE id_detalle_servicio=$id_detalle_servicio ");
if($bd->numFila_afectada($registros)>0)
{
	echo json_encode(array("success" => true));
}
else
{
	echo json_encode(array("success" => false));
}

?>
<?php
include("../../modelo/conexion.php");
include("../../modelo/funciones.php");

$id_detalle_activo = $_GET[id_detalle_activo];

$bd = new conexion();

$registros = $bd->Consulta("DELETE FROM detalle_activo WHERE id_detalle_activo=$id_detalle_activo ");
if($bd->numFila_afectada($registros)>0)
{
	echo json_encode(array("success" => true));
}
else
{
	echo json_encode(array("success" => false));
}

?>
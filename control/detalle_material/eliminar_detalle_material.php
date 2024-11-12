<?php
include("../../modelo/conexion.php");
include("../../modelo/funciones.php");

$id_detalle_material = $_GET[id_detalle_material];

$bd = new conexion();

$registros = $bd->Consulta("DELETE FROM detalle_material WHERE id_detalle_material=$id_detalle_material ");
if($bd->numFila_afectada($registros)>0)
{
	echo json_encode(array("success" => true));
}
else
{
	echo json_encode(array("success" => false));
}

?>
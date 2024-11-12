<?php
include("../../modelo/solicitud_material_ampe.php");
include("../../modelo/funciones.php");

referer_permit();

$id_solicitud_material = $_POST[id_solicitud_material];
$gerente_area = utf8_decode($_POST[gerente_area]);
$autorizado_por = utf8_decode($_POST[autorizado_por]);
$justificativo = utf8_decode(strtoupper($_POST[justificativo]));

$solicitud_material = new solicitud_material_ampe();
$result = $solicitud_material->modificar_solicitud_material($id_solicitud_material,$justificativo, $gerente_area, $autorizado_por );
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "No se realizaron Cambios.";
}


?>
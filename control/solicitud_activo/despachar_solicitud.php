<?php
include("../../modelo/conexion.php");
include("../../modelo/funciones.php");

$id_solicitud_activo = $_GET[id_solicitud_activo];
$fecha_despacho = $_GET[fecha_despacho];

$bd = new conexion();

$registros_detalle_activo = $bd->Consulta("SELECT * from detalle_activo where id_solicitud_activo=$id_solicitud_activo");
while($registro_d = $bd->getFila($registros_detalle_activo))
{
    $registro_activo = $bd->Consulta("SELECT cantidad as cantidad from activo WHERE descripcion='$registro_d[descripcion]' and unidad_medida='$registro_d[unidad_medida]' ");
    $registro_m = $bd->getFila($registro_activo);
    $cantidad_restante = floatval($registro_m[cantidad]) - floatval($registro_d[cantidad_despachada]);
    $actualizar_cantidad = $bd->Consulta("UPDATE activo set cantidad='$cantidad_restante' WHERE descripcion='$registro_d[descripcion]' and unidad_medida='$registro_d[unidad_medida]' ");
    if($bd->numFila_afectada($actualizar_cantidad)>0)
	    $afectado='SI';
    else
		$afectado='NO';
}
$registros_solicitud = $bd->Consulta("UPDATE solicitud_activo set fecha_despacho='$fecha_despacho', estado_solicitud_activo='DESPACHADO' WHERE id_solicitud_activo=$id_solicitud_activo ");
if($bd->numFila_afectada($registros_solicitud)>0)
{
	echo json_encode(array("success" => true));
}
else
{
	echo json_encode(array("success" => false));
}

?>
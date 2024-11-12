<?php
include("../../modelo/conexion.php");
include("../../modelo/funciones.php");

$id_solicitud_material = $_GET[id_solicitud_material];
$fecha_despacho = $_GET[fecha_despacho];

$bd = new conexion();

$registros_detalle_material = $bd->Consulta("SELECT * from detalle_material where id_solicitud_material=$id_solicitud_material");
while($registro_d = $bd->getFila($registros_detalle_material))
{
    $registro_material = $bd->Consulta("SELECT cantidad as cantidad from material WHERE descripcion='$registro_d[descripcion]' and unidad_medida='$registro_d[unidad_medida]' ");
    $registro_m = $bd->getFila($registro_material);
    $cantidad_restante = floatval($registro_m[cantidad]) - floatval($registro_d[cantidad_despachada]);
    $actualizar_cantidad = $bd->Consulta("UPDATE material set cantidad='$cantidad_restante' WHERE descripcion='$registro_d[descripcion]' and unidad_medida='$registro_d[unidad_medida]' ");
    if($bd->numFila_afectada($actualizar_cantidad)>0)
	    $afectado='SI';
    else
		$afectado='NO';
}
$registros_solicitud = $bd->Consulta("UPDATE solicitud_material set fecha_despacho='$fecha_despacho', estado_solicitud_material='DESPACHADO' WHERE id_solicitud_material=$id_solicitud_material ");
if($bd->numFila_afectada($registros_solicitud)>0)
{
	echo json_encode(array("success" => true));
}
else
{
	echo json_encode(array("success" => false));
}

?>
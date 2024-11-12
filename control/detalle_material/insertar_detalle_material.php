<?php
session_start();
include("../../modelo/conexion.php");
include("../../modelo/funciones.php");

$id_solicitud_material   = $_POST['id_solicitud_material'];
$id_material             = $_POST['id_material'];
// $id_partida              = $_POST['id_partida'];
$descripcion_material    = $_POST['descripcion_material'];
$descripcion_material_sn = $_POST['descripcion_material_sn'];
$unidad_m                = $_POST['unidad_medida'];
$unidad_medida_sn        = $_POST['unidad_medida_sn'];
$cantidad_solicitada     = $_POST['cantidad_solicitada'];
$cantidad_sn             = $_POST['cantidad_sn'];
$precio_unitario         = floatval($_POST['precio_unitario']);
$precio_unitario_sn      = floatval($_POST['precio_unitario_sn']);
$precio_referencia       = floatval($_POST['precio_referencia']);
$existencia              = $_POST['existencia'];
$total_usado             = (isset($_POST[total_usado])) ? floatval($_POST[total_usado]) : 0;
// echo json_encode(array("success" => false, "descripcion" =>$descripcion_material, "unidad sn" => $unidad_medida_sn, "unidad" =>$unidad_medida));
$bd = new conexion();


if ($id_material != 0) {
	// $registro_material = $bd->Consulta("SELECT * from material where id_material=$id_material");
	// $registro_m = $bd->getFila($registro_material);
	// $descripcion = $registro_m[descripcion];
	$descripcion = utf8_decode($descripcion_material);
	// $unidad_medida = $registro_m[unidad_medida];
	$unidad_medida = utf8_decode($unidad_m);
} else {
	$descripcion = utf8_decode($descripcion_material_sn);
	$unidad_medida = utf8_decode($unidad_medida_sn);
	$precio_unitario = $precio_unitario_sn;
}

$cantidad_despachada = $cantidad_solicitada;
$dineros = $bd->Consulta("SELECT sum(precio_total) as TOTAL from detalle_material WHERE id_solicitud_material=$id_solicitud_material");
$dinero = $bd->getFila($dineros);

$verificar_material = $bd->Consulta("SELECT * FROM detalle_material where id_solicitud_material=$id_solicitud_material and descripcion='$descripcion' and unidad_medida='$unidad_medida'");
$verificar_m = $bd->getFila($verificar_material);

$costo = floatval($dinero[TOTAL]) + floatval($precio_referencia);
$topes = 50000.00;
$tope = floatval($topes);
$sobregiro = $costo - $tope;
$sobregiro = number_format($sobregiro, 2, ',', '.') . " Bs";
// echo json_encode(array("success" => false, "message" => "Total ".$costo." el tope es: ".$tope));
// echo json_encode(array(
// 	"success" => false, 
// 	'$descripcion' => $descripcion,
// 	'$unidad_medida' => $unidad_medida,
// 	'$cantidad_solicitada' => $cantidad_solicitada,
// 	'$cantidad_despachada' => $cantidad_despachada,
// 	'$precio_unitario' => $precio_unitario,
// 	'$id_solicitud_material' => $id_solicitud_material 
// ));
// // if ($costo <= $tope) { // suspencion temporal
if ($verificar_m[descripcion] != $descripcion && $verificar_m[unidad_medida] != $unidad_medida) {
	if ($existencia == 'SI') {
		$registros = $bd->Consulta("INSERT INTO detalle_material ( descripcion, unidad_medida, cantidad_solicitada,cantidad_despachada,precio_unitario,id_solicitud_material) 
				VALUES(
						'$descripcion',
						'$unidad_medida',
						'$cantidad_solicitada',
						'$cantidad_despachada',
						'$precio_unitario',
						'$id_solicitud_material'
						)");
		if ($bd->numFila_afectada() > 0) {
			echo json_encode(array("success" => true));
		} else {
			echo json_encode(array("success" => false, "message" => "Error no se insertó material"));
		}
	} else {
		if (($total_usado + $precio_referencia) <= 50000) {
			$registros = $bd->Consulta("INSERT INTO detalle_material (descripcion, unidad_medida, cantidad_solicitada, cantidad_despachada, precio_unitario, precio_total, id_solicitud_material )
				VALUES(
						'$descripcion',
						'$unidad_medida',
						'$cantidad_sn',
						'$cantidad_sn',
						'$precio_unitario',
						'$precio_referencia',
						'$id_solicitud_material'
						)");
			if ($bd->numFila_afectada() > 0) {
				echo json_encode(array("success" => true));
			} else {
				echo json_encode(array("success" => false, "message" => "Error no se insertó material"));
			}
		} else {
			echo json_encode(array("success" => false, "message" => "Error ya supero los 50.000,00 Bs, tiene acumulado: " . ($total_usado + $precio_referencia)));
		}
	}
} else {
	echo json_encode(array("success" => false, "message" => utf8_encode('Error ya existe material registrado : ' . $descripcion_material . ' != ' . $descripcion_material_sn . ' !== ' . $descripcion . ' (' . $unidad_m . ' != ' . $unidad_medida_sn . ') != ' . $verificar_m[descripcion])));
}
// // } else {
// // 	echo json_encode(array("success" => false, "message" => "Exedio los 50.000,00 Bs. por: ".$sobregiro.", no se puede realizar la Accion"));
// // }
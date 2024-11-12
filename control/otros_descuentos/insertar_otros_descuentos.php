<?php
include("../../modelo/otros_descuentos.php");
include("../../modelo/conf_otros_descuentos.php");
include("../../modelo/funciones.php");

referer_permit();

$mes = utf8_decode($_POST[mes]);
$gestion = utf8_decode($_POST[gestion]);
$id_conf_otros_descuentos = utf8_decode($_POST[id_conf_otros_descuentos]);
$de_donde = utf8_decode($_POST[de_donde]);
$id_asignacion_cargo = utf8_decode($_POST[id_asignacion_cargo]);

$otros_descuentos = new otros_descuentos();
$conf_otros_descuentos = new conf_otros_descuentos();
$bd = new conexion();
echo $mes."mes".$gestion."gestion".$id_conf_otros_descuentos."od".$de_donde;
$conf_otros_descuentos->get_conf_otros_descuentos($id_conf_otros_descuentos);

$verificar = $bd->Consulta("select * from otros_descuentos where id_asignacion_cargo=$id_asignacion_cargo and mes=$mes and gestion=$gestion and descripcion='$conf_otros_descuentos->descripcion'");
$factor_calculo = $conf_otros_descuentos->factor_calculo;
$verificar_1 = $bd->getFila($verificar);
if(empty($verificar_1))
{
	$registros_tg = $bd->Consulta("select * from total_ganado where id_asignacion_cargo=$id_asignacion_cargo and mes=$mes and gestion=$gestion");
	$registro_tg = $bd->getFila($registros_tg);

	if($de_donde == 1)
	{
			eval("\$monto_od = \$registro_tg[total_ganado]$factor_calculo;");
			$otros_descuentos->registrar_otros_descuentos($mes, $gestion, $conf_otros_descuentos->descripcion, $factor_calculo, round($monto_od,2), $id_asignacion_cargo);
	}
	else
	{
		eval("\$monto_od = \$registro_tg[haber_basico]$factor_calculo;");
			$otros_descuentos->registrar_otros_descuentos($mes, $gestion, $conf_otros_descuentos->descripcion, $factor_calculo, round($monto_od,2), $id_asignacion_cargo);
	}
			
}
else
{
	echo "Error. Ya se tiene generada un descuento con la misma descripcion de ese periodo";
}

?>
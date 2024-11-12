<?php
include("../../modelo/descuentos.php");
include("../../modelo/funciones.php");

referer_permit();

$mes = utf8_decode($_POST[mes]);
$gestion = utf8_decode($_POST[gestion]);

$descuentos = new descuentos();
$bd = new conexion();


$verificar = $bd->Consulta("select * from descuentos where mes=$mes and gestion=$gestion");
$verificar_1 = $bd->getFila($verificar);
if($verificar_1[gestion]!=$gestion && $verificar_1[mes]!=$mes)
{
	$registros_ac = $bd->Consulta("select * from asignacion_cargo where estado_asignacion='HABILITADO'");
	while($registro_ac = $bd->getFila($registros_ac))
	{
		$registros_des = $bd->Consulta("select * from conf_descuentos where estado='HABILITADO'");
		while($registro_des = $bd->getFila($registros_des))
		{
				$descuentos->registrar_descuentos($mes, $gestion, $registro_des[nombre_descuento], 0, $registro_ac[id_asignacion_cargo]);	
		}
	}

}
else
{
	echo "Error. Ya se tiene generada esa planilla de ese periodo";
}

?>
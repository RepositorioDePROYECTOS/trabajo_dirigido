<?php
include("../../modelo/reintegro_bono_antiguedad.php");
include("../../modelo/funciones.php");

referer_permit();

$mes = utf8_decode($_POST[mes]);
$gestion = utf8_decode($_POST[gestion]);

$reintegro_bono_antiguedad = new reintegro_bono_antiguedad();
$bd = new conexion();
$registros_b = $bd->Consulta("select * from bono_antiguedad where gestion=$gestion and mes=$mes");
$registro_b = $bd->getFila($registros_b);
if(!empty($registro_b))
{
	$verificar = $bd->Consulta("select * from reintegro_bono_antiguedad where gestion_reintegro=$gestion and mes_reintegro=$mes");
	$verificar_1 = $bd->getFila($verificar);
	if($verificar_1[gestion_reintegro]!=$gestion && $verificar_1[mes_reintegro]!=$mes)
	{
		$registros_ac = $bd->Consulta("select * from bono_antiguedad ba inner join asignacion_cargo ac on ba.id_asignacion_cargo=ac.id_asignacion_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador inner join asistencia a on a.id_asignacion_cargo=ac.id_asignacion_cargo where ba.gestion=$gestion and ba.mes=$mes and a.gestion=$gestion and a.mes=$mes");
		while($registro_ac = $bd->getFila($registros_ac))
		{
			$monto_bono_antiguedad = $registro_ac[monto];
			$monto_nuevo_bono_antiguedad = (((2164*3*$registro_ac[porcentaje])/100)/$registro_ac[dias_laborables])*$registro_ac[dias_asistencia];
			$monto_reintegro = $monto_nuevo_bono_antiguedad - $monto_bono_antiguedad;
			$reintegro_bono_antiguedad->registrar_reintegro_bono_antiguedad($gestion, $mes, $registro_ac[porcentaje], $monto_reintegro, $registro_ac[id_bono_antiguedad]);
		}
	}
	else
	{
		echo "Error. Ya se tiene generada esa planilla de ese periodo";
	}
}
else
{
	echo "Error. No existe bono de antiguedad";
}

?>
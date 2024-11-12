<?php
include("../../modelo/bono_antiguedad.php");
include("../../modelo/funciones.php");

referer_permit();

$mes = utf8_decode($_POST[mes]);
$gestion = utf8_decode($_POST[gestion]);
$fecha_calculo = utf8_decode($_POST[fecha_calculo]);

$bono_antiguedad = new bono_antiguedad();
$bd = new conexion();

$registros_b = $bd->Consulta("select * from conf_bono_antiguedad where estado_bono='HABILITADO'");
$registro_b = $bd->getFila($registros_b);
if(!empty($registro_b))
{
	$verificar = $bd->Consulta("select * from bono_antiguedad where mes=$mes and gestion=$gestion");
	$verificar_1 = $bd->getFila($verificar);
	if($verificar_1[gestion]!=$gestion && $verificar_1[mes]!=$mes)
	{
		$registros_ac = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on t.id_trabajador=ac.id_trabajador inner join asistencia a on a.id_asignacion_cargo=ac.id_asignacion_cargo where ac.estado_asignacion='HABILITADO' and mes=$mes and gestion=$gestion");


		while($registro_ac = $bd->getFila($registros_ac))
		{
			
			if($registro_ac[fecha_ingreso] < $fecha_calculo)
			{
				$antiguedad_actual = antiguedad($registro_ac[fecha_ingreso],$fecha_calculo);
			}
			else
			{
				echo "Error. incoherencia de fechas en el trabajador: ".$registro_ac[nombres]." ".$registro_ac[apellido_paterno]." ".$registro_ac[apellido_materno];
			}

			$antiguedad_anterior = array($registro_ac[antiguedad_anios],$registro_ac[antiguedad_meses],$registro_ac[antiguedad_dias]);
			$antiguedad = sumar_antiguedad($antiguedad_anterior,$antiguedad_actual);
			if($antiguedad[0] >= 2)
			{
				$registros_ba = $bd->Consulta("select * from conf_bono_antiguedad where estado_bono='HABILITADO'");
				while($registro_ba = $bd->getFila($registros_ba))
				{
					if(($antiguedad[0] >= $registro_ba[anio_i]) && ($antiguedad[0] <= $registro_ba[anio_f]))
					{
						$monto = (((2500*3*$registro_ba[porcentaje])/100)/$registro_ac[dias_laborables])*$registro_ac[dias_asistencia];
						$bono_antiguedad->registrar_bono_antiguedad($registro_ac[antiguedad_anios], $registro_ac[antiguedad_meses], $registro_ac[antiguedad_dias], $registro_ac[fecha_ingreso], $fecha_calculo, $antiguedad[0], $antiguedad[1], $antiguedad[2], $gestion, $mes, $registro_ba[porcentaje], $monto, $registro_ac[id_asignacion_cargo]);
						
					}
				}
			}
			else
			{
				$bono_antiguedad->registrar_bono_antiguedad($registro_ac[antiguedad_anios], $registro_ac[antiguedad_meses], $registro_ac[antiguedad_dias], $registro_ac[fecha_ingreso], $fecha_calculo, $antiguedad[0], $antiguedad[1], $antiguedad[2], $gestion, $mes, 0, 0, $registro_ac[id_asignacion_cargo]);
			}


		}
	}
	else
	{
		echo "Error. Ya se tiene generada esa planilla de ese periodo";
	}
}
else
{
	echo "Error. No existen tipos de bono de antiguedad";
}





?>
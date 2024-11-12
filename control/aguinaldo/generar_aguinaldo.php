<?php
include("../../modelo/aguinaldo.php");
include("../../modelo/funciones.php");

referer_permit();

$nro_aguinaldo = utf8_decode($_POST['nro_aguinaldo']);
$gestion = utf8_decode($_POST['gestion']);


$aguinaldo = new aguinaldo();
$bd = new conexion();
$mes = 12;
$mes_calculo = $mes - 1;

$verificar_pls = $bd->Consulta("select * from planilla where mes=$mes_calculo and gestion=$gestion");
$verificar_pl = $bd->getFila($verificar_pls);
if(!empty($verificar_pl))
{

	$verificar = $bd->Consulta("select * from aguinaldo where gestion=$gestion and nro_aguinaldo=$nro_aguinaldo");
	$verificar_1 = $bd->getFila($verificar);
	if(empty($verificar_1))
	{
		$registros_ac = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on t.id_trabajador=ac.id_trabajador where ac.estado_asignacion='HABILITADO'");
		$sueldo_1 = 0;
		$sueldo_2 = 0;
		$sueldo_3 = 0;
		while($registro_ac = $bd->getFila($registros_ac))
		{
			$registros_tr = $bd->Consulta("select sum(a.dias_asistencia) as dias from asistencia a inner join asignacion_cargo ac on a.id_asignacion_cargo=ac.id_asignacion_cargo where ac.id_trabajador=$registro_ac[id_trabajador] and a.gestion=$gestion"); 

			$registros_tg = $bd->Consulta("select * from total_ganado tg inner join asignacion_cargo ac on tg.id_asignacion_cargo=ac.id_asignacion_cargo where ac.id_trabajador=$registro_ac[id_trabajador] and tg.mes>=9 and tg.mes<12 and tg.gestion=$gestion order by cast(tg.mes as unsigned) desc");

			$i = 2;
			$tg[0] = 0;
			$tg[1] = 0;
			$tg[2] = 0;
			while($registro_tg = $bd->getFila($registros_tg))
			{
				$tg[$i] = $registro_tg[total_ganado];
				$i--;
			}
			
			$registros_tgr = $bd->Consulta("select * from total_ganado tg inner join reintegro_total_ganado tgr on tg.id_total_ganado=tgr.id_total_ganado inner join asignacion_cargo ac on tg.id_asignacion_cargo=ac.id_asignacion_cargo where ac.id_trabajador=$registro_ac[id_trabajador] and tgr.mes_reintegro=9 and tgr.gestion_reintegro=$gestion");
			$registro_tgr = $bd->getFila($registros_tgr);
			$reintegro_total = $registro_tgr[total_ganado_reintegro];
			$tg[0] = $tg[0] + $reintegro_total;

			//$registros_d = $bd->Consulta("select sum(dias_asistencia) as dias from asistencia where id_asignacion_cargo=$registro_ac[id_asignacion_cargo] and gestion=$gestion  ");

			$registro_d = $bd->getFila($registros_tr);
			$dias_total = $registro_d[dias];

			$meses = intdiv($dias_total, 30);
			
			$dias = $dias_total % 30;

			$sueldo_1 = $tg[0];
			$sueldo_2 = $tg[1];
			$sueldo_3 = $tg[2];



			$total = $sueldo_1 + $sueldo_2 + $sueldo_3;
			$item = $registro_ac[item];
			$ci = $registro_ac[ci];
			$nombre_empleado = $registro_ac[apellido_paterno]." ".$registro_ac[apellido_materno]." ".$registro_ac[nombres];
			$sexo = $registro_ac[sexo];
			$cargo = $registro_ac[cargo];
			$fecha_ingreso = $registro_ac[fecha_ingreso];
			
			if($meses >= 3)
			{
				$promedio_3_meses = $total/3;
			}
			else
			{
				//$numero = $meses;
				$promedio_3_meses = $total/3;
			}

			if($meses >= 3)
			{
				$aguinaldo_anual = $promedio_3_meses;
			}
			else
			{
				if($registro_ac[item]==125)
				{
					$aguinaldo_anual = (1139.83 + 4885.00 + 4885.00)/3;//promediar 3 meses de octubre, noviembre y diciembre
				}
				else
				{
					$aguinaldo_anual =0;
				}
			}		
			
			$aguinaldo_pagar = ($aguinaldo_anual/360) * $dias_total;
			
			$estado = 'GENERADO';
			$id_asignacion_cargo = $registro_ac[id_asignacion_cargo];
			
			$aguinaldo->registrar_aguinaldo($gestion, $meses, $item, $ci, $nombre_empleado, $dias, $sexo, $cargo, $fecha_ingreso, $sueldo_1, $sueldo_2, $sueldo_3, $total, $promedio_3_meses, $aguinaldo_anual, $aguinaldo_pagar, $estado, $nro_aguinaldo, $id_asignacion_cargo);
		}

	}
	else
	{
		echo "Error. Ya se tiene generada la planilla de aguinaldo";
	}
}
else
echo "Error. tiene que generar la planilla de sueldo de noviembre primero";
?>
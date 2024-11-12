<?php
include("../../modelo/planilla.php");
include("../../modelo/funciones.php");

referer_permit();

$id_nombre_planilla = utf8_decode($_POST[id_nombre_planilla]);
$mes = utf8_decode($_POST[mes]);
$gestion = utf8_decode($_POST[gestion]);

$planilla = new planilla();
$bd = new conexion();

//$verificar_pls = $bd->Consulta("select * from total_ganado tg inner join asignacion_cargo ac on tg.id_asignacion_cargo=ac.id_asignacion_cargo inner join aporte_laboral al on al.id_asignacion_cargo=ac.id_asignacion_cargo inner join descuentos d on ac.id_asignacion_cargo=d.id_asignacion_cargo inner join fondo_empleados fe on ac.id_asignacion_cargo=fe.id_asignacion_cargo inner join bono_antiguedad ba on ac.id_asignacion_cargo=ba.id_asignacion_cargo where tg.mes=$mes and tg.gestion=$gestion");

$verificar_pls = $bd->Consulta("select * from impositiva where mes=$mes and gestion=$gestion");
$verificar_pl = $bd->getFila($verificar_pls);
if(!empty($verificar_pl))
{

	$verificar = $bd->Consulta("select * from planilla where id_nombre_planilla=$id_nombre_planilla");
	$verificar_1 = $bd->getFila($verificar);
	if($verificar_1[id_nombre_planilla]!=$id_nombre_planilla)
	{
		$registros_ac = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on t.id_trabajador=ac.id_trabajador where ac.estado_asignacion='HABILITADO'");
		while($registro_ac = $bd->getFila($registros_ac))
		{
			
			$registros_tg = $bd->Consulta("select * from total_ganado where id_asignacion_cargo=$registro_ac[id_asignacion_cargo] and mes=$mes and gestion=$gestion");
			$registro_tg = $bd->getFila($registros_tg);

			$registros_apo = $bd->Consulta("select * from aporte_laboral where id_asignacion_cargo=$registro_ac[id_asignacion_cargo] and mes=$mes and gestion=$gestion");
			$suma = 0;
			while($registro_apo = $bd->getFila($registros_apo))
			{
				if($registro_apo[tipo_aporte] == 'COTIZACION MENSUAL')
				{
					$categoria_individual = $registro_apo[monto_aporte];
				}
				else
					if($registro_apo[tipo_aporte] == 'PRIMA RIESGO COMUN')
					{
						$prima_riesgo_comun = $registro_apo[monto_aporte];
					}
					else
						if($registro_apo[tipo_aporte] == 'COMISION AL ENTE ADMINISTRADOR')
						{
							$comision_ente = $registro_apo[monto_aporte];
						}
						else
						{
							$suma = $registro_apo[monto_aporte] + $suma;
						}
			}

			$registros_desc = $bd->Consulta("select * from descuentos where id_asignacion_cargo=$registro_ac[id_asignacion_cargo] and mes=$mes and gestion=$gestion");
			while($registro_desc = $bd->getFila($registros_desc))
			{
				if($registro_desc[nombre_descuento] == 'FONDO SOCIAL')
				{
					$fondo_social = $registro_desc[monto];
				}
				else
					if($registro_desc[nombre_descuento] == 'ENTIDADES FINANCIERAS')
					{
						$entidades_financieras = $registro_desc[monto];
					}
					else
						if($registro_desc[nombre_descuento] == 'RETENCION JUDICIAL')
						{
							$retencion_judicial = $registro_desc[monto];
						}
			}

			$registros_od = $bd->Consulta("select * from otros_descuentos where id_asignacion_cargo=$registro_ac[id_asignacion_cargo] and mes=$mes and gestion=$gestion");
			$registro_od = $bd->getFila($registros_od);			
			if(empty($registro_od))
			{
				$otros_descuentos = 0;
			}
			else
			{
				$otros_descuentos = $registro_od[monto_od];
			}
			
			$otros_descuentos = $retencion_judicial + $otros_descuentos;

			$registros_fe = $bd->Consulta("select * from fondo_empleados where id_asignacion_cargo=$registro_ac[id_asignacion_cargo] and mes=$mes and gestion=$gestion");
			$registro_fe = $bd->getFila($registros_fe);
			if(empty($registro_fe))
			{
				$fondo_empleados = 0;
			}
			else
			{
				$fondo_empleados = $registro_fe[total_fe];
			}

			$registros_imp = $bd->Consulta("select * from impositiva where id_asignacion_cargo=$registro_ac[id_asignacion_cargo] and mes=$mes and gestion=$gestion");
			$registro_imp = $bd->getFila($registros_imp);

			$total_aporte_solidario = $suma;

			$item = $registro_ac[item];
			$ci = $registro_ac[ci];
			$nombres = $registro_ac[nombres];
			$apellidos = $registro_ac[apellido_paterno]." ".$registro_ac[apellido_materno];
			$cargo = $registro_ac[cargo];
			$fecha_ingreso = $registro_ac[fecha_ingreso];
			$dias_pagado = $registro_tg[total_dias];
			$haber_mensual = $registro_tg[haber_mensual];
			$haber_basico = $registro_tg[haber_basico];
			$bono_antiguedad = $registro_tg[bono_antiguedad];
			$horas_extra = $registro_tg[monto_horas_extra];
			$suplencia = $registro_tg[suplencia];
			$total_ganado = $registro_tg[total_ganado];
			if($registro_ac[sindicato]==1)
			{	
				if($dias_pagado != 0)
				{
					$sindicato = round((($haber_mensual * 1.5)/100),2);
				}
				else
				{
					$sindicato = 0;
				}
				
			}
			else
			{
				$sindicato = 0;
			}
			
			$desc_rciva = $registro_imp[retencion_pagar];

			$total_descuentos = $sindicato + $categoria_individual + $prima_riesgo_comun + $comision_ente + $total_aporte_solidario + $desc_rciva + $otros_descuentos + $fondo_social + $fondo_empleados + $entidades_financieras;
			$liquido_pagable = $total_ganado - $total_descuentos;
			$estado_planilla = 'GENERADO';
			$fecha_generado = date('Y-m-d');
			$nua = $registro_ac[nua];

			$planilla->registrar_planilla($mes, $gestion, $item, $ci, $nua, $nombres, $apellidos, $cargo, $fecha_ingreso, $dias_pagado, $haber_mensual, $haber_basico, $bono_antiguedad, $horas_extra, $suplencia, $total_ganado, $sindicato, $categoria_individual, $prima_riesgo_comun, $comision_ente, $total_aporte_solidario, $desc_rciva, $otros_descuentos, $fondo_social, $fondo_empleados, $entidades_financieras, $total_descuentos, $liquido_pagable, $estado_planilla, $fecha_generado, $id_nombre_planilla);
		}

	}
	else
	{
		echo "Error. Ya se tiene generada esa planilla de ese periodo";
	}
}
else
echo "Error. tiene que generar todas las planillas previas del mes primero";
?>
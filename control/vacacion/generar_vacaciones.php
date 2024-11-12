<?php
include("../../modelo/vacacion.php");
include("../../modelo/detalle_vacacion.php");
include("../../modelo/funciones.php");

referer_permit();

$fecha_calculo = utf8_decode($_POST[fecha_calculo]);
$vacacion = new vacacion();
$detalle_vacacion = new detalle_vacacion();
$bd = new conexion();
$fecha_actual = date("m-d",$fecha_calculo);
$gestion_fin = date("Y");
$gestion_inicio = $gestion_fin - 1;
	
	$registros_t = $bd->Consulta("select * from trabajador t inner join asignacion_cargo ac on t.id_trabajador=ac.id_trabajador where t.estado_trabajador='HABILITADO' and ac.estado_asignacion='HABILITADO' ");

		while($registro_t = $bd->getFila($registros_t))
		{
			$fecha_anterior = date("m-(d+1)",$registro_t[fecha_ingreso]);
			if($fecha_anterior <= $fecha_actual)
			{
				$antiguedad_actual = antiguedad($registro_t[fecha_ingreso],$fecha_calculo);
			}

			$antiguedad_anterior = array($registro_t[antiguedad_anios],$registro_t[antiguedad_meses],$registro_t[antiguedad_dias]);
			$antiguedad = sumar_antiguedad($antiguedad_anterior,$antiguedad_actual);

			if($antiguedad[0]>=1 && $antiguedad[0]<=5)
			{
				$dias_vacacion = 15;
			}
			else
			if($antiguedad[0]>5 && $antiguedad[0]<=10)
			{
				$dias_vacacion = 20;
			}
			else
			if($antiguedad[0]>10)
			{
				$dias_vacacion = 30;

			}
			else
			if($antiguedad[0]==0)
			{
				$dias_vacacion = 0;
			}

			$datos_v = $bd->Consulta("select * from vacacion where id_trabajador=$registro_t[id_trabajador]");
			$dato_v = $bd->getFila($datos_v);
			$dias_utilizados = 0;
			if($dato_v[id_trabajador] == $registro_t[id_trabajador])
			{
				$vacacion->actualizar_vacacion($dato_v[id_vacacion], $antiguedad[0],$antiguedad[1],$antiguedad[2], $dias_vacacion, $fecha_calculo);
				//aqui esta el error ya que la funcion diferencia no esta botando un resultado correcto
				$diferencia = diferenciafechas($registro_t[fecha_ingreso],$fecha_actual);
				echo $diferencia[0]."-".$diferencia[1]."-".$diferencia[2]."<br>";
				$registros_vd = $bd->Consulta("select * from detalle_vacacion where id_vacacion=$dato_v[id_vacacion] and gestion_fin=$gestion_fin");
				if(empty($registros_vd) && ($diferencia[0]>=1 && ($diferencia[1]>=0 || $diferencia[2]>=2)))
				{
					echo 1;

					$result = $detalle_vacacion->registrar_detalle_vacacion($gestion_inicio, $gestion_fin, $fecha_calculo, $dias_vacacion, $dias_utilizados, $dato_v[id_vacacion]);
					if($result)
					{
						$result1 = $vacacion->modificar_vacacion_acumulada($dato_v[id_vacacion],$dias_vacacion);
						if($result1)
						{
							echo "Datos registrados.";
						}
						else
						{
							echo "Error al modificar dias acumulados";
						}
						
					}
					else
					{
						echo "Ocurri&oacute; un Error.";
					}
				}
			}
			else
			{
				$vacacion_acumulada = 0;
				$vacacion->registrar_vacacion($registro_t[fecha_ingreso],$antiguedad[0],$antiguedad[1],$antiguedad[2], $dias_vacacion, $vacacion_acumulada, $fecha_calculo, $registro_t[id_trabajador]);
				$diferencia = diferenciafechas($registro_t[fecha_ingreso],$fecha_actual);
				$registros_vd = $bd->Consulta("select * from vacacion_detalle where id_trabajador=$registro_t[id_trabajador]");
				$registro_vd = $bd->getFila($registros_vd);
				if($diferencia[0]>=1 && $diferencia[1]>=2)
				{
					$result = $detalle_vacacion->registrar_detalle_vacacion($gestion_inicio, $gestion_fin, $fecha_calculo, $dias_vacacion, $dias_utilizados, $registro_vd[id_vacacion]);
					if($result)
					{
						$result1 = $vacacion->modificar_vacacion_acumulada($registro_vd[id_vacacion],$dias_vacacion);
						if($result1)
						{
							echo "Datos registrados.";
						}
						else
						{
							echo "Error al modificar dias acumulados";
						}
						
					}
					else
					{
						echo "Ocurri&oacute; un Error.";
					}
				}	
				
			}
			
		}

?>
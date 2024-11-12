<?php
	include("modelo/salida.php");
    include("modelo/rol.php");
    
    $fecha_actual = date("Y-m-d");
    $mes = date("m");
    $salida = new salida();
    if($_SESSION[nivel] == "GUARDIA SEGURIDAD"){
    echo "<meta http-equiv='refresh' content='30'>";
    $registros = $bd->Consulta("SELECT * from salida s inner join vehiculo v on v.id_vehiculo=s.id_vehiculo inner join usuario u on u.id_usuario=s.id_usuario inner join tipo_salida ts on ts.id_tipo_salida=s.id_tipo_salida inner join trabajador t on u.id_trabajador=t.id_trabajador where s.fecha='$fecha_actual' and s.estado=0");  }  
    else {
        $registros = $bd->Consulta("SELECT * from salida s inner join vehiculo v on v.id_vehiculo=s.id_vehiculo inner join usuario u on u.id_usuario=s.id_usuario inner join tipo_salida ts on ts.id_tipo_salida=s.id_tipo_salida inner join trabajador t on u.id_trabajador=t.id_trabajador where u.id_usuario=$_SESSION[id_usuario] and MONTH( s.fecha) =$mes");
        $horas_solicitadas = $bd->Consulta("SELECT * FROM salida s INNER JOIN vehiculo v ON v.id_vehiculo = s.id_vehiculo INNER JOIN usuario u ON u.id_usuario = s.id_usuario INNER JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida INNER JOIN trabajador t ON u.id_trabajador = t.id_trabajador WHERE s.estado =2 AND u.id_usuario =$_SESSION[id_usuario] AND ts.nombre = 'PARTICULAR' AND MONTH( s.fecha ) =$mes");
        $n=0;
        while($registro_hor = $bd->getFila($horas_solicitadas)) 
        {
            $datos_hora[$n++]=$registro_hor[tiempo_solicitado];
        }
       
    }
    $horas=intval(sumar_horas($datos_hora)/60);
    $minutos= intval(sumar_horas($datos_hora)%60);
?>
<h2>Lista de Salida Solicitadas</h2>
<?php if($_SESSION[nivel]!="GUARDIA SEGURIDAD") { ?>
    <h2>Tiempo total particular solicitado: <u> <?php  echo $horas; ?> horas </u> y <u> <?php  echo $minutos; ?> minutos </u> </h2>
<?php } ?>

<h2>

<?php 
    if($_SESSION[nivel] != "GUARDIA SEGURIDAD"){
        if(sumar_horas($datos_hora)<120){
            echo "<a href='?mod=salida&pag=form_salida' class='btn btn-green btn-icon' style='float: right;'>
            Agregar Salida
            <i class='entypo-plus'></i>
            </a>";
        }
    }
?>

    <?php if($_SESSION[nivel] == "GUARDIA SEGURIDAD"){?>
    <a href="?mod=salida&pag=lista_proceso2" class="btn btn-blue btn-icon" style="float :right;">
        Solicitudes en Proceso
        <i class="entypo-check"></i>
    </a>
    <?php } ?>
</h2>
<br />        
<table class="table table-bordered datatable" id="table-1">
	<thead>
		<tr>
			<th>No</th>
			<th>Fecha</th>
            <th>Hora Salida</th>
            <th>Hora Retorno</th>
            <th>Tiempo Solicitado</th>
            <th>Direccion de Salida</th>
            <th>Motivo</th>
            <th>Vehiculo</th>
            <th>Tipo de Salida</th>

            <?php if($_SESSION[nivel] == "TRABAJADOR"){
                echo "<th>Estado</th>"; }else{
                echo "<th>Estado</th>";
            }
             ?>
            <th>Acciones</th>
		</tr>
	</thead>
	<tbody>
<?php
    $n = 0;
    
    while($registro = $bd->getFila($registros)) 
    {
            if(($_SESSION[nivel] != 'GUARDIA SEGURIDAD' && $registro[14] == 0)||$registro[14] == 3){
            $eliminar = "<a href='control/salida/eliminar.php?id=$registro[id_salida]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>"; 
        }
        else{
            $eliminar = '';
        } 
        $n++;
        echo "<tr>";        
            if ($_SESSION[nivel] == 'TRABAJADOR'){}
                
            echo utf8_encode("
                            <td>$n</td>
                            <td>$registro[9]</td>
                            <td>$registro[hora_salida]</td>
                            <td>$registro[hora_retorno]</td>
                            <td>$registro[tiempo_solicitado]</td>
                            <td>$registro[direccion_salida]</td>
                            <td>$registro[motivo]</td>
                            <td>$registro[18]-$registro[17]</td>
                            <td>$registro[36]</td>"
                        );
                        if($registro[14]==0){
                            echo "<td><span class='btn btn-orange btn-xs'>Pendiente</span></td>";
                        }
                        elseif ($registro[14]==1) {
                            echo "<td><span class='btn btn-warning btn-xs'>En Proceso</span></td>";
                        }
                        elseif ($registro[14]==3) {
                            echo "<td><span class='btn btn-info btn-xs'>ALMUERZO</span></td>";
                        }
                        else{
                            echo "<td><span class='btn btn-success btn-xs'>Realizado</span></td>";
                        }
                            
            if($_SESSION[nivel] != "GUARDIA SEGURIDAD"){
            echo "<td>
                    <a target='_blank' href='vista/reportes/visor_reporte.php?f=vista/salida/reporte_salida.php&id=$registro[id_salida]' class='btn btn-green btn-icon btn-xs'>Papeleta salida <i class='entypo-print'></i></a>
                    $eliminar
                    </td>";
            echo "</tr>";
            }
            else{
                echo "<td>
                <a href='control/salida/modificar_sol.php?id=$registro[id_salida]' class='accion btn btn-green btn-icon btn-xs'>Registrar Salida <i class='entypo-pencil'></i></a>
                </td>";
            }

    }	
?>
    </tbody>
	<tfoot>
        <tr>
			<th>No</th>
			<th>Fecha</th>
            <th>Hora retorno</th>
            <th>Hora salida</th>
            <th>Tiempo Solicitado</th>
            <th>Direccion de Salida</th>
            <th>Motivo</th>
            <th>Vehiculo</th>
            <th>Tipo de Salida</th>
            <?php if($_SESSION[nivel] == "TRABAJADOR"){
                echo "<th>Estado</th>";}else{
                    echo "<th>Estado</th>";
                }
            ?>
            <th>Acciones</th>
		</tr>
	</tfoot>
</table>

<?php
	$salida->__destroy();
?>
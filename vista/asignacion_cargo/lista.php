<?php include("modelo/asignacion_cargo.php");    
    $asignacion_cargo = new asignacion_cargo();
    $registros = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on t.id_trabajador=ac.id_trabajador order by CAST(ac.item as UNSIGNED) asc");    
?>
<h2>ASIGNACION DE CARGOS
    <a href="?mod=asignacion_cargo&pag=form_asignacion_cargo" class="btn btn-green btn-icon" style="float: right;">
    	Asignar cargo <i class="entypo-plus"></i>
    </a>
    <a target="_blank" href="vista/reportes/visor_reporte.php?f=vista/asignacion_cargo/planilla_asignacion_cargo_pdf.php" class="btn btn-info btn-icon" style="float: right; margin-right: 5px;">
        Planilla Puestos<i class="entypo-print"></i>
    </a>
</h2>
<br />
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
<thead>
  <tr>	
    <th>No</th>
	<th>Fecha ingreso</th>
	<th>Fecha salida</th>
    <th>Item</th>
    <th>Cargo</th>
    <th>Salario</th>
    <th>Trabajador</th>
    <th>Aportante AFP</th>
    <th>Sindicalizado</th>
    <th>Socio F.E.</th>
	<th>Estado asignaci&oacute;n</th>
    <th width="160">Acciones</th>
  </tr>
</thead>
<tbody>    
<?php
    $n = 0;
    while($registro = $bd->getFila($registros)) 
    {
        $n++;
        echo "<tr>";        
                  
        echo utf8_encode("	<td>$n</td><td>$registro[fecha_ingreso]</td><td>$registro[fecha_salida]</td><td>$registro[item]</td><td>$registro[cargo]</td><td>$registro[salario]</td><td> $registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</td>");
            if($registro[aportante_afp]==0)
            {
                echo "<td align='center'>NO</td>";
            }
            else
            {
                echo "<td align='center'>SI</td>";
            }
            if($registro[sindicato]==0)
            {
                echo "<td align='center'>NO</td>";
            }
            else
            {
                echo "<td align='center'>SI</td>";
            }
            if($registro[socio_fe]==0)
            {
                echo "<td align='center'>NO</td>";
            }
            else
            {
                echo "<td align='center'>SI</td>";
            }
        echo    "<td>$registro[estado_asignacion]</td>";
        echo "<td>
        	       <a href='?mod=asignacion_cargo&pag=editar_asignacion_cargo&id=$registro[id_asignacion_cargo]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                   <a href='?mod=asignacion_cargo&pag=estado_asignacion_cargo&id=$registro[id_asignacion_cargo]' class='btn btn-warning btn-icon btn-xs'>Dar Baja <i class='entypo-pencil'></i></a>
                   <a href='control/asignacion_cargo/eliminar.php?id=$registro[id_asignacion_cargo]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
      		  </td>";
        echo "</tr>";
    }	
?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>


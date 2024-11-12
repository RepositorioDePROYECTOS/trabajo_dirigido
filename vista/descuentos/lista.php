<?php include("modelo/descuentos.php"); 
    $gestion = $_REQUEST['gestion'];
    $mes = $_REQUEST['mes'];  
    $descuentos = new descuentos();
    $registros = $bd->Consulta("select * from descuentos d inner join asignacion_cargo ac on d.id_asignacion_cargo=ac.id_asignacion_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador where d.mes=$mes and d.gestion=$gestion");    
?>
<h2>DESCUENTOS PERIODO <?php echo $mes."/".$gestion;?>
    <a href="?mod=descuentos&pag=planilla_descuentos&mes=<?php echo $mes;?>&gestion=<?php echo $gestion;?>" class="btn btn-green btn-icon" style="float: right;">
    	Crear planilla<i class="entypo-plus"></i>
    </a>
    <a href="?mod=descuentos&pag=form_descuentos&mes=<?php echo $mes;?>&gestion=<?php echo $gestion;?>" class="btn btn-green btn-icon" style="float: right;margin-right: 5px;">
        Crear descuento individual<i class="entypo-plus"></i>
    </a>
    <a target="_blank" href="vista/reportes/visor_reporte.php?f=vista/descuentos/planilla_descuentos_pdf.php&mes=<?php echo $mes; ?>&gestion=<?php echo $gestion; ?>" class="btn btn-info btn-icon" style="float: right; margin-right: 5px;">
        Planilla descuentos<i class="entypo-print"></i>
    </a>
</h2>
<br />
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
    <thead>
    <tr>	
        <th>No</th>
        <th>Mes</th>
    	<th>Gestion</th>
    	<th>Trabajador</th>
        <th>Nombre descuento</th>
    	<th>Monto</th>
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
            echo utf8_encode("	<td>$n</td><td>$registro[mes]</td><td>$registro[gestion]</td><td>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</td><td>$registro[nombre_descuento]</td><td>$registro[monto]</td>");
            echo "<td>";
	           if($registro[nombre_descuento] == 'FONDO SOCIAL')
               {
                    echo "<a href='?mod=descuentos&pag=editar_descuentos_fs&id=$registro[id_descuentos]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>";
                }
                else
                {
                    echo "<a href='?mod=descuentos&pag=editar_descuentos&id=$registro[id_descuentos]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>";
                }
            echo "<a href='control/descuentos/eliminar.php?id=$registro[id_descuentos]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a></td>";
                       
                       
            echo "</tr>";
        }	
    ?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>
                    
                    
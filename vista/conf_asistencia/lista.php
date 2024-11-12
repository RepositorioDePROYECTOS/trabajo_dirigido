<?php include("modelo/conf_asistencia.php");    
    $conf_asistencia = new conf_asistencia();
    $registros = $bd->Consulta("SELECT * FROM conf_asistencia");    
?>
<h2>LISTA DE CONFIGURACIONES DE ASISTENCIA
    <a href="?mod=conf_asistencia&pag=form_conf_asistencia" class="btn btn-green btn-icon" style="float: right;">
    	Crear Assitencia <i class="entypo-plus"></i>
    </a>
</h2>
<br />
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
    <thead>
    <tr>	
        <th>No</th>
        <th>Nombre asistencia</th>
        <th>Entrada Mañana</th>
        <th>Salida Mañana</th>
        <th>Entrada Tarde</th>
        <th>Salida Tarde</th>
        <th>Estado</th>
        <th width="160">Acciones</th>
	</tr>
   </thead>
   <tbody>    
   <?php
        $n = 0;
        while($registro = $bd->getFila($registros)) 
        {
            $n++; ?>
            <tr>
                <td><?php echo $n; ?></td>
                <td><?php echo utf8_encode( $registro[nombre_asistencia] );?></td>
                <td><?php echo utf8_encode( $registro[inicio_manana] );?></td>
                <td><?php echo utf8_encode( $registro[fin_manana] );?></td>
                <td><?php echo utf8_encode( $registro[inicio_tarde] );?></td>
                <td><?php echo utf8_encode( $registro[fin_tarde] );?></td>
                <td><?php echo utf8_encode( $registro[estado] );?></td>
                <td>
                    <!-- <a href='?mod=conf_asistencias&pag=editar_conf_asistencias&id=<?php // echo $registro[id_conf_asistencias]; ?>' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a> -->
                    <a href='control/conf_asistencia/cambiar_estado.php?id=<?php echo $registro[id_conf_asistencia]; ?>' class='accion btn btn-info btn-icon btn-xs'>Cambiar Estado <i class='entypo-pencil'></i></a>
                    <a href='control/conf_asistencia/eliminar.php?id=<?php echo $registro[id_conf_asistencia]; ?>' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
                </td>
            </tr>
        <?php }	?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>
                    
                    
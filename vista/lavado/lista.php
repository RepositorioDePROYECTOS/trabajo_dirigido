<?php
	include("modelo/telefono.php");
    $telefono = new telefono();
    $registros = $bd->Consulta("select * from telefono te inner join cargo c on c.id_cargo=te.id_cargo left join trabajador t on te.id_trabajador=t.id_trabajador");
    
?>
<h2>Telefono

    <?php if($_SESSION[nivel] == "rrhh") {?>
    <a href="?mod=telefono&pag=form_telefono" class="btn btn-green btn-icon" style="float: right;">
    	Agregar telefono
    	<i class="entypo-plus"></i>
    </a>
    <?php } ?>
    
</h2>
<br>        
<table class="table table-bordered datatable" id="table-1">
	<thead>
		<tr>
			<th>No</th>
            <th>Cargo</th>
            <th>Telefono Interno</th>
			<th>Trabajador</th>
            <?php if($_SESSION[nivel] == "rrhh"){
                echo "<th>Acciones</th>";
            }?>
		</tr>
	</thead>
	<tbody>
<?php
    $n = 0;
    
    while($registro = $bd->getFila($registros))
    {
        $eliminar = "<a href='control/telefono/eliminar.php?id=$registro[id_telefono]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>";
        $editar = "<a href='?mod=telefono&pag=editar_telefono&id=$registro[id_telefono]&id_trabajador=$registro[id_trabajador]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>";
        $n++;
        echo "<tr>";        
                   
        echo utf8_encode("<td>$n</td><td width='250'>$registro[descripcion]</td><td style='text-align:center;'>$registro[telf_interno]</td><td style='text-align:center;'>$registro[nombres] $registro[apellido_paterno] $registro[apellido_materno]</td>");
        if($_SESSION[nivel] == "rrhh"){
            echo "<td width='170'>
        	       $editar
                   $eliminar           
      		  </td>";
        }
        echo "</tr>";
    }	
?>
    </tbody>
	<tfoot>
        <tr >
            <th style='text-align:center;'>No</th>
            <th style='text-align:center;'>Cargo</th>
            <th style='text-align:center;'>Telefono Interno</th>
			<th style='text-align:center;'>Trabajador</th>
            <?php 
                if($_SESSION[nivel] == "rrhh"){
                    echo "<th style='text-align:center;'>Acciones</th>";
                } ?>
            </tr>		
	</tfoot>
</table>
<?php
	$telefono->__destroy();
?>
<?php include("modelo/trabajador.php");    
    $trabajador = new trabajador();
    $registros = $bd->Consulta("select * from trabajador t left join formacion f on t.id_trabajador=f.id_trabajador");    
?>
<h2>TRABAJADORES
    <a href="?mod=trabajador&pag=form_trabajador" class="btn btn-green btn-icon" style="float: right;">
    	Crear Trabajador <i class="entypo-plus"></i>
    </a>
</h2>
<br />
<div class="table-responsive">
<table class="table table-bordered datatable" id="table-1">
<thead>
  <tr>	
    <th>No</th>
	<th>Ci</th>
    <th>NUA</th>
	<th>Nombres</th>
	<th>Apellido Paterno</th>
    <th>Apellido Materno</th>
	<th>Direccion</th>
	<th>Sexo</th>
	<th>Nacionalidad</th>
	<th>Fecha nacimiento</th>
    <th>Grado</th>
    <th>Titulo</th>
    <th>Antiguedad</th>
	<th>Estado trabajador</th>
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
                  
        echo utf8_encode("	<td>$n</td><td>$registro[ci]</td><td>$registro[nua]</td><td>$registro[nombres]</td><td>$registro[apellido_paterno]</td><td>$registro[apellido_materno]</td><td>$registro[direccion]</td><td>$registro[sexo]</td><td>$registro[nacionalidad]</td><td>$registro[fecha_nacimiento]</td><td>$registro[grado_formacion]</td><td>$registro[titulo_academico]</td><td>$registro[antiguedad_anios] a&ntilde;os<br>$registro[antiguedad_meses] mes(es)<br>$registro[antiguedad_dias] dias</td><td>$registro[estado_trabajador]</td>");
        echo "<td>
        	       <a href='?mod=trabajador&pag=editar_trabajador&id=$registro[0]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                   <a href='control/trabajador/eliminar.php?id=$registro[0]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
      		  </td>";
        echo "</tr>";
    }	
?>
    </tbody>
	<tfoot>                            		
	</tfoot>
</table>
</div>


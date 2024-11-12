<?php
include("modelo/participante.php");
$registros = $bd->Consulta("SELECT * from postulante");
?>
<h2>Postulantes
    <a href="?mod=participante&pag=form_participante" class="btn btn-green btn-icon" style="float: right;">
        Registrar participante<i class="entypo-plus"></i>
    </a>
</h2>
<br />
<div class="table-responsive">
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th>No</th>
                <th>Nombres</th>
                <th>CI</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th width="100">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $n = 0;
            while ($registro = $bd->getFila($registros)) {
                $n++;
                echo "<tr>";

                echo utf8_encode("<td>$n</td>
            <td>$registro[nombre_postulante]</td>
            <td>$registro[ci_postulante]</td>
            <td>$registro[telefono_postulante]</td>
            <td>$registro[correo_postulante]</td>");
                echo "<td>
                   <a href='?mod=participante&pag=editar_participante&id=$registro[id_postulante]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>
                       <a href='control/participante/eliminar.php?id=$registro[id_postulante]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
      		  </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
</div>
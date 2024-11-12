<?php 
include("modelo/comisiones.php");
include("modelo/preguntas.php");

$bd = new Conexion(); // Asegurar que la conexión esté disponible

// Consulta para obtener las comisiones y los nombres de las convocatorias habilitadas o indefinidas
$consultaComisiones = $bd->Consulta("SELECT c.id_convocatoria, conv.nombre_convocatoria, c.id_trabajador
                                     FROM comision c 
                                     LEFT JOIN convocatorias conv ON c.id_convocatoria = conv.id_convocatoria 
                                     WHERE conv.estado IN (1, 3)
                                     GROUP BY c.id_convocatoria");
?>

<h2>Preguntas y respuestas
    <?php if ($_SESSION['nivel'] == "rrhh") { ?>
        <a href="?mod=comisiones&pag=form_comision" class="btn btn-green btn-icon" style="float: right;">
            Crear Comisión
            <i class="entypo-plus"></i>
        </a>
    <?php } ?>
</h2>
<h4>Registre preguntas y respuestas</h4>
<br>
<table class="table table-bordered datatable" id="table-1">
    <thead>
        <tr>
            <th>No</th>
            <th>Nombre Convocatoria</th>
            <th width="150">Miembros</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $n = 0;

        while ($registro = $bd->getFila($consultaComisiones)) {
            $n++; ?>
            <tr>
                <td><?php echo $n?></td>
                <td><?php echo utf8_encode($registro['nombre_convocatoria'])?></td>
                <td>
                    <?php
                    $consultaComisionesTrabajadores = $bd->Consulta("SELECT c.id_convocatoria, conv.nombre_convocatoria, c.id_trabajador, CONCAT(t.nombres, ' ', t.apellido_paterno, ' ', t.apellido_materno) as trabajador
                    FROM comision c 
                    LEFT JOIN convocatorias conv ON c.id_convocatoria = conv.id_convocatoria 
                    INNER JOIN trabajador as t ON t.id_trabajador = c.id_trabajador
                    WHERE c.id_convocatoria=$registro[id_convocatoria]");
                    while($registros = $bd->getFila($consultaComisionesTrabajadores)){
                    ?>
                    <a href="?mod=evaluacion&pag=tipo_preguntas&id_convocatoria=<?php echo $registros['id_convocatoria']?>&id_trabajador=<?php echo $registros['id_trabajador']?>" class='btn btn-info btn-icon btn-xs'>
                        <?php echo utf8_encode($registros['trabajador'])?><i class='entypo-plus'></i>
                    </a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Eliminar la sección de preguntas, ya que la redirección hace que no sea necesaria -->

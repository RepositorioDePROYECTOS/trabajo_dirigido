<?php
include("modelo/partidas.php");

$partidas = new Partidas();

$registros = $partidas->get_all("");

?>
<h2>Partidas
    <a href="?mod=partidas&pag=form_partidas" class="btn btn-green btn-icon" style="float: right;">
        Agregar partidas
        <i class="entypo-plus"></i>
    </a>
</h2>
<br />
<table class="table table-bordered datatable" id="table-1">
    <thead>
        <tr>
            <th>No</th>
            <th>Codigo</th>
            <th>Descripcion</th>
            <th>Tipo Partida</th>
            <th width="50px">Tipo de Gastos</th>
            <!-- <th>Estado</th> -->
            <th>Glosa</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $n = 0;
        foreach ($registros as $key => $registro) {
            $n++; ?>
            <tr>

                <td> <?php echo $n; ?></td>
                <td> <?php echo strtoupper(utf8_encode($registro[codigo_partida])); ?></td>
                <td> <?php echo strtoupper(utf8_encode($registro[nombre_partida])); ?></td>
                <td> <?php echo strtoupper(utf8_encode($registro[tipo_partida])); ?></td>
                <td>
                    <?php 
                        $conceptos = $bd->Consulta("SELECT concepto_partida, tipo_detalle_partida FROM partidas_detalle WHERE id_partida = $registro[id_partida]");
                        while($concepto = $bd->getFila($conceptos)) {
                            echo utf8_encode('<ul>
                            <li>'. $concepto[concepto_partida] .'</li>
                            </ul>');
                        }
                        ?>
                </td>
                <td> <?php echo strtoupper(utf8_encode($registro[glosa_partida])); ?></td>
                <!-- <td> <?php // echo ( $registro[estado_partida] == 1 ) ? 'ACTIVO' : 'INACTIVO'; ?></td> -->
                <td>
                    <a href='?mod=partidas&pag=editar_partidas&id=<?php echo $registro[id_partida]; ?>' class='btn btn-info btn-icon btn-xs' style='float: right; margin-right: 20px;'>
                        Editar 
                        <i class='entypo-pencil'></i>
                    </a>
                    <br />
                    <a href='control/partidas/eliminar.php?id=<?php echo $registro[id_partida]; ?>' class='accion btn btn-danger btn-icon btn-xs' style='float: right; margin-right: 20px;'>
                        Eliminar
                        <i class='entypo-cancel'></i>
                    </a>
                    <br />
                    <a href='?mod=partidas&pag=index_glosa&id_partida=<?php echo $registro[id_partida]; ?>' class='btn btn-green btn-icon btn-xs' style='float: right; margin-right: 20px;'>
                        A&ntilde;adir Concepto<i class='entypo-plus'></i></a>
                </td>
            </tr>

        <?php }    ?>
    </tbody>
    <tfoot>
        <tr>
            <th>No</th>
            <th>Codigo</th>
            <th>Descripcion</th>
            <th>Tipo Partida</th>
            <th width="50px">Tipo de Gastos</th>
            <!-- <th>Estado</th> -->
            <th>Glosa</th>
            <th>Acciones</th>
        </tr>
    </tfoot>
</table>

<?php
$estante->__destroy();
?>
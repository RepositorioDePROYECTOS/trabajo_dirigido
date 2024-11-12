<?php
include("modelo/partidas_detalle.php");
$id_partida = $_GET[id_partida];
// echo $id_partida;
$registros = $bd->Consulta("SELECT * FROM partidas_detalle WHERE id_partida = $id_partida");

?>
<h2>Partidas
    <a href="?mod=partidas&pag=index" class="btn btn-danger btn-icon" style="float: right;">
        Atras
        <i class="entypo-back"></i>
    </a>
    <a href="?mod=partidas&pag=form_partidas_detalles&id=<?php echo $id_partida; ?>" class="btn btn-green btn-icon" style="float: right;">
        Agregar Concepto
        <i class="entypo-plus"></i>
    </a>
</h2>
<br />
<table class="table table-bordered datatable" id="table-1">
    <thead>
        <tr>
            <th>No</th>
            <th>Concepto</th>
            <th>Tipo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $n = 0;
        while ($registro = $bd->getFila($registros)) {
            $n++; ?>
            <tr>

                <td> <?php echo $n; ?></td>
                <td> <?php echo strtoupper(utf8_encode($registro[concepto_partida])); ?></td>
                <td> <?php echo strtoupper(utf8_encode($registro[tipo_detalle_partida])); ?></td>
                <td>
                    <!-- <a href='?mod=partidas&pag=editar_partidas_detalle&id=<?php echo $registro[id_partida]; ?>' class='btn btn-info btn-icon btn-xs' style='float: right; margin-right: 20px;'>
                        Editar
                        <i class='entypo-pencil'></i>
                    </a>
                    <br /> -->
                    <a href='control/partidas_detalle/eliminar.php?id=<?php echo $registro[id_partida]; ?>' class='accion btn btn-danger btn-icon btn-xs' style='float: right; margin-right: 20px;'>
                        Eliminar
                        <i class='entypo-cancel'></i>
                    </a>
                </td>
            </tr>

        <?php }    ?>
    </tbody>
    <tfoot>
        <tr>
            <th>No</th>
            <th>Concepto</th>
            <th>Tipo</th>
            <th>Acciones</th>
        </tr>
    </tfoot>
</table>
<?php
$date = date('Y-m-d');
$user_id = $_SESSION[id_usuario];
$tipo_de = $bd->Consulta("SELECT * FROM usuario WHERE id_usuario = $user_id");
$t_personal = $bd->getFila($tipo_de);
print_r($t_personal);
if ($t_personal[id_eventual] == null || $t_personal[id_eventual] == '') {
    $data = $bd->Consulta("SELECT t.ci, t.nombres, t.apellido_paterno, t.apellido_materno, m.timestamp
    FROM marcaciones_zkteco as m
    INNER JOIN trabajador as t ON t.ci = m.user_id
    INNER JOIN usuario as u ON u.id_trabajador = t.id_trabajador
    WHERE u.id_usuario = $user_id");
} else {
    $data = $bd->Consulta("SELECT t.ci, t.nombres, t.apellido_paterno, t.apellido_materno, m.timestamp
    FROM marcaciones_zkteco as m
    INNER JOIN eventual as t ON t.ci = m.user_id
    INNER JOIN usuario as u ON u.id_eventual = t.id_eventual
    WHERE u.id_usuario = $user_id");
}

?>
<h2>Lista de Asistencia Hasta <?php echo date('d-m-Y'); ?></h2></br></br>

</h2>
<br /><br /><br />
<div class="table-responsive">
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th>#</th>
                <th>Trabajador</th>
                <th>Fecha</th>
                <th width="160">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $n = 1;
            while ($info = $bd->getFila($data)) { ?>

                <tr>
                    <td> <?php echo $n ?> </td>
                    <td> <?php echo utf8_encode($info[nombres] . " " . $info[apellido_paterno] . " " . $info[apellido_materno]) ?> </td>
                    <td> <?php echo date("d-m-Y H:i:s", strtotime($info[timestamp])) ?> </td>
                    <td>-</td>
                </tr>

            <?php $n++;
            } ?>
        </tbody>
        <tfoot>
            <tr>
                <th>#</th>
                <th>Trabajador</th>
                <th>Fecha</th>
                <th width="160">Acciones</th>
            </tr>
        </tfoot>
    </table>
</div>
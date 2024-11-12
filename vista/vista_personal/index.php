<?php
include("modelo/trabajador.php");
$trabajador = new trabajador();
$registros = $bd->Consulta("SELECT * FROM trabajador t LEFT JOIN formacion f ON t.id_trabajador=f.id_trabajador");
?>
<h2>
    TRABAJADORES
</h2>
<br />
<div class="table-responsive">
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th>No</th>
                <th>Nombre Completo/th>
                <th>Ci</th>
                <th>Estado trabajador</th>
                <th width="160">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $n = 0;
            while ($registro = $bd->getFila($registros)) {
                $n++; ?>
                <tr>
                    <td>
                        <?php echo $n; ?>
                    </td>
                    <td>
                        <?php echo utf8_encode($registro[nombres]) . " " . utf8_encode($registro[apellido_paterno]) . " " . utf8_encode($registro[apellido_materno]); ?>
                    </td>
                    <td>
                        <?php echo $registro[ci]; ?>
                    </td>
                    <td>
                        <?php echo $registro[estado_trabajador]; ?>
                    </td>
                    <td>
                        <a href='?mod=vista_personal&pag=detalles_file&id=<?php echo $registro[id_trabajador] ?>' class='btn btn-info btn-icon'>
                        Ver 
                        <i class='entypo-eye'></i>
                    </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
</div>

<script type="text/javascript">
    const formatoMoneda = new Intl.NumberFormat('es-BO', {
        style: 'currency',
        currency: 'BOB'
    });

    jQuery(document).ready(function($) {
        $(document).ready(function() {
            $(".nav-item a").click(function(event) {
                event.preventDefault();
                var opcion = $(this).attr('href');
                console.log(opcion);
                $('.nav-item').removeClass('active');
                $(this).parent().addClass('active');

                $('.tab-pane').hide();
                $(opcion).show();
            });
        });
    });
</script>
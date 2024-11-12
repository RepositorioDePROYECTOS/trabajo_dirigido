<?php


$id_solicitud_servicio = $_GET[id_solicitud_servicio];

// almacenar el id de la solicitud en los detalles de la solicitud


$registros_m =  $bd->Consulta("select * from servicio");
$registros_s = $bd->Consulta("select * from detalle_servicio where id_solicitud_servicio=$id_solicitud_servicio");
$registros_solicitud = $bd->Consulta("select * from solicitud_servicio where id_solicitud_servicio=$id_solicitud_servicio");
$registro_sol = $bd->getFila($registros_solicitud);

?>


<h2>Detalle de la solicitud</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-4">
                <label for="trabajador" class="control-label">Nombre Solicitante</label>
                <input type="text" name="5rabajador" id="trabajador" class="form-control required text" placeholder=''
                    value='<?php echo utf8_encode($registro_sol[nombre_solicitante]);?>' disabled />
            </div>
            <div class="col-sm-4">
                <label for="fecha_registro" class="control-label">Fecha de solicitud</label>
                <input type="text" name="fecha_registro" id="fecha_registro" class="form-control required datepicker"
                    placeholder='' value='<?php echo date("Y-m-d", strtotime($registro_sol[fecha_solicitud]));?>'
                    disabled />
            </div>
            <?php if($_SESSION[nivel] == 'ADQUISICION' && $registro_sol[estado_solicitud_servicio] == 'ADQUISICION' ){ ?>
            <div class="col-sm-4 bg-success">
                <label for="fecha_despacho" class="control-label">Fecha de registro de adquisicion</label>
                <input type="text" name="fecha_despacho" id="fecha_despacho" class="form-control required datepicker"
                    value='<?php echo $registro_sol[fecha_registro_adquisiciones];?>' disabled />
            </div>
            <?php } ?>
        </div>
        <hr>
        <label for="detalle_servicioes" class="col-sm-12 control-label">Detalle de servicioes solicitados</label>
        <div class="row">
            <div id="detalle_servicioes" class="col-sm-12 table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nro</th>
                            <th>Descripci&oacute;n</th>
                            <th>Unidad de medida</th>
                            <th>Cantidad Solicitada</th>
                            <th>Precio_unitario</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody id="tbl_body">
                        <!-- realizar una consulta de acuerdo a la solicitud si tiene servicioes $solicitud->servicioes->count() e imprimir aqui -->
                        <?php
                        while($registro_s = $bd->getFila($registros_s)) 
                        {
                            $n++;
                            echo "<tr>";        
                            echo utf8_encode("
                                    <td>$n</td>
                                    <td>$registro_s[descripcion]</td>
                                    <td>$registro_s[unidad_medida]</td>
                                    <td>$registro_s[cantidad_solicitada]</td>
                                    <td>$registro_s[precio_unitario]</td>"
                                );
                            echo "<td>".$registro_s[precio_unitario]*$registro_s[cantidad_solicitada]."</td>";
                            echo "</tr>"; 
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="form-group">
            
            <?php if($_SESSION[nivel] == 'GERENTE ADMINISTRATIVO'){ ?>
            <div class="col-sm-12">
                <?php if($registro_sol[estado_solicitud_servicio] == 'SOLICITADO'){ ?>
                <a href='control/solicitud_servicio_ampe/aprobar_solicitud_ampe.php?id=<?= $id_solicitud_servicio;?>'
                    class='accion btn btn-green btn-icon' style='float: right; margin-left: 5px;'>Aprobar <i
                        class='entypo-pencil'></i></a>
                <button class='accion btn btn-red btn-icon view_modal_rechazar' style='float: right; margin-left: 5px;'>
                    Rechazar <i class='entypo-cancel'></i></button>
                <button type="button" class="btn btn-default pull-right btn-icon" data-dismiss="modal">Cerrar <i
                        class='entypo-cancel'></i></button>
                <?php } ?>
            </div>
            <?php } ?>

            <?php if($_SESSION[nivel] == 'PRESUPUESTO'){ ?>
            <div class="col-sm-12">
                <?php if($registro_sol[estado_solicitud_servicio] == 'APROBADO'){ ?>
                <a href='control/solicitud_servicio_ampe/presupuestar_ampe.php?id=<?= $id_solicitud_servicio;?>&estado=PRESUPUESTADO'
                    class='accion btn btn-green btn-icon' style='float: right; margin-left: 5px;'>Con Presupuesto <i
                        class='entypo-pencil'></i></a>
                <a href='control/solicitud_servicio_ampe/presupuestar_ampe.php?id=<?= $id_solicitud_servicio;?>&estado=SIN PRESUPUESTO'
                    class='accion btn btn-danger btn-icon' style='float: right; margin-left: 5px;'>Sin Presupuesto <i
                        class='entypo-pencil'></i></a>
                <button type="button" class="btn btn-default pull-right btn-icon" data-dismiss="modal">Cerrar <i
                        class='entypo-cancel'></i></button>
                <?php } ?>
            </div>
            <?php } ?>

            <?php if($_SESSION[nivel] == 'ADQUISICION'){ ?>
            <div class="col-sm-12">
                <?php if($registro_sol[estado_solicitud_servicio] == 'PRESUPUESTADO'){ ?>
                <a href='control/solicitud_servicio_ampe/solicitud_adquisicion_ampe.php?id=<?= $id_solicitud_servicio;?>&estado=ADQUISICION'
                    class='accion btn btn-green btn-icon' style='float: right; margin-left: 5px;'>En adquisición <i
                        class='entypo-pencil'></i></a>
                <?php }elseif($registro_sol[estado_solicitud_servicio] == 'ADQUISICION'){ ?>
                    <a href='control/solicitud_servicio_ampe/solicitud_adquisicion_ampe.php?id=<?= $id_solicitud_servicio;?>&estado=COMPRADO'
                    class='accion btn btn-blue btn-icon' style='float: right; margin-left: 5px;'>Comprado <i
                        class='entypo-pencil'></i></a>
                <?php } ?>
                <button type="button" class="btn btn-default pull-right btn-icon" data-dismiss="modal">Cerrar <i
                        class='entypo-cancel'></i></button>
            </div>
            <?php } ?>

        </div>
    </div>
</div>
<!-- **************** MODAL PARA RECHAZAR LA SOLICITUD *************************** -->
<div class="modal fade" id="modal_rechazar_solicitud" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="margin-top:100px">
        <div class="modal-content">
            <div class="modal-header ">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="title"><b>Rechazar Solicitud de servicio</b></h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <label for="fecha_registro" class="col-sm-2 control-label">Fecha de solicitud</label>
                    <div class="col-sm-2">
                        <input type="text" name="fecha_registro" id="fecha_registro"
                            class="form-control required datepicker" placeholder=''
                            value='<?php echo date("d-m-Y", strtotime($registro_sol[fecha_solicitud]));?>' readonly />
                    </div>
                    <label for="trabajador" class="col-sm-2 control-label">Nombre Solicitante</label>
                    <div class="col-sm-6">
                        <input type="text" name="trabajador" id="trabajador" class="form-control required text"
                            placeholder='' value='<?php echo utf8_encode($registro_sol[nombre_solicitante]);?>'
                            readonly />
                    </div>
                </div>
                <div class="row">
                    <form name="frm_solicitud_servicio" id="frm_solicitud_servicio"
                        action="control/solicitud_servicio_ampe/rechazar_solicitud_ampe.php" method="post" role="form"
                        class="validate_edit form-horizontal form-groups-bordered">

                        <label for="observacion" class="col-sm-2 control-label">Observacion</label>
                        <div class="col-sm-10">

                            <textarea name="observacion" id="observacion" class="form-control required text" cols="120"
                                rows="3" placeholder='Escriba el motivo del rechazo u observación...'></textarea>
                        </div>
                        <hr>
                        <input type="hidden" name="id_solicitud_servicio" value="<?php echo $id_solicitud_servicio ; ?>"
                            <hr>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-danger pull-right btn-icon"
                                    style="margin-right: 25px;margin-top:10px">Rechazar <i
                                        class='entypo-cancel'></i></button>
                                <button type="button" class="btn btn-default pull-right btn-icon"
                                    style="margin-right: 25px;margin-top:10px" data-dismiss="modal">Cerrar <i
                                        class='entypo-cancel'></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
    jQuery(".view_modal_edit").live("click", function(e) {
        e.preventDefault();
        var param = $(this).attr('href');
        var dir = "modal_index_ajax.php" + param;
        jQuery('#modal_editar_detalle').modal('show', {
            backdrop: 'static'
        });
        jQuery('#modal_editar_detalle').draggable({
            handle: ".modal-header"
        });
        jQuery("#modal_editar_detalle .modal-body").load(dir, function(res) {
            if (res) {
                var titulo = jQuery('#modal_editar_detalle .modal-body h2').html();
                jQuery('#modal_editar_detalle .modal-body h2').hide();
                jQuery('#modal_editar_detalle .modal-body br').hide();
                jQuery('#modal_editar_detalle .modal-title').html(titulo);
                jQuery('#modal_editar_detalle .modal-body .cancelar').hide();
            }
        });
    });

    $(".despachar_solicitud").click(function(e) {
        e.preventDefault();
        var dir = $(this).attr("href");
        var fecha_despacho = $("#fecha_despacho").val();
        var url_despacho = dir + "&fecha_despacho=" + fecha_despacho;
        console.log(url_despacho);
        jConfirm("¿Est&aacute; seguro de realizar la acci&oacute;n?", "Mensaje", function(resp) {
            if (resp) {
                $.ajax({
                    type: "GET",
                    url: url_despacho,
                }).done(function(response) {
                    var data = JSON.parse(response);
                    console.log(response)
                    if (data.success === true) {
                        jAlert("Solicitud despachada con exito", "Approval", function(
                            resp) {
                            window.location.reload();
                        });
                    } else {
                        jAlert("Error. no se despacho solicitud", "Mensaje")
                    }
                })
                // window.location.reload();
                // $(location).attr('href',dir);
            }
        });

    });

    jQuery(".view_modal_rechazar").live("click", function() {
        jQuery("#modal_rechazar_solicitud").modal('show');
    });
});
</script>
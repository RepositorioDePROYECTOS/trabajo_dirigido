<?php

$tipo = $_GET[tipo];
$id = $_GET[id];
// echo "SELECT id_derivacion  FROM derivaciones WHERE id_solicitud=$id AND tipo_solicitud='$tipo'";

$fecha              = "";
$nombre_solicitante = "";
$existencia         = "";
$tipo_buscador      = "";
$nro_solicitud      = "";
if ($tipo == 'material') {
    $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_material WHERE id_solicitud_material=$id");
    $registro_sol = $bd->getFila($registros_solicitud);
    $tipo_buscador = "ALMACENERO";
    $fecha = date("d-m-Y", strtotime($registro_sol[fecha_solicitud]));
    $nombre_solicitante = utf8_encode($registro_sol[nombre_solicitante]);
    $existencia = utf8_encode($registro_sol[existencia_material]);
    $nro_solicitud = $registro_sol[nro_solicitud_material];
} elseif ($tipo == 'activo') {
    $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_activo WHERE id_solicitud_activo=$id");
    $registro_sol = $bd->getFila($registros_solicitud);
    $tipo_buscador = "ACTIVOS";
    $fecha = date("d-m-Y", strtotime($registro_sol[fecha_solicitud]));
    $nombre_solicitante = utf8_encode($registro_sol[nombre_solicitante]);
    $existencia = utf8_encode($registro_sol[existencia_material]);
    $nro_solicitud = $registro_sol[nro_solicitud_activo];
} else {
    $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_servicio WHERE id_solicitud_servicio =$id");
    $registro_sol = $bd->getFila($registros_solicitud);
    $tipo_buscador = "SERVICIO";
    $fecha = date("d-m-Y", strtotime($registro_sol[fecha_solicitud]));
    $nombre_solicitante = utf8_encode($registro_sol[nombre_solicitante]);
    $existencia = utf8_encode($registro_sol[existencia_material]);
    $nro_solicitud = $registro_sol[nro_solicitud_servicio];
}

// 
$buscarTipoTrabajador = $bd->Consulta("SELECT 
    t.id_trabajador 
    FROM usuario u 
    INNER JOIN trabajador t ON t.id_trabajador = u.id_trabajador 
    WHERE u.id_usuario = $_SESSION[id_usuario]");

$id_trabajador = $bd->getFila($buscarTipoTrabajador);
$tipo_trabajador = "";
// print_r($id_trabajador);
if ($id_trabajador[id_trabajador]) {
    $tipo_trabajador = "ITEM";
} else {
    $tipo_trabajador = "EVENTUAL";
}
// echo $tipo_trabajador;
// 

$se_puede = $bd->Consulta("SELECT id_derivacion, estado_derivacion, id_trabajador  FROM derivaciones WHERE id_solicitud=$id AND tipo_solicitud='$tipo'");
$puede = $bd->getFila($se_puede);

if ($tipo_buscador == "SERVICIO") {
    $trabajadores = $bd->Consulta("SELECT 
        t.nombres, 
        t.apellido_paterno, 
        t.apellido_materno, 
        u.id_usuario 
        FROM usuario as u 
        INNER JOIN trabajador as t ON t.id_trabajador = u.id_trabajador");
    if ($puede) {
        $derivado_a = $bd->Consulta("SELECT 
            nombre_apellidos 
            FROM usuario 
            WHERE id_usuario=$puede[id_trabajador];");
        if (!empty($derivado_a)) {
            $derivado = $bd->getFila($derivado_a);
        }
    }
} else {
    $trabajadores = $bd->Consulta("SELECT u.nombre_apellidos, u.id_usuario 
        FROM usuario as u 
        INNER JOIN rol as r ON r.id_rol = u.id_rol 
        WHERE r.nombre_rol = '$tipo_buscador'");
    if ($puede) {
        $derivado_a = $bd->Consulta("SELECT nombre_apellidos 
            FROM usuario 
            WHERE id_usuario=$puede[id_trabajador];");
        if (!empty($derivado_a)) {
            $derivado = $bd->getFila($derivado_a);
        }
    }
}

?>
<h2>
    <button type="reset" class="btn btn-success cancelar pull-left">Volver&nbsp;<i class="entypo-back"></i></button>
</h2>
<br /><br><br>
<!-- <div class="panel panel-default panel-shadow" data-collapsed="0"> -->

<div class="panel-body">
    <h4>Fecha de Solicitud: <strong><?php echo $fecha; ?></strong></h4>
    <h4>Nombre Solicitante: <strong><?php echo $nombre_solicitante; ?></strong></h4>
    <h4>Tipo de Solicitud: <strong><?php echo strtoupper($tipo_buscador); ?></strong></h4>
    <?php if ($tipo == 'material') { ?>
        <h4>Existencia de material: <strong><?php echo  $existencia ?></strong></h4>
    <?php } ?>
    <?php if ($puede) { ?>
        <?php if ($puede[estado_derivacion] == 'solicitar') { ?>
            <div class="container">
                <a href="control/derivaciones/cambiar.php?id=<?php echo $puede[id_derivacion]; ?>&id_usuario=<?php echo $_SESSION[id_usuario] ?>&tipo_trabajador=<?php echo $tipo_trabajador; ?>" class=" eliminar_lista btn btn-primary mx-auto d-block" style="width: 300px;">Volver a Derivar</a>
            </div>
        <?php } elseif ($puede[estado_derivacion] == 'solicitado') { ?>
            <h4>Derivado A: <strong><?php echo $derivado[nombre_apellidos]; ?></A:strong>
            </h4>
            <h2> <strong>Ya derivo la SOLICITUD</strong></h2>
        <?php } ?>

    <?php } else { ?>
        <!-- action="control/derivaciones/insertar.php" -->
        <form method="post">
            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
            <input type="hidden" id="tipo_solicitud" name="tipo_solicitud" value="<?php echo $tipo; ?>">
            <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION[id_usuario] ?>">
            <input type="hidden" name="nro_solicitud" id="nro_solicitud" value="<?php echo $nro_solicitud ?>">
            <input type="hidden" name="tipo_trabajador" id="tipo_trabajador" value="<?php echo $tipo_trabajador ?>">
            <div class="form-group">
                <label for="id_trabajador" class="col-sm-3 control-label">Derivar A:</label>
                <div class="col-sm-6">
                    <select name="id_trabajador" id="id_trabajador" class="form-control required select2">
                        <option value="" selected>--SELECCIONE--</option>
                        <?php
                        if ($tipo_buscador == "SERVICIO") {
                            while ($trabajador = $bd->getFila($trabajadores)) {
                                echo utf8_encode(strtoupper("<option value='$trabajador[id_usuario]'>$trabajador[nombres] $trabajador[apellido_paterno] $trabajador[apellido_maerno]</option>"));
                            }
                        } else {
                            // echo "<option>$tipo_buscador</option>";
                            while ($trabajador = $bd->getFila($trabajadores)) {
                                echo utf8_encode("<option value='$trabajador[id_usuario]'>$trabajador[nombre_apellidos]</option>");
                            }
                        }
                        ?>

                    </select>
                </div>
            </div>
            <button type="button" class="btn btn-green btn-icon pull-right" id="agregar">
                Derivar <i class="entypo-plus"></i>
            </button>
        </form>
    <?php } ?>
</div>

<!-- </div> -->
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("a.eliminar_lista").click(function(e) {
            e.preventDefault();
            dir = $(this).attr("href");
            jConfirm("¿Est&aacute; seguro de realizar la acci&oacute;n?", "Mensaje", function(resp) {
                if (resp) {
                    $.ajax({
                        type: "GET",
                        url: dir,
                    }).done(function(response) {
                        var data = JSON.parse(response);
                        console.log(response)
                        if (data.success === true) {
                            jAlert("Solicitud realizada con exito", "Aceptar", function(
                                resp) {
                                window.location.reload();
                            });
                        } else {
                            jAlert(data.message, "Mensaje")
                        }
                    }).fail(function(response) {
                        console.log(response)
                    })
                }
            });

        });
        $('#agregar').click(function() {
            var id = $("#id").val();
            var tipo_solicitud = $("#tipo_solicitud").val();
            var id_trabajador = $("#id_trabajador").val();
            var id_usuario = $('#id_usuario').val();
            var nro_solicitud = $('#nro_solicitud').val();
            var tipo_trabajador = $('#tipo_trabajador').val();
            if (id_trabajador == null || id_trabajador == '') {
                jAlert("Error, No se selecciono a quien derivar!", "Mensaje")
            } else {
                $.ajax({
                    type: "POST",
                    url: "control/derivaciones/insertar.php",
                    data: {
                        'id': id,
                        'tipo_solicitud': tipo_solicitud,
                        'id_trabajador': id_trabajador,
                        'id_usuario': id_usuario,
                        'nro_solicitud': nro_solicitud,
                        'tipo_trabajador': tipo_trabajador
                    }
                }).done(function(response) {
                    var data = JSON.parse(response);
                    console.log(response)
                    if (data.success === true) {
                        window.location.reload();
                        jAlert(data.message, "Mensaje")
                    } else {
                        jAlert(data.message, "Mensaje")
                    }
                }).fail(function(response) {
                    console.log(response)
                })
            }
            console.log('ID: ' + id + " Tipo Solicitud: " + tipo_solicitud + " ID Trabajador: " + id_trabajador + ' id_usuario: ' + id_usuario + ' nro_solicitud: ' + nro_solicitud + ' tipo_trabajador: ' + tipo_trabajador);
        })
    })
</script>
<style>
    .container {
        /* display: flex; */
        justify-content: center;
    }
</style>
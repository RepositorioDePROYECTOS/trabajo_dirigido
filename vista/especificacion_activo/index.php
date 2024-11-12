<?php
include("modelo/detalle_activo.php");
$id_detalle_activo = $_GET[id];
// echo $id_detalle_activo;
$detalle_activos = $bd->Consulta("SELECT * FROM detalle_activo WHERE id_detalle_activo=$id_detalle_activo");
$detalle_activo = $bd->getFila($detalle_activos);
$n = 1;
$especificaciones = $bd->Consulta("SELECT * FROM especificaciones_activo WHERE id_detalle_activo=$id_detalle_activo");
// $a = $bd->getFila($especificaciones);
// var_dump($a);
?>
<div class="panel panel-default panel-shadow" data-collapsed="0">

    <div class="panel-body">
        <h2>
            <button type="reset" class="btn btn-success cancelar pull-left">Volver&nbsp;<i class="entypo-back"></i></button> <br><br>
            Detalle Activo Formulario CM - 01
        </h2>
        <h3>Descripcion: <strong><?php echo utf8_encode($detalle_activo[descripcion]) ?></strong></h3>
        <h3>Cantidad: <strong><?php echo utf8_encode($detalle_activo[cantidad_solicitada]) ?></strong><strong> (<?php echo utf8_encode($detalle_activo[unidad_medida]) ?></strong> )</h3>
        <h3>Precio: <strong><?php echo utf8_encode($detalle_activo[precio_unitario]) ?></strong></h3>

        <!-- Formulario para insercion de estas especificaciones -->
        <!-- action="control/especificaciones_activo/insertar_especificacion_activo.php"  -->
        <form method="POST" ole="form" class="validate_venta form-horizontal form-groups-bordered">
            <input type="hidden" name="id_detalle_activo" id="id_detalle_activo" value="<?php echo $id_detalle_activo ?>">
            <div class="form-group">
                <label for="detallar" class="col-sm-1 control-label">Detallar</label>
                <div class="col-sm-11">
                    <!-- ckeditor -->
                <textarea name="detallar" id="detallar" class="form-control"></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-green btn-icon pull-right" id="guardar" onclick="guardarDatos()">
                Agregar <i class="entypo-plus"></i>
            </button>
        </form>
    </div>
    <div id="detalle_activoes" class="col-sm-12 table-responsive">
        <h3>Expecificaciones Registradas</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Descripcion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($registro = $bd->getFila($especificaciones)) {
                    echo utf8_encode("
                            <tr align='center'>
                            <td>$n</td>
                            <td>$registro[especificacion]</td>
                            <td><a href='control/especificaciones_activo/eliminar_especificacion_activo.php?id=$registro[id_especificaciones_activo]' class='eliminar_registro btn btn-red btn-icon btn-xs'>Quitar <i class='entypo-cancel'></i></a></td>
                            </tr>
                        ");
                    $n++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    CKEDITOR.config.defaultLanguage = 'en';
    CKEDITOR.config.contentsLangDirection = 'ltr';
    CKEDITOR.config.entities = false;
    CKEDITOR.config.entities_greek = false;
    CKEDITOR.config.entities_latin = false;
    CKEDITOR.config.forceSimpleAmpersand = true;
    window.addEventListener("load", function() {
        event.preventDefault()
        var btnEliminar = document.querySelectorAll('.eliminar_registro');
        for (var i = 0; i < btnEliminar.length; i++) {
            btnEliminar[i].addEventListener("click", function(event) {
                event.preventDefault();
                var url = this.getAttribute('href');
                fetch(url, {
                        method: 'GET'
                    })
                    .then(response => {
                        if (response.ok) {
                            location.reload();
                        } else {
                            throw new Error('Error en la eliminación');
                        }
                    })
                    .catch(error => console.error(error));
            });
        }
    });

    function guardarDatos() {
        // e.preventDefault();
        var id = document.getElementById('id_detalle_activo').value;
        // var detallar = CKEDITOR.instances.detallar.getData();;
        var detallar = document.getElementById('detallar').value;
        // alert(id + "   " + detallar);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'control/especificaciones_activo/insertar_especificacion_activo.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                location.reload(); // recarga la página después de que los datos hayan sido guardados
            } else {
                console.log('Error al guardar los datos');
            }
        };
        xhr.send('id_detalle_activo=' + encodeURIComponent(id) + '&detallar=' + encodeURIComponent(detallar));
    }
</script>
<?php
$registros = $bd->Consulta("SELECT * from unidad_de_medida");

?>
<h2>Unidades
    <!-- <a href="?mod=telefono&pag=form_telefono" class="btn btn-green btn-icon" style="float: right;">
    	Agregar telefono
    	<i class="entypo-plus"></i>
    </a>
     -->
    <button type="button" class="btn btn-green btn-icon" data-toggle="modal" data-target="#myModal" id="agregar" style="float: right;">Agregar Unidad<i class="entypo-plus"></i></button>
</h2>
<br>
<div class="table-responsive">
    <table class="table table-bordered datatable" id="table-1" style="width: 100%;">
        <thead>
            <tr>
                <th style="width: 15%;">No</th>
                <th style="width: 70%;">Descripcion</th>
                <th style="width: 15%;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $n = 0;

            while ($registro = $bd->getFila($registros)) {
                $n++; ?>
                <tr align="center">
                    <td><?php echo $n; ?></td>
                    <td width='250'><?php echo utf8_encode($registro[descripcion]); ?></td>
                    <td>
                        <button data-id="<?php echo $registro[id_unidad_medida]; ?>" id="btn_editar" class="btn btn-info btn-icon btn-xs editar-button" data-toggle="modal" data-target="#editar_unidad">Editar <i class='entypo-pencil'></i></button>
                        <a href='control/unidad_mediad/eliminar.php?id=<?php echo $registro[id_unidad_medida]; ?>' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th>No</th>
                <th>Descripcion</th>
                <th>Acciones</th>
            </tr>
        </tfoot>
    </table>
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <br />
                <div class="panel panel-default panel-shadow" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Crear nueva Unidad
                        </div>
                    </div>
                    <div class="panel-body">
                        <form name="frm_entidad" id="frm_entidad" action="" method="post" role="form" class="validate form-horizontal form-groups-bordered">
                            <div class="form-group">
                                <label for="insert_descripcion" class="col-sm-3 control-label">Descripcion</label>
                                <div class="col-sm-5">
                                    <input type="text" name="insert_descripcion" id="insert_descripcion" class="form-control required text" />
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-5">
                                    <button type="button" id="registrar" class="btn btn-info">Registrar</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <!-- <button type="reset" class="btn btn-default cancelar">Cancelar</button> -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div> -->
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="editar_unidad" tabindex="-1" role="dialog" aria-labelledby="editar_unidadLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editar_unidadLabel">Editar Unidad</h5>
            </div>
            <div class="modal-body">
                <form name="frm_entidad" id="frm_entidad" action="" method="post" role="form" class="validate form-horizontal form-groups-bordered">
                    <div class="form-group">
                        <label for="edit_descripcion" class="col-sm-3 control-label">Descripcion</label>
                        <div class="col-sm-5">
                            <input type="text" name="edit_descripcion" id="edit_descripcion" class="form-control required text" />
                            <input type="hidden" name="edit_id_unidad" id="edit_id_unidad" class="form-control required text" />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <button type="button" id="actualizar" class="accion btn btn-info">Actualizar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.getElementById("registrar").addEventListener("click", function() {
        agregar_detalles();
        // alert("Agregar_detalles");
    });

    function agregar_detalles() {
        var descripcion = document.getElementById("insert_descripcion").value; // Obtener el valor del campo
        var datos = [{
            name: "descripcion",
            value: descripcion // Crear un objeto con el valor
        }];
        console.table(datos);
        
        var url = "control/unidad_mediad/store.php";

        var data = new FormData();
        data.append('descripcion', descripcion);

        fetch(url, {
                method: 'POST',
                body: data
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success === true) {
                    descripcion.value = "";
                    window.location.reload();
                } else {
                    // alert(data.message);
                    jAlert(data.message, "Mensaje")
                }
            })
            .catch(error => {
                console.log(error);
            });
    }

    // Obtén todos los botones con ID que comienza con "editar_"
    const editButtons = document.querySelectorAll('.editar-button');

    // Agrega un evento de clic a cada botón
    editButtons.forEach((button) => {
        button.addEventListener("click", function() {
            document.getElementById('edit_descripcion').value = "";
            document.getElementById('edit_id_unidad').value = "";
            // Obtén el data-id del botón clicado
            const idUnidadMedida = button.getAttribute("data-id");
            console.log(idUnidadMedida);
            fetch('control/unidad_mediad/edit.php?id=' + idUnidadMedida)
            .then(response => response.json())
            .then(data => {
                if (data.success === true) {
                    // console.log(data);
                    document.getElementById('edit_descripcion').value = data.data;
                    document.getElementById('edit_id_unidad').value = idUnidadMedida;
                } else {
                    console.log(data.message);
                }
            })
            .catch(error => console.error(error));
        });
    });
    const btn_actualizar = document.querySelectorAll("#actualizar");
    btn_actualizar.forEach((btn_actualizar) => {
        btn_actualizar.addEventListener("click", function() {
            var id = document.getElementById('edit_id_unidad').value;
            var unidad = document.getElementById('edit_descripcion').value;
            console.log("Datos: " + id + " - " + unidad);
            var url = "control/unidad_mediad/update.php";
            var data = new URLSearchParams();
            data.append('descripcion', unidad);
            data.append('id_unidad_medida', id);

            fetch(url, {
                    method: 'POST',
                    body: data
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.success === true) {
                        window.location.reload();
                    } else {
                        // alert(data.message);
                        jAlert(data.message, "Mensaje")
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        });
    });
</script>
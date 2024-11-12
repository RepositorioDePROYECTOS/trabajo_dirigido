<?php
include("modelo/participante.php");
$registros = $bd->Consulta("SELECT * from convocatoria ORDER BY id_convocatoria DESC");
$registros_participantes = $bd->Consulta("SELECT * FROM postulante ORDER BY id_postulante DESC");
?>
<h2>Entrevista
    <a href="?mod=entrevista&pag=form_entrevista" class="btn btn-green btn-icon" style="float: right;">
        Registrar Entrevista<i class="entypo-plus"></i>
    </a>
</h2>
<br />
<div class="table-responsive">
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th>No</th>
                <th>Nombres</th>
                <th>Mes</th>
                <th>Gestion</th>
                <th width="100">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $n = 0;
            while ($registro = $bd->getFila($registros)) {
                $n++; ?>
                <tr>
                    <td><?php echo $n; ?></td>
                    <td><?php echo utf8_encode($registro[nombre_convocatoria]); ?></td>
                    <td><?php echo utf8_encode($registro[mes_convocatoria]); ?></td>
                    <td><?php echo utf8_encode($registro[gestion_convocatoria]); ?></td>
                    <td>
                        <a href='?mod=entrevista&pag=editar_entrevista&id=<?php echo utf8_encode($registro[id_convocatoria]); ?>' class='btn btn-info btn-icon btn-xs'>
                            Editar <i class='entypo-pencil'></i>
                        </a>
                        <a href='control/entrevista/eliminar.php?id=<?php echo utf8_encode($registro[id_convocatoria]); ?>' class='accion btn btn-red btn-icon btn-xs'>
                            Eliminar <i class='entypo-cancel'></i>
                        </a>
                        <a id="buscar_preguntas" data-id="<?php echo $registro[id_convocatoria] ?>" data-toggle="modal" data-target="#boton-modal_preguntas" class='buscar_preguntas btn btn-success btn-icon btn-xs'> Agregar Preguntas <i class="entypo-plus"></i></a>
                        <a data-id="<?php echo $registro[id_convocatoria] ?>" data-toggle="modal" data-target="#boton-modal_candidatos" class='modal_candidatos btn btn-orange btn-icon btn-xs'> Agregar Participantes <i class="entypo-plus"></i></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
</div>
<div class="modal fade" id="boton-modal_preguntas" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">Cerrar&nbsp;&times;</button>
                <h4 class="modal-title" id="titulo">Preguntas</h4>
            </div>
            <div class="modal-body">
                <form method="post" class="validate_preguntas form-horizontal form-groups-bordered">
                    <input type="hidden" name="id_convocatoria" id="id_convocatoria">
                    <div class="form-group">
                        <label for="enunciado_preguntas" class="col-sm-3 control-label">Enunciado de la preguntas</label>
                        <div class="col-sm-9">
                            <input type="text" name="enunciado_preguntas" id="enunciado_preguntas" class="form-control required text" placeholder='' />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="calificacion_preguntas" class="col-sm-3 control-label">Calificacion de la preguntas</label>
                        <div class="col-sm-9">
                            <input type="number" min="0" name="calificacion_preguntas" id="calificacion_preguntas" class="form-control required text" placeholder='' />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="send_questions btn btn-info">Registrar</button> 
                            <!-- <button type="reset" class="btn btn-default cancelar">Cancelar</button> -->
                        </div>
                    </div>
                </form>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered datatable" id="table-1">
                        <thead>
                            <th>Nombre de la pregunta</th>
                            <th>Calificacion ponderada</th>
                            <th>Acciones</th>
                        </thead>
                        <tbody id="tblPreguntas">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="boton-modal_candidatos" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">Cerrar&nbsp;&times;</button>
                <h4 class="modal-title" id="titulo">Participantes</h4>
            </div>
            <div class="modal-body">
                <form method="post" class="validate_preguntas form-horizontal form-groups-bordered">
                    <input type="hidden" name="id_convocatoria" id="id_convocatoria">
                    <div class="form-group">
                        <label for="id_participante" class="col-sm-3 control-label">Enunciado de la preguntas</label>
                        <div class="col-sm-9">
                            <!-- <input type="text" name="id_participante" id="id_participante" class="form-control required text" placeholder='' /> -->
                            <select name="id_participante" id="id_participante[]" multiple="multtiple" class="form-control required select2 multiple">
                                <option value="" disabled selected>__ Seleccione __</option>
                                <?php while($data = $bd->getFila($registros_participantes)) {?>
                                    <option value="<?php echo $data[id_postulante]?>"><?php echo utf8_encode($data[nombre_postulante])?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="send_supports btn btn-info">Registrar</button> 
                            <!-- <button type="reset" class="btn btn-default cancelar">Cancelar</button> -->
                        </div>
                    </div>
                </form>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered datatable" id="table-1">
                        <thead>
                            <th>Nombre Participante</th>
                            <th>CI</th>
                            <th>Telefono</th>
                            <th>Correo</th>
                            <th>Acciones</th>
                        </thead>
                        <tbody id="tblParticipantes">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function($) {
        $(".buscar_preguntas").click(function() {
            var dataId = $(this).attr('data-id');
            // alert(dataId)
            asignarPreguntas(dataId);
        });
        
        $(".send_questions").click(function() {
            addQuestions();
        });
        
        $(".send_supports").click(function() {
            var dataId = $(this).attr('data-id');
            sendAssitants(dataId);
        });

        function asignarPreguntas(id) {
            document.getElementById("id_convocatoria").value = id;
            var id_convocatoria = id;
            var url = 'control/entrevista/lista_preguntas.php';
            fetch(url + '?id=' + id_convocatoria)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.success === true) {
                        let tabla2 = '<tbody>';
                        data.info.forEach(detalle => {
                            tabla2 += `<tr align='center'>
                                <td>${decodeURIComponent(detalle.enunciado_preguntas)}</td>
                                <td>${decodeURIComponent(detalle.calificacion_preguntas)}</td>
                                <td>
                                    <a href='control/entrevista/eliminar_preguntas.php?id=${decodeURIComponent(detalle.id)}' class='accion btn btn-red btn-icon btn-xs'>
                                        Eliminar <i class='entypo-cancel'></i>
                                    </a>
                                </td>`
                                ;
                            tabla2 += `</tr>`;
                        })
                        tabla2 += '</tbody>';
                        document.getElementById('tblPreguntas').innerHTML = tabla2;
                    }
                })
                .catch(error => console.error(error));
        }

        function addQuestions() {
            // event.preventDefault();
            var id = document.getElementById('id_convocatoria').value;
            var enunciado_preguntas = document.getElementById('enunciado_preguntas').value;
            var calificacion_preguntas = document.getElementById('calificacion_preguntas').value;
            // var url = "control/entrevista/insertar_preguntas.php";
            var url = "control/entrevista/insertar_preguntas.php";
            if (id == '' && enunciado_preguntas == '' && calificacion_preguntas == '') {
                jAlert("Datos necesarios.", "Mensaje", function(reso) {
                    $("#enunciado_preguntas").focus();
                    $("#calificacion_preguntas").focus();
                });
            } else {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        'id_convocatoria': id,
                        'enunciado_preguntas': enunciado_preguntas,
                        'calificacion_preguntas': calificacion_preguntas
                    }
                }).done(function(response) {
                    var data = JSON.parse(response);
                    console.log(response)
                    if (data.success === true) {
                        // window.location.reload();
                        asignarPreguntas(id)
                    } else {
                        jAlert(data.message, "Mensaje")
                    }
                }).fail(function(response) {
                    console.log(response)
                })
            }

        };

        function sendAssitants(id) {
            const id_participante = Array.from(document.querySelectorAll('#id_participante option:checked')).map(option => option.value);
            var datos = new FormData();
            datos.append('id_convocatoria', id)
            id_participante.forEach(responsable => {
                datos.append('id_postulante[]', responsable);
            });
            console.log(datos);
            alert(datos)
            fetch(ruta, {
                method: 'POST',
                body: datos
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
        }
    });
</script>
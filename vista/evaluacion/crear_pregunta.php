<?php
include("modelo/preguntas.php");

// Asegúrate de que el ID del miembro se reciba correctamente
$miembro_id = security($_GET['id_miembro']);
$preguntas = new Preguntas();

// Obtener las comisiones y convocatorias
$convocatorias = $bd->Consulta("SELECT * FROM convocatorias WHERE Estado IN (1, 3)");

// Inicializar variables para los IDs
$id_comision = isset($_GET['id_comision']) ? security($_GET['id_comision']) : null;
$id_convocatoria = isset($_GET['id_convocatoria']) ? security($_GET['id_convocatoria']) : null;

// Si no se recibe id_comision, obtenerlo desde la base de datos
if (empty($id_comision)) {
    $comision_data = $bd->Consulta("SELECT id_comision, id_convocatoria FROM comision ");
    if ($comision_data && count($comision_data) > 0) {
        $id_comision = $comision_data[0]['id_comision'];
        $id_convocatoria = $comision_data[0]['id_convocatoria'];
    } else {
        echo "<script>alert('No se encontró ninguna comisión asociada a este miembro.')</script>";
        exit;
    }
}

// Verificar si se envió el formulario para registrar preguntas
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Registro de preguntas
    $preguntas_insertadas = array();
    for ($i = 1; $i <= 10; $i++) {
        if (!empty($_POST["pregunta_$i"]) && !empty($_POST["tipo_respuesta_$i"])) {
            $pregunta = $_POST["pregunta_$i"];
            $tipo_respuesta = $_POST["tipo_respuesta_$i"];
            $id_comision = $_POST['id_comision'];
            $id_convocatoria = $_POST['id_convocatoria'];

            // Registrar la pregunta
            $id_pregunta = $preguntas->registrar_pregunta($id_comision, $miembro_id, $id_convocatoria, $pregunta, $tipo_respuesta);

            if ($id_pregunta) {
                $preguntas_insertadas[] = $id_pregunta;

                // Manejo de opciones según el tipo de respuesta
                if ($tipo_respuesta == "multiple") {
                    for ($j = 1; $j <= 4; $j++) {
                        if (!empty($_POST["opcion_{$i}_$j"])) {
                            $respuesta = $_POST["opcion_{$i}_$j"];
                            $correcta = ($_POST["respuesta_correcta_$i"] == $j) ? 1 : 0;
                            $preguntas->insertar_respuesta_opcion($id_pregunta, $respuesta, $correcta);
                        }
                    }
                } elseif ($tipo_respuesta == "verdadero_falso") {
                    $respuesta_vf = array("Verdadero", "Falso");
                    for ($k = 0; $k < 2; $k++) {
                        $correcta = ($k == $_POST["respuesta_correcta_vf_$i"]) ? 1 : 0;
                        $preguntas->insertar_respuesta_opcion($id_pregunta, $respuesta_vf[$k], $correcta);
                    }
                } elseif ($tipo_respuesta == "abierta") {
                    $preguntas->insertar_respuesta_abierta($id_pregunta, $id_convocatoria);
                }
            }
        }
    }

    if (!empty($preguntas_insertadas)) {
        echo "<script>alert('Preguntas registradas con éxito.')</script>";
    } else {
        echo "<script>alert('Error al registrar las preguntas.');</script>";
    }
}
?>

<h2>Crear Preguntas para el Miembro</h2>
<div class="panel panel-default panel-shadow" data-collapsed="0">
    <div class="panel-heading">
        <div class="panel-title">Registrar Preguntas</div>
    </div>
    <div class="panel-body">
        <form name="frm_preguntas" id="frm_preguntas" action="" method="post" class="validate form-horizontal form-groups-bordered">
            
            <div class="form-group">
                <label for="id_convocatoria" class="col-sm-3 control-label">Convocatoria</label>
                <div class="col-sm-5">
                    <select name="id_convocatoria" id="id_convocatoria" class="form-control" required onchange="actualizarComision(this.value)">
                        <option value="">Selecciona una Convocatoria</option>
                        <?php
                        while ($conv = mysql_fetch_array($convocatorias)) {
                            echo "<option value='{$conv['id_convocatoria']}' data-comision='{$conv['id_comision']}'>{$conv['nombre_convocatoria']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            
            <input type="hidden" name="id_comision" id="id_comision" value="">

            <div id="preguntas_container">
                <div class="pregunta" id="pregunta_1">
                    <div class="form-group">
                        <label for="pregunta_1" class="col-sm-3 control-label">Pregunta 1</label>
                        <div class="col-sm-5">
                            <input type="text" name="pregunta_1" id="pregunta_1" class="form-control" placeholder="Escribe la pregunta 1" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tipo_respuesta_1" class="col-sm-3 control-label">Tipo de Respuesta</label>
                        <div class="col-sm-5">
                            <select name="tipo_respuesta_1" id="tipo_respuesta_1" class="form-control" onchange="showOptions(this.value, 1)" required>
                                <option value="">Selecciona el tipo</option>
                                <option value="multiple">Múltiple</option>
                                <option value="verdadero_falso">Verdadero/Falso</option>
                                <option value="abierta">Abierta</option>
                            </select>
                        </div>
                    </div>
                    <div id="opciones_1" style="display:none;">
                        <?php for ($j = 1; $j <= 4; $j++): ?>
                            <div class="form-group">
                                <label for="opcion_1_<?php echo $j; ?>" class="col-sm-3 control-label">Opción <?php echo $j; ?></label>
                                <div class="col-sm-5">
                                    <input type="text" name="opcion_1_<?php echo $j; ?>" id="opcion_1_<?php echo $j; ?>" class="form-control" placeholder="Escribe la opción <?php echo $j; ?>" />
                                </div>
                            </div>
                        <?php endfor; ?>
                        <div class="form-group">
                            <label for="respuesta_correcta_1" class="col-sm-3 control-label">Respuesta Correcta</label>
                            <div class="col-sm-5">
                                <select name="respuesta_correcta_1" id="respuesta_correcta_1" class="form-control">
                                    <option value="">Selecciona la opción correcta</option>
                                    <?php for ($j = 1; $j <= 4; $j++): ?>
                                        <option value="<?php echo $j; ?>">Opción <?php echo $j; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" onclick="addPregunta()" class="btn btn-default">Agregar otra pregunta</button>
            <br /><br />
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    <button type="submit" class="btn btn-success">Registrar Preguntas</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    function actualizarComision(id_convocatoria) {
        var selectConvocatoria = document.getElementById('id_convocatoria');
        var optionSelected = selectConvocatoria.options[selectConvocatoria.selectedIndex];
        var id_comision = optionSelected.getAttribute('data-comision');
        document.getElementById('id_comision').value = id_comision;
    }

    function showOptions(tipo, numero) {
        var opcionesDiv = document.getElementById('opciones_' + numero);
        if (tipo === "multiple") {
            opcionesDiv.style.display = "block";
        } else if (tipo === "verdadero_falso") {
            opcionesDiv.style.display = "block";
        } else {
            opcionesDiv.style.display = "none";
        }
    }

    function addPregunta() {
        var container = document.getElementById('preguntas_container');
        var totalPreguntas = container.children.length + 1;

        if (totalPreguntas <= 10) {
            var nuevaPregunta = document.getElementById('pregunta_1').cloneNode(true);
            nuevaPregunta.id = 'pregunta_' + totalPreguntas;
            
            var inputs = nuevaPregunta.getElementsByTagName('input');
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].id = inputs[i].name = inputs[i].name.replace('_1_', '_' + totalPreguntas + '_');
                inputs[i].value = '';
            }
            
            var selects = nuevaPregunta.getElementsByTagName('select');
            for (var j = 0; j < selects.length; j++) {
                selects[j].id = selects[j].name = selects[j].name.replace('_1', '_' + totalPreguntas);
                selects[j].selectedIndex = 0;
            }
            
            container.appendChild(nuevaPregunta);
        } else {
            alert('Solo puedes agregar hasta 10 preguntas.');
        }
    }
</script>

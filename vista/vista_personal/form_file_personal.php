<?php 
    $id = security($_GET[id]);
    $datos_personales = $bd->Consulta("SELECT nombres, apellido_paterno, apellido_materno FROM trabajador WHERE id_trabajador = $id");
    $datos = $bd->getFila($datos_personales);
?>
<h2>Registrar Nuevo</h2>
<h3>Para: <i><?php echo utf8_encode($datos[nombres]) . " " . utf8_encode($datos[apellido_paterno]) . " " . utf8_encode($datos[apellido_materno]);?></i></h3>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
    <div class="panel-heading">
        <div class="panel-title">
            Solicitud de Vacaci&oacute;n
        </div>
    </div>
    <div class="panel-body">
        <form action="control/control_personal/subir_file.php" class="validate form-horizontal form-groups-bordered">
            <div class="row">
                <div class="form-group">
                    <input type="hidden" name="id_trabajador_registro" id="id_trabajador_registro" value="<?php echo $id; ?>">
                    <input type="hidden" id="seleccion_actual" name="seleccion_actual">
                </div>
                <div class="form-group">
                    <label for="tipo_registro" class="col-sm-2 control-label">Tipo de Registro</label>
                    <div class="col-sm-10">
                        <select name="tipo_registro" id="tipo_registro" class="form-control required select">
                            <option value="" selected disabled>__SELECCIONE__</option>
                            <option value="hoja_vida">Hoja de Vida</option>
                            <option value="documentos_personales">Documentos Personales</option>
                            <option value="cursos">Cursos</option>
                            <option value="experiencia">Experiencia</option>
                            <option value="memorandun">Memorandun</option>
                            <option value="comunicacion_interna">Comunicacion Interna</option>
                            <option value="otros_documentos">Otros Documentos</option>
                            <option value="contratos">Contratos</option>
                            <option value="afiliaciones">Afiliaciones</option>
                        </select>
                    </div>
                </div>
                <div id="tipoDocumentosPersonales">
                    <div class="form-group">
                        <label for="detalleDP" class="col-sm-2 control-label">Tipo de Documentos</label>
                        <div class="col-sm-10">
                            <select name="detalleDP" id="detalleDP" class="form-control select">
                                <option value="" selected disabled>__SELECCIONE__</option>
                                <option value="ci">CI</option>
                                <option value="Carnet de Asegurado">Carnet de Asegurado</option>
                                <option value="Certificado de Nacimiento">Certificado de Nacimiento</option>
                                <option value="Libreta de Servicio Militar">Libreta de Servicio Militar</option>
                                <option value="Estado Civil">Estado Civil</option>
                                <option value="Ficha Personal">Ficha Personal</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="tipoDocumentosSap">
                    <div class="form-group">
                        <label for="detalleSAP" class="col-sm-2 control-label">Tipo de Documento</label>
                        <div class="col-sm-10">
                            <select name="detalleSAP" id="detalleSAP" class="form-control select">
                                <option value="" selected disabled>__SELECCIONE__</option>
                                <option value="Declaracion Jurada">Declaracion Jurada</option>
                                <option value="Solvencia Fiscal">Solvencia Fiscal</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="tipoContratos">
                    <div class="form-group">
                        <label for="detalleContratos" class="col-sm-2 control-label">Tipo de Documento</label>
                        <div class="col-sm-10">
                            <select name="detalleContratos" id="detalleContratos" class="form-control select">
                                <option value="" selected disabled>__SELECCIONE__</option>
                                <option value="Consultoria">Consultoria</option>
                                <option value="Eventual">Eventual</option>
                                <option value="Permanente">Permanente</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="tipoAfiliacionesDoc">
                    <div class="form-group">
                        <label for="detalleAfiliaciones" class="col-sm-2 control-label">Tipo de Documento</label>
                        <div class="col-sm-10">
                            <select name="detalleAfiliaciones" id="detalleAfiliaciones" class="form-control select">
                                <option value="" selected disabled>__SELECCIONE__</option>
                                <option value="gestora">Gestora</option>
                                <option value="Ministerio de Trabajo">Ministerio de Trabajo</option>
                                <option value="Bajas Caja Cordes">Bajas Caja Cordes</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="tipoMemorandun">
                    <div class="form-group">
                        <label for="fechaInicioMemorandun" class="col-sm-2 control-label">Fecha Inicio</label>
                        <div class="col-sm-4">
                            <input type="date" name="fechaInicioMemorandun" id="fechaInicioMemorandun" class="form-control">
                        </div>
                        <label for="fechaFinMemorandun" class="col-sm-2 control-label">Fecha Fin</label>
                        <div class="col-sm-4">
                            <input type="date" name="fechaFinMemorandun" id="fechaFinMemorandun" class="form-control">
                        </div>
                    </div>
                </div>
                <div id="tipoComunicacionInterna">
                    <div class="form-group">
                        <label for="fechaInicioComunicacionInterna" class="col-sm-2 control-label">Fecha Inicio</label>
                        <div class="col-sm-4">
                            <input type="date" name="fechaInicioComunicacionInterna" id="fechaInicioComunicacionInterna" class="form-control">
                        </div>
                        <label for="fechaFinComunicacionInterna" class="col-sm-2 control-label">Fecha Fin</label>
                        <div class="col-sm-4">
                            <input type="date" name="fechaFinComunicacionInterna" id="fechaFinComunicacionInterna" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="file" class="col-sm-2 control-label">Registrar Nuevo Archivo</label>
                    <div class="col-sm-10">
                        <input type="file" accept=".pdf" class="form-control" name="file" id="file">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-info">Registrar</button>
                        <button type="reset" class="btn btn-default cancelar">Cancelar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        $("#tipo_registro").change(function() {
            var seleccion = $(this).val();
            $("#seleccion_actual").val(seleccion);
        });

        // Vista de los inputs por categorias
        $(document).ready(function() {
            $('#tipoDocumentosPersonales, #tipoDocumentosSap, #tipoContratos, #tipoAfiliacionesDoc, #tipoMemorandun, #tipoComunicacionInterna').hide();

            $('#tipo_registro').change(function() {
                var seleccion = $(this).val();
                console.log(seleccion);
                $('#tipoDocumentosPersonales, #tipoDocumentosSap, #tipoContratos, #tipoAfiliacionesDoc, #tipoMemorandun, #tipoComunicacionInterna').hide();

                if (seleccion == 'documentos_personales') {
                    $('#tipoDocumentosPersonales').show();
                } else if (seleccion == 'otros_documentos') {
                    $('#tipoDocumentosSap').show();
                } else if (seleccion == 'contratos') {
                    $('#tipoContratos').show();
                } else if (seleccion == 'afiliaciones') {
                    $('#tipoAfiliacionesDoc').show();
                } else if (seleccion == 'memorandun') {
                    $('#tipoMemorandun').show();
                } else if (seleccion == 'comunicacion_interna') {
                    $('#tipoComunicacionInterna').show();
                }
            });
        });
    });
</script>
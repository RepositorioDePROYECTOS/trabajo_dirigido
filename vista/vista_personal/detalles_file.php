<?php
$id = $_GET[id];
$consulta_hoja_vida = $bd->Consulta("SELECT * FROM files WHERE id_trabajador = $id AND tipo = 'HOJA DE VIDA' ORDER BY id_file DESC");
$consulta_documentos_personales = $bd->Consulta("SELECT * FROM files WHERE id_trabajador = $id AND tipo = 'DOCUMENTOS PERSONALES' ORDER BY id_file DESC");
$consulta_cursos = $bd->Consulta("SELECT * FROM files WHERE id_trabajador = $id AND tipo = 'CURSOS' ORDER BY id_file DESC");
$consulta_experiencia_laboral = $bd->Consulta("SELECT * FROM files WHERE id_trabajador = $id AND tipo = 'EXPERIENCIA LABORAL' ORDER BY id_file DESC");
$consulta_memorandun = $bd->Consulta("SELECT * FROM files WHERE id_trabajador = $id AND tipo = 'MEMORANDUN' ORDER BY id_file DESC");
$consulta_comunicacion_interna = $bd->Consulta("SELECT * FROM files WHERE id_trabajador = $id AND tipo = 'COMUNICACION INTERNA' ORDER BY id_file DESC");
$consulta_otros_documentos = $bd->Consulta("SELECT * FROM files WHERE id_trabajador = $id AND tipo = 'OTROS DOCUMENTOS' ORDER BY id_file DESC");
$consulta_contratos = $bd->Consulta("SELECT * FROM files WHERE id_trabajador = $id AND tipo = 'CONTRATOS' ORDER BY id_file DESC");
$consulta_afiliaciones = $bd->Consulta("SELECT * FROM files WHERE id_trabajador = $id AND tipo = 'AFILIACIONES' ORDER BY id_file DESC");
$datos_personales = $bd->Consulta("SELECT nombres, apellido_paterno, apellido_materno FROM trabajador WHERE id_trabajador = $id");
$datos = $bd->getFila($datos_personales);
?>
<h2>
    Registros
    <h3>Nombre: <i><?php echo utf8_encode($datos[nombres]) . " " . utf8_encode($datos[apellido_paterno]) . " " . utf8_encode($datos[apellido_materno]);?></i></h3>
    <a 
        href="?mod=vista_personal&pag=form_file_personal&id=<?php echo $id; ?>" 
        class="btn btn-success btn-icon" 
        style="float: right;"
    >
        Agregar
        <i class="entypo-plus"></i>
    </a>
    <a 
        href="?mod=vista_personal&pag=index" 
        class="btn btn-danger btn-icon" 
        style="float: right;"
        >
        Atras
        <i class="entypo-back"></i>
    </a>
</h2>
<br />
<hr>
<input type="hidden" name="id_trabajador" id="id_trabajador" value="<?php echo $id; ?>">
<div class="table-responsive">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <!-- <li class="nav-item" role="presentation">
            <button class="nav-link btn-info active" id="pills-guardar-tab" data-toggle="pill" data-target="#pills-guardar" type="button" role="tab" aria-controls="pills-guardar" aria-selected="false">Registrar Nuevo</button>
        </li> -->
        <!-- <li class="nav-item" role="presentation">
            <button class="nav-link btn-info active" id="pills-inicio-tab" data-toggle="pill" data-target="#pills-inicio" type="button" role="tab" aria-controls="pills-inicio" aria-selected="true">Detalles</button>
        </li> -->
        <li class="nav-item" role="presentation">
            <button class="nav-link btn-info active" id="pills-hoja-vida-tab" data-toggle="pill" data-target="#pills-hoja-vida" type="button" role="tab" aria-controls="pills-hoja-vida" aria-selected="true">Hoja de Vida</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link btn-info" id="pills-documentos-personales-tab" data-toggle="pill" data-target="#pills-documentos-personales" type="button" role="tab" aria-controls="pills-documentos-personales" aria-selected="true">Documentos Personales</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link btn-info" id="pills-cursos-tab" data-toggle="pill" data-target="#pills-cursos" type="button" role="tab" aria-controls="pills-cursos" aria-selected="false">Cursos</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link btn-info" id="pills-experiencia-tab" data-toggle="pill" data-target="#pills-experiencia" type="button" role="tab" aria-controls="pills-experiencia" aria-selected="false">Experiencia</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link btn-info" id="pills-memorandun-tab" data-toggle="pill" data-target="#pills-memorandun" type="button" role="tab" aria-controls="pills-memorandun" aria-selected="false">Memorandun</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link btn-info" id="pills-comunicacion-interna-tab" data-toggle="pill" data-target="#pills-comunicacion-interna" type="button" role="tab" aria-controls="pills-comunicacion-interna" aria-selected="false">Comunicacion Interna</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link btn-info" id="pills-otros_documentos-tab" data-toggle="pill" data-target="#pills-otros_documentos" type="button" role="tab" aria-controls="pills-otros_documentos" aria-selected="false">Otros Documentos</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link btn-info" id="pills-contratos-tab" data-toggle="pill" data-target="#pills-contratos" type="button" role="tab" aria-controls="pills-contratos" aria-selected="false">Contratos</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link btn-info" id="pills-afiliaciones-tab" data-toggle="pill" data-target="#pills-afiliaciones" type="button" role="tab" aria-controls="pills-afiliaciones" aria-selected="false">Afiliaciones</button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane active" id="pills-hoja-vida" role="tabpanel" aria-labelledby="pills-hoja-vida-tab">
            <h3>Registros Hoja de Vida</h3>
            <div>
                <table class="table table-bordered datatable">
                    <thead>
                        <th>N</th>
                        <th>Tipo</th>
                        <th>Fecha Registro</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody id="tabla_hoja_vida">
                        <?php
                        $n = 1;
                        while ($registros = $bd->getFila($consulta_hoja_vida)) { 
                            $fecha = $registros[fecha_creacion];
                            $fecha      = str_replace(' ', '_', $fecha); // Reemplazar espacios con "_"
                            $fecha      = str_replace(':', '-', $fecha);?>
                            <tr>
                                <td><?php echo $n; ?></td>
                                <td>Hoja de Vida</td>
                                <td><?php echo date("d-m-Y", strtotime($registros[fecha_creacion])); ?></td>
                                <td>
                                    <a href="files/hoja_vida/<?php echo $registros[id_trabajador] . "_HOJA_DE_VIDA_" . $fecha ?>.pdf" target="_blank" class="btn btn-info pull-right">
                                        Ver
                                        <i class='entypo-eye'></i>
                                    </a>
                                    <a href='control/control_personal/eliminar_file.php?id=<?php echo $registros[id_file] ?>' class='accion btn btn-red pull-right'>
                                        Eliminar 
                                        <i class='entypo-cancel'></i>
                                    </a>
                                </td>
                            </tr>
                        <?php $n++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-documentos-personales" role="tabpanel" aria-labelledby="pills-documentos-personales-tab">
            <h3>Registros Documentos Personales</h3>
            <div>
                <table class="table table-bordered datatable">
                    <thead>
                        <th>N</th>
                        <th>Tipo</th>
                        <th>Especificación</th>
                        <th>Fecha Registro</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody id="tabla_documentos_personales">
                        <?php
                        $n = 1;
                        while ($registros = $bd->getFila($consulta_documentos_personales)) { 
                            $fecha = $registros[fecha_creacion];
                            $fecha      = str_replace(' ', '_', $fecha); // Reemplazar espacios con "_"
                            $fecha      = str_replace(':', '-', $fecha);?>
                            <tr>
                                <td><?php echo $n; ?></td>
                                <td>Documentos Personales</td>
                                <td><?php echo utf8_encode(strtoupper($registros[detalle])); ?></td>
                                <td><?php echo date("d-m-Y", strtotime($registros[fecha_creacion])); ?></td>
                                <td>
                                    <a href="files/documentos_personales/<?php echo $registros[id_trabajador] . "_DOCUMENTOS_PERSONALES_" . $fecha ?>.pdf" target="_blank" class="btn btn-info pull-right">
                                        Ver
                                        <i class='entypo-eye'></i>
                                    </a>
                                    <a href='control/control_personal/eliminar_file.php?id=<?php echo $registros[id_file] ?>' class='accion btn btn-red pull-right'>
                                        Eliminar 
                                        <i class='entypo-cancel'></i>
                                    </a>
                                </td>
                            </tr>
                        <?php $n++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-cursos" role="tabpanel" aria-labelledby="pills-cursos-tab">
            <h3>Registros Cursos</h3>
            <div>
                <table class="table table-bordered datatable">
                    <thead>
                        <th>N</th>
                        <th>Tipo</th>
                        <th>Fecha Registro</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody id="tabla_cursos">
                        <?php
                        $n = 1;
                        while ($registros = $bd->getFila($consulta_cursos)) { 
                            $fecha = $registros[fecha_creacion];
                            $fecha      = str_replace(' ', '_', $fecha); // Reemplazar espacios con "_"
                            $fecha      = str_replace(':', '-', $fecha);?>
                            <tr>
                                <td><?php echo $n; ?></td>
                                <td>Cursos</td>
                                <td><?php echo date("d-m-Y", strtotime($registros[fecha_creacion])); ?></td>
                                <td>
                                    <a href="files/cursos/<?php echo $registros[id_trabajador] . "_CURSOS_" . $fecha ?>.pdf" target="_blank" class="btn btn-info pull-right">
                                        Ver
                                        <i class='entypo-eye'></i>
                                    </a>
                                    <a href='control/control_personal/eliminar_file.php?id=<?php echo $registros[id_file] ?>' class='accion btn btn-red pull-right'>
                                        Eliminar 
                                        <i class='entypo-cancel'></i>
                                    </a>
                                </td>
                            </tr>
                        <?php $n++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-experiencia" role="tabpanel" aria-labelledby="pills-experiencia-tab">
            <h3>Registros Experiencia</h3>
            <div>
                <table class="table table-bordered datatable">
                    <thead>
                        <th>N</th>
                        <th>Tipo</th>
                        <th>Fecha Registro</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody id="tabla_experiencia">
                        <?php
                        $n = 1;
                        while ($registros = $bd->getFila($consulta_experiencia_laboral)) { 
                            $fecha = $registros[fecha_creacion];
                            $fecha      = str_replace(' ', '_', $fecha); // Reemplazar espacios con "_"
                            $fecha      = str_replace(':', '-', $fecha);?>
                            <tr>
                                <td><?php echo $n; ?></td>
                                <td>Experiencial Laboral</td>
                                <td><?php echo date("d-m-Y", strtotime($registros[fecha_creacion])); ?></td>
                                <td>
                                    <a href="files/experiencia_laboral/<?php echo $registros[id_trabajador] . "_EXPERIENCIA_LABORAL_" . $fecha ?>.pdf" target="_blank" class="btn btn-info pull-right">
                                        Ver
                                        <i class='entypo-eye'></i>
                                    </a>
                                    <a href='control/control_personal/eliminar_file.php?id=<?php echo $registros[id_file] ?>' class='accion btn btn-red pull-right'>
                                        Eliminar 
                                        <i class='entypo-cancel'></i>
                                    </a>
                                </td>
                            </tr>
                        <?php $n++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-memorandun" role="tabpanel" aria-labelledby="pills-memorandun-tab">
            <h3>Registros Memorandun</h3>
            <div>
                <table class="table table-bordered datatable">
                    <thead>
                        <th>N</th>
                        <th>Tipo</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Fecha Registro</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody id="tabla_memorandun">
                        <?php
                        $n = 1;
                        while ($registros = $bd->getFila($consulta_memorandun)) { 
                            $fecha = $registros[fecha_creacion];
                            $fecha      = str_replace(' ', '_', $fecha); // Reemplazar espacios con "_"
                            $fecha      = str_replace(':', '-', $fecha);?>
                            <tr>
                                <td><?php echo $n; ?></td>
                                <td>Memorandun</td>
                                <td><?php echo date("d-m-Y", strtotime($registros[fecha_inicio])); ?></td>
                                <td><?php echo date("d-m-Y", strtotime($registros[fecha_fin])); ?></td>
                                <td><?php echo date("d-m-Y", strtotime($registros[fecha_creacion])); ?></td>
                                <td>
                                    <a href="files/memorandun/<?php echo $registros[id_trabajador] . "_MEMORANDUN_" . $fecha ?>.pdf" target="_blank" class="btn btn-info pull-right">
                                        Ver
                                        <i class='entypo-eye'></i>
                                    </a>
                                    <a href='control/control_personal/eliminar_file.php?id=<?php echo $registros[id_file] ?>' class='accion btn btn-red pull-right'>
                                        Eliminar 
                                        <i class='entypo-cancel'></i>
                                    </a>
                                </td>
                            </tr>
                        <?php $n++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-comunicacion-interna" role="tabpanel" aria-labelledby="pills-comunicacion-interna-tab">
            <h3>Registros Comunicacion Interna</h3>
            <div>
                <table class="table table-bordered datatable">
                    <thead>
                        <th>N</th>
                        <th>Tipo</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Fecha Registro</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody id="tabla_comunicacion_interna">
                        <?php
                        $n = 1;
                        while ($registros = $bd->getFila($consulta_comunicacion_interna)) { 
                            $fecha = $registros[fecha_creacion];
                            $fecha      = str_replace(' ', '_', $fecha); // Reemplazar espacios con "_"
                            $fecha      = str_replace(':', '-', $fecha);?>
                            <tr>
                                <td><?php echo $n; ?></td>
                                <td>Comunicacion Interna</td>
                                <td><?php echo date("d-m-Y", strtotime($registros[fecha_inicio])); ?></td>
                                <td><?php echo date("d-m-Y", strtotime($registros[fecha_fin])); ?></td>
                                <td><?php echo date("d-m-Y", strtotime($registros[fecha_creacion])); ?></td>
                                <td>
                                    <a href="files/comunicacion_interna/<?php echo $registros[id_trabajador] . "_COMUNICACION_INTERNA_" . $fecha ?>.pdf" target="_blank" class="btn btn-info pull-right">
                                        Ver
                                        <i class='entypo-eye'></i>
                                    </a>
                                    <a href='control/control_personal/eliminar_file.php?id=<?php echo $registros[id_file] ?>' class='accion btn btn-red pull-right'>
                                        Eliminar 
                                        <i class='entypo-cancel'></i>
                                    </a>
                                </td>
                            </tr>
                        <?php $n++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-otros_documentos" role="tabpanel" aria-labelledby="pills-otros_documentos-tab">
            <h3>Registros Otros Documentos</h3>
            <div>
                <table class="table table-bordered datatable">
                    <thead>
                        <th>N</th>
                        <th>Tipo</th>
                        <th>Detalle</th>
                        <th>Fecha Registro</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody id="tabla_otros_documentos">
                        <?php
                        $n = 1;
                        while ($registros = $bd->getFila($consulta_otros_documentos)) { 
                            $fecha = $registros[fecha_creacion];
                            $fecha      = str_replace(' ', '_', $fecha); // Reemplazar espacios con "_"
                            $fecha      = str_replace(':', '-', $fecha);?>
                            <tr>
                                <td><?php echo $n; ?></td>
                                <td>Otros Documentos</td>
                                <td><?php echo utf8_encode(strtoupper($registros[detalle])); ?></td>
                                <td><?php echo date("d-m-Y", strtotime($registros[fecha_creacion])); ?></td>
                                <td>
                                    <a href="files/otros_documentos/<?php echo $registros[id_trabajador] . "_OTROS_DOCUMENTOS_" . $fecha ?>.pdf" target="_blank" class="btn btn-info pull-right">
                                        Ver
                                        <i class='entypo-eye'></i>
                                    </a>
                                    <a href='control/control_personal/eliminar_file.php?id=<?php echo $registros[id_file] ?>' class='accion btn btn-red pull-right'>
                                        Eliminar 
                                        <i class='entypo-cancel'></i>
                                    </a>
                                </td>
                            </tr>
                        <?php $n++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-contratos" role="tabpanel" aria-labelledby="pills-contratos-tab">
            <h3>Registros Contratos</h3>
            <div>
                <table class="table table-bordered datatable">
                    <thead>
                        <th>N</th>
                        <th>Tipo</th>
                        <th>Detalle</th>
                        <th>Fecha Registro</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody id="tabla_contratos">
                        <?php
                        $n = 1;
                        while ($registros = $bd->getFila($consulta_contratos)) { 
                            $fecha = $registros[fecha_creacion];
                            $fecha      = str_replace(' ', '_', $fecha); // Reemplazar espacios con "_"
                            $fecha      = str_replace(':', '-', $fecha);?>
                            <tr>
                                <td><?php echo $n; ?></td>
                                <td>Contratos</td>
                                <td><?php echo utf8_encode(strtoupper($registros[detalle])); ?></td>
                                <td><?php echo date("d-m-Y", strtotime($registros[fecha_creacion])); ?></td>
                                <td>
                                    <a href="files/contratos/<?php echo $registros[id_trabajador] . "_CONTRATOS_" . $fecha ?>.pdf" target="_blank" class="btn btn-info pull-right">
                                        Ver
                                        <i class='entypo-eye'></i>
                                    </a>
                                    <a href='control/control_personal/eliminar_file.php?id=<?php echo $registros[id_file] ?>' class='accion btn btn-red pull-right'>
                                        Eliminar 
                                        <i class='entypo-cancel'></i>
                                    </a>
                                </td>
                            </tr>
                        <?php $n++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-afiliaciones" role="tabpanel" aria-labelledby="pills-afiliaciones-tab">
            <h3>Registros Afiliaciones</h3>
            <div>
                <table class="table table-bordered datatable">
                    <thead>
                        <th>N</th>
                        <th>Tipo</th>
                        <th>Detalle</th>
                        <th>Fecha Registro</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody id="tabla_afiliaciones">
                        <?php
                        $n = 1;
                        while ($registros = $bd->getFila($consulta_afiliaciones)) { 
                            $fecha = $registros[fecha_creacion];
                            $fecha      = str_replace(' ', '_', $fecha); // Reemplazar espacios con "_"
                            $fecha      = str_replace(':', '-', $fecha);?>
                            <tr>
                                <td><?php echo $n; ?></td>
                                <td>Afiliaciones</td>
                                <td><?php echo utf8_encode(strtoupper($registros[detalle])); ?></td>
                                <td><?php echo date("d-m-Y", strtotime($registros[fecha_creacion])); ?></td>
                                <td>
                                    <a href="files/afiliaciones/<?php echo $registros[id_trabajador] . "_AFILIACIONES_" . $fecha ?>.pdf" target="_blank" class="btn btn-info pull-right">
                                        Ver
                                        <i class='entypo-eye'></i>
                                    </a>
                                    <a href='control/control_personal/eliminar_file.php?id=<?php echo $registros[id_file] ?>' class='accion btn btn-red pull-right'>
                                        Eliminar 
                                        <i class='entypo-cancel'></i>
                                    </a>
                                </td>
                            </tr>
                        <?php $n++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- <div class="tab-pane active" id="pills-guardar" role="tabpanel" aria-labelledby="pills-guardar-tab">
            <h2>Registrar Nuevo</h2>
            <div class="panel-body" style="padding-left: 30px; padding-right: 30px;">
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
        </div> -->
    </div>
</div>

<style>
    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        color: #fff;
        background-color: #007bff;
    }

    #table-2 td a,
    #table-2 th a {
        text-transform: none;
    }

    #table-2 td,
    #table-2 th {
        text-transform: uppercase;
        font-size: 11px;
    }

    #table-3 td a,
    #table-3 th a {
        text-transform: none;
    }

    #table-3 td,
    #table-3 th {
        text-transform: uppercase;
        font-size: 11px;
    }

    #table-4 td a,
    #table-4 th a {
        text-transform: none;
    }

    #table-4 td,
    #table-4 th {
        text-transform: uppercase;
        font-size: 11px;
    }

    #table-5 td a,
    #table-5 th a {
        text-transform: none;
    }

    #table-5 td,
    #table-5 th {
        text-transform: uppercase;
        font-size: 11px;
    }

    #table-6 td a,
    #table-6 th a {
        text-transform: none;
    }

    #table-6 td,
    #table-6 th {
        text-transform: uppercase;
        font-size: 11px;
    }

    #table-7 td a,
    #table-7 th a {
        text-transform: none;
    }

    #table-7 td,
    #table-7 th {
        text-transform: uppercase;
        font-size: 11px;
    }

    #table-8 td a,
    #table-8 th a {
        text-transform: none;
    }

    #table-8 td,
    #table-8 th {
        text-transform: uppercase;
        font-size: 11px;
    }

    #table-9 td a,
    #table-9 th a {
        text-transform: none;
    }

    #table-9 td,
    #table-9 th {
        text-transform: uppercase;
        font-size: 11px;
    }

    #table-10 td a,
    #table-10 th a {
        text-transform: none;
    }

    #table-10 td,
    #table-10 th {
        text-transform: uppercase;
        font-size: 11px;
    }
</style>
<script>
    jQuery(document).ready(function($) {
        // tableContainer2 = $("#table-2");

        // tableContainer2.dataTable({
        //     "sPaginationType": "bootstrap",
        //     "aLengthMenu": [
        //         [25, 50, 100, -1],
        //         [25, 50, 100, "Todo"]
        //     ],
        //     "bStateSave": true,

        //     // Responsive Settings
        //     bAutoWidth: true,
        //     fnPreDrawCallback: function() {
        //         // Initialize the responsive datatables helper once.
        //         if (!responsiveHelper) {
        //             responsiveHelper = new ResponsiveDatatablesHelper(tableContainer2, breakpointDefinition);
        //         }
        //     },
        //     fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        //         responsiveHelper.createExpandIcon(nRow);
        //     },
        //     fnDrawCallback: function(oSettings) {
        //         responsiveHelper.respond();
        //     }
        // });

        // $(".dataTables_wrapper select").select2({
        //     minimumResultsForSearch: -1
        // });

        // tableContainer3 = $("#table-3");

        // tableContainer3.dataTable({
        //     "sPaginationType": "bootstrap",
        //     "aLengthMenu": [
        //         [25, 50, 100, -1],
        //         [25, 50, 100, "Todo"]
        //     ],
        //     "bStateSave": true,

        //     // Responsive Settings
        //     bAutoWidth: true,
        //     fnPreDrawCallback: function() {
        //         // Initialize the responsive datatables helper once.
        //         if (!responsiveHelper) {
        //             responsiveHelper = new ResponsiveDatatablesHelper(tableContainer3, breakpointDefinition);
        //         }
        //     },
        //     fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        //         responsiveHelper.createExpandIcon(nRow);
        //     },
        //     fnDrawCallback: function(oSettings) {
        //         responsiveHelper.respond();
        //     }
        // });

        // $(".dataTables_wrapper select").select2({
        //     minimumResultsForSearch: -1
        // });

        // tableContainer4 = $("#table-4");

        // tableContainer4.dataTable({
        //     "sPaginationType": "bootstrap",
        //     "aLengthMenu": [
        //         [25, 50, 100, -1],
        //         [25, 50, 100, "Todo"]
        //     ],
        //     "bStateSave": true,

        //     // Responsive Settings
        //     bAutoWidth: true,
        //     fnPreDrawCallback: function() {
        //         // Initialize the responsive datatables helper once.
        //         if (!responsiveHelper) {
        //             responsiveHelper = new ResponsiveDatatablesHelper(tableContainer4, breakpointDefinition);
        //         }
        //     },
        //     fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        //         responsiveHelper.createExpandIcon(nRow);
        //     },
        //     fnDrawCallback: function(oSettings) {
        //         responsiveHelper.respond();
        //     }
        // });

        // $(".dataTables_wrapper select").select2({
        //     minimumResultsForSearch: -1
        // });

        // tableContainer5 = $("#table-5");

        // tableContainer5.dataTable({
        //     "sPaginationType": "bootstrap",
        //     "aLengthMenu": [
        //         [25, 50, 100, -1],
        //         [25, 50, 100, "Todo"]
        //     ],
        //     "bStateSave": true,

        //     // Responsive Settings
        //     bAutoWidth: true,
        //     fnPreDrawCallback: function() {
        //         // Initialize the responsive datatables helper once.
        //         if (!responsiveHelper) {
        //             responsiveHelper = new ResponsiveDatatablesHelper(tableContainer5, breakpointDefinition);
        //         }
        //     },
        //     fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        //         responsiveHelper.createExpandIcon(nRow);
        //     },
        //     fnDrawCallback: function(oSettings) {
        //         responsiveHelper.respond();
        //     }
        // });

        // $(".dataTables_wrapper select").select2({
        //     minimumResultsForSearch: -1
        // });

        // tableContainer6 = $("#table-6");

        // tableContainer6.dataTable({
        //     "sPaginationType": "bootstrap",
        //     "aLengthMenu": [
        //         [25, 50, 100, -1],
        //         [25, 50, 100, "Todo"]
        //     ],
        //     "bStateSave": true,

        //     // Responsive Settings
        //     bAutoWidth: true,
        //     fnPreDrawCallback: function() {
        //         // Initialize the responsive datatables helper once.
        //         if (!responsiveHelper) {
        //             responsiveHelper = new ResponsiveDatatablesHelper(tableContainer6, breakpointDefinition);
        //         }
        //     },
        //     fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        //         responsiveHelper.createExpandIcon(nRow);
        //     },
        //     fnDrawCallback: function(oSettings) {
        //         responsiveHelper.respond();
        //     }
        // });

        // $(".dataTables_wrapper select").select2({
        //     minimumResultsForSearch: -1
        // });

        // tableContainer7 = $("#table-7");

        // tableContainer7.dataTable({
        //     "sPaginationType": "bootstrap",
        //     "aLengthMenu": [
        //         [25, 50, 100, -1],
        //         [25, 50, 100, "Todo"]
        //     ],
        //     "bStateSave": true,

        //     // Responsive Settings
        //     bAutoWidth: true,
        //     fnPreDrawCallback: function() {
        //         // Initialize the responsive datatables helper once.
        //         if (!responsiveHelper) {
        //             responsiveHelper = new ResponsiveDatatablesHelper(tableContainer7, breakpointDefinition);
        //         }
        //     },
        //     fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        //         responsiveHelper.createExpandIcon(nRow);
        //     },
        //     fnDrawCallback: function(oSettings) {
        //         responsiveHelper.respond();
        //     }
        // });

        // $(".dataTables_wrapper select").select2({
        //     minimumResultsForSearch: -1
        // });

        // tableContainer8 = $("#table-8");

        // tableContainer8.dataTable({
        //     "sPaginationType": "bootstrap",
        //     "aLengthMenu": [
        //         [25, 50, 100, -1],
        //         [25, 50, 100, "Todo"]
        //     ],
        //     "bStateSave": true,

        //     // Responsive Settings
        //     bAutoWidth: true,
        //     fnPreDrawCallback: function() {
        //         // Initialize the responsive datatables helper once.
        //         if (!responsiveHelper) {
        //             responsiveHelper = new ResponsiveDatatablesHelper(tableContainer8, breakpointDefinition);
        //         }
        //     },
        //     fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        //         responsiveHelper.createExpandIcon(nRow);
        //     },
        //     fnDrawCallback: function(oSettings) {
        //         responsiveHelper.respond();
        //     }
        // });

        // $(".dataTables_wrapper select").select2({
        //     minimumResultsForSearch: -1
        // });

        // tableContainer9 = $("#table-9");

        // tableContainer9.dataTable({
        //     "sPaginationType": "bootstrap",
        //     "aLengthMenu": [
        //         [25, 50, 100, -1],
        //         [25, 50, 100, "Todo"]
        //     ],
        //     "bStateSave": true,

        //     // Responsive Settings
        //     bAutoWidth: true,
        //     fnPreDrawCallback: function() {
        //         // Initialize the responsive datatables helper once.
        //         if (!responsiveHelper) {
        //             responsiveHelper = new ResponsiveDatatablesHelper(tableContainer9, breakpointDefinition);
        //         }
        //     },
        //     fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        //         responsiveHelper.createExpandIcon(nRow);
        //     },
        //     fnDrawCallback: function(oSettings) {
        //         responsiveHelper.respond();
        //     }
        // });

        // $(".dataTables_wrapper select").select2({
        //     minimumResultsForSearch: -1
        // });

        // tableContainer10 = $("#table-10");

        // tableContainer10.dataTable({
        //     "sPaginationType": "bootstrap",
        //     "aLengthMenu": [
        //         [25, 50, 100, -1],
        //         [25, 50, 100, "Todo"]
        //     ],
        //     "bStateSave": true,

        //     // Responsive Settings
        //     bAutoWidth: true,
        //     fnPreDrawCallback: function() {
        //         // Initialize the responsive datatables helper once.
        //         if (!responsiveHelper) {
        //             responsiveHelper = new ResponsiveDatatablesHelper(tableContainer10, breakpointDefinition);
        //         }
        //     },
        //     fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        //         responsiveHelper.createExpandIcon(nRow);
        //     },
        //     fnDrawCallback: function(oSettings) {
        //         responsiveHelper.respond();
        //     }
        // });

        // $(".dataTables_wrapper select").select2({
        //     minimumResultsForSearch: -1
        // });

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
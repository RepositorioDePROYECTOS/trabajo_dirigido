<?php
$id_solicitud   = $_GET[id_solicitud];
$id_proveedor   = $_GET[id_proveedor];
$tipo           = $_GET[tipo];
$id_detalle     = $_GET[id_detalle];

$fecha = "";
$nombre_solicitante = "";
$existencia = "";
$tipo_buscador = "";
$justificativo = "";
$objetivo = "";
$detalles_proveedores = $bd->Consulta("SELECT * FROM proveedores WHERE id_proveedor=$id_proveedor");
$detalles_proveedor   = $bd->getFila($detalles_proveedores);
if ($tipo == 'material') {
    $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_material WHERE id_solicitud_material=$id_solicitud");
    $detalles = $bd->Consulta("SELECT d.precio_total, d.id_detalle_material as id_detalle, d.descripcion, d.unidad_medida, d.cantidad_solicitada, p.codigo_partida, p.nombre_partida 
            FROM solicitud_material as s 
            INNER JOIN detalle_material as d ON d.id_solicitud_material = s.id_solicitud_material 
            INNER JOIN partidas as p ON p.id_partida = d.id_partida
            WHERE s.id_solicitud_material=$id_solicitud");

    $registro_sol = $bd->getFila($registros_solicitud);
    $tipo_buscador = "ALMACENERO";
    $fecha = date("d-m-Y", strtotime($registro_sol[fecha_solicitud]));
    $nombre_solicitante = utf8_encode($registro_sol[nombre_solicitante]);
    $existencia = utf8_encode($registro_sol[existencia_material]);
    $justificativo = $registro_sol[justificativo];
    $objetivo = $registro_sol[objetivo_contratacion];
} elseif ($tipo == 'activo') {
    $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_activo WHERE id_solicitud_activo=$id_solicitud");
    $detalles = $bd->Consulta("SELECT d.precio_total, d.id_detalle_activo as id_detalle, d.descripcion, d.unidad_medida, d.cantidad_solicitada, p.codigo_partida, p.nombre_partida 
            FROM solicitud_activo as s 
            INNER JOIN detalle_activo as d ON d.id_solicitud_activo = s.id_solicitud_activo 
            INNER JOIN partidas as p ON p.id_partida = d.id_partida
            WHERE s.id_solicitud_activo=$id_solicitud");

    $registro_sol = $bd->getFila($registros_solicitud);
    $tipo_buscador = "ACTIVOS";
    $fecha = date("d-m-Y", strtotime($registro_sol[fecha_solicitud]));
    $nombre_solicitante = utf8_encode($registro_sol[nombre_solicitante]);
    $existencia = utf8_encode($registro_sol[existencia_material]);
    $justificativo = $registro_sol[justificativo];
    $objetivo = $registro_sol[objetivo_contratacion];
} else {
    $registros_solicitud = $bd->Consulta("SELECT * FROM solicitud_servicio WHERE id_solicitud_servicio =$id_solicitud");
    $detalles = $bd->Consulta("SELECT d.precio_total, d.id_detalle_servicio as id_detalle, d.descripcion, d.unidad_medida, d.cantidad_solicitada, p.codigo_partida, p.nombre_partida 
            FROM solicitud_servicio as s 
            INNER JOIN detalle_servicio as d ON d.id_solicitud_servicio = s.id_solicitud_servicio 
            INNER JOIN partidas as p ON p.id_partida = d.id_partida
            WHERE s.id_solicitud_servicio =$id_solicitud");

    $registro_sol = $bd->getFila($registros_solicitud);
    $tipo_buscador = "SERVICIO";
    $fecha = date("d-m-Y", strtotime($registro_sol[fecha_solicitud]));
    $nombre_solicitante = utf8_encode($registro_sol[nombre_solicitante]);
    $existencia = utf8_encode($registro_sol[existencia_material]);
    $justificativo = $registro_sol[justificativo];
    $objetivo = $registro_sol[objetivo_contratacion];
}
$requisitos = $bd->Consulta("SELECT * FROM requisitos WHERE id_solicitud=$id_solicitud AND id_proveedor=$id_proveedor AND id_detalle=$id_detalle");
$r = $bd->getFila($requisitos);
// print_r($r);
$sin_datos  = "block";
$con_datos = "none";
if ($r[forma_pago] != NULL) {
    $sin_datos = "none";
    $con_datos = "block";
    // echo "mostrar empty";
} else {
    $sin_datos = "block";
    $con_datos = "none";
}
// echo $sin_datos." -- ".$con_datos;
?>
<h2>
    <button type="reset" class="btn btn-success cancelar pull-left">Volver&nbsp;<i class="entypo-back"></i></button>
    <br><br>
    Condiciones
</h2>

<div class="panel panel-default panel-shadow" data-collapsed="0">
    <div class="panel-body">
        <h4>Fecha de solicitud: <strong><?php echo $fecha; ?></strong></h4>
        <h4>Nombre Solicitante: <strong><?php echo $nombre_solicitante; ?></strong></h4>
        <h4>Objetivo: <strong><?php echo utf8_encode($objetivo); ?></strong></h4>
        <h4>Justificativo: <strong><?php echo utf8_encode($justificativo); ?></strong></h4>
        <h4>Proveedor: <strong><?php echo utf8_encode($detalles_proveedor[nombre]); ?>&nbsp;Nit:&nbsp;<?php echo utf8_encode($detalles_proveedor[nit]); ?></strong> </h4>
    </div>
    <div style="display: <?php echo $sin_datos; ?>;">
        <form action="control/derivaciones/condiciones.php" name="frm_conf_refrigerio" id="frm_conf_refrigerio" method="post" role="form" class="validate form-horizontal form-groups-bordered">
            <!-- <div class="col-md-6"> -->
            <div class="form-group">
                <label for="modalidad_contratacion" class="col-sm-3 control-label">Modalidad Contratacion</label>
                <div class="col-sm-7">
                    <input type="text" name="modalidad_contratacion" id="modalidad_contratacion" value="CONTRATACION DE MENOR DE BIENES Y SERVICIOS SEGUN D.S.0181" class="form-control required text" />
                </div>
            </div>
            <div class="form-group">
                <label for="plazo_entrega" class="col-sm-3 control-label">Plazo de Entrega</label>
                <div class="col-sm-7">
                    <input type="text" name="plazo_entrega" id="plazo_entrega" placeholder="Ej. 5 DIAS CALENDARIO" class="form-control required text" />
                </div>
            </div>
            <div class="form-group">
                <label for="forma_adjudicacion" class="col-sm-3 control-label">Forma de Adjudicacion</label>
                <div class="col-sm-7">
                    <input type="text" name="forma_adjudicacion" id="forma_adjudicacion" placeholder="Ej. POR EL TOTAL DE LO SOLICITADO" class="form-control required text" />
                </div>
            </div>
            <div class="form-group">
                <label for="multas_retraso" class="col-sm-3 control-label">Multas</label>
                <div class="col-sm-7">
                    <input type="text" name="multas_retraso" id="multas_retraso" VALUE="NINGUNA" class="form-control required text" />
                </div>
            </div>
            <div class="form-group">
                <label for="forma_pago" class="col-sm-3 control-label">Forma de Pago</label>
                <div class="col-sm-7">
                    <!-- <input type="text" name="forma_pago" id="forma_pago" placeholder="Cheque / Efectivo / Otros" class="form-control required text" /> -->
                    <select name="forma_pago" id="forma_pago" class="form-control required select2">
                        <option value="">--SELECCIONE--</option>
                        <option value="CHEQUE">CHEQUE</option>
                        <option value="EFECTIVO">EFECTIVO</option>
                        <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                        <option value="OTROS">OTROS</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="lugar_entrega" class="col-sm-3 control-label">Lugar de Entrega</label>
                <div class="col-sm-7">
                    <input type="text" name="lugar_entrega" id="lugar_entrega" VALUE="OFICINAS DE LA INSTITUCION" class="form-control required text" />
                </div>
            </div>

            <br><br>
            <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION[id_usuario]; ?>">
            <input type="hidden" name="id_solicitud" id="id_solicitud" value="<?php echo $id_solicitud; ?>">
            <input type="hidden" name="id_proveedor" id="id_proveedor" value="<?php echo $id_proveedor; ?>">
            <input type="hidden" name="tipo" id="tipo" value="<?php echo $tipo; ?>">
            <button type="submit" class="btn btn-green btn-icon pull-right" id="agregar">
                Agregar <i class="entypo-plus"></i>
            </button>
            <!-- </div> -->
        </form>
    </div>
    <div style="display: <?php echo $con_datos; ?>;">
        <h2 align="center">
            Datos Registrados <br>
            <a href="control/derivaciones/borrar_condiciones.php?id_solicitud=<?php echo $id_solicitud; ?>&id_proveedor=<?php echo $id_proveedor; ?>" class="accion btn btn-danger btn-icon pull-center">Borrar Condiciones<i class="entypo-back"></i></a>
        </h2>
        <br><br>
        <div class="form-group">
            <label class="col-sm-3 control-label">Modalidad Contratacion</label>
            <div class="col-sm-7">
                <input type="text" value="<?php echo $r[modalidad_contratacion] ?>" readonly class="form-control required text" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Plazo de Entrega</label>
            <div class="col-sm-7">
                <input type="text" value="<?php echo $r[plazo_entrega] ?>" readonly class="form-control required text" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Forma de Adjudicacion</label>
            <div class="col-sm-7">
                <input type="text" value="<?php echo $r[forma_adjudicacion] ?>" readonly class="form-control required text" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Multas</label>
            <div class="col-sm-7">
                <input type="text" value="<?php echo $r[multas_retraso] ?>" readonly class="form-control required text" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Forma de Pago</label>
            <div class="col-sm-7">
                <input type="text" value="<?php echo $r[forma_pago] ?>" readonly class="form-control required text" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Lugar de Entrega</label>
            <div class="col-sm-7">
                <input type="text" value="<?php echo $r[lugar_entrega] ?>" readonly class="form-control required text" />
            </div>
        </div>
    
    </div>
</div>
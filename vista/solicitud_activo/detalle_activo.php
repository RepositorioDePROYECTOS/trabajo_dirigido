<?php

$id_solicitud_activo = $_GET[id_solicitud_activo];
// echo  "ID: ".$id_solicitud_activo;

// almacenar el id de la solicitud en los detalles de la solicitud

// $registros_m =  $bd->Consulta("select * from activo");
$registros_s = $bd->Consulta("SELECT * 
    from detalle_activo as d 
    LEFT JOIN partidas as p ON p.id_partida = d.id_partida 
    LEFT JOIN requisitos as r ON r.id_detalle = d.id_detalle_activo
    LEFT JOIN proveedores as pr ON pr.id_proveedor = r.id_proveedor
    WHERE d.id_solicitud_activo=$id_solicitud_activo");
$registros_solicitud = $bd->Consulta("select * from solicitud_activo where id_solicitud_activo=$id_solicitud_activo");
$registro_sol = $bd->getFila($registros_solicitud);
// echo "SELECT * from detalle_activo where id_solicitud_activo=$id_solicitud_activo";
// echo "<br>";
// echo "SELECT * from solicitud_activo where id_solicitud_activo=$id_solicitud_activo";
?>
<?php
function numeroALetras($num, $currency = array())
{
    $defaultCurrency = array(
        'plural' => 'BOLIVIANOS',
        'singular' => 'BOLIVIANO',
        'centPlural' => 'CENTAVOS',
        'centSingular' => 'CENTAVO'
    );
    $currency = array_merge($defaultCurrency, $currency);

    $data = array(
        'numero' => $num,
        'enteros' => floor($num),
        'centavos' => round(($num - floor($num)) * 100),
        'letrasCentavos' => '',
        'letrasMonedaPlural' => $currency['plural'],
        'letrasMonedaSingular' => $currency['singular'],
        'letrasMonedaCentavoPlural' => $currency['centPlural'],
        'letrasMonedaCentavoSingular' => $currency['centSingular']
    );

    if ($data['enteros'] == 0) {
        return 'CERO ' . $data['centavos'] . '/100 ' . $data['letrasMonedaSingular'];
    } elseif ($data['enteros'] == 1) {
        return Millones($data['enteros']) . ' ' . $data['centavos'] . '/100 ' . $data['letrasMonedaSingular'];
    } else {
        return Millones($data['enteros']) . ' ' . $data['centavos'] . '/100 ' . $data['letrasMonedaPlural'];
    }
}

function Unidades($num)
{
    switch ($num) {
        case 1:
            return 'UNO';
        case 2:
            return 'DOS';
        case 3:
            return 'TRES';
        case 4:
            return 'CUATRO';
        case 5:
            return 'CINCO';
        case 6:
            return 'SEIS';
        case 7:
            return 'SIETE';
        case 8:
            return 'OCHO';
        case 9:
            return 'NUEVE';
    }
    return '';
}

function Decenas($num)
{
    $decena = floor($num / 10);
    $unidad = $num - ($decena * 10);

    switch ($decena) {
        case 1:
            switch ($unidad) {
                case 0:
                    return 'DIEZ';
                case 1:
                    return 'ONCE';
                case 2:
                    return 'DOCE';
                case 3:
                    return 'TRECE';
                case 4:
                    return 'CATORCE';
                case 5:
                    return 'QUINCE';
                default:
                    return 'DIECI' . Unidades($unidad);
            }
        case 2:
            switch ($unidad) {
                case 0:
                    return 'VEINTE';
                default:
                    return 'VEINTI' . Unidades($unidad);
            }
        case 3:
            return DecenasY('TREINTA', $unidad);
        case 4:
            return DecenasY('CUARENTA', $unidad);
        case 5:
            return DecenasY('CINCUENTA', $unidad);
        case 6:
            return DecenasY('SESENTA', $unidad);
        case 7:
            return DecenasY('SETENTA', $unidad);
        case 8:
            return DecenasY('OCHENTA', $unidad);
        case 9:
            return DecenasY('NOVENTA', $unidad);
        case 0:
            return Unidades($unidad);
    }
}

function DecenasY($strSin, $numUnidades)
{
    if ($numUnidades > 0)
        return $strSin . ' Y ' . Unidades($numUnidades);
    return $strSin;
}

function Centenas($num)
{
    $centenas = floor($num / 100);
    $decenas = $num - ($centenas * 100);

    switch ($centenas) {
        case 1:
            if ($decenas > 0)
                return 'CIENTO ' . Decenas($decenas);
            return 'CIEN';
        case 2:
            return 'DOSCIENTOS ' . Decenas($decenas);
        case 3:
            return 'TRESCIENTOS ' . Decenas($decenas);
        case 4:
            return 'CUATROCIENTOS ' . Decenas($decenas);
        case 5:
            return 'QUINIENTOS ' . Decenas($decenas);
        case 6:
            return 'SEISCIENTOS ' . Decenas($decenas);
        case 7:
            return 'SETECIENTOS ' . Decenas($decenas);
        case 8:
            return 'OCHOCIENTOS ' . Decenas($decenas);
        case 9:
            return 'NOVECIENTOS ' . Decenas($decenas);
    }
    return Decenas($decenas);
}

function Seccion($num, $divisor, $strSingular, $strPlural)
{
    $cientos = floor($num / $divisor);
    $resto = $num - ($cientos * $divisor);

    $letras = '';

    if ($cientos > 0)
        if ($cientos > 1)
            $letras = Centenas($cientos) . ' ' . $strPlural;
        else
            $letras = $strSingular;

    if ($resto > 0)
        $letras .= '';

    return $letras;
}

function Miles($num)
{
    $divisor = 1000;
    $cientos = floor($num / $divisor);
    $resto = $num - ($cientos * $divisor);

    $strMiles = Seccion($num, $divisor, 'MIL', 'MIL');
    $strCentenas = Centenas($resto);

    if ($strMiles == '')
        return $strCentenas;

    return $strMiles . ' ' . $strCentenas;
}

function Millones($num)
{
    $divisor = 1000000;
    $cientos = floor($num / $divisor);
    $resto = $num - ($cientos * $divisor);

    $strMillones = Seccion($num, $divisor, 'UN MILLON DE', 'MILLONES DE');
    $strMiles = Miles($resto);

    if ($strMillones == '')
        return $strMiles;

    return $strMillones . ' ' . $strMiles;
}
$totales = 0;
while ($registro_st = $bd->getFila($registros_s)) {
    // print_r($registro_s);
    $totales = $totales + ($registro_st[precio_unitario] * $registro_st[cantidad_solicitada]);
}
?>

<h2>Detalle de la solicitud</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <label for="objetivo" class="control-label">Objetivo</label>
                <?php
                $objetivo = $bd->Consulta("SELECT objetivo_contratacion FROM solicitud_activo WHERE id_solicitud_activo = $id_solicitud_activo");
                $data_objetivo = $bd->getFila($objetivo);
                ?>
                <input type="text" name="objetivo" id="objetivo" class="form-control" readonly value="<?php echo $data_objetivo[objetivo_contratacion] ?>">
                <label for="justificativo" class="control-label">Justificativo</label>
                <?php
                $justificativo = $bd->Consulta("SELECT justificativo FROM solicitud_activo WHERE id_solicitud_activo = $id_solicitud_activo");
                $data_justificativo = $bd->getFila($justificativo);
                ?>
                <input type="text" name="justificativo" id="justificativo" class="form-control" readonly value="<?php echo $data_justificativo[justificativo] ?>">
            </div>
            <div class="col-sm-4">
                <label for="trabajador" class="control-label">Nombre Solicitante</label>
                <input type="text" name="5rabajador" id="trabajador" class="form-control required text" placeholder='' value='<?php echo utf8_encode($registro_sol[nombre_solicitante]); ?>' disabled />
            </div>
            <div class="col-sm-4">
                <label for="fecha_registro" class="control-label">Fecha de solicitud</label>
                <input type="text" name="fecha_registro" id="fecha_registro" class="form-control required datepicker" placeholder='' value='<?php echo date("Y-m-d", strtotime($registro_sol[fecha_solicitud])); ?>' disabled />
            </div>
            <?php if ($_SESSION[nivel] == 'PRESUPUESTO') { ?>
                <?php if ($registro_sol[estado_solicitud_activo] == 'VERIFICADO') { ?>
                    <div class="col-sm-4">
                        <label for="selectPresupuesto" class="control-label">Presupesto</label>
                        <select name="selectPresupuesto" id="selectPresupuesto" class="form-control">
                            <option value="PRESUPUESTADO">PRESUPUESTADO</option>
                            <option value="SIN PRESUPUESTO">SIN PRESUPUESTO</option>
                        </select>
                    </div>
                    <div class="col-sm-11">
                        <label for="fileCertificacionPresupuestaria" class="control-label">Certificación Presupuestaria</label>
                        <input type="file" accept=".pdf" class="form-control" name="fileCertificacionPresupuestaria" id="fileCertificacionPresupuestaria">
                    </div>
                <?php } ?>
            <?php } ?>
            <?php if ($_SESSION[nivel] == 'RPA') { ?>
                <div class="col-sm-4">
                    <?php if ($registro_sol[estado_solicitud_activo] == 'PRESUPUESTADO') { ?>
                        <label for="check_rpa" class="control-label">Control de documentos</label>
                        <div class="form-check">
                            <input id="check_cert_presupuestaria" class="form-check-input" type="checkbox" name="check_rpa" value="true">
                            <label for="check_cert_presupuestaria" class="form-check-label">CERTIFICACION PRESUPUESTARIA</label>
                        </div>
                        <div class="form-check">
                            <input id="check_poa" class="form-check-input" type="checkbox" name="check_rpa" value="true">
                            <label for="check_poa" class="form-check-label">INSCRITO EN EL POA</label>
                        </div>
                        <?php if ($totales > 20000) { ?>
                            <div class="form-check">

                                <input id="check_pac" class="form-check-input" type="checkbox" name="check_rpa" value="true">
                                <label for="check_pac" class="form-check-label">INSCRITO EN PAC (MAYOR 20.000 Bs.)</label>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php } ?>
            <?php if ($_SESSION[nivel] == 'ACTIVOS' && $registro_sol[existencia_activo] == 'SI' && $registro_sol[estado_solicitud_activo] == 'APROBADO') { ?>
                <div class="col-sm-4">
                    <label for="fecha_despacho" class="control-label">Fecha de Despacho (*)</label>
                    <input type="text" name="fecha_despacho" id="fecha_despacho" class="form-control required datepicker" value='<?php echo date("Y-m-d"); ?>' />
                </div>
            <?php } elseif (($_SESSION[nivel] == 'ACTIVOS' || $_SESSION[nivel] == 'PRESUPUESTO')  && $registro_sol[existencia_activo] == 'NO' && ($registro_sol[estado_solicitud_activo] == 'APROBADO' || $registro_sol[estado_solicitud_activo] == 'SIN EXISTENCIA' || $registro_sol[estado_solicitud_activo] == 'COMPRADO')) { ?>
                <div class="col-sm-4 bg-danger">
                    <label for="existencia_activo" class="control-label">Existencia de activo (*)</label>
                    <input type="text" name="existencia_activo" id="existencia_activo" class="form-control bg-danger" value='<?php echo $registro_sol[existencia_activo]; ?>' disabled />
                </div>
            <?php } elseif ($_SESSION[nivel] == 'ADQUISICION' && $registro_sol[estado_solicitud_activo] == 'ADQUISICION') { ?>
                <div class="col-sm-4 bg-success">
                    <label for="fecha_despacho" class="control-label">Fecha de registro de adquisicion</label>
                    <input type="text" name="fecha_despacho" id="fecha_despacho" class="form-control required datepicker" value='<?php echo $registro_sol[fecha_registro_adquisiciones]; ?>' disabled />
                </div>
            <?php } ?>
        </div>
        <hr>
        <label for="detalle_activo" class="col-sm-12 control-label">Detalle de activo solicitados</label>
        <?php if ($_SESSION[nivel] == 'PRESUPUESTO') { ?>
            <div class="row">
                <div id="detalle_materiales" class="col-sm-12 table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nro</th>
                                <th>Descripci&oacute;n</th>
                                <th>Unidad de medida</th>
                                <th>Cantidad Solicitada</th>
                                <th>Cantidad a despachar</th>
                                <th>Partida Presupuestaria</th>
                                <th>Proveedor</th>
                                <th>Precio_unitario</th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody id="tbl_body">
                            <?php
                            mysql_data_seek($registros_s, 0);
                            while ($registro_s = $bd->getFila($registros_s)) {
                                $n++; ?>
                                <tr>
                                    <td><?php echo $n; ?></td>
                                    <td><?php echo utf8_encode($registro_s[descripcion]); ?></td>
                                    <td><?php echo utf8_encode($registro_s[unidad_medida]); ?></td>
                                    <td><?php echo utf8_encode($registro_s[cantidad_solicitada]); ?></td>
                                    <td><?php echo utf8_encode($registro_s[cantidad_despachada]); ?></td>
                                    <td>
                                        <input type="hidden" name="id_detalle_<?php echo $n; ?>" id="id_detalle_<?php echo $n; ?>" value="<?php echo $registro_s[id_detalle_activo]; ?>">
                                        <?php
                                        $partidas = $bd->Consulta("SELECT * FROM partidas WHERE estado_partida = '1'");
                                        ?>
                                        <select id="<?php echo 'id_partida_' . $n ?>" class="form-control required select2">
                                            <?php
                                            while ($partida = $bd->getFila($partidas)) {
                                                echo utf8_encode("<option value='$partida[id_partida]'>$partida[codigo_partida] - $partida[nombre_partida]</option>");
                                            }
                                            ?>
                                    </td>
                                    <td><?php echo ($registro_s[nombre] != NULL) ? utf8_encode("$registro_s[nombre] - $registro_s[nit]") : " - " ?></td>
                                    <td><?php echo utf8_encode($registro_s[precio_unitario]); ?></td>
                                    <td><?php echo $registro_s[precio_unitario] * $registro_s[cantidad_despachada]; ?></td>
                                </tr>
                            <?php } ?>
                            <input type="hidden" name="tamanio" id="tamanio" value="<?php echo $n; ?>">
                            <tr>
                                <td colspan='8' align='right'>TOTAL: <?php echo numeroALetras($totales) ?></td>
                                <td><?php echo number_format($totales) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } else { ?>
            <div class="row">
                <div id="detalle_activo" class="col-sm-12 table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nro</th>
                                <th>Descripci&oacute;n</th>
                                <th>Unidad de medida</th>
                                <th>Cantidad Solicitada</th>
                                <th>Cantidad a despachar</th>
                                <th>Partida Presupuestaria</th>
                                <th>Proveedor</th>
                                <th>Precio_unitario</th>
                                <th>TOTAL</th>
                                <?php if ($_SESSION[nivel] == 'ACTIVOS' && $registro_sol[existencia_activo] == 'SI' && $registro_sol[estado_solicitud_activo] == 'APROBADO') { ?>
                                    <th>Acción</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody id="tbl_body">
                            <!-- realizar una consulta de acuerdo a la solicitud si tiene activo $solicitud->activo->count() e imprimir aqui -->
                            <?php
                            mysql_data_seek($registros_s, 0);
                            while ($registro_s = $bd->getFila($registros_s)) {
                                $n++;
                                echo "<tr>";
                                echo utf8_encode("
                                <td>$n</td>
                                <td>$registro_s[descripcion]</td>
                                <td>$registro_s[unidad_medida]</td>
                                <td>$registro_s[cantidad_solicitada]</td>
                                <td>$registro_s[cantidad_despachada]</td>
                                ");
                                echo utf8_encode("<td>$registro_s[codigo_partida] - $registro_s[nombre_partida]</td>");
                                echo ($registro_s[nombre] != NULL) ? utf8_encode("<td>$registro_s[nombre] - $registro_s[nit]</td>") : "<td>-</td>";
                                echo utf8_encode(
                                    "<td>$registro_s[precio_unitario]</td>"
                                );
                                echo "<td>" . $registro_s[precio_unitario] * $registro_s[cantidad_despachada] . "</td>";
                                if ($_SESSION[nivel] == 'ACTIVOS' && $registro_sol[existencia_activo] == 'SI' && $registro_sol[estado_solicitud_activo] == 'APROBADO') {
                                    echo "<td><a href='?mod=solicitud_activo&pag=editar_detalle_activo&id_detalle_activo=$registro_s[id_detalle_activo]&id_solicitud_activo=$id_solicitud_activo' class='btn btn-info btn-icon view_modal_edit'>Editar cantidad <i class='entypo-pencil'></i></a></td>";
                                }
                                echo "</tr>";
                            }
                            ?>
                            <tr>
                                <td colspan='8' align='right'>TOTAL: <?php echo numeroALetras($totales) ?></td>
                                <td><?php echo number_format($totales) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php  } ?>
        <div class="form-group">

            <?php if ($_SESSION[nivel] == 'GERENTE ADMINISTRATIVO') { ?>
                <div class="col-sm-12">
                    <?php if ($registro_sol[existencia_activo] == 'SI') { ?>
                        <?php if ($registro_sol[estado_solicitud_activo] == 'SOLICITADO') { ?>
                            <a href="control/solicitud_activo/aprobar_solicitud_ga.php?id=<?= $id_solicitud_activo; ?>" class='accion btn btn-green btn-icon' style='float: right; margin-left: 5px;'>Aprobar <i class='entypo-pencil'></i></a>
                            <button class='accion btn btn-red btn-icon view_modal_rechazar' style='float: right; margin-left: 5px;'>
                                Rechazar <i class='entypo-cancel'></i></button>
                            <button type="button" class="btn btn-default pull-right btn-icon" data-dismiss="modal">Cerrar <i class='entypo-cancel'></i></button>
                        <?php } ?>
                    <?php } ?>
                    <?php if ($registro_sol[estado_solicitud_activo] == 'VISTO BUENO RPA') { ?>
                        <a href="control/solicitud_activo/aprobar_solicitud_ga.php?id=<?php echo $id_solicitud_activo; ?>&estado=visto bueno G.A.&id_usuario=<?php echo $_SESSION[id_usuario]; ?>&tipo=activo" class='accion btn btn-green btn-icon' style='float: right; margin-left: 5px;'>Visto Bueno <i class='entypo-pencil'></i></a>
                        <a href="control/solicitud_activo/aprobar_solicitud_ga.php?id=<?php echo $id_solicitud_activo; ?>&estado=sin visto bueno G.A.&id_usuario=<?php echo $_SESSION[id_usuario]; ?>&tipo=activo" class='accion btn btn-red btn-icon' style='float: right; margin-left: 5px;'>
                            Rechazar Detalles <i class='entypo-cancel'></i></a>
                        <button class='accion btn btn-red btn-icon view_modal_rechazar' style='float: right; margin-left: 5px;'>
                            Anular Solicitud <i class='entypo-cancel'></i></button>

                        <button type="button" class="btn btn-default pull-right btn-icon" data-dismiss="modal">Cerrar <i class='entypo-cancel'></i></button>
                    <?php } ?>
                </div>
            <?php } ?>
            <?php if ($_SESSION[nivel] == 'GERENTE GENERAL') { ?>
                <div class="col-sm-12">
                    <?php if ($registro_sol[estado_solicitud_activo] == 'SOLICITADO') { ?>
                        <!-- <a href='control/solicitud_activo/aprobar_solicitud.php?id=<?= $id_solicitud_activo; ?>' class='accion btn btn-green btn-icon' style='float: right; margin-left: 5px;'>Aprobar <i class='entypo-pencil'></i></a>
                        <button class='accion btn btn-red btn-icon view_modal_rechazar' style='float: right; margin-left: 5px;'>
                            Rechazar <i class='entypo-cancel'></i></button>
                        <button type="button" class="btn btn-default pull-right btn-icon" data-dismiss="modal">Cerrar <i class='entypo-cancel'></i></button> -->
                    <?php } ?>
                </div>
            <?php } ?>
            <?php if ($_SESSION[nivel] == 'GERENTE TECNICO') { ?>
                <div class="col-sm-12">
                    <?php if ($registro_sol[estado_solicitud_activo] == 'SOLICITADO') { ?>
                        <!-- <a href='control/solicitud_activo/aprobar_solicitud.php?id=<?= $id_solicitud_activo; ?>' class='accion btn btn-green btn-icon' style='float: right; margin-left: 5px;'>Aprobar <i class='entypo-pencil'></i></a>
                        <button class='accion btn btn-red btn-icon view_modal_rechazar' style='float: right; margin-left: 5px;'>
                            Rechazar <i class='entypo-cancel'></i></button>
                        <button type="button" class="btn btn-default pull-right btn-icon" data-dismiss="modal">Cerrar <i class='entypo-cancel'></i></button> -->
                    <?php } ?>
                </div>
            <?php } ?>
            <?php if ($_SESSION[nivel] == 'GERENTE COMERCIAL') { ?>
                <div class="col-sm-12">
                    <?php if ($registro_sol[estado_solicitud_activo] == 'SOLICITADO') { ?>
                        <!-- <a href='control/solicitud_activo/aprobar_solicitud.php?id=<?= $id_solicitud_activo; ?>' class='accion btn btn-green btn-icon' style='float: right; margin-left: 5px;'>Aprobar <i class='entypo-pencil'></i></a>
                        <button class='accion btn btn-red btn-icon view_modal_rechazar' style='float: right; margin-left: 5px;'>
                            Rechazar <i class='entypo-cancel'></i></button>
                        <button type="button" class="btn btn-default pull-right btn-icon" data-dismiss="modal">Cerrar <i class='entypo-cancel'></i></button> -->
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if ($_SESSION[nivel] == 'PRESUPUESTO') { ?>
                <div class="col-sm-12">
                    <?php if ($registro_sol[estado_solicitud_activo] == 'VERIFICADO') { ?>
                        <?php 
                            $consultar = $bd->Consulta("SELECT observaciones FROM derivaciones WHERE tipo_solicitud='activo' AND id_solicitud=$id_solicitud_activo");
                            $daos_consulta = $bd->getFila($consultar);
                            if($daos_consulta[observaciones] != "SIN EXISTENCIA"){
                        ?>
                            <a href="documents/<?php echo $id_solicitud_activo; ?>_activo.pdf" target="_blank" class="btn btn-red pull-left">Verificacion de Inexistencia</a>
                        <?php } ?>
                        <button type="button" class="btn btn-default pull-right btn-icon" data-dismiss="modal">Cerrar <i class='entypo-cancel'></i></button>
                        <button id_solicitud=<? echo $id_solicitud_activo; ?> id_usuario=<?php echo $_SESSION[id_usuario] ?> type="button" class="btn btn-success pull-right btn-icon ml-2" id="enviarPresupuesto" data-dismiss="modal">Enviar <i class='entypo-cancel'></i></button>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if ($_SESSION[nivel] == 'ADQUISICION') { ?>
                <div class="col-sm-12">
                    <?php if ($registro_sol[estado_solicitud_activo] == 'APROBADO') { ?>
                        <a href='control/solicitud_activo/solicitud_adquisicion.php?id=<?= $id_solicitud_activo; ?>&estado=ADQUISICION' class='accion btn btn-green btn-icon' style='float: right; margin-left: 5px;'>En adquisición <i class='entypo-pencil'></i></a>
                    <?php } elseif ($registro_sol[estado_solicitud_activo] == 'ADQUISICION') { ?>
                        <a href='control/solicitud_activo/solicitud_adquisicion.php?id=<?= $id_solicitud_activo; ?>&estado=COMPRADO' class='accion btn btn-blue btn-icon' style='float: right; margin-left: 5px;'>Comprado <i class='entypo-pencil'></i></a>
                    <?php } ?>
                    <button type="button" class="btn btn-default pull-right btn-icon" data-dismiss="modal">Cerrar <i class='entypo-cancel'></i></button>
                </div>
            <?php } ?>

            <?php if ($_SESSION[nivel] == 'RPA') { ?>
                <div class="col-sm-12">
                    <?php if ($registro_sol[estado_solicitud_activo] == 'PRESUPUESTADO') { ?>
                        <a href="documents/presupuesto_<?php echo $id_solicitud_activo; ?>_activo.pdf" target="_blank" class="btn btn-red pull-left">Cerificación Presupuestaria</a>
                        <button id_solicitud="<?php echo $id_solicitud_activo; ?>" id_usuario="<?php echo  $_SESSION[id_usuario]; ?>" totales="<?php echo $totales; ?> " class='btn btn-green btn-icon' style='float: right; margin-left: 5px;' id="aprobarRPA">
                            Enviar <i class='entypo-cancel'></i></button>
                        <button type="button" class="btn btn-default pull-right btn-icon" data-dismiss="modal">Cerrar <i class='entypo-cancel'></i></button>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if ($_SESSION[nivel] == 'ACTIVOS' && $registro_sol[existencia_activo] == 'SI' && $registro_sol[estado_solicitud_activo] == 'APROBADO') { ?>
                <div class="col-sm-12">
                    <a href='control/solicitud_activo/despachar_solicitud.php?id_solicitud_activo=<?= $id_solicitud_activo; ?>' class='btn btn-green btn-icon despachar_solicitud' style='float: right; margin-left: 5px;'>Despachar
                        <i class="entypo-forward"></i></a>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
                </div>


            <?php } elseif ($_SESSION[nivel] == 'ACTIVOS' && $registro_sol[existencia_activo] == 'NO' && $registro_sol[estado_solicitud_activo] == 'APROBADO') { ?>
                <a href='control/solicitud_activo/solicitud_sin_existencia.php?id=<?= $id_solicitud_activo; ?>' class='accion btn btn-danger btn-icon' style='float: right; margin-left: 5px;'>Sin Existencia <i class='entypo-forward'></i></a>
                <button type="button" class="btn btn-default pull-right btn-icon" data-dismiss="modal">Cerrar <i class='entypo-cancel'></i></button>
            <?php }
            if ($_SESSION[nivel] == 'ACTIVOS' && $registro_sol[existencia_activo] == 'NO' && $registro_sol[estado_solicitud_activo] == 'COMPRADO') { ?>
                <a href='control/solicitud_activo/solicitud_adquisicion.php?id=<?= $id_solicitud_activo; ?>&estado=DESPACHADO SIN EXISTENCIA' class='accion btn btn-orange btn-icon' style='float: right; margin-left: 5px;'>Despachar activo sin existencia <i class='entypo-pencil'></i></a>
                <button type="button" class="btn btn-default pull-right btn-icon" data-dismiss="modal">Cerrar <i class='entypo-cancel'></i></button>
            <?php } ?>


            <?php if ($registro_sol[estado_solicitud_activo] == 'DESPACHADO') { ?>
                <div class="col-sm-12">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
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
                <h3 class="title"><b>Rechazar Solicitud de activo</b></h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <label for="fecha_registro" class="col-sm-2 control-label">Fecha de solicitud</label>
                    <div class="col-sm-2">
                        <input type="text" name="fecha_registro" id="fecha_registro" class="form-control required datepicker" placeholder='' value='<?php echo date("d-m-Y", strtotime($registro_sol[fecha_solicitud])); ?>' readonly />
                    </div>
                    <label for="trabajador" class="col-sm-2 control-label">Nombre Solicitante</label>
                    <div class="col-sm-6">
                        <input type="text" name="trabajador" id="trabajador" class="form-control required text" placeholder='' value='<?php echo utf8_encode($registro_sol[nombre_solicitante]); ?>' readonly />
                    </div>
                </div>
                <div class="row">
                    <form name="frm_solicitud_activo" id="frm_solicitud_activo" action="control/solicitud_activo/rechazar_solicitud.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">

                        <label for="observacion" class="col-sm-2 control-label">Observacion</label>
                        <div class="col-sm-10">

                            <textarea name="observacion" id="observacion" class="form-control required text" cols="120" rows="3" placeholder='Escriba el motivo del rechazo u observación...'></textarea>
                        </div>
                        <hr>
                        <input type="hidden" name="id_solicitud_activo" value="<?php echo $id_solicitud_activo; ?>">
                        <input type="hidden" name="id_usuario" value="<?php echo $_SESSION[id_usuario]; ?>">
                        <hr>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-danger pull-right btn-icon" style="margin-right: 25px;margin-top:10px">Rechazar <i class='entypo-cancel'></i></button>
                                <button type="button" class="btn btn-default pull-right btn-icon" style="margin-right: 25px;margin-top:10px" data-dismiss="modal">Cerrar <i class='entypo-cancel'></i></button>
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

        $('#enviarPresupuesto').click(function(e) {
            let id = $(this).attr('id_solicitud');
            let id_usuario = $(this).attr('id_usuario');
            let estado = $('#selectPresupuesto').val();
            var fileInput = $('#fileCertificacionPresupuestaria')[0];
            var file = fileInput.files[0];
            let array = [];
            let tamanio = parseInt($('#tamanio').val());
            let contador = 1;
            var form_data = new FormData();
            form_data.append('id', id);
            form_data.append('estado', estado);
            form_data.append('archivo', file);
            form_data.append('id_usuario', id_usuario);
            for (let contador = 1; contador <= tamanio; contador++) {
                let detalle_id = '#id_detalle_' + contador;
                let select_detalles = $(detalle_id).val();
                let selectId = '#id_partida_' + contador;
                let selectedValue = $(selectId).val();
                form_data.append('partidas[]', select_detalles + '-' + selectedValue);
            }
            if (file) {
                $.ajax({
                    url: 'control/solicitud_activo/presupuestar.php', // Ruta al controlador PHP
                    type: 'POST',
                    data: form_data,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Manejar la respuesta del controlador PHP
                        if (response.startsWith("Solicitud")) {
                            jAlert("Solicitud despachada con exito", "Approval", function(
                                resp) {
                                window.location.reload();
                            });
                        } else {
                            jAlert(response, "Mensaje")

                        }

                    },
                    error: function(xhr, status, error) {
                        // Manejar el error de la solicitud Ajax
                        console.error(error);
                    }
                });
            } else {
                jAlert("Por favor suba la certificacion presupuestaria", "Mensaje")
                return;
            }


        });
        $('#aprobarRPA').click(function(e) {
            let mensaje = "";
            let aprobar = null;
            let id = $(this).attr('id_solicitud');
            id = parseInt(id);
            let id_usuario = $(this).attr('id_usuario');
            let totales = $(this).attr('totales');
            totales = parseInt(totales);
            let check_certificacion = $("#check_cert_presupuestaria").is(':checked');
            let check_poa = $("#check_poa").is(':checked');
            let check_pac = $("#check_pac").is(':checked');

            if (totales <= 20000) {
                console.log(check_certificacion && check_poa, )
                mensaje = (check_certificacion && check_poa) ? 'Aprobará la solicitud.' : 'Rechazarará la solicitud.';
                aprobar = (check_certificacion && check_poa) ? true : false;
            } else {
                mensaje = (check_certificacion && check_poa && check_pac) ? 'Aprobará la solicitud.' : 'Rechazarará la solicitud.';
                aprobar = (check_certificacion && check_poa && check_pac) ? true : false;
            }
            jConfirm("¿Est&aacute; seguro de realizar la acci&oacute;n?. " + mensaje, "Mensaje", function(resp) {
                if (resp) {
                    let data = {
                        'id': id,
                        'id_usuario': id_usuario,
                        'totales': totales,
                        'check_certificacion': check_certificacion ? 1 : 0,
                        'check_poa': check_poa ? 1 : 0,
                        'check_pac': check_pac ? 1 : 0,
                        'aprobar': aprobar ? 1 : 0,
                    }
                    console.log(data, 'dat');
                    $.ajax({
                        url: 'control/solicitud_activo/aprobar_solicitud.php', // Ruta al controlador PHP
                        type: 'POST',
                        data: {
                            'id': id,
                            'id_usuario': id_usuario,
                            'totales': totales,
                            'check_certificacion': check_certificacion ? 1 : 0,
                            'check_poa': check_poa ? 1 : 0,
                            'check_pac': check_pac ? 1 : 0,
                            'aprobar': aprobar ? 1 : 0,
                        },

                        success: function(response) {
                            // Manejar la respuesta del controlador PHP
                            if (response.startsWith("Accion")) {
                                jAlert(response, "Approval", function(
                                    resp) {
                                    window.location.reload();
                                });
                            } else {
                                jAlert(response, "Mensaje")

                            }

                        },
                        error: function(xhr, status, error) {
                            // Manejar el error de la solicitud Ajax
                            console.error(error);
                        }
                    });
                }
            })
        });

        jQuery(".view_modal_rechazar").live("click", function() {
            jQuery("#modal_rechazar_solicitud").modal('show');
        });
    });
</script>
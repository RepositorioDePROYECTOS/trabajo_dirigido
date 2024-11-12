<?php
include("modelo/material.php");
include("modelo/detalle_material.php");

$id = $_GET[id];
// echo $id; Correcciones
$derivaciones = $bd->Consulta("SELECT * FROM derivaciones WHERE id_derivacion = $id");
$derivacion = $bd->getFila($derivaciones);
// var_dump($derivacion);
$fecha = "";
$nombre_solicitante = "";
$existencia = "";
$tipo_buscador = "";
$justificativo = "";
$tipo = "";
if ($derivacion[tipo_solicitud] == 'material') {
    $tipo = $derivacion[tipo_solicitud];
    $registros_solicitud = $bd->Consulta("SELECT * 
        FROM solicitud_material 
        WHERE id_solicitud_material=$derivacion[id_solicitud]
        AND programa_solicitud_material IS NULL
        AND actividad_solicitud_material IS NULL");
    $detalles = $bd->Consulta("SELECT d.precio_unitario, d.id_detalle_material as id_detalle, d.descripcion, d.unidad_medida, d.cantidad_solicitada
        -- Estaba en el select cuando este habilitado las partidas , p.codigo_partida, p.nombre_partida 
        FROM solicitud_material as s 
        INNER JOIN detalle_material as d ON d.id_solicitud_material = s.id_solicitud_material 
        -- INNER JOIN partidas as p ON p.id_partida = d.id_partida
        -- INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_material
        WHERE s.id_solicitud_material=$derivacion[id_solicitud]
        AND s.programa_solicitud_material IS NULL
        AND s.actividad_solicitud_material IS NULL");

    $registro_sol = $bd->getFila($registros_solicitud);
    $tipo_buscador = "ALMACENERO";
    $fecha = date("d-m-Y", strtotime($registro_sol[fecha_solicitud]));
    $nombre_solicitante = utf8_encode($registro_sol[nombre_solicitante]);
    $existencia = utf8_encode($registro_sol[existencia_material]);
    $justificativo = utf8_encode($registro_sol[justificativo]);
} elseif ($derivacion[tipo_solicitud] == 'activo') {
    $tipo = $derivacion[tipo_solicitud];
    $registros_solicitud = $bd->Consulta("SELECT * 
        FROM solicitud_activo 
        WHERE id_solicitud_activo=$derivacion[id_solicitud]
        AND programa_solicitud_activo IS NULL
        AND actividad_solicitud_activo IS NULL");
    $detalles = $bd->Consulta("SELECT d.precio_unitario, d.id_detalle_activo as id_detalle, d.descripcion, d.unidad_medida, d.cantidad_solicitada
        -- Estaba en el select cuando este habilitado las partidas , p.codigo_partida, p.nombre_partida 
        FROM solicitud_activo as s 
        INNER JOIN detalle_activo as d ON d.id_solicitud_activo = s.id_solicitud_activo 
        -- INNER JOIN partidas as p ON p.id_partida = d.id_partida
        -- INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_activo
        WHERE s.id_solicitud_activo=$derivacion[id_solicitud]
        AND s.programa_solicitud_activo IS NULL
        AND s.actividad_solicitud_activo IS NULL");

    $registro_sol = $bd->getFila($registros_solicitud);
    $tipo_buscador = "ACTIVOS";
    $fecha = date("d-m-Y", strtotime($registro_sol[fecha_solicitud]));
    $nombre_solicitante = utf8_encode($registro_sol[nombre_solicitante]);
    $existencia = utf8_encode($registro_sol[existencia_material]);
    $justificativo = $registro_sol[justificativo];
} else {
    $tipo = $derivacion[tipo_solicitud];
    $registros_solicitud = $bd->Consulta("SELECT * 
        FROM solicitud_servicio 
        WHERE id_solicitud_servicio =$derivacion[id_solicitud]
        AND programa_solicitud_servicio IS NULL
        AND actividad_solicitud_servicio IS NULL");
    $detalles = $bd->Consulta("SELECT d.precio_unitario, d.id_detalle_servicio as id_detalle, d.descripcion, d.unidad_medida, d.cantidad_solicitada
        -- Estaba en el select cuando este habilitado las partidas , p.codigo_partida, p.nombre_partida 
        FROM solicitud_servicio as s 
        INNER JOIN detalle_servicio as d ON d.id_solicitud_servicio = s.id_solicitud_servicio 
        -- INNER JOIN partidas as p ON p.id_partida = d.id_partida
        WHERE s.id_solicitud_servicio =$derivacion[id_solicitud]
        AND s.programa_solicitud_servicio IS NULL
        AND s.actividad_solicitud_servicio IS NULL");

    $registro_sol = $bd->getFila($registros_solicitud);
    $tipo_buscador = "SERVICIO";
    $fecha = date("d-m-Y", strtotime($registro_sol[fecha_solicitud]));
    $nombre_solicitante = utf8_encode($registro_sol[nombre_solicitante]);
    $existencia = utf8_encode($registro_sol[existencia_material]);
    $justificativo = $registro_sol[justificativo];
}

$lista_proveedores = $bd->Consulta("SELECT * FROM proveedores ORDER BY id_proveedor DESC");
// Verificar si ya se cumplio todos los pedidos
if ($derivacion[tipo_solicitud] == "material") {
    $detalles_de_solicitud = $bd->Consulta("SELECT count(d.id_detalle_material) as id_detalle 
            FROM solicitud_material as s 
            INNER JOIN detalle_material as d ON d.id_solicitud_material = s.id_solicitud_material 
            WHERE s.id_solicitud_material=$derivacion[id_solicitud]
            AND programa_solicitud_material IS NULL
            AND actividad_solicitud_material IS NULL");
    $detalle_de_solicitud = $bd->getFila($detalles_de_solicitud);
} elseif ($derivacion[tipo_solicitud] == 'activo') {
    $detalles_de_solicitud = $bd->Consulta("SELECT count(d.id_detalle_activo) as id_detalle 
            FROM solicitud_activo as s 
            INNER JOIN detalle_activo as d ON d.id_solicitud_activo = s.id_solicitud_activo 
            WHERE s.id_solicitud_activo=$derivacion[id_solicitud]
            AND s.programa_solicitud_activo IS NULL
            AND s.actividad_solicitud_activo IS NULL");
    $detalle_de_solicitud = $bd->getFila($detalles_de_solicitud);
} else {
    $detalles_de_solicitud = $bd->Consulta("SELECT count(d.id_detalle_servicio) as id_detalle 
            FROM solicitud_servicio as s 
            INNER JOIN detalle_servicio as d ON d.id_solicitud_servicio = s.id_solicitud_servicio 
            WHERE s.id_solicitud_servicio =$derivacion[id_solicitud]
            AND s.programa_solicitud_servicio IS NULL
            AND s.actividad_solicitud_servicio IS NULL");
    $detalle_de_solicitud = $bd->getFila($detalles_de_solicitud);
}
// var_dump($detalle);
$cantidad_requisitos = $bd->Consulta("SELECT count(id_detalle) as id_detalles FROM requisitos WHERE id_solicitud=$derivacion[id_solicitud] AND id_derivaciones=$id");
$cantidad_requisito  = $bd->getFila($cantidad_requisitos);
// var_dump($cantidad_requisito);
$mostrar1 = "block";
$mostrar2 = "none";
$mostrar3 = "none";
$mostrar4 = "none";
if ($_SESSION[nivel] == "ADQUISICION") {
    if ($cantidad_requisito[id_detalles] == $detalle_de_solicitud[id_detalle]) {
        $mostrar1 = "none";
        $mostrar2 = "block";
    }
} else {
    $mostrar1 = "none";
    $mostrar2 = "none";
    if ($cantidad_requisito[id_detalles] == $detalle_de_solicitud[id_detalle]) {
        $mostrar3 = "block";
    } else {
        $mostrar4 = "block";
    }
}
// echo $mostrar4;
// Verificar si ya se cumplio todos los pedidos

?>
<div style="display: <?php echo $mostrar1; ?>;">
    <h2>
        <button type="reset" class="btn btn-success cancelar pull-left">Volver&nbsp;<i class="entypo-back"></i></button>
        <a href="?mod=proveedor&pag=create" class="btn btn-info pull-left">Proveedores&nbsp;<i class="entypo-plus"></i></a>
        <br><br>
        Registrar Proveedor
    </h2>
    <div class="panel panel-default panel-shadow" data-collapsed="0">

        <div class="panel-body">
            <h4>Fecha de solicitud: <strong><?php echo $fecha; ?></strong></h4>
            <h4>Nombre Solicitante: <strong><?php echo $nombre_solicitante; ?></strong></h4>
            <h4>Justificativo: <strong><?php echo utf8_encode($justificativo); ?></strong></h4>
        </div>
        <div class="row">
            <div class="col-md-6">
                <ul>
                    <?php while ($detalle = $bd->getFila($detalles)) { ?>
                        <li class="border">
                            <div class="checkbox_group">
                                <?php
                                $consulta = $bd->Consulta("SELECT * FROM requisitos WHERE id_detalle=$detalle[id_detalle]");
                                $datos = $bd->getFila($consulta);
                                ?>

                                <p><?php echo utf8_encode("<strong>Requerimiento:</strong> " . $detalle[descripcion]); ?></p>
                                <p><?php echo utf8_encode("<strong>Unidad de Medida: </strong>" . $detalle[unidad_medida]); ?></p>
                                <p><?php echo utf8_encode("<strong> Cantidad solicitada: </strong>" . $detalle[cantidad_solicitada]); ?></p>
                                <!-- <p><?php //echo utf8_encode("<strong> Precio Establecido: </strong>" . $detalle[precio_total]); 
                                        ?></p> -->
                                <?php
                                if (empty($datos)) {
                                ?>
                                    <p>
                                        <?php echo utf8_encode("<strong> Precio Unitario: </strong>"); ?>
                                        <input type="number" step="0.01" max="<?php echo $detalle[precio_unitario] ?>" class="precio-partidas precio-input calculo-total" name="precio_establecido_<?php echo $detalle[id_detalle] ?>" id="precio_establecido_<?php echo $detalle[id_detalle] ?>" value="<?php echo $detalle[precio_unitario] ?>" data-cantidad="<?php echo $detalle['cantidad_solicitada']; ?>" oninput="calcularTotal(this)">
                                    </p>
                                    <input type="hidden" name="cantidadTotal" value="cantidadTotal" value="<?php echo $detalle[cantidad_solicitada]; ?>">
                                    <p><strong>Costo Total:</strong><i id="itemTotal_<?php echo $detalle[id_detalle]; ?>"> <?php echo $detalle[precio_unitario] * $detalle[cantidad_solicitada]; ?></i></p>
                                <?php } else { ?>
                                    <p>
                                        <?php echo utf8_encode("<strong> Precio Unitario: </strong>" . $detalle[precio_unitario]); ?></p>
                                <?php } ?>

                                <input type="checkbox" class="color_checkbox estilos checkbox-dinamico" name="<?php echo $detalle[id_detalle] ?>" id="<?php echo $detalle[id_detalle] ?>">
                                <?php
                                $consulta = $bd->Consulta("SELECT * FROM requisitos WHERE id_detalle=$detalle[id_detalle]");
                                $datos = $bd->getFila($consulta);
                                if (!empty($datos)) {
                                    $proveedores = $bd->Consulta("SELECT * FROM proveedores WHERE id_proveedor=$datos[id_proveedor]");
                                    $proveedor = $bd->getFila($proveedores);
                                    if (!empty($proveedor)) {
                                        echo "<p style='background-color:#D0FCA4;'><strong>$proveedor[nombre] - $proveedor[nit]</strong></p>";
                                    }

                                ?>
                                    <a target='_blank' href="vista/derivaciones/pdf.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_detalle=<?php echo $detalle[id_detalle]; ?>&tipo=<?php echo $tipo; ?>" class="btn btn-info estilos"><i class="entypo-print"></i></a>
                                    <a href="control/requisitos/eliminar.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_detalle=<?php echo $detalle[id_detalle]; ?>" class="eliminar_lista btn btn-danger estilos"><i class="entypo-cancel"></i></a>
                                <?php } //} 
                                ?>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-md-6">
                <form name="frm_conf_refrigerio" id="frm_conf_refrigerio" method="post" role="form" class="validate form-horizontal form-groups-bordered">
                    <div class="form-group">
                        <label for="fecha_elaboracion" class="col-sm-3 control-label">Fecha Elaboracion</label>
                        <div class="col-sm-9">
                            <input type="date" name="fecha_elaboracion" id="fecha_elaboracion" readonly value="<?php echo date('Y-m-d'); ?>" class="form-control required text" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="id_proveedor" class="col-sm-3 control-label">Lista de Proveedores:</label>
                        <div class="col-sm-9">
                            <select name="id_proveedor" id="id_proveedor" class="form-control required select2">
                                <option value="">--SELECCIONE--</option>
                                <?php
                                while ($proveedor = $bd->getFila($lista_proveedores)) {
                                    echo "hola";
                                    echo utf8_encode("<option value='$proveedor[id_proveedor]'>$proveedor[nombre] - NIT: $proveedor[nit]</option>");
                                }
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tipo_solicitud" class="col-sm-3 control-label">Tipo de Solicitud:</label>
                        <div class="col-sm-9">
                            <select name="tipo_solicitud" id="tipo_solicitud" class="form-control required select2">
                                <option value="">--SELECCIONE--</option>
                                <option value="compra">ORDEN DE COMPRA</option>
                                <option value="contrato">CONTRATO</option>
                            </select>
                        </div>
                    </div>

                    <br><br>
                    <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION[id_usuario]; ?>">
                    <input type="hidden" name="id_solicitud" id="id_solicitud" value="<?php echo $derivacion[id_solicitud]; ?>">
                    <input type="hidden" name="id_derivacion" id="id_derivacion" value="<?php echo $id; ?>">
                    <button type="button" class="btn btn-green btn-icon pull-right" id="enviar_proveedor">
                        Agregar <i class="entypo-plus"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<div style="display: <?php echo $mostrar2; ?>;">
    <h2>
        <button type="reset" class="btn btn-success cancelar pull-left">Volver&nbsp;<i class="entypo-back"></i></button><br></br>
        Pasos de la Adquisicion o Servicio
    </h2>
    <?php
    // echo "MOSTRAR 2: ".$derivacion[id_solicitud]."  -  ";
    if ($derivacion[tipo_solicitud] == "material") {
        $detalles_de_solicitud_por_requisito = $bd->Consulta("SELECT p.id_proveedor, p.nombre, p.nit, r.fecha_elaboracion, d.id_detalle_material as id_detalle, dv.estado_derivacion, s.objetivo_contratacion, s.justificativo, s.nombre_solicitante, s.unidad_solicitante, s.oficina_solicitante, SUM(d.precio_total) as total_gastado
                FROM solicitud_material as s 
                INNER JOIN derivaciones as dv ON dv.id_solicitud = s.id_solicitud_material
                INNER JOIN detalle_material as d ON d.id_solicitud_material = s.id_solicitud_material 
                INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_material
                INNER JOIN proveedores as p ON p.id_proveedor = r.id_proveedor
                WHERE s.id_solicitud_material=$derivacion[id_solicitud]
                GROUP BY p.id_proveedor");
        // , p.nombre, p.nit, r.fecha_elaboracion, d.id_detalle_material, dv.estado_derivacion
        // $detalle_de_solicitud_por_requisito = $bd->getFila($detalles_de_solicitud_por_requisito);
    } elseif ($derivacion[tipo_solicitud] == 'activo') {
        $detalles_de_solicitud_por_requisito = $bd->Consulta("SELECT  p.id_proveedor, p.nombre, p.nit, r.fecha_elaboracion, d.id_detalle_activo as id_detalle, dv.estado_derivacion, s.objetivo_contratacion, s.justificativo, s.nombre_solicitante, s.unidad_solicitante, s.oficina_solicitante, SUM(d.precio_total) as total_gastado
                FROM solicitud_activo as s 
                INNER JOIN derivaciones as dv ON dv.id_solicitud = s.id_solicitud_activo
                INNER JOIN detalle_activo as d ON d.id_solicitud_activo = s.id_solicitud_activo
                INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_activo
                INNER JOIN proveedores as p ON p.id_proveedor = r.id_proveedor
                where s.id_solicitud_activo= $derivacion[id_solicitud]
                GROUP BY p.id_proveedor");
        // , p.nombre, p.nit, r.fecha_elaboracion, d.id_detalle_activo, dv.estado_derivacion
        // $detalle_de_solicitud_por_requisito = $bd->getFila($detalles_de_solicitud_por_requisito);
    } else {
        $detalles_de_solicitud_por_requisito = $bd->Consulta("SELECT  p.id_proveedor, p.nombre, p.nit, r.fecha_elaboracion, d.id_detalle_servicio as id_detalle, dv.estado_derivacion, s.objetivo_contratacion, s.justificativo, s.nombre_solicitante, s.unidad_solicitante, s.oficina_solicitante, SUM(d.precio_total) as total_gastado
            FROM solicitud_servicio as s 
            INNER JOIN derivaciones as dv ON dv.id_solicitud = s.id_solicitud_servicio
            INNER JOIN detalle_servicio as d ON d.id_solicitud_servicio = s.id_solicitud_servicio
            INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_servicio
            INNER JOIN proveedores as p ON p.id_proveedor = r.id_proveedor
            where s.id_solicitud_servicio = $derivacion[id_solicitud]
            GROUP BY p.id_proveedor");
        // , p.nombre, p.nit, r.fecha_elaboracion, d.id_detalle_servicio, dv.estado_derivacion
        // $detalle_de_solicitud_por_requisito = $bd->getFila($detalles_de_solicitud_por_requisito);
    }
    ?>
    <br />
    <div class="table-responsive">
        <table class="table table-bordered datatable" id="table-1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Objetivo</th>
                    <th>Justificacion</th>
                    <th>Solicitante</th>
                    <th>Unidad Solicitante</th>
                    <th>Proveedor</th>
                    <th>Fecha de Elaboracion</th>
                    <th>Detalles de <br>la Solicitud</th>
                    <th width="160">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $n = 0;
                while ($registro_requisitos = $bd->getFila($detalles_de_solicitud_por_requisito)) {
                    $n++;
                    if ($derivacion[tipo_solicitud] == "material") {
                        $requisitos_detallados = $bd->Consulta("SELECT *
                            FROM detalle_material as d
                            INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_material
                            WHERE id_solicitud_material=$derivacion[id_solicitud]
                            AND  r.id_proveedor=$registro_requisitos[id_proveedor]");
                    } elseif ($derivacion[tipo_solicitud] == 'activo') {
                        $requisitos_detallados = $bd->Consulta("SELECT *
                            FROM detalle_activo as d
                            INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_activo 
                            where id_solicitud_activo= $derivacion[id_solicitud]
                            AND  r.id_proveedor=$registro_requisitos[id_proveedor]");
                    } else {
                        $requisitos_detallados = $bd->Consulta("SELECT *
                        FROM detalle_servicio as d
                        INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_servicio
                        where id_solicitud_servicio = $derivacion[id_solicitud]
                        AND  r.id_proveedor=$registro_requisitos[id_proveedor]");
                    }
                ?>
                    <tr>
                        <td><?php echo $n; ?></td>
                        <td><?php echo utf8_encode("$registro_requisitos[objetivo_contratacion]"); ?></td>
                        <td><?php echo utf8_encode("$registro_requisitos[justificativo]"); ?></td>
                        <td><?php echo utf8_encode("$registro_requisitos[nombre_solicitante]"); ?></td>
                        <td><?php echo ($registro_requisitos[unidad_solicitante] != NULL) ? utf8_encode("$registro_requisitos[unidad_solicitante]") : utf8_encode("$registro_requisitos[oficina_solicitante]"); ?></td>
                        <td><?php echo utf8_encode("$registro_requisitos[nombre] - $registro_requisitos[nit]"); ?></td>
                        <td><?php echo utf8_encode("$registro_requisitos[fecha_elaboracion]"); ?></td>
                        <td>
                            <?php
                            while ($detalles = $bd->getFila($requisitos_detallados)) {
                                echo utf8_encode("<ul>
                                    <li>
                                        $detalles[descripcion]<br>Unidad: $detalles[unidad_medida]<br>Cantidad: $detalles[cantidad_solicitada]
                                    </li>
                                </ul>");
                            } ?>
                        </td>
                        <td>
                            <?php if ($_SESSION[nivel] == "ACTIVOS") { ?>
                                <a target='_blank' href="vista/derivaciones/acta_conformidad_no_conformidad_pdf.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>&tipo=<?php echo $tipo; ?>&id_requisitos=<?php echo $registro_requisitos[id_requisitos]; ?>&conformidad=si" class="btn btn-success btn-icon btn-xs">Acta conformidad<i class="entypo-print"></i></a>
                                <a target='_blank' href="vista/derivaciones/acta_conformidad_no_conformidad_pdf.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>&tipo=<?php echo $tipo; ?>&id_requisitos=<?php echo $registro_requisitos[id_requisitos]; ?>&conformidad=no" class="btn btn-danger btn-icon btn-xs">Acta no conformidad<i class="entypo-print"></i></a>
                            <?php } elseif ($_SESSION[nivel] == "ALMACENERO") { ?>
                                <a target='_blank' href="vista/derivaciones/acta_conformidad_no_conformidad_pdf.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>&tipo=<?php echo $tipo; ?>&id_requisitos=<?php echo $registro_requisitos[id_requisitos]; ?>&conformidad=si" class="btn btn-success btn-icon btn-xs">Acta conformidad<i class="entypo-print"></i></a>
                                <a target='_blank' href="vista/derivaciones/acta_conformidad_no_conformidad_pdf.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>&tipo=<?php echo $tipo; ?>&id_requisitos=<?php echo $registro_requisitos[id_requisitos]; ?>&conformidad=no" class="btn btn-danger btn-icon btn-xs">Acta no conformidad<i class="entypo-print"></i></a>
                            <?php } elseif ($_SESSION[nivel] == "ADQUISICION") {  ?>
                                <?php if ($registro_requisitos[estado_derivacion] == "proveedor asignado") { ?>
                                    <?php
                                    $consulta_requisitos = $bd->Consulta("SELECT * 
                                        FROM requisitos 
                                        WHERE id_solicitud=$derivacion[id_solicitud]
                                        AND id_proveedor=$registro_requisitos[id_proveedor]
                                        AND estado='visto bueno rpa' 
                                        OR estado='sin visto bueno rpa' 
                                        OR estado='sin visto bueno G.A.'
                                    ");
                                    $c_requisitos = $bd->getFila($consulta_requisitos);
                                    // print_r($c_requisitos);
                                    if ($c_requisitos) {
                                        if ($c_requisitos[estado] == "visto bueno rpa") { ?>
                                            <a class='btn btn-success btn-icon btn-xs' style='float: right; margin-right: 15px;'>Proveedor Aprobado<i class='entypo-eye'></i></a>
                                        <?php } elseif ($c_requisitos[estado] == "visto bueno G.A.") { ?>
                                            <a target='_blank' href="vista/derivaciones/pdf_proveedores_seleccionados.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_proveedor=<?php echo $registro_requisitos[id_proveedor] ?>&tipo=<?php echo $derivacion[tipo_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>" class="btn btn-warning btn-icon btn-xs" style='float: right; margin-right: 15px;'>
                                                Informe de Adjudicacion<i class="entypo-print"></i>
                                            </a>
                                            <a href="?mod=derivaciones&pag=condiciones&id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_proveedor=<?php echo $registro_requisitos[id_proveedor] ?>&tipo=<?php echo $derivacion[tipo_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>" class="btn btn-info btn-icon btn-xs" style='float: right; margin-right: 15px;'>
                                                Condiciones <i class="entypo-plus"></i>
                                            </a>

                                        <?php } elseif ($c_requisitos[estado] == "sin visto bueno G.A." || $c_requisitos[estado] == "sin visto bueno rpa") { ?>
                                            <button data_id_solicitud=<?php echo $derivacion[id_solicitud]; ?> data_id_proveedor=<?php echo $registro_requisitos[id_proveedor]; ?> data_tipo=<?php echo $derivacion[tipo_solicitud]; ?> data_id_derivacion=<?php echo $derivacion[id_derivacion]; ?> id="borrar_adquisicion_sn_vb_rpa" class="btn btn-danger btn-icon btn-xs" style="float: right; margin-right: 15px;">Borrar Proveedor&nbsp;<i class="entypo-back"></i> </button>
                                            <!-- <p>Mostrar 3_2</p> -->
                                        <?php }
                                    } else { ?>
                                        <a href="?mod=derivaciones&pag=condiciones&id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_proveedor=<?php echo $registro_requisitos[id_proveedor] ?>&tipo=<?php echo $derivacion[tipo_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>" class="btn btn-info btn-icon btn-xs" style='float: right; margin-right: 15px;'>
                                            Condiciones
                                            <i class="entypo-plus"></i>
                                        </a>
                                        <a target='_blank' href="vista/derivaciones/pdf_proveedores_seleccionados.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_proveedor=<?php echo $registro_requisitos[id_proveedor] ?>&tipo=<?php echo $derivacion[tipo_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>" class="btn btn-success btn-icon btn-xs" style='float: right; margin-right: 15px;'>
                                            Sugerencia de Adjudicacion
                                            <i class="entypo-print"></i>
                                        </a>
                                        <a class='btn btn-warning btn-icon btn-xs' style='float: right; margin-right: 15px;'>Esperando Aprobacion RPA<i class='entypo-eye'></i></a>
                                        <?php
                                        // echo $c_requisitos[estado]; 
                                        // echo $registro_requisitos[estado_derivacion];
                                        ?>
                                    <?php } ?>
                                <?php } elseif ($registro_requisitos[estado_derivacion] == "visto bueno rpa") { ?>
                                    <a target='_blank' href="vista/derivaciones/pdf_proveedores_seleccionados.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_proveedor=<?php echo $registro_requisitos[id_proveedor] ?>&tipo=<?php echo $derivacion[tipo_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>" class="btn btn-warning btn-icon btn-xs" style='float: right; margin-right: 15px;'>
                                        Informe de Adjudicacion
                                        <i class="entypo-print"></i>
                                    </a>
                                    <a target='_blank' href="vista/derivaciones/nota_adjudicacion_pdf.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>&tipo=<?php echo $tipo; ?>" class="btn btn-success btn-icon btn-xs" style='float: right; margin-right: 15px;'>
                                        Nota de Adjudicación
                                        <i class="entypo-print"></i>
                                    </a>
                                    <a target='_blank' href="vista/derivaciones/pdf.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>&tipo=<?php echo $tipo; ?>" class="btn btn-info btn-icon btn-xs" style='float: right; margin-right: 15px;'>
                                        Imprimir Orden de <?php echo $tipo; ?>
                                        <i class="entypo-print"></i>
                                    </a>

                                <?php } elseif ($registro_requisitos[estado_derivacion] == "sin visto bueno rpa") { ?>
                                    <button data_id_solicitud=<?php echo $derivacion[id_solicitud]; ?> data_id_proveedor=<?php echo $registro_requisitos[id_proveedor]; ?> data_tipo=<?php echo $derivacion[tipo_solicitud]; ?> data_id_derivacion=<?php echo $derivacion[id_derivacion]; ?> id="borrar_rpa_sn_rpa" class="btn btn-danger btn-icon btn-xs" style="float: right; margin-right: 15px;">
                                        Borrar Proveedor&nbsp;<i class="entypo-back"></i>
                                    </button>
                                    <!-- <p>AQUUI Corregido</p> -->
                                <?php } elseif ($registro_requisitos[estado_derivacion] == "sin visto bueno G.A.") { ?>
                                    <button data_id_solicitud=<?php echo $derivacion[id_solicitud]; ?> data_id_proveedor=<?php echo $registro_requisitos[id_proveedor]; ?> data_tipo=<?php echo $derivacion[tipo_solicitud]; ?> data_id_derivacion=<?php echo $derivacion[id_derivacion]; ?> id="borrar_rpa_sn_vb_ga" class="btn btn-danger btn-icon btn-xs" style="float: right; margin-right: 15px;">
                                        Borrar Proveedor&nbsp;<i class="entypo-back"></i>
                                    </button>
                                    <!-- <p>AQUUI 2</p> -->
                                <?php } elseif ($registro_requisitos[estado_derivacion] == "visto bueno G.A." || $registro_requisitos[estado_derivacion] == "SIN VISTO BUENO G.A.") { ?>
                                    <!-- <a 
                                        href="?mod=derivaciones&pag=condiciones&id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_proveedor=<?php echo $registro_requisitos[id_proveedor] ?>&tipo=<?php echo $derivacion[tipo_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>" 
                                        class="btn btn-info btn-icon btn-xs"
                                        style='float: right; margin-right: 15px;'
                                    >
                                        Condiciones <i class="entypo-plus"></i> 
                                    </a> -->
                                    <a target='_blank' href="vista/derivaciones/pdf_proveedores_seleccionados.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_proveedor=<?php echo $registro_requisitos[id_proveedor] ?>&tipo=<?php echo $derivacion[tipo_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>" class="btn btn-warning btn-icon btn-xs" style='float: right; margin-right: 15px;'>
                                        Informe de Adjudicacion<i class="entypo-print"></i>
                                    </a>
                                    <a target='_blank' href="vista/derivaciones/nota_adjudicacion_pdf.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>&tipo=<?php echo $tipo; ?>" class="btn btn-success btn-icon btn-xs" style='float: right; margin-right: 15px;'>
                                        Nota de Adjudicación<i class="entypo-print"></i>
                                    </a>

                                    <a target='_blank' href="vista/derivaciones/pdf.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>&tipo=<?php echo $tipo; ?>" class="btn btn-info btn-icon btn-xs">Imprimir Orden de Compra<i class="entypo-print"></i></a>
                                <?php } else { ?>
                                    <a href="?mod=derivaciones&pag=condiciones&id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_proveedor=<?php echo $registro_requisitos[id_proveedor] ?>&tipo=<?php echo $derivacion[tipo_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>" class="btn btn-info btn-icon btn-xs">
                                        Condiciones
                                        <i class="entypo-plus"></i>
                                    </a>
                                    <!-- <a 
                                        target='_blank' 
                                        href="vista/derivaciones/pdf_proveedores_seleccionados.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_proveedor=<?php echo $registro_requisitos[id_proveedor] ?>&tipo=<?php echo $derivacion[tipo_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>" 
                                        class="btn btn-warning btn-icon btn-xs" 
                                        style='float: right; margin-right: 15px;'
                                    >
                                        Informe de Adjudicacion<i class="entypo-print"></i>
                                    </a> -->
                                    <!-- Nota de adjudicacion Solo cuando este en visto bueno RPA -->
                                    <!-- <a 
                                        target='_blank' href="vista/derivaciones/nota_adjudicacion_pdf.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>&tipo=<?php echo $tipo; ?>" 
                                        class="btn btn-success btn-icon btn-xs"
                                    >
                                        Nota de Adjudicación
                                        <i class="entypo-print"></i>
                                    </a> -->
                                    <a target='_blank' href="vista/derivaciones/pdf.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>&tipo=<?php echo $tipo; ?>" class="btn btn-info btn-icon btn-xs">
                                        Imprimir Orden de Compra
                                        <i class="entypo-print"></i>
                                    </a>
                                <?php } ?>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
</div>
<!-- VISTA SESSION DIFERENTE DE RPA -->
<div style="display: <?php echo $mostrar3; ?>;">
    <h2>
        <button type="reset" class="btn btn-success cancelar pull-left">Volver&nbsp;<i class="entypo-back"></i></button><br><br>
        Pasos de la Adquisicion o Servicio
    </h2>
    <?php
    if ($derivacion[tipo_solicitud] == "material") {
        $detalles_de_solicitud_por_requisito = $bd->Consulta("SELECT p.id_proveedor, p.nombre, p.nit, r.fecha_elaboracion, d.id_detalle_material as id_detalle, dv.estado_derivacion, r.id_requisitos, s.objetivo_contratacion, s.justificativo, s.nombre_solicitante, s.unidad_solicitante, s.oficina_solicitante, SUM(d.precio_total) as total_gastado
                FROM solicitud_material as s 
                INNER JOIN derivaciones as dv ON dv.id_solicitud = s.id_solicitud_material
                INNER JOIN detalle_material as d ON d.id_solicitud_material = s.id_solicitud_material 
                INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_material
                INNER JOIN proveedores as p ON p.id_proveedor = r.id_proveedor
                WHERE s.id_solicitud_material=$derivacion[id_solicitud]
                GROUP BY p.id_proveedor");
        // , p.nombre, p.nit, r.fecha_elaboracion, d.id_detalle_material, dv.estado_derivacion, r.id_requisitos
        // $detalle_de_solicitud_por_requisito = $bd->getFila($detalles_de_solicitud_por_requisito);
    } elseif ($derivacion[tipo_solicitud] == 'activo') {
        $detalles_de_solicitud_por_requisito = $bd->Consulta("SELECT  p.id_proveedor, p.nombre, p.nit, r.fecha_elaboracion, d.id_detalle_activo as id_detalle, dv.estado_derivacion, r.id_requisitos, s.objetivo_contratacion, s.justificativo, s.nombre_solicitante, s.unidad_solicitante, s.oficina_solicitante, SUM(d.precio_total) as total_gastado
                FROM solicitud_activo as s 
                INNER JOIN derivaciones as dv ON dv.id_solicitud = s.id_solicitud_activo
                INNER JOIN detalle_activo as d ON d.id_solicitud_activo = s.id_solicitud_activo
                INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_activo
                INNER JOIN proveedores as p ON p.id_proveedor = r.id_proveedor
                where s.id_solicitud_activo= $derivacion[id_solicitud]
                GROUP BY p.id_proveedor");
        // , p.nombre, p.nit, r.fecha_elaboracion, d.id_detalle_activo, dv.estado_derivacion, r.id_requisitos
        // $detalle_de_solicitud_por_requisito = $bd->getFila($detalles_de_solicitud_por_requisito);
    } else {
        $detalles_de_solicitud_por_requisito = $bd->Consulta("SELECT  p.id_proveedor, p.nombre, p.nit, r.fecha_elaboracion, d.id_detalle_servicio as id_detalle, dv.estado_derivacion, r.id_requisitos, s.objetivo_contratacion, s.justificativo, s.nombre_solicitante, s.unidad_solicitante, s.oficina_solicitante, SUM(d.precio_total) as total_gastado
            FROM solicitud_servicio as s 
            INNER JOIN derivaciones as dv ON dv.id_solicitud = s.id_solicitud_servicio
            INNER JOIN detalle_servicio as d ON d.id_solicitud_servicio = s.id_solicitud_servicio
            INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_servicio
            INNER JOIN proveedores as p ON p.id_proveedor = r.id_proveedor
            where s.id_solicitud_servicio = $derivacion[id_solicitud]
            GROUP BY p.id_proveedor");
        // , p.nombre, p.nit, r.fecha_elaboracion, d.id_detalle_servicio, dv.estado_derivacion, r.id_requisitos
        // $detalle_de_solicitud_por_requisito = $bd->getFila($detalles_de_solicitud_por_requisito);
    }
    ?>
    <br />
    <div class="table-responsive">
        <table class="table table-bordered datatable" id="table-1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Objetivo</th>
                    <th>Justificativo</th>
                    <th>Solicitante</th>
                    <th>Unidad Solicitante</th>
                    <th>Proveedor</th>
                    <th>Fecha de Elaboracion</th>
                    <th>Detalles de <br>la Solicitud</th>
                    <th width="160">Acciones</th>
                </tr>
            </thead>
            <tbody id="tbodyactas">
                <?php
                $n = 0;
                while ($registro_requisitos = $bd->getFila($detalles_de_solicitud_por_requisito)) {
                    $n++;
                    if ($derivacion[tipo_solicitud] == "material") {
                        $requisitos_detallados = $bd->Consulta("SELECT *
                            FROM detalle_material as d
                            INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_material
                            WHERE id_solicitud_material=$derivacion[id_solicitud]
                            AND  r.id_proveedor=$registro_requisitos[id_proveedor]");
                    } elseif ($derivacion[tipo_solicitud] == 'activo') {
                        $requisitos_detallados = $bd->Consulta("SELECT *
                            FROM detalle_activo as d
                            INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_activo 
                            where id_solicitud_activo= $derivacion[id_solicitud]
                            AND  r.id_proveedor=$registro_requisitos[id_proveedor]");
                    } else {
                        $requisitos_detallados = $bd->Consulta("SELECT *
                        FROM detalle_servicio as d
                        INNER JOIN requisitos as r ON r.id_detalle = d.id_detalle_servicio
                        where id_solicitud_servicio = $derivacion[id_solicitud]
                        AND  r.id_proveedor=$registro_requisitos[id_proveedor]");
                    }
                ?>
                    <tr>
                        <td><?php echo $n; ?></td>
                        <td><?php echo utf8_encode("$registro_requisitos[objetivo_contratacion]"); ?></td>
                        <td><?php echo utf8_encode("$registro_requisitos[justificativo]"); ?></td>
                        <td><?php echo utf8_encode("$registro_requisitos[nombre_solicitante]"); ?></td>
                        <td><?php echo ($registro_requisitos[unidad_solicitante] != NULL) ? utf8_encode("$registro_requisitos[unidad_solicitante]") : utf8_encode("$registro_requisitos[oficina_solicitante]"); ?></td>
                        <td><?php echo utf8_encode("$registro_requisitos[nombre] - NIT: $registro_requisitos[nit]"); ?></td>
                        <td><?php echo utf8_encode("$registro_requisitos[fecha_elaboracion]"); ?></td>
                        <td>
                            <?php
                            while ($detalles = $bd->getFila($requisitos_detallados)) {
                                echo utf8_encode("<ul>
                                    <li>
                                        $detalles[descripcion]<br>Unidad: $detalles[unidad_medida]<br>Cantidad: $detalles[cantidad_solicitada]<br>Precio: $detalles[precio_total] Bs.
                                    </li>
                                </ul>");
                            } ?>
                        </td>
                        <td>
                            <?php if ($_SESSION[nivel] == "ACTIVOS" || $_SESSION[nivel] == "ALMACENERO") { ?>
                                <button name="acta-recepcion" enlace="vista/derivaciones/acta_recepcion_pdf.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>&tipo=<?php echo $tipo; ?>&id_requisitos=<?php echo $registro_requisitos[id_requisitos]; ?>" data-toggle="modal" data-target="modalAclaraciones" class="btn btn-success btn-icon btn-xs">
                                    Acta recepción
                                    <i class="entypo-print"></i>
                                </button>
                                <a target='_blank' href="vista/derivaciones/acta_conformidad_no_conformidad_pdf.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>&tipo=<?php echo $tipo; ?>&id_requisitos=<?php echo $registro_requisitos[id_requisitos]; ?>&conformidad=no" class="btn btn-danger btn-icon btn-xs">
                                    Acta no conformidad
                                    <i class="entypo-print"></i>
                                </a>
                                <button id="ingreso_egreso" data-id="<?php echo $derivacion[id_solicitud]; ?>" data-id-detalle="<?php echo $registro_requisitos[id_detalle]; ?>" data-tipo="<?php echo $tipo; ?>" name="observaciones-form10" enlace="vista/derivaciones/pdf_ingreso_egreso.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>&tipo=<?php echo $tipo; ?>" class="btn btn-info btn-icon btn-xs">
                                    Ingreso y Egreso
                                    <i class="entypo-doc"></i>
                                </button>
                                <a target='_blank' href="vista/derivaciones/pdf_recepcion.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>&tipo=<?php echo $tipo; ?>" class="btn btn-info btn-icon btn-xs">Recepcion, Conformidad<i class="entypo-doc"></i></a>
                                <button name="asignacion-bienes" enlace="vista/derivaciones/pdf_asignacion_vienes.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>&id_proveedor=<?php echo $registro_requisitos[id_proveedor]; ?>&tipo=<?php echo $tipo; ?>" class="btn btn-info btn-icon btn-xs">Asignacion de Bienes<i class="entypo-doc"></i></button>
                            <?php } elseif ($_SESSION[nivel] == "ALMACENERO") { ?>

                            <?php } elseif ($_SESSION[nivel] == "RPA") { ?>
                                <?php // echo $registro_requisitos[estado_derivacion]; 
                                ?>
                                <?php if ($registro_requisitos[estado_derivacion] == "proveedor asignado") { ?>
                                    <?php $consulta_requisitos = $bd->Consulta("SELECT * 
                                        FROM requisitos 
                                        WHERE id_solicitud=$derivacion[id_solicitud]
                                        AND id_proveedor=$registro_requisitos[id_proveedor]
                                        AND estado='visto bueno rpa' OR estado='sin visto bueno rpa'
                                    ");
                                    $c_requisitos = $bd->getFila($consulta_requisitos);
                                    if ($c_requisitos) {
                                        if ($c_requisitos[estado] == "visto bueno rpa") { ?>
                                            <a class='btn btn-success btn-icon btn-xs' style='float: right; margin-right: 15px;'>Proveedor Aprobado<i class='entypo-eye'></i></a>
                                        <?php } else { ?>
                                            <a class='btn btn-info btn-icon btn-xs' style='float: right; margin-right: 15px;'>Proveedor Observado<i class='entypo-eye'></i></a>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <button id="enviar_aprobacion" class='btn btn-success btn-icon btn-xs' style="float: right; margin-right: 15px;" data-id-solicitud="<?php echo $derivacion[id_solicitud]; ?>" data-id-detalle="<?php echo $registro_requisitos[id_detalle]; ?>" data-tipo="<?php echo $tipo; ?>" data-estado="<?php echo "visto_bueno"; ?>" data-id-usuario="<?php echo $_SESSION[id_usuario]; ?>" data-nivel="<?php echo $_SESSION[nivel]; ?>" data-id-proveedor="<?php echo $registro_requisitos[id_proveedor] ?>
                                            ">
                                            Aprobar&nbsp;
                                            <i class="entypo-plus"></i>
                                        </button>
                                        <!-- Cambio del primer boton -->

                                        <button id="enviar_reprobacion" class='btn btn-red btn-icon btn-xs' style="float: right; margin-right: 15px;" data-id-solicitud="<?php echo $derivacion[id_solicitud]; ?>" data-id-detalle="<?php echo $registro_requisitos[id_detalle]; ?>" data-tipo="<?php echo $tipo; ?>" data-estado="<?php echo "no_visto_bueno"; ?>" data-id-usuario="<?php echo $_SESSION[id_usuario]; ?>" data-nivel="<?php echo $_SESSION[nivel]; ?>" data-id-proveedor="<?php echo $registro_requisitos[id_proveedor] ?>
                                            ">
                                            Rechazar&nbsp;
                                            <i class="entypo-plus"></i>
                                        </button>
                                    <?php } ?>
                                <?php } elseif ($registro_requisitos[estado_derivacion] == "visto bueno rpa") { ?>
                                    <a target='_blank' href="vista/derivaciones/nota_adjudicacion_pdf.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>&tipo=<?php echo $tipo; ?>" class="btn btn-success btn-icon btn-xs">
                                        Nota de Adjudicación
                                        <i class="entypo-print"></i>
                                    </a>
                                <?php } elseif ($registro_requisitos[estado_derivacion] == "sin visto bueno rpa") { ?>
                                    <button data_id_solicitud=<?php echo $derivacion[id_solicitud]; ?> data_id_proveedor=<?php echo $registro_requisitos[id_proveedor]; ?> data_tipo=<?php echo $derivacion[tipo_solicitud]; ?> data_id_derivacion=<?php echo $derivacion[id_derivacion]; ?> id="borrar_adquisicion_sn_vb_ga" class="btn btn-danger btn-icon btn-xs" style="float: right; margin-right: 15px;">
                                        Borrar Proveedor&nbsp;
                                        <i class="entypo-back"></i>
                                    </button>
                                <?php } elseif ($registro_requisitos[estado_derivacion] == "visto bueno G.A." || $registro_requisitos[estado_derivacion] == "memorandun") { ?>

                                    <a target='_blank' href="vista/derivaciones/nota_adjudicacion_pdf.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>&tipo=<?php echo $tipo; ?>" class="btn btn-success btn-icon btn-xs" style="float: right; margin-right: 15px;">
                                        Nota de Adjudicación
                                        <i class="entypo-print"></i>
                                    </a>
                                    <a target='_blank' href="vista/derivaciones/pdf.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>&tipo=<?php echo $tipo; ?>" class="btn btn-info btn-icon btn-xs" style="float: right; margin-right: 15px;">
                                        Imprimir Orden de <?php echo $tipo; ?>
                                        <i class="entypo-print"></i>
                                    </a>
                                    <?php
                                    $consultar_gastos = $bd->Consulta("");
                                    if (floatval($registro_requisitos[total_gastado]) <= 20000) {
                                        //! Validar que si es menor al hacer click en visto bueno G.A. ya se cree el memorandun a la unidad solicitante
                                        //! Revisar el controlador de las 3 solicitudes para el tema de la utogeneracion de el memorandun
                                        // echo "SI-20000";
                                        // Tocar aqui
                                    } else {
                                        //! Si es mayor a los 20.000 recien mostrar el boton memorandun
                                        // echo "NO-20000";
                                    }
                                    ?>
                                    <a href="?mod=procedimientos&pag=memorandun&id_derivacion=<?php echo $id; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>&tipo=<?php echo $tipo; ?>" class="btn btn-success btn-icon btn-xs" style="float: right; margin-right: 15px;">
                                        Memorandun<i class="entypo-doc"></i>
                                    </a>
                                <?php } elseif ($registro_requisitos[estado_derivacion] == "sin visto bueno G.A.") { ?>
                                    <button data_id_solicitud=<?php echo $derivacion[id_solicitud]; ?> data_id_proveedor=<?php echo $registro_requisitos[id_proveedor]; ?> data_tipo=<?php echo $derivacion[tipo_solicitud]; ?> data_id_derivacion=<?php echo $derivacion[id_derivacion]; ?> id="borrar_adquisicion_sn_vb_ga" class="btn btn-danger btn-icon btn-xs" style="float: right; margin-right: 15px;">Borrar Proveedor&nbsp;<i class="entypo-back"></i> </button>
                                    <!-- <p>Mostrar 3_1</p> -->
                                <?php } else { ?>
                                    <a target='_blank' href="vista/derivaciones/pdf.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>&tipo=<?php echo $tipo; ?>" class="btn btn-info btn-icon btn-xs">Imprimir Orden de <?php echo $tipo; ?><i class="entypo-print"></i></a>

                                <?php } ?>
                            <?php } else { ?>
                                <a target='_blank' href="vista/derivaciones/acta_conformidad_no_conformidad_pdf.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>&tipo=<?php echo $tipo; ?>&id_requisitos=<?php echo $registro_requisitos[id_requisitos]; ?>&conformidad=si" class="btn btn-success btn-icon btn-xs">Acta conformidad<i class="entypo-print"></i></a>
                                <a target='_blank' href="vista/derivaciones/acta_conformidad_no_conformidad_pdf.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>&tipo=<?php echo $tipo; ?>&id_requisitos=<?php echo $registro_requisitos[id_requisitos]; ?>&conformidad=no" class="btn btn-danger btn-icon btn-xs">Acta no conformidad<i class="entypo-print"></i></a>
                                <button name="acta-recepcion" enlace="vista/derivaciones/acta_recepcion_pdf.php?id_solicitud=<?php echo $derivacion[id_solicitud]; ?>&id_detalle=<?php echo $registro_requisitos[id_detalle]; ?>&tipo=<?php echo $tipo; ?>&id_requisitos=<?php echo $registro_requisitos[id_requisitos]; ?>" data-toggle="modal" data-target="modalAclaraciones" class="btn btn-warning btn-icon btn-xs">
                                    Acta recepción
                                    <i class="entypo-print"></i>
                                </button>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
</div>
<!-- Vista SESSION DIFERENTE DE RPA SIN DATOS PROCESADOS -->
<div style="display: <?php echo $mostrar4; ?>;">
    <h2>
        ADQUISICIONES NO PROCESO LA SOLICITUD
        <!-- <a href="?mod=proveedor&pag=create" class="btn btn-success pull-right">Proveedores&nbsp;<i class="entypo-plus"></i></a> -->
        <button type="reset" class="btn btn-danger cancelar pull-right">Volver&nbsp;<i class="entypo-back"></i></button>
    </h2>
</div>

<!-- existencia de la Solicitud REVISAR -->
<div class="modal fade" id="existencia_solicitud" role="dialog">
    <div class="modal-dialog">
        <!-- existencia de la Solicitud content-->
        <!-- href="control/derivaciones/verificar.php?id=<?php // echo $registro[id_derivacion] 
                                                            ?>" -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Designacion</h4>
            </div>
            <div class="modal-body">
                <!-- action="control/procedimientos/insertar_procedimientos.php" -->
                <form name="frm_derivaciones" id="frm_derivaciones" action="control/procedimientos/insertar_procedimientos.php" method="post" role="form" class="form-horizontal form-groups-bordered" enctype="multipart/form-data">
                    <input type="hidden" name="val_id_proveedor" id="val_id_proveedor">
                    <input type="hidden" name="val_id_solicitud" id="val_id_solicitud">
                    <input type="hidden" name="val_id_derivacion" id="val_id_derivacion">
                    <input type="hidden" name="val_tipo" id="val_tipo">
                    <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION[id_usuario] ?>">
                    <!-- Fecha de verificacion -->
                    <div class="form-group">
                        <label for="fecha_respuesta" class="col-sm-2 control-label">Fecha respuesta</label>
                        <div class="col-sm-8">
                            <input type="text" name="fecha_respuesta" id="fecha_respuesta" class="form-control required datepicker" value="<?php echo date("Y-m-d H:i:s"); ?>" readonly />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cuce" class="col-sm-2 control-label">CUCE si corresponde</label>
                        <div class="col-sm-8">
                            <input type="text" name="cuce" id="cuce" class="form-control required" placeholder="Una ves registrado el CUCE no se podra cambiar!." />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rpa" class="col-sm-2 control-label">Personal Responsable RPA</label>
                        <div class="col-sm-8">
                            <select id="rpa" name="rpa" class="form-control required select2">
                                <option value="" selected>--SELECCIONE--</option>
                                <?php
                                while ($trabajador = $bd->getFila($trabajadores)) {
                                    echo utf8_encode("<option value='$trabajador[id_trabajador]'>$trabajador[nombres] - $trabajador[apellido_paterno] - $trabajador[apellido_materno]</option>");
                                }
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="responsables" class="col-sm-2 control-label">Designar Responsable A:</label>
                        <div class="col-sm-8">
                            <select name="responsables[]" id="responsables" multiple="multtiple" class="form-control required select2 multiple">
                                <!-- <option value="" selected>--SELECCIONE--</option> -->
                                <?php
                                while ($trabajador_res = $bd->getFila($trabajadores2)) {
                                    echo utf8_encode("<option value='$trabajador_res[id_trabajador]'>$trabajador_res[nombres]  $trabajador_res[apellido_paterno]  $trabajador_res[apellido_materno]</option>");
                                }
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="text-align: center;">
                        <div class="col-sm-offset-3 col-sm-5">
                            <button type="submit" class="btn btn-info">Registrar</button>
                            <!-- <button type="button" id="agregar" class="btn btn-info">Registrar</button> -->
                            <!-- <button type="button" class="btn cancelar">Cancelar</button> -->
                        </div>
                    </div>
                </form>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div> -->
        </div>

    </div>
</div>
<div id="modalAclaraciones" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="my-modal-title">Acta recepción</h3>
                <button class="close" id="btnCerrarModal" data-dismiss="modal" aria-label="Close">
                    X
                </button>
            </div>
            <form id="formAclaraciones" class="form">
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="aclaraciones">Condiciones Adicionales y/o Aclaraciones</label>
                            <textarea class="form-control" name="textAclaraciones" id="textAclaraciones" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Generar Acta</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="modalObservacionesForm10" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="my-modal-title">Ingreso y Egreso</h3>
                <button type="button" class="close" id="btnCerrarModalform10" data-dismiss="modal" aria-label="Close">
                    X
                </button>
            </div>
            <form id="formObservacionesForm10" class="form">
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php
                            if ($derivacion[tipo_solicitud] == 'material' || $derivacion[tipo_solicitud] == 'activo') {
                                if ($derivacion[tipo_solicitud] == 'material') {
                                    $buscar_detalles = $bd->Consulta("SELECT id_detalle_material AS id_detalle, cantidad_solicitada, descripcion, cantidad_stock FROM detalle_material WHERE id_solicitud_material = $derivacion[id_solicitud]");
                                    $tamanio_detalles = $bd->Consulta("SELECT COUNT(id_solicitud_material) as tamanio_detalles FROM detalle_material WHERE id_solicitud_material = $derivacion[id_solicitud]");
                                } elseif ($derivacion[tipo_solicitud] == 'activo') {
                                    $buscar_detalles = $bd->Consulta("SELECT id_detalle_activo AS id_detalle, cantidad_solicitada, descripcion, cantidad_stock FROM detalle_activo WHERE id_solicitud_activo = $derivacion[id_solicitud]");
                                    $tamanio_detalles = $bd->Consulta("SELECT COUNT(id_solicitud_activo) as tamanio_detalles FROM detalle_activo WHERE id_solicitud_activo = $derivacion[id_solicitud]");
                                }
                                // $valicacion_de_stock = $bd->getFila($buscar_detalles);


                                echo "<input type='hidden' name='tipo' id='tipo' value='$derivacion[tipo_solicitud]'>";
                                $tamanio_de_detalles = $bd->getFila($tamanio_detalles);
                                $numero_inputs = 1;
                                echo "<input type='hidden' name='tamanio_de_los_detalles' id='tamanio_de_los_detalles' value='$tamanio_de_detalles[tamanio_detalles]'>";
                                while ($mostrar_detalles = $bd->getFila($buscar_detalles)) {
                                    if (empty($mostrar_detalles[cantidad_stock])) {
                                        // echo "ENTREGA: " . $mostrar_detalles[cantidad_stock] . " ----- ";
                                        // echo strtoupper($mostrar_detalles[descripcion]) . "<br>";
                            ?>
                                        <div class='row'>
                                            <div class="form-group">
                                                <h4 class="col-md-12 bg-info"><?php echo $mostrar_detalles[descripcion] ?> - Cantidad Solicitada: <?php echo $mostrar_detalles[cantidad_solicitada] ?></h4>
                                                <input type="hidden" name="id_detalles_<?php echo $numero_inputs; ?>" id="id_detalles_<?php echo $numero_inputs; ?>" value="<?php echo $mostrar_detalles[id_detalle] ?>">
                                                <input type="hidden" name="cantidad_tope_<?php echo $numero_inputs; ?>" id="cantidad_tope_<?php echo $numero_inputs; ?>" value="<?php echo $mostrar_detalles[cantidad_solicitada] ?>">
                                                <div class="col-md-3">
                                                    <label for="entrega_<?php echo $numero_inputs ?>">Para Entregar</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" name="entrega_<?php echo $numero_inputs ?>" id="entrega_<?php echo $numero_inputs ?>" class="form-control" value="0" min="0" max="<?php echo $mostrar_detalles[cantidad_solicitada] ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="stock_<?php echo $numero_inputs ?>">Para Stock</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" name="stock_<?php echo $numero_inputs ?>" id="stock_<?php echo $numero_inputs ?>" class="form-control" value="0" min="0" max="<?php echo $mostrar_detalles[cantidad_solicitada] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                        $numero_inputs++;
                                    }
                                    ?>

                            <?php
                                }
                            }
                            ?>
                            <label for="aclaraciones">Observaciones (Opcional)</label>
                            <textarea class="form-control" name="textObservacionesForm10" id="textObservacionesForm10" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Generar Acta</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="modalObservacionesForm11" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="my-modal-title">Recepción y Conformidad</h3>
                <button type="button" class="close" id="btnCerrarModalform11" data-dismiss="modal" aria-label="Close">
                    X
                </button>
            </div>
            <form id="formObservacionesForm11" class="form">
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="aclaraciones">Observaciones (Opcional)</label>
                            <textarea class="form-control" name="textObservacionesForm11" id="textObservacionesForm11" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Generar Acta</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="modalAsignacionBienes" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="my-modal-title">Asignacion de Bienes</h3>
                <button type="button" class="close" id="btnCerrarAsignacionBienes" data-dismiss="modal" aria-label="Close">
                    X
                </button>
            </div>
            <form id="formAsignacionesBienes" class="form" autocomplete="off">
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="numFactura">Nro Factura (*)</label>
                            <input type="text" class="form-control" name="numFactura" id="numFacturaAsignaccionBienes" required>
                            <label for="fechaFactura">Fecha Factura(*)</label>
                            <input type="date" class="form-control datepicker" name="fechaFactura" id="fechaFacturaAsignaccionBienes" required>
                        </div>
                        <div class="form-group">
                            <label for="aclaraciones">Observaciones (Opcional)</label>
                            <textarea class="form-control" name="textObsAsignaccionBienes" id="textObsAsignaccionBienes" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Generar Acta</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    const btn_ingreso_egreso = document.getElementById("ingreso_egreso");
    console.log("Boton: ", btn_ingreso_egreso);
    if (btn_ingreso_egreso != null) {
        btn_ingreso_egreso.addEventListener("click", function() {
            var id_solicitud = this.getAttribute('data-id');
            var id_detalle = this.getAttribute('data-id-detalle');
            var tipo = this.getAttribute('data-tipo');
            let data = [{
                    "name": "solicitud",
                    "value": id_solicitud
                },
                {
                    "name": "detalle",
                    "value": id_detalle
                },
                {
                    "name": "tipo",
                    "value": tipo
                },
            ];
            console.table(data);
        })
    }
    // Borrar Adquisiciones
    const borrar_adquisicion_sn_vb_rpa = document.getElementById("borrar_adquisicion_sn_vb_rpa");
    if (borrar_adquisicion_sn_vb_rpa != null) {
        borrar_adquisicion_sn_vb_rpa.addEventListener("click", function() {
            const idSolicitud = borrar_adquisicion_sn_vb_rpa.getAttribute("data_id_solicitud");
            const idProveedor = borrar_adquisicion_sn_vb_rpa.getAttribute("data_id_proveedor");
            const tipoSolicitud = borrar_adquisicion_sn_vb_rpa.getAttribute("data_tipo");
            const idDerivacion = borrar_adquisicion_sn_vb_rpa.getAttribute("data_id_derivacion");

            const ruta = `control/derivaciones/borrar_requisitos.php?id_solicitud=${idSolicitud}&id_proveedor=${idProveedor}&tipo=${tipoSolicitud}&id_derivacion=${idDerivacion}`;

            console.log(ruta);
            // Enviar los datos al controlador utilizando fetch con el método GET
            fetch(ruta, {
                    method: 'GET'
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
    }
    const borrar_adquisicion_sn_vb_ga = document.getElementById("borrar_adquisicion_sn_vb_ga");
    if (borrar_adquisicion_sn_vb_ga != null) {
        borrar_adquisicion_sn_vb_ga.addEventListener("click", function() {
            const idSolicitud = borrar_adquisicion_sn_vb_ga.getAttribute("data_id_solicitud");
            const idProveedor = borrar_adquisicion_sn_vb_ga.getAttribute("data_id_proveedor");
            const tipoSolicitud = borrar_adquisicion_sn_vb_ga.getAttribute("data_tipo");
            const idDerivacion = borrar_adquisicion_sn_vb_ga.getAttribute("data_id_derivacion");

            const ruta = `control/derivaciones/borrar_requisitos.php?id_solicitud=${idSolicitud}&id_proveedor=${idProveedor}&tipo=${tipoSolicitud}&id_derivacion=${idDerivacion}`;

            console.log(ruta);
            // Enviar los datos al controlador utilizando fetch con el método GET
            fetch(ruta, {
                    method: 'GET'
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
    }
    // Borrar RPA
    const borrar_rpa_sn_vb_ga = document.getElementById("borrar_rpa_sn_vb_ga");
    if (borrar_rpa_sn_vb_ga != null) {
        borrar_rpa_sn_vb_ga.addEventListener("click", function() {
            const idSolicitud = borrar_rpa_sn_vb_ga.getAttribute("data_id_solicitud");
            const idProveedor = borrar_rpa_sn_vb_ga.getAttribute("data_id_proveedor");
            const tipoSolicitud = borrar_rpa_sn_vb_ga.getAttribute("data_tipo");
            const idDerivacion = borrar_rpa_sn_vb_ga.getAttribute("data_id_derivacion");

            const ruta = `control/derivaciones/borrar_requisitos.php?id_solicitud=${idSolicitud}&id_proveedor=${idProveedor}&tipo=${tipoSolicitud}&id_derivacion=${idDerivacion}`;

            console.log(ruta);
            // Enviar los datos al controlador utilizando fetch con el método GET
            fetch(ruta, {
                    method: 'GET'
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
    }
    const borrar_rpa_sn_rpa = document.getElementById("borrar_rpa_sn_rpa");
    if (borrar_rpa_sn_rpa != null) {
        borrar_rpa_sn_rpa.addEventListener("click", function() {
            const idSolicitud = borrar_rpa_sn_rpa.getAttribute("data_id_solicitud");
            const idProveedor = borrar_rpa_sn_rpa.getAttribute("data_id_proveedor");
            const tipoSolicitud = borrar_rpa_sn_rpa.getAttribute("data_tipo");
            const idDerivacion = borrar_rpa_sn_rpa.getAttribute("data_id_derivacion");

            const ruta = `control/derivaciones/borrar_requisitos.php?id_solicitud=${idSolicitud}&id_proveedor=${idProveedor}&tipo=${tipoSolicitud}&id_derivacion=${idDerivacion}`;

            console.log(ruta);
            // Enviar los datos al controlador utilizando fetch con el método GET
            fetch(ruta, {
                    method: 'GET'
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
    }

    //Obtener el botón por su ID
    const enviarAprobacionBtn = document.getElementById("enviar_aprobacion");
    if (enviarAprobacionBtn != null) {
        enviarAprobacionBtn.addEventListener("click", function() {
            // Obtener los datos necesarios para construir la URL del backend
            const id_solicitud = enviarAprobacionBtn.dataset.idSolicitud;
            const id_detalle = enviarAprobacionBtn.dataset.idDetalle;
            const tipo = enviarAprobacionBtn.dataset.tipo;
            const id_usuario = enviarAprobacionBtn.dataset.idUsuario;
            const nivel = enviarAprobacionBtn.dataset.nivel;
            const id_proveedor = enviarAprobacionBtn.dataset.idProveedor;
            const estado = enviarAprobacionBtn.dataset.estado;

            const datos = {
                "ID Solicitud": id_solicitud,
                "ID Detalle": id_detalle,
                "Tipo": tipo,
                "ID Usuario": id_usuario,
                "Nivel": nivel,
                "ID Proveedor": id_proveedor,
                "Estado": estado,
            };

            // Mostrar la tabla en la consola
            console.table(datos);

            // // Construir la URL con los datos a enviar
            const url = `control/derivaciones/visto_bueno.php?id_solicitud=${id_solicitud}&id_detalle=${id_detalle}&tipo=${tipo}&estado=visto_bueno&id_usuario=${id_usuario}&nivel=${nivel}&id_proveedor=${id_proveedor}`;

            // // Realizar la solicitud GET utilizando fetch
            fetch(url, {
                    method: 'GET'
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.success === true) {
                        window.location.reload();
                        jAlert(data.message, "Mensaje")
                    } else {
                        // alert(data.message);
                        jAlert(data.message, "Mensaje")
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        });
    }
    // Agregar un evento de clic al botón


    //Obtener el botón por su ID
    const enviar_reprobacion = document.getElementById("enviar_reprobacion");

    // Agregar un evento de clic al botón
    if (enviar_reprobacion != null) {
        enviar_reprobacion.addEventListener("click", function() {
            // Obtener los datos necesarios para construir la URL del backend
            const id_solicitud = enviar_reprobacion.dataset.idSolicitud;
            const id_detalle = enviar_reprobacion.dataset.idDetalle;
            const tipo = enviar_reprobacion.dataset.tipo;
            const id_usuario = enviar_reprobacion.dataset.idUsuario;
            const nivel = enviar_reprobacion.dataset.nivel;
            const id_proveedor = enviar_reprobacion.dataset.idProveedor;
            const estado = enviar_reprobacion.dataset.estado;

            const datos = {
                "ID Solicitud": id_solicitud,
                "ID Detalle": id_detalle,
                "Tipo": tipo,
                "ID Usuario": id_usuario,
                "Nivel": nivel,
                "ID Proveedor": id_proveedor,
                "Estado": estado,
            };

            // Mostrar la tabla en la consola
            console.table(datos);

            // Construir la URL con los datos a enviar
            const url = `control/derivaciones/visto_bueno.php?id_solicitud=${id_solicitud}&id_detalle=${id_detalle}&tipo=${tipo}&estado=no_visto_bueno&id_usuario=${id_usuario}&nivel=${nivel}&id_proveedor=${id_proveedor}`;

            // Realizar la solicitud GET utilizando fetch
            fetch(url, {
                    method: 'GET'
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
    }


    jQuery(document).ready(function($) {

        $("#tbodyactas").click(function(e) {

            let nombre = e.target.getAttribute('name');
            if (nombre != null && nombre == 'acta-recepcion') {
                document.getElementById('formAclaraciones').setAttribute('enlace', e.target.getAttribute('enlace'))
                console.log(e.target.getAttribute('enlace'), 'enlace acta')
                $('#modalAclaraciones').modal('show');
            } else if (nombre != null && nombre == 'observaciones-form10') {
                document.getElementById('formObservacionesForm10').setAttribute('enlace', e.target.getAttribute('enlace'))
                console.log("Renderizado: ", e.target.getAttribute('enlace'), 'enlace acta')
                $('#modalObservacionesForm10').modal('show');
            } else if (nombre != null && nombre == 'observaciones-form11') {
                document.getElementById('formObservacionesForm11').setAttribute('enlace', e.target.getAttribute('enlace'))
                console.log(e.target.getAttribute('enlace'), 'enlace acta')
                $('#modalObservacionesForm11').modal('show');
            } else if (nombre != null && nombre == 'asignacion-bienes') {
                document.getElementById('formAsignacionesBienes').setAttribute('enlace', e.target.getAttribute('enlace'))
                console.log(e.target.getAttribute('enlace'), 'enlace acta')
                $('#modalAsignacionBienes').modal('show');
            }

        });

        $("a.eliminar_lista").click(function(e) {
            e.preventDefault();
            dir = $(this).attr("href");
            console.log(dir);
            jConfirm("¿Est&aacute; seguro de realizar la acci&oacute;n?", "Mensaje", function(resp) {
                if (resp) {
                    $.ajax({
                        type: "GET",
                        url: dir,
                    }).done(function(response) {
                        var data = JSON.parse(response);
                        console.log(response)
                        if (data.success === true) {
                            window.location.reload();
                        } else {
                            jAlert(data.message, "Mensaje")
                        }
                    })
                    // window.location.reload();
                    // $(location).attr('href',dir);
                }
            });

        });

        $('#enviar_proveedor').click(function() {
            var id_proveedor = $("#id_proveedor").val();
            var id_usuario = $("#id_usuario").val();
            var id_solicitud = $("#id_solicitud").val();
            var id_derivacion = $("#id_derivacion").val();
            var fecha_elaboracion = $("#fecha_elaboracion").val();
            var tipo_solicitud = $('#tipo_solicitud').val();
            var valoresSeleccionados = [];
            $('.checkbox-dinamico').each(function() {
                if ($(this).is(':checked')) {
                    // valoresSeleccionados.push($(this).attr('id'));
                    var detalleId = $(this).attr('id');
                    var precioInput = $('.precio-input[id^="precio_establecido_' + detalleId + '"]');
                    if (precioInput.length > 0) {
                        // Concatena el ID y el precio usando un separador, por ejemplo, ":"
                        var valorConcatenado = detalleId + ":" + precioInput.val();
                        valoresSeleccionados.push(valorConcatenado);
                    }
                }

            });
            var datos = [{
                    name: "id_proveedor",
                    value: id_proveedor
                },
                {
                    name: "id_usuario",
                    value: id_usuario
                },
                {
                    name: "id_solicitud",
                    value: id_solicitud
                },
                {
                    name: "id_derivacion",
                    value: id_derivacion
                },
                {
                    name: "id_detalles",
                    value: valoresSeleccionados
                },
                {
                    name: "fecha_elaboracion",
                    value: fecha_elaboracion
                },
                {
                    name: "tipo_solicitud",
                    value: tipo_solicitud
                },
            ];
            console.table(datos);

            // console.log(valoresSeleccionados);
            if (valoresSeleccionados.length == 0) {
                jAlert("No selecciono ningun elemento de la solicitud", "Mensaje");
            }
            if (id_proveedor == null || id_proveedor == '') {
                jAlert("No selecciono ningun proveedor", "Mensaje");
            }
            $.ajax({
                type: "POST",
                url: "control/derivaciones/orden_compra.php",
                data: {
                    'id_proveedor': id_proveedor,
                    'id_usuario': id_usuario,
                    'id_solicitud': id_solicitud,
                    'id_derivacion': id_derivacion,
                    'id_detalles': valoresSeleccionados,
                    'fecha_elaboracion': fecha_elaboracion,
                    'tipo_solicitud': tipo_solicitud,
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
        })

        // $("#tbodyactas").click(function(e) {
        //     let nombre = e.target.getAttribute('name');
        //     if (nombre != null && nombre == 'acta-recepcion') {
        //         document.getElementById('formAclaraciones').setAttribute('enlace', e.target.getAttribute('enlace'))
        //         $('#modalAclaraciones').modal('show');
        //     }
        // })
    })
    document.addEventListener('DOMContentLoaded', function() {
        var checkboxes = document.querySelectorAll('.checkbox-dinamico');
        // var print = document.getElementById('botones_detalles_print');
        // var trash = document.getElementById('botones_detalles_trash');
        //   console.log(checkboxes);
        checkboxes.forEach(function(checkbox) {
            var id = checkbox.id;
            // console.log("ID checkbox es: " + id);
            // Realizar la petición para verificar si el id existe en otra tabla
            // fetch('control/detalle_material/detalle_material.php?id_detalle_material=' + id)
            fetch('control/requisitos/buscar_id.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    if (data.success === true) {
                        // document.getElementById('cantidad_material').value = data.cantidad + ' ' + data.unidad_medida + ' restantes';
                        // document.getElementById('cant_mat').value = data.cantidad;
                        // alert("El ID ya se registro " + id);
                        // jAlert(data.message, "Mensaje")
                        checkbox.disabled = true;
                        checkbox.style.display = 'none';
                    } else {
                        console.log(data.id);
                        // jAlert(data.message, "Mensaje")
                    }
                })
                .catch(error => console.error(error));
        });
    });

    function memorandun() {
        var boton = event.target;
        var dataId = boton.getAttribute("data_id");
        var partes = dataId.split("-");
        var id_proveedor = partes[0];
        var id_solicitud = partes[1];
        var id_derivacion = partes[2];
        var tipo = partes[3];
        console.log('ID Prov: ' + id_proveedor + " Sol: " + id_solicitud + " DERIVACION: " + id_derivacion + " Tipo " + tipo);
        document.getElementById('val_id_proveedor').innerHTML = id_proveedor;
        document.getElementById('val_id_proveedor').value = id_proveedor;
        document.getElementById('val_id_solicitud').innerHTML = id_solicitud;
        document.getElementById('val_id_solicitud').value = id_solicitud;
        document.getElementById('val_id_derivacion').innerHTML = id_derivacion;
        document.getElementById('val_id_derivacion').value = id_derivacion;
        document.getElementById('val_tipo').innerHTML = tipo;
        document.getElementById('val_tipo').value = tipo;
    }
    document.getElementById("formAclaraciones").addEventListener('submit', (e) => {
        e.preventDefault();
        let formulario = document.getElementById('formAclaraciones');
        let enlace = formulario.getAttribute('enlace');
        let aclaracion = document.getElementById('textAclaraciones').value;
        let enlace_pdf = enlace + '&aclaracion=' + aclaracion;
        let btnCerrarModal = document.getElementById('btnCerrarModal');
        let nuevo_enlace = document.createElement('a');
        nuevo_enlace.href = enlace_pdf;
        nuevo_enlace.target = '_blank';
        nuevo_enlace.click();
        formulario.reset();
        btnCerrarModal.click();
    });
    document.getElementById("modalObservacionesForm10").addEventListener('submit', (e) => {
        e.preventDefault();
        var grupo = [];
        let formulario = document.getElementById('formObservacionesForm10');
        let enlace = formulario.getAttribute('enlace');
        let tipo = document.getElementById('tipo').value;
        // let stock = document.getElementById('stock').value;
        let observaciones = document.getElementById('textObservacionesForm10').value;
        let tamanio_de_los_detalles = document.getElementById('tamanio_de_los_detalles').value;
        let enlace_pdf_sn_entregaStock = enlace + '&observaciones=' + observaciones;
        var data = [{
                name: "enlace",
                value: enlace
            },
            {
                name: "observaciones",
                value: observaciones
            },
            {
                name: "enlace_pdf_sn_entregaStock",
                value: enlace_pdf_sn_entregaStock
            },
            {
                name: 'tipo',
                value: tipo
            },
            {
                name: 'tamanio_de_los_detalles',
                value: tamanio_de_los_detalles
            }
        ];
        console.log("antes de enviar: ", data);
        for (let contador = 1; contador <= tamanio_de_los_detalles; contador++) {
            let topes = 'cantidad_tope_' + contador;
            let topeElement = document.getElementById(topes);

            if (topeElement) {
                let topes = 'cantidad_tope_' + contador;
                let tope = parseInt(document.getElementById(topes).value);
                let ids = 'id_detalles_' + contador;
                let ids_detalles = document.getElementById(ids).value;
                let entregados = 'entrega_' + contador;
                let input_entrega = parseInt(document.getElementById(entregados).value);
                let stock = 'stock_' + contador;
                let input_stock = parseInt(document.getElementById(stock).value);
                let sumatoria_e_s = input_entrega + input_stock;
                if (input_entrega === "" || input_stock === "") {
                    jAlert("Los campos de entrega y stock no pueden estar vacíos.", "Mensaje");
                    return;
                }
                if (sumatoria_e_s > tope) {
                    jAlert("No puede registrar en stock y entrega mas de lo solicitado!" + input_entrega + " y " + input_stock, "Mensaje");
                    return;
                }

                grupo.push(ids_detalles + "-" + input_entrega + "-" + input_stock);
                data.push({
                    name: "tope",
                    value: tope
                });
            }
        }
        let grupoJSON = JSON.stringify(grupo);
        let enlace_pdf = enlace_pdf_sn_entregaStock + '&datos=' + grupoJSON;
        data.push({
            name: "información",
            value: grupoJSON
        });
        data.push({
            name: "enlace",
            value: enlace_pdf
        });


        console.table(data);
        let btnCerrarModal = document.getElementById('btnCerrarModalform10');
        let nuevo_enlace = document.createElement('a');
        nuevo_enlace.href = enlace_pdf;
        nuevo_enlace.target = '_blank';
        nuevo_enlace.click();
        formulario.reset();
        btnCerrarModal.click();
    });
    document.getElementById("modalObservacionesForm11").addEventListener('submit', (e) => {
        e.preventDefault();
        let formulario = document.getElementById('formObservacionesForm11');
        let enlace = formulario.getAttribute('enlace');
        let observaciones = document.getElementById('textObservacionesForm11').value;
        let enlace_pdf = enlace + '&observaciones=' + observaciones;
        let btnCerrarModal = document.getElementById('btnCerrarModalform11');
        let nuevo_enlace = document.createElement('a');
        nuevo_enlace.href = enlace_pdf;
        nuevo_enlace.target = '_blank';
        nuevo_enlace.click();
        formulario.reset();
        btnCerrarModal.click();
    });
    document.getElementById("modalAsignacionBienes").addEventListener('submit', (e) => {
        e.preventDefault();
        let formulario = document.getElementById('formAsignacionesBienes');
        let enlace = formulario.getAttribute('enlace');
        let observaciones = document.getElementById('textObsAsignaccionBienes').value;
        let nro_factura = document.getElementById('numFacturaAsignaccionBienes').value;
        let fecha_factura = document.getElementById('fechaFacturaAsignaccionBienes').value;
        let enlace_pdf = enlace + '&nro_factura=' + nro_factura + '&fecha_factura=' + fecha_factura + '&observaciones=' + observaciones;
        let btnCerrarModal = document.getElementById('btnCerrarAsignacionBienes');
        let nuevo_enlace = document.createElement('a');
        nuevo_enlace.href = enlace_pdf;
        nuevo_enlace.target = '_blank';
        nuevo_enlace.click();
        formulario.reset();
        btnCerrarModal.click();
    });

    function calcularTotal(element) {
        // Obtener el ID del elemento actual
        const idDetalle = element.id.split('_')[2];

        // Obtener la cantidad solicitada
        const cantidadSolicitada = element.getAttribute('data-cantidad');

        // Calcular el costo total
        const precioUnitario = parseFloat(element.value);
        const costoTotal = precioUnitario * cantidadSolicitada;

        // Actualizar el valor del costo total en el DOM
        document.getElementById(`itemTotal_${idDetalle}`).innerText = costoTotal.toFixed(2);
    }
</script>
<style>
    .border {
        border: 1px solid black;
    }

    .container {
        /* display: flex; */
        justify-content: center;
    }

    .checkbox_group {
        display: flex;
        flex-direction: column;
        background-color: #21a9e1;
        /* color: yellow; */
        /* margin-top: 10px; */
    }

    .estilos {
        transform: scale(1.5);
        /* Ajusta el tamaño del checkbox */
        /* margin-right: 10px; */
        /* Espacio entre el checkbox y el texto */
        font-size: 1.2em;
    }

    .color_checkbox {
        background-color: yellow;
        color: yellow;
    }

    .checkbox_group input[type="checkbox"] {
        margin-bottom: 30px;
        margin-left: 80%;
        width: 30px;
        height: 30px;
        /* appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-color: #fff;
        border: 1px solid #000; */

        /* Personaliza el aspecto cuando está marcado */
        /* &:checked {
            background-color: #000;
        } */
    }

    .checkbox_group a {
        display: block;
        width: 40px;
        height: 40px;
        margin-bottom: 30px;
        margin-left: 80%;
    }

    /* .checkbox_group label {
        margin-left: 10px;
    } */
</style>
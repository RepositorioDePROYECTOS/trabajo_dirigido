<?php
include("modelo/conv_lista.php"); // Incluir la clase ConvLista

// Obtener instancia de la conexión
$bd = new Conexion();
?>
<h2>Asignar Postulante a Convocatoria</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
    <div class="panel-heading">
        <div class="panel-title">
            Asignar Postulante
        </div>
    </div>
    <div class="panel-body">
        <form name="frm_asignar_postulante" id="frm_asignar_postulante" action="control/obtener_pos/insertar_conv_lista.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
            
            <!-- ID Convocatoria -->
            <div class="form-group">
                <label for="id_convocatoria" class="col-sm-3 control-label">Convocatoria</label>
                <div class="col-sm-5">
                    <select name="id_convocatoria" id="id_convocatoria" class="form-control required select2" data-validate="required" data-message-required="Seleccione una convocatoria">
                        <option value="">Seleccione una convocatoria</option>
                        
                        <?php
                        $convocatorias = $bd->Consulta("SELECT * FROM convocatorias WHERE Estado IN (1, 3)");

                        while ($conv = mysql_fetch_array($convocatorias)) {
                            echo "<option value='{$conv['id_convocatoria']}'>{$conv['nombre_convocatoria']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- ID Postulante -->
            <div class="form-group">
                <label for="id_postulante" class="col-sm-3 control-label">Postulante</label>
                <div class="col-sm-5">
                    <select name="id_postulante" id="id_postulante" class="form-control required select2" data-validate="required" data-message-required="Seleccione un postulante">
                        <option value="">Seleccione un postulante</option>
                        
                        <?php
                        $postulantes = $bd->Consulta("SELECT * FROM postulantes ORDER BY id_postulante DESC");
                        
                        while ($post = mysql_fetch_array($postulantes)) {
                            echo "<option value='{$post['id_postulante']}'>{$post['nombre']} {$post['apellido_paterno']} {$post['apellido_materno']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- Botones -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    <button type="submit" class="btn btn-info">Asignar</button>
                    <button type="button" class="btn cancelar btn btn-danger">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>





<!-- Tabla de asignaciones -->
<h2>Eliminar Asignaciones Actuales</h2>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Postulante</th>
            <th>Convocatoria</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php
$sql = "
    SELECT cl.id_conv_lista, p.nombre, p.apellido_paterno, c.nombre_convocatoria 
    FROM conv_lista cl
    JOIN postulantes p ON cl.id_postulante = p.id_postulante
    JOIN convocatorias c ON cl.id_convocatoria = c.id_convocatoria
";
$asignaciones = $bd->Consulta($sql);

if (!$asignaciones) {
    echo "<tr><td colspan='3'>Error en la consulta: " . mysql_error() . "<br>Consulta: $sql</td></tr>";
} else {
    while ($asig = mysql_fetch_array($asignaciones)) {
        echo "<tr>";
        echo "<td>{$asig['nombre']} {$asig['apellido_paterno']}</td>";
        echo "<td>{$asig['nombre_convocatoria']}</td>";
        echo "<td><a href='control/obtener_pos/eliminar_conv_lista.php?id_conv_lista={$asig['id_conv_lista']}' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a></td>";

        echo "</tr>";
    }
}
        ?>
    </tbody>
</table>
<?php 
include("modelo/comisiones.php");
$bd = new Conexion(); // Asegurar que la conexión esté disponible

// Consulta para obtener las comisiones y los nombres de las convocatorias
$consultaComisiones = $bd->Consulta("SELECT c.id_convocatoria, conv.nombre_convocatoria, c.id_miembro_comision, c.id_trabajador 
                                     FROM comision c 
                                     LEFT JOIN convocatorias conv ON c.id_convocatoria = conv.id_convocatoria 
                                     GROUP BY c.id_convocatoria");


?>
<!-- Incluye CSS de Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- Incluye JS de Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<h2>Comisiones
    <?php if ($_SESSION['nivel'] == "rrhh") { ?>
        <a href="?mod=comisiones&pag=form_comision" class="btn btn-green btn-icon" style="float: right;">
            Crear Comisión
            <i class="entypo-plus"></i>
        </a>
    <?php } ?>
</h2>
<br>
<table class="table table-bordered datatable" id="table-1">
    <thead>
        <tr>
            <th>No</th>
            <th>Nombre Convocatoria</th>
            <?php if ($_SESSION['nivel'] == "rrhh") {
                echo "<th>Acciones</th>";
            } ?>
            <th>Miembros</th>
        </tr>
        
    </thead>
    <tbody>
        <?php
        $n = 0;

        // Array para almacenar miembros por comisión
        $miembrosComision = array();

        while ($registro = $bd->getFila($consultaComisiones)) {
            $n++;
            echo "<tr>";
            echo "<td>$n</td><td>$registro[nombre_convocatoria]</td>";

            // Mostrar acciones solo si el usuario tiene permiso
            if ($_SESSION['nivel'] == "rrhh") {
                echo "<td>
                    <form method='POST' action='control/comision/actualizar_comision.php' class='accion btn btn-green btn-icon btn-xs'>
                        <input type='hidden' name='id_convocatoria' value='{$registro['id_convocatoria']}'>
                        <select name='id_trabajador' required>
                            <option value=''>Seleccionar Miembro</option>";
                            // Consulta para obtener todos los trabajadores que no están en la comisión, ordenados de A a Z
                            $trabajadores = $bd->Consulta("SELECT id_trabajador, nombres, apellido_paterno, apellido_materno 
                                                            FROM trabajador 
                                                            WHERE id_trabajador NOT IN 
                                                            (SELECT id_trabajador FROM comision WHERE id_convocatoria = {$registro['id_convocatoria']})
                                                            ORDER BY nombres ASC, apellido_paterno ASC, apellido_materno ASC");

                            while ($trabajador = $bd->getFila($trabajadores)) {
                                echo "<option value='{$trabajador['id_trabajador']}'>{$trabajador['nombres']} {$trabajador['apellido_paterno']} {$trabajador['apellido_materno']}</option>";
                            }
                        echo "</select>
                        <button type='submit' class='btn btn-success btn-xs'>Agregar Miembro</button>
                    </form>
                    <form method='POST' action='control/comision/eliminar_miembro.php' class='accion btn btn-red btn-icon btn-xs'>
                        <input type='hidden' name='id_convocatoria' value='{$registro['id_convocatoria']}'>
                        <select name='id_trabajador' required>
                            <option value='' class='accion btn btn-red btn-icon btn-xs'>Eliminar Miembro<i class='entypo-cancel'></i></option>";

                            // Consulta para obtener los miembros de la comisión
                            $miembros = $bd->Consulta("SELECT id_trabajador FROM comision WHERE id_convocatoria = {$registro['id_convocatoria']}");
                            while ($miembro = $bd->getFila($miembros)) {
                                // Obtener datos del trabajador para mostrar en la lista
                                $trabajadorData = $bd->Consulta("SELECT nombres, apellido_paterno, apellido_materno FROM trabajador WHERE id_trabajador = {$miembro['id_trabajador']}");
                                $data = $bd->getFila($trabajadorData);
                                echo "<option value='{$miembro['id_trabajador']}'>{$data['nombres']} {$data['apellido_paterno']} {$data['apellido_materno']}</option>";
                            }
                        echo "</select>
                        <button type='submit' class='btn btn-danger btn-xs'>Eliminar Miembro</button>
                    </form>

                </td>";
            }
            
            echo "<td class='accion btn btn-warning btn-icon btn-xs'>";
            // Mostrar los miembros de la comisión en formato desplegable
            echo "<select class='miembros-dropdown' >";
            $miembrosLista = $bd->Consulta("SELECT id_trabajador FROM comision WHERE id_convocatoria = {$registro['id_convocatoria']}");
            while ($miembro = $bd->getFila($miembrosLista)) {
                // Obtener datos del trabajador
                $trabajadorData = $bd->Consulta("SELECT nombres, apellido_paterno, apellido_materno FROM trabajador WHERE id_trabajador = {$miembro['id_trabajador']}");
                $data = $bd->getFila($trabajadorData);
                echo "<option class='accion btn btn-red btn-icon btn-xs'>⫸ {$data['nombres']} {$data['apellido_paterno']} {$data['apellido_materno']} ⫷</option>";
            }
            echo "</select>";
            echo "</td>";
            echo "</tr>";
        }
        ?>

    </tbody>
    <tfoot>
        <tr>
            <th>No</th>
            <th>Nombre Convocatoria</th>
            <?php if ($_SESSION['nivel'] == "rrhh") {
                echo "<th>Acciones</th>";
            } ?>
            <th>Miembros</th>
        </tr>
    </tfoot>
</table>

<!-- Agregar estilos CSS -->
<style>
    .miembros-dropdown {
        width: 100%; /* Ancho completo para la lista desplegable */
        max-height: 100px; /* Altura máxima para evitar que ocupe mucho espacio */
        overflow-y: auto; /* Añadir desplazamiento si hay muchos elementos */
    }

    .miembros-dropdown option:hover {
        font-size: 1.2em; /* Aumentar el tamaño del texto al pasar el mouse */
        transition: font-size 0.3s ease; /* Transición suave para el efecto de aumento */

        
</style>

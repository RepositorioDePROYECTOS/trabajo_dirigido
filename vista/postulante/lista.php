<?php
include("modelo/postulante.php");

$postulante = new Postulante();
$registros = $bd->Consulta("SELECT * FROM postulantes");

// Consulta para obtener todos los CI y contar duplicados
$ci_contador = array();
$registros_ci = $bd->Consulta("SELECT CI FROM postulantes");
while ($registro_ci = $bd->getFila($registros_ci)) {
    $ci = $registro_ci['CI'];
    if (isset($ci_contador[$ci])) {
        $ci_contador[$ci]++;
    } else {
        $ci_contador[$ci] = 1;
    }
}

// Arreglo para almacenar los CI duplicados
$ci_duplicados = array_filter($ci_contador, function($count) {
    return $count > 1;
});

// Obtener las convocatorias
$convocatorias = $bd->Consulta("SELECT * FROM convocatorias");
while ($registro_convocatoria = $bd->getFila($convocatorias)) {
    if ($registro_convocatoria['Estado'] == 2) {
        $bd->Consulta("UPDATE postulantes SET estado=2 WHERE id_convocatoria = $registro_convocatoria[id_convocatoria]");
    }
}

$postulantes_por_convocatoria = array(); 
while ($registro = $bd->getFila($registros)) {
    $postulantes_por_convocatoria[$registro['id_convocatoria']][] = $registro;
}
?>



<h2>Lista de Postulantes
    <?php if ($_SESSION['nivel'] == "rrhh") { ?>
        <a href="?mod=postulante&pag=form_postulante" class="btn btn-green btn-icon" style="float: right;">
            Agregar postulante
            <i class="entypo-plus"></i>
        </a>
    <?php } ?>
</h2>
<br>
<table class="table table-bordered datatable" id="table-1">
    <thead>
        <tr>
            <th>No</th>
            <th>Nombre</th>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>CI</th>
            <th>Gmail</th>
            <th>Teléfono</th>
            <?php if ($_SESSION['nivel'] == "rrhh") {
                echo "<th>Acciones</th>";
            } ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $n = 0;

        foreach ($postulantes_por_convocatoria as $id_convocatoria => $postulantes) {
            foreach ($postulantes as $registro) {
                $eliminar = "<a href='control/postulante/eliminar.php?id=$registro[id_postulante]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>";
                $editar = "<a href='?mod=postulante&pag=editar_postulante&id=$registro[id_postulante]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>";
                $n++;

                // Comprobar si el CI está en la lista de duplicados
                $ci_style = isset($ci_duplicados[$registro['CI']]) ? "color:red;" : "";

                echo "<tr>";
                echo utf8_encode("<td>$n</td><td>$registro[nombre]</td><td>$registro[apellido_paterno]</td><td>$registro[apellido_materno]</td>");
                echo "<td style='$ci_style'>$registro[CI]</td>";
                echo utf8_encode("<td>$registro[Gmail]</td><td>$registro[telefono]</td>");
                if ($_SESSION['nivel'] == "rrhh") {
                    echo "<td width='170'>
                        $editar
                        $eliminar           
                    </td>";
                }
                echo "</tr>";
            }
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th style='text-align:center;'>No</th>
            <th style='text-align:center;'>Nombre</th>
            <th style='text-align:center;'>Apellido Paterno</th>
            <th style='text-align:center;'>Apellido Materno</th>
            <th style='text-align:center;'>CI</th>
            <th style='text-align:center;'>Gmail</th>
            <th style='text-align:center;'>Teléfono</th>
            <?php if ($_SESSION['nivel'] == "rrhh") {
                echo "<th style='text-align:center;'>Acciones</th>";
            } ?>
        </tr>
    </tfoot>
</table>
<?php
$postulante->__destroy();
?>

<?php
include("modelo/convocatoria.php");

$convocatoria = new Convocatoria();
$registros = $bd->Consulta("SELECT * FROM convocatorias");

$hoy = date('Y-m-d');
$bd->Consulta("UPDATE convocatorias SET Estado=2 WHERE Fecha_fin < '$hoy' AND Estado != 3");

?>
<h2>Lista de Convocatorias
    <?php if ($_SESSION['nivel'] == "rrhh") { ?>
        <a href="?mod=convocatoria&pag=form_convocatoria" class="btn btn-green btn-icon" style="float: right;">
            Agregar convocatoria
            <i class="entypo-plus"></i>
        </a>
    <?php } ?>
</h2>
<br>
<table class="table table-bordered datatable" id="table-1">
    <thead>
        <tr>
            <th>No</th>

            <th>Nombre de la Convocatoria</th>
            <th>Fecha de Creación</th>
            <th>Fecha de Inicio</th>
            <th>Fecha de Fin</th>
            <th>Estado</th>
            <th>Vacantes</th>
            <th>Requisitos</th>
            <?php if ($_SESSION['nivel'] == "rrhh") {
                echo "<th>Acciones</th>";
            } ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $n = 0;

        while ($registro = $bd->getFila($registros)) {
            $eliminar = "<a href='control/convocatoria/eliminar.php?id=$registro[id_convocatoria]' class='accion btn btn-red btn-icon btn-xs'>Eliminar <i class='entypo-cancel'></i></a>";
            $editar = "<a href='?mod=convocatoria&pag=editar_convocatoria&id=$registro[id_convocatoria]' class='btn btn-info btn-icon btn-xs'>Editar <i class='entypo-pencil'></i></a>";
            $n++;

            // Convertir el estado numérico a texto
            switch ($registro['Estado']) {
                case 1:
                    $estado_texto = "Habilitado";
                    break;
                case 2:
                    $estado_texto = "Inhabilitado";
                    break;
                case 3:
                    $estado_texto = "Indefinido";
                    break;
                default:
                    $estado_texto = "NA";
                    break;
            }

            $requisitos = explode("\n", $registro['Requisitos']);
            $requisitos_lista = "<ul class='requisitos-lista'>";
            foreach ($requisitos as $requisito) {
                $requisitos_lista .= "<li>▶ " . htmlspecialchars(trim($requisito)) . "</li>";
            }
            $requisitos_lista .= "</ul>";

            echo "<tr>";
            echo utf8_encode("<td>$n</td><td>$registro[nombre_convocatoria]</td><td>$registro[Fecha_creacion]</td><td>$registro[Fecha_inicio]</td><td>$registro[Fecha_fin]</td><td>$estado_texto</td><td>$registro[Vacantes]</td>");
            echo "<td>
                    <button class='btn btn-info btn-icon btn-xs' onclick='toggleRequisitos($n)'>Mostrar Requisitos <i class='entypo-list'></i></button>
                    <div id='requisitos-$n' class='requisitos-container' style='display: none;'>
                        $requisitos_lista
                    </div>
                  </td>";
            if ($_SESSION['nivel'] == "rrhh") {
                echo "<td width='170'>
                    $editar
                    $eliminar           
                </td>";
            }
            echo "</tr>";
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th style='text-align:center;'>No</th>
            <th style='text-align:center;'>Nombre de la Convocatoria</th>
            <th style='text-align:center;'>Fecha de Creación</th>
            <th style='text-align:center;'>Fecha de Inicio</th>
            <th style='text-align:center;'>Fecha de Fin</th>
            <th style='text-align:center;'>Estado</th>
            <th style='text-align:center;'>Vacantes</th>
            <th style='text-align:center;'>Requisitos</th>
            <?php
            if ($_SESSION['nivel'] == "rrhh") {
                echo "<th style='text-align:center;'>Acciones</th>";
            } ?>
        </tr>
    </tfoot>
</table>
<?php
$convocatoria->__destroy();
?>

<!-- CSS para los requisitos -->
<style>
    .requisitos-lista {
        list-style-type: none;
        padding-left: 0;
    }
    .requisitos-lista li {
        margin: 5px 0;
    }
    .requisitos-container {
        margin-top: 10px;
        white-space: pre-wrap;
    }
</style>

<!-- JavaScript para manejar el desplegable de requisitos -cambiar- -->
<script>
    function toggleRequisitos(rowId) {
        var requisitosDiv = document.getElementById('requisitos-' + rowId);
        if (requisitosDiv.style.display === 'none') {
            requisitosDiv.style.display = 'block';
        } else {
            requisitosDiv.style.display = 'none';
        }
    }
</script>

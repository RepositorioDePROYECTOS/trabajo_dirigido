<?php
include("../../modelo/partidas_detalle.php");
include("../../modelo/funciones.php");

$partidas = new Partidas_detalle();
if ($partidas->eliminar(security($_GET[id]))) {
    echo "Acci&oacute;n completada con &eacute;xito";
} else {
    echo "Ocurri&oacute; un error.";
}

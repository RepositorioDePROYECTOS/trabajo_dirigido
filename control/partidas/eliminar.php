<?php
include("../../modelo/partidas.php");
include("../../modelo/funciones.php");

$partidas = new Partidas();
if ($partidas->eliminar(security($_GET[id]))) {
    echo "Acci&oacute;n completada con &eacute;xito";
} else {
    echo "Ocurri&oacute; un error.";
}

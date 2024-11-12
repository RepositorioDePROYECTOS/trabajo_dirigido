<?php
session_start();
include("../../modelo/conexion.php");
include("../../modelo/funciones.php");
include("../../modelo/derivaciones.php");

referer_permit();
setlocale(LC_TIME, "es_ES");
ini_set('date.timezone', 'America/La_Paz');
$bd = new conexion();
$id = security($_GET[id]);

$result = $bd->Consulta("DELETE FROM derivaciones WHERE id_derivacion = $id");
if ($bd->numFila_afectada($registros) > 0)
    echo "Acci&oacute;n completada con &eacute;xito";
else
    echo "Ocuri&oacute; un Error.";
// echo $id;

<?php
include("../../modelo/planilla.php");
include("../../modelo/funciones.php");

referer_permit();

$id_planilla = $_GET[id];

$planilla = new planilla();
$result = $planilla->aprobar_planilla($id_planilla);
if($result)
{
	echo "Planilla Aprobada.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>
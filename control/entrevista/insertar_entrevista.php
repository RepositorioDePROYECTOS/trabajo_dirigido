<?php
include("../../modelo/entrevista.php");
include("../../modelo/funciones.php");

referer_permit();

$nombre = utf8_decode($_POST[nombre]);
$mes = utf8_decode($_POST[mes]);
$gestion = utf8_decode($_POST[gestion]);

$entrevista = new Entrevista();

$result = $entrevista->registrar_convocatoria($nombre, $mes, $gestion);
if($result)
{
	echo "Datos registrados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>
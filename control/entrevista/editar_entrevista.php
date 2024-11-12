<?php
include("../../modelo/entrevista.php");
include("../../modelo/funciones.php");

referer_permit();

$id_convocatoria = $_POST[id_convocatoria];
$nombre    = utf8_decode($_POST[nombre]);
$mes       = utf8_decode($_POST[mes]);
$gestion   = utf8_decode($_POST[gestion]);
// echo "DATOS: ".$id_convocatoria." - " .$nombre." - ". $mes." - ".$gestion." - ".$correo;
$entrevista = new Entrevista();
$result = $entrevista->modificar_convocatoria($id_convocatoria, $nombre, $mes, $gestion);
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>
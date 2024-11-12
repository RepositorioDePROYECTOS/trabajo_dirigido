<?php
include("../../modelo/participante.php");
include("../../modelo/funciones.php");

referer_permit();

$id_postulante = $_POST[id_postulante];
$nombre    = utf8_decode($_POST[nombre]);
$ci        = utf8_decode($_POST[ci]);
$telefono  = utf8_decode($_POST[telefono]);
$correo    = utf8_decode($_POST[correo]);
// echo "DATOS: ".$id_postulante." - " .$nombre." - ". $ci." - ".$telefono." - ".$correo;
$postulante = new Postulante();
$result = $postulante->modificar_postulante($id_postulante, $nombre, $ci, $telefono, $correo);
if($result)
{
	echo "Datos actualizados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>
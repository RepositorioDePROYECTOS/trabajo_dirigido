<?php
include("../../modelo/participante.php");
include("../../modelo/funciones.php");

referer_permit();

$nombre = utf8_decode($_POST[nombre]);
$ci = utf8_decode($_POST[ci]);
$telefono = utf8_decode($_POST[telefono]);
$correo = utf8_decode($_POST[correo]);

$postulante = new Postulante();

$result = $postulante->registrar_postulante($nombre, $ci, $telefono, $correo);
if($result)
{
	echo "Datos registrados.";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>
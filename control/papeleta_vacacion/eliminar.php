<?php
include("../../modelo/papeleta_vacacion.php");
include("../../modelo/funciones.php");

referer_permit();
$id_papeleta_vacacion = security($_GET[id]);

$papeleta_vacacion = new papeleta_vacacion();
$result = $papeleta_vacacion->eliminar($id_papeleta_vacacion);
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.$id_papeleta_vacacion";
}


?>
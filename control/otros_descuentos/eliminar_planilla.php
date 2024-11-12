<?php
include("../../modelo/otros_descuentos.php");
include("../../modelo/funciones.php");

referer_permit();
$mes = security($_GET[mes]);
$gestion = security($_GET[gestion]);

$otros_descuentos = new otros_descuentos();
$bd = new conexion();

$registros = $bd->Consulta("select * from planilla where mes=$mes and gestion=$gestion");
$registro = $bd->getFila($registros);
if(!empty($registro))
{
	echo "Error. Existen planilla general de dicho periodo. Elimine primero dicha planilla";
}
else
{
	$result = $otros_descuentos->eliminar_planilla($mes, $gestion);
	if($result)
	{
		echo "Acci&oacute;n completada con &eacute;xito";
	}
	else
	{
		echo "Ocuri&oacute; un Error.";
	}
}


?>
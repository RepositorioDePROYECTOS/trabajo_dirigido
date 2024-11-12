<?php
include("../../modelo/total_ganado.php");
include("../../modelo/funciones.php");

referer_permit();


$total_ganado = new total_ganado();
$result = $total_ganado->eliminar(security($_GET[id]));
if($result)
{
	echo "Acci&oacute;n completada con &eacute;xito";
}
else
{
	echo "Ocuri&oacute; un Error.";
}


?>
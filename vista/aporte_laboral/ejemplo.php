<?php
	include("../../modelo/funciones.php");

	$anios = antiguedad('1970-04-16','2019-08-31');
	$years = date('Y',strtotime('2019-08-31')) - date('Y',strtotime('1954-04-16'));
	echo "edad".$anios[0];
	echo "Years:".$years;
?>

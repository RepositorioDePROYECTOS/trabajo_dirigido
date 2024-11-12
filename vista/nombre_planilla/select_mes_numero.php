<?php
    include("../../modelo/funciones.php");
    
    $numero_mes = $_POST[numero_mes];
	$mes = getMes($numero_mes);;

 	echo "<input type='text' name='mes' value='$mes' class='form-control required text' readonly/>";
?>
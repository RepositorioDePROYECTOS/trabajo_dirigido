<?php
    include("../../modelo/cargo.php");
    $cargo = new cargo();
    $cargo_salario = $_POST[id_cargo];

	$cargo->get_cargo($cargo_salario);
	$salario = $cargo->salario_mensual;

 	echo "<input type='text' name='salario' value='$salario' class='form-control required text'/>";
?>
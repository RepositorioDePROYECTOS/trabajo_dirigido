<?php
include("../../modelo/rol.php");

$nombre = $_POST[nombre];
$estado = 1;

$rol = new rol();
$result = $rol->registrar_rol($nombre, $estado);

if($result)
{
    echo "Datos registrados.";
}
else
{
    echo "Ocuri&oacute; un Error. El rol ya existe.";
}

?>
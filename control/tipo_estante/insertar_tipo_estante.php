<?php
include("../../modelo/tipo_estante.php");

$categoria = $_POST[categoria];
$descripcion = $_POST[descripcion];

$tipo_estante = new tipo_estante();
$result = $tipo_estante->registrar_tipo_estante($categoria, $descripcion);
if($result)
{
    echo "Datos registrados.";
}
else
{
    echo "Ocuri&oacute; un Error. El estante ya existe.";
}

?>
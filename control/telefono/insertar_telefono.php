<?php
include("../../modelo/telefono.php");
include("../../modelo/trabajador.php");
// include("../../modelo/conexion.php");

$id_trabajador = $_POST[id_trabajador];
$id_cargo = $_POST[id_cargo];
$telf_interno = $_POST[telf_interno];
$telefono = new telefono();
$result = $telefono->registrar_telefono($telf_interno,$id_trabajador, $id_cargo);
if($result)
{
    echo "Datos registrados.";
}
else
{
    echo "Ocuri&oacute; un Error. El Tel&eacute;fono ya esta registrado";
}

?>

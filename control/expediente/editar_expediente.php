<?php
include("../../modelo/expediente.php");

$id_expediente = $_POST[id_expediente];
$nombre_archivo = $_POST[nombre_archivo];
$nro_fojas = intval($_POST[nro_fojas]);
$observacion = $_POST[observacion];

$expediente = new expediente();
$result = $expediente->modificar_expediente($id_expediente, $nombre_archivo, $nro_fojas, $observacion);

if($result){
    echo "Datos actualizados.";
}else{
    echo "Ocuri&oacute; un Error.";
}
?>
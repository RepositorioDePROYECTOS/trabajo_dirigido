<?php
include("../../modelo/conv_asignar.php");

$id_conv_lista = intval($_GET['id_conv_lista']); 
echo "ID a eliminar: " . $id_conv_lista; 

$convLista = new ConvLista();

if ($convLista->eliminar_asignacion($id_conv_lista)) {
    echo "Eliminación exitosa";
    exit();
} else {
    echo "Ocurrió un error al eliminar";
    exit();
}
?>

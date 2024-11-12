<?php
include("../../modelo/conv_asignar.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_convocatoria']) && isset($_POST['id_postulante'])) {
        $id_convocatoria = intval($_POST['id_convocatoria']);
        $id_postulante = intval($_POST['id_postulante']);

        $convLista = new ConvLista();
        
        $resultado = $convLista->registrar_asignacion($id_convocatoria, $id_postulante);

        if ($resultado) {
            echo("se registro correctamente.Revisa lista");
            exit();
        } else {
            echo("el postulante ya esta en la convocatoria:Revise lista");
            exit();
        }
    } else {
        echo("incompleto");
        exit();
    }
} else {
    echo("Location: error.php");
    exit();
}
?>

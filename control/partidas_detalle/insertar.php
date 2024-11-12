<?php
    include("../../modelo/partidas_detalle.php");

    $concepto_partida     = utf8_decode($_POST[concepto_partida]);
    $tipo_detalle_partida = utf8_decode($_POST[tipo_detalle_partida]);
    $id_partida           = utf8_decode($_POST[id_partida]);

    $partida = new Partidas_detalle();
    $result = $partida->registrar_partida_detalle($concepto_partida, $tipo_detalle_partida, $id_partida);
    if($result)
    {
        echo "Datos registrados.";
    }
    else
    {
        echo "Ocuri&oacute; un Error.";
    }

?>
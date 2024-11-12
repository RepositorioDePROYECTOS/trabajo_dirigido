<?php
    include("../../modelo/partidas.php");

    $codigo_partida = utf8_decode($_POST[codigo_partida]);
    $nombre_partida = utf8_decode($_POST[nombre_partida]);
    $glosa_partida  = utf8_decode($_POST[glosa_partida]);
    $tipo_partida   = utf8_decode($_POST[tipo_partida]);
    $estado_partida = 1;

    $partida = new Partidas();
    $result = $partida->registrar_partida($codigo_partida, $nombre_partida, $glosa_partida, $tipo_partida, $estado_partida);
    if($result)
    {
        echo "Datos registrados.";
    }
    else
    {
        echo "Ocuri&oacute; un Error.";
    }

?>
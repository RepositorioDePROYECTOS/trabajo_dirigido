<?php    
    include("../../modelo/salida.php");  
    include("../../modelo/funciones.php");
    setlocale(LC_TIME,"es_ES");
    ini_set('date.timezone','America/La_Paz');
    $hora_exac_llegada = date('H:i:s');
    // $hora_exac_llegada='9:30';
    // $hora_e_salida='9:00';
    $hora_e_salida = $_GET[hora_e_salida];


    // $salida = new DateTime($hora_e_salida);
    // $llegada = new DateTime($hora_exac_llegada);
    $tiempo_usado=date("H:i", strtotime("00:00") + strtotime($hora_exac_llegada)- strtotime($hora_e_salida) );
    $salida = new salida();
    if($salida->modificarhora(security($_GET[id]), $hora_exac_llegada,$tiempo_usado))
    {
        echo "Acci&oacute;n completada con &eacute;xito";
    }
    else
    {
        echo "Ocurri&oacute; un error.";
        echo "<br>";
        echo "Hora de Llegada: ".$_GET[hora_exac_llegada]."<br>"." ID: ".$_GET[id];
    
    }
            // echo "Hora de Llegada: ".$hora_exac_llegada."<br>"." hora salida: ".$hora_e_salida."<br>"." tiempo usado: ".$tiempo_usado;
?>
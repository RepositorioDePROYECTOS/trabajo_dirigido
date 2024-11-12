<?php    
    include("../../modelo/salida.php");  
    include("../../modelo/funciones.php");
    setlocale(LC_TIME,"es_ES");
    ini_set('date.timezone','America/La_Paz');
    $hora_e_salida = date('H:i:s');
    
        $estado=1;//EN proceso
        $salida = new salida();
        if($salida->modificar_estado_s(security($_GET[id]), $estado, $hora_e_salida))
        {
            echo "Acci&oacute;n completada con &eacute;xito";
        }
        else
        {
            echo "Ocurri&oacute; un error.";
        }
?>
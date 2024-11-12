<?php
include("../../modelo/salida.php");
include("../../modelo/funciones.php");

$id_usuario = (isset($_POST[id_usuario])) ? $_POST[id_usuario] : '';
$cargo = (isset($_POST[cargo])) ? $_POST[cargo] : '';
$area = (isset($_POST[area])) ? $_POST[area] : '';
$cargo2 = ($_POST[cargo2]) ? $_POST[area] : '';
$tipo_salida = (isset($_POST[tipo_salida])) ? $_POST[tipo_salida] : '';
$chofer=intval($_POST[id_conductor]);
$id_chofer = (isset($chofer)) ? $chofer : '';
$id_vehiculo = (isset($_POST[id_vehiculo])) ? $_POST[id_vehiculo] : '';
$fecha = (isset($_POST[fecha])) ? $_POST[fecha] : '';
if($tipo_salida==4){
    
    $horas_justificacion_real = '01:00';
}
else{
    $horas_justificacion_real = (isset($_POST[horas_justificacion_real])) ? $_POST[horas_justificacion_real] : '00:00';
}

$hora_retorno = (isset($_POST[hora_hasta])) ? $_POST[hora_hasta] : '00:00';
$hora_salida = (isset($_POST[hora_desde])) ? $_POST[hora_desde] : '00:00';
if($tipo_salida==4){
    $direccion_salida = (isset($_POST[direccion_salida])) ? 'ALMUERZO' : '';
}
else{
    $direccion_salida = (isset($_POST[direccion_salida])) ? $_POST[direccion_salida] : '';
}

if($tipo_salida==4){
    $motivo = (isset($_POST[motivo])) ? 'ALMUERZO' : '';
}
else{
    $motivo = (isset($_POST[motivo])) ? $_POST[motivo] : '';
}
if($tipo_salida==4){
    $observaciones = (isset($_POST[observaciones])) ? 'ALMUERZO' : '';
}
else{
    $observaciones = (isset($_POST[observaciones])) ? $_POST[observaciones] : '';
}

$hora_exac_llegada='00:00';
$hora_e_salida='00:00';

if($tipo_salida==4){
    $estado=3;
}
else{
    $estado=0;
}

$horas_total = (isset($_POST[horas_total])) ? $_POST[horas_total] : '';
// cantidad horas 

$hora=split(":",$horas_justificacion_real);
$h=$h+(int)$hora[0];
$m=$m+(int)$hora[1];
$h+=(int)($m/60);
$m = $m % 60;
$hora_salida_2 = ($h*60)+$m;
$total=$hora_salida_2+$horas_total; //<120

$hora1=split(":",$hora_retorno);
$h_retorno=$h_retorno+(int)$hora1[0];
$m_retorno=$m_retorno+(int)$hora1[1];

$hora2=split(":",$hora_salida);
$h_salida=$h_salida+(int)$hora2[0];
$m_salida=$m_salida+(int)$hora2[1];
// echo $total;
// echo $h."  -  ".$m;
if($total <= 120 && $tipo_salida==2){
    if($h<=1 && $m>=1){
        $salida = new salida();
        $result = $salida->registrar_salida($hora_retorno, $hora_exac_llegada, $hora_salida, $hora_e_salida, $horas_justificacion_real, $direccion_salida, $motivo, $observaciones, $fecha, $id_vehiculo, $id_usuario, $tipo_salida,$id_chofer, $estado);
        if($result)
        {
            echo "Datos registrados.".$h;
        }
        else
        {
            echo "Ocuri&oacute; un Error. ";
        }
    }
    else{
            echo ($h_retorno>$h_salida && $m_retorno>=$m_salida ) ? "Error. No puede registrar mas de una hora para la misma papeleta":"Error. Verifique la hora. ";
        
    }
        
}
elseif($tipo_salida==4){
    $salida = new salida();
    $result = $salida->registrar_salida($hora_retorno, $hora_exac_llegada, $hora_salida,$hora_e_salida, $horas_justificacion_real, $direccion_salida, $motivo, $observaciones, $fecha, $id_vehiculo, $id_usuario, $tipo_salida,$id_chofer, $estado);
    if($result)
    {
        echo "Datos registrados.";
    }
    else
    {
        echo "Ocuri&oacute; un Error. Almuerzo no insertado -- hora_retorno ".$hora_retorno.",hora_exac_llegada ".$hora_exac_llegada.",hora_salida ".$hora_salida.",hora_e_salida ".$hora_e_salida.",horas_justificacion_real ".$horas_justificacion_real.",direccion_salida ".$direccion_salida.",7 ".$motivo.",8 ".$observaciones.",9 ".$fecha.",10".$id_vehiculo.",11 ".$id_usuario.",TIPO SALIDA ".$tipo_salida.",13 ".$id_chofer.",14 ".$estado;
    }
}
elseif($tipo_salida==1 || $tipo_salida==3){
    if($h_retorno>$h_salida && $m_retorno>=$m_salida){
        $salida = new salida();
        $result = $salida->registrar_salida($hora_retorno, $hora_exac_llegada, $hora_salida,$hora_e_salida, $horas_justificacion_real, $direccion_salida, $motivo, $observaciones, $fecha, $id_vehiculo, $id_usuario, $tipo_salida,$id_chofer, $estado);
        if($result)
        {
            echo "Datos registrados.";
        }
        else
        {
            echo "Ocuri&oacute; un Error. registro no insertado -- hora_retorno ".$hora_retorno.",hora_exac_llegada ".$hora_exac_llegada.",hora_salida ".$hora_salida.",hora_e_salida ".$hora_e_salida.",horas_justificacion_real ".$horas_justificacion_real.",direccion_salida ".$direccion_salida.",7 ".$motivo.",8 ".$observaciones.",9 ".$fecha.",10".$id_vehiculo.",11 ".$id_usuario.",TIPO SALIDA ".$tipo_salida.",13 ".$id_chofer.",14 ".$estado;
        }
    }
    else{
        echo "Error. Verifique la hora.";
    }
}
else{
    echo "Lo siento ya no tiene tiempo correspondiente, le queda:".(120-$horas_total)." minutos disponibles";
}


?>
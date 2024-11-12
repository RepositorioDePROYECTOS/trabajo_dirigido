<?php
require_once('codigo_control.class.php');

// Ejemplo de generacion
$CodigoControl = new CodigoControl(
	'29040011007',
	'1503',
	'4189179011',
	'20070702',
	'2500',
	'9rCB7Sv4X29d)5k7N%3ab89p-3(5[A'
	);
    
echo $CodigoControl->generar().'<br/>';
echo "<hr>";

$CodigoControl = new CodigoControl(
	'79040011859',
	'152',
	'1026469026',
	'20070728',
	'135',
	'A3Fs4s$)2cvD(eY667A5C4A2rsdf53kw9654E2B23s24df35F5'
	);
    
echo $CodigoControl->generar().'<br/>';
echo "<hr>";

$CodigoControl = new CodigoControl(
	'30040010595',
	'10015',
	'953387014',
	'20070825',
	'5725.90',
	'33E265B43C4435sdTuyBVssD355FC4A6F46sdQWasdA)d56666fDsmp9846636B3'
	);
    
echo $CodigoControl->generar().'<br/>';
echo "<hr>";

$CodigoControl = new CodigoControl(
	'4004006765522',
	'606940',
	'826980014',
	'20070307',
	'20232.5',
	't9[XDb+cu5j5T7}BKzRBm77RLrFqm*D+tk3q%ja7[Hd#$C8Y#-+IEMZ$y87yM$NW'
	);
    
echo $CodigoControl->generar().'<br/>';
echo "<hr>";


?>

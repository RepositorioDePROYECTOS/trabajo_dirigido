<?php
session_start();
include("../../modelo/expediente.php");
include("../../modelo/funciones.php");
include("../../modelo/usuario_elapas.php");


$extensiones = array("pdf");

referer_permit();

$usuario_elapas = new usuario_elapas();

$fecha_registro=$_POST[fecha_registro];
$nombre_archivo=$_POST[nombre_archivo];
$nro_fojas=intval($_POST[nro_fojas]);
$observacion=$_POST[observacion];
$id_usuario_elapas=$_POST[id_usuario_elapas];

$usuario_elapas->get_usuario_elapas($id_usuario_elapas);
$nombreCarpeta = $usuario_elapas->numero_cuenta;

if (!file_exists("../../archivo/expediente/$nombreCarpeta")) 
{
    mkdir("../../archivo/expediente/$nombreCarpeta", 0777, true);
}
$destination_path = "../../archivo/expediente/$nombreCarpeta" . DIRECTORY_SEPARATOR;
$archivo = basename($_FILES['nombre_archivo']['name']);
$tipo = explode(".", $archivo);
$ext = $tipo[count(explode(".", $archivo)) - 1];
$nombre = date('Ymdhis');
$archivo = $nombre.".".$ext;
$tamanio = $_FILES['nombre_archivo']['size'];
// Validacion Codigo Catastral
// $cod_cat = $bd->Consulta("select codigo_catastral from expediente");
// $lista_codigos = array();
// foreach()
// Validacion Codigo Catastral
$expediente = new expediente();

if($ext=="pdf"){
	$result = $expediente->registrar_expediente($fecha_registro, $nombre_archivo, $nro_fojas, $observacion, $archivo, $id_usuario_elapas);
	if($result){
		if(in_array($ext, $extensiones) && $tamanio <= 94371840)
		{
			$target_path = $destination_path . $archivo;    
			if (@move_uploaded_file($_FILES['nombre_archivo']['tmp_name'], $target_path)) 
			{
				chmod ($target_path,0755);
				echo "Datos registrados.";
			}
			else
			{
				echo "Ocurri&oacute; un Error.";
			}
		}
		else
		{
			   echo "Ocuri&oacute; un Error. Archivo no permitido.";
			exit();
		}
	}
	else{
		echo "Codigo catastral Existente.";
	}
}
else
{
	echo "Ocuri&oacute; un Error. Archivo no permitido.";
	exit();
}


?>
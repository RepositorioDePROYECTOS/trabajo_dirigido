<?php
include("../../modelo/conexion.php");
include("../../modelo/solicitud_activo.php");
include("../../modelo/funciones.php");
referer_permit();
// date_default_timezone_set('America/La_Paz');
setlocale(LC_TIME, "es_ES");
ini_set('date.timezone', 'America/La_Paz');

$id_solicitud_activo   = $_POST[id];
$estado                = $_POST[estado];
$id_usuario            = $_POST[id_usuario];
$file_input            = (!empty($_FILES['archivo']['name'])) ? $_FILES['archivo'] : '';
$fecha                 = date("Y-m-d H:i:s");
$array                 = $_POST['partidas'];

// $array = array("solicitud"=>$id_solicitud_activo, "estado"=>$estado, "usuario"=>$id_usuario);
// print_r($array);
$bd = new conexion();
$solicitud_activo = new solicitud_activo();

foreach ($array as $key) {
    list($id_detalle, $id_partida) = explode('-', $key); // Usar $key en lugar de $data
	$buscar = $bd->Consulta("UPDATE detalle_activo set id_partida=$id_partida WHERE id_detalle_activo = $id_detalle");
}
// Verificacion
$tipo_trabajador = "";
$verificacion_usuario = $bd->Consulta("SELECT t.id_trabajador FROM trabajador as t INNER JOIN usuario as u ON u.id_trabajador = t.id_trabajador WHERE u.id_usuario=$id_usuario");
$verificacion_usuarios = $bd->getFila($verificacion_usuario);
if($verificacion_usuarios[id_trabajador]){
    $tipo_trabajador = "ITEM";
} else {
    // $usuario = $bd->Consulta("SELECT t.id_eventual as id_trabajador FROM eventual as t INNER JOIN usuario as u ON u.id_eventual = t.id_eventual WHERE u.id_usuario=$id_usuario");
    // $user = $bd->getFila($usuario);
    $tipo_trabajador = "EVENTUAL";
}
// echo "ID Sol: ".$id_solicitud." ID Ver: ".$id_verificacion." Tipo: ".$tipo_verificacion. " FECHA: ".$fecha;
$target_dir = "../../documents" . DIRECTORY_SEPARATOR;
// $timestamp = time();
$target_file = $target_dir . "/presupuesto_" . $id_solicitud_activo . "_activo.pdf";
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Verificar si el archivo es demasiado grande
if ($file_input["size"] > 5000000) {
	echo "Ocuri&oacute; un Error. El archivo es demasiado grande.";
	$uploadOk = 0;
}
// Permitir solo archivos PDF
if ($fileType != "pdf") {
	echo "Ocuri&oacute; un Error. Solo se permiten archivos PDF.";
	$uploadOk = 0;
}
// Verificar si se produjo un error
if ($uploadOk == 0) {
	echo "Ocuri&oacute; un Error. El archivo no se pudo subir.";
	// Si todo está bien, intenta subir el archivo
} else {
	if (move_uploaded_file($file_input["tmp_name"], $target_file)) {
		$result = $solicitud_activo->presupuestar($id_solicitud_activo, $estado);
		$trabajador = $bd->Consulta("SELECT t.id_trabajador FROM trabajador as t INNER JOIN usuario as u ON t.id_trabajador = u.id_trabajador WHERE u.id_usuario=$id_usuario");
		$t = $bd->getFila($trabajador);
		$id_t = $t[id_trabajador];
		// echo "ID: ".$id_t;
		$derivaciones = $bd->Consulta("SELECT * FROM derivaciones WHERE id_solicitud=$id_solicitud_activo AND tipo_solicitud = 'activo'");
		$derivacion   = $bd->getFila($derivaciones);
		if ($result) {
			if ($estado == "PRESUPUESTADO") {
				$derivacion_estado = $bd->Consulta("UPDATE derivaciones set estado_derivacion='presupuestado' where id_derivacion=$derivacion[id_derivacion]");
				$historico = $bd->Consulta("INSERT into historicos (id_derivaciones, id_solicitud, id_trabajador, tipo_solicitud, tipo_trabajador, estado) VALUES ($derivacion[id_derivacion], $id_solicitud_activo, $id_t, 'activo', '$tipo_trabajador', 'presupuestado')");
			} else {
				$derivacion_estado = $bd->Consulta("UPDATE derivaciones set estado_derivacion='sin presupuesto' where id_derivacion=$derivacion[id_derivacion]");
				$historico = $bd->Consulta("INSERT into historicos (id_derivaciones, id_solicitud, id_trabajador, tipo_solicitud, estado) VALUES ($derivacion[id_derivacion], $id_solicitud_activo, $id_t, 'activo', 'sin presupuesto')");
			}
			echo "Solicitud de activo modificado.";
		} else {
			echo "Ocuri&oacute; un Error.";
			// echo "SELECT t.id_trabajador FROM trabajador as t INNER JOIN usuario as u ON t.id_trabajador = u.id_trabajador WHERE u.id_usuario=$id_usuario"." -- ". "SELECT * FROM derivaciones WHERE id_solicitud=$id_solicitud_activo AND tipo_solicitud = 'activo'";
		}
	} else {
		echo "Ocuri&oacute; un Error. Al subir el archivo.";
	}
}

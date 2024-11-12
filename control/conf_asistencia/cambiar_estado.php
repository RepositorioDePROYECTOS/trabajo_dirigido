<?php
include("../../modelo/conf_asistencia.php");
include("../../modelo/funciones.php");

referer_permit();
$id_asistencia = security($_GET[id]);

$conf_asistencia = new conf_asistencia();
$result = $conf_asistencia->get_conf_asistencia_by_id($id_asistencia);
if($result[estado] == 'HABILITADO')
{
    $res = $conf_asistencia->modificar_estado_inhabilitado_conf_asistencia($id_asistencia);
    if($res) {
        echo "Acci&oacute;n completada con &eacute;xito";
    } else {
        echo "Ocuri&oacute; un Error. ";
    }
}
else
{
	$res = $conf_asistencia->modificar_estado_habilitado_conf_asistencia($id_asistencia);
    if($res) {
        echo "Acci&oacute;n completada con &eacute;xito";
    } else {
        echo "Ocuri&oacute; un Error. ";
    }
}


?>
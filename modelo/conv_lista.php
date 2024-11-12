<?php
if (!class_exists("conexion")) {
    include("conexion.php");
}
class Convocatoria
{
    private $bd;

    function __construct()
    {
        $this->bd = new Conexion();
    }

    // Método para obtener las convocatorias habilitadas e indefinidas
    function get_convocatorias()
    {
        $registros = $this->bd->Lista("SELECT * FROM convocatorias WHERE Estado IN (1, 3)");
        return $registros;
    }

    // Método para obtener los postulantes asignados a una convocatoria en conv_lista
    function get_postulantes_asignados($id_convocatoria)
    {
        $consulta = "SELECT p.nombre, p.apellido_paterno, p.apellido_materno , p.CI , p.Gmail , p.Telefono 
                     FROM conv_lista cl
                     JOIN postulantes p ON cl.id_postulante = p.id_postulante
                     WHERE cl.id_convocatoria = $id_convocatoria";
        return $this->bd->Lista($consulta);
    }

    function __destruct()
    {
        $this->bd->Cerrar();
    }
}
?>
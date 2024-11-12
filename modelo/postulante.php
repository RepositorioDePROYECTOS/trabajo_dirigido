<?php
if (!class_exists("conexion")) {
    include("conexion.php");
}

class Postulante 
{
    public $id_postulante;
    public $nombre;
    public $apellido_paterno;
    public $apellido_materno;
    public $CI;
    public $Gmail;
    public $telefono;
    public $id_convocatoria;

    private $bd;

    function __construct()
    {
        $this->bd = new Conexion();
    }

    // Registrar un nuevo postulante
    function registrar_postulante($nombre, $apellido_paterno, $apellido_materno, $CI, $Gmail, $telefono, $id_convocatoria)
    {
        $registros = $this->bd->Consulta("INSERT INTO postulantes (nombre, apellido_paterno, apellido_materno, CI, Gmail, telefono, id_convocatoria) VALUES ('$nombre', '$apellido_paterno', '$apellido_materno', '$CI', '$Gmail', '$telefono', '$id_convocatoria')");
        return $this->bd->numFila_afectada() > 0;
    }

    // Modificar un postulante existente
    function modificar_postulante($id_postulante, $nombre, $apellido_paterno, $apellido_materno, $CI, $Gmail, $telefono, $id_convocatoria)
    {
        $registros = $this->bd->Consulta("UPDATE postulantes SET nombre='$nombre', apellido_paterno='$apellido_paterno', apellido_materno='$apellido_materno', CI='$CI', Gmail='$Gmail', telefono='$telefono', id_convocatoria='$id_convocatoria' WHERE id_postulante=$id_postulante");
        return $this->bd->numFila_afectada() > 0;
    }

    // Obtener un postulante por su ID
    function get_postulante($id_postulante)
    {
        $registros = $this->bd->Consulta("SELECT * FROM postulantes WHERE id_postulante=$id_postulante");
        $registro = $this->bd->getFila($registros);

        if ($registro) {
            $this->id_postulante = $registro['id_postulante'];
            $this->nombre = $registro['nombre'];
            $this->apellido_paterno = $registro['apellido_paterno'];
            $this->apellido_materno = $registro['apellido_materno'];
            $this->CI = $registro['CI'];
            $this->Gmail = $registro['Gmail'];
            $this->telefono = $registro['telefono'];
            $this->id_convocatoria = $registro['id_convocatoria'];
        }
    }

    // Obtener todos los postulantes con un criterio
    function get_all($criterio = "")
    {
        $where = empty($criterio) ? "" : " WHERE $criterio";
        $registros = $this->bd->Lista("SELECT * FROM postulantes $where");
        return $registros;
    }

    // Eliminar un postulante
    function eliminar_postulante($id_postulante)
    {
        $registros = $this->bd->Consulta("DELETE FROM postulantes WHERE id_postulante=$id_postulante");
        return $this->bd->numFila_afectada() > 0;
    }

    function __destroy()
    {
        $this->bd->Cerrar();
    }
}
?>

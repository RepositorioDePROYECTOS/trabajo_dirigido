<?php
if(!class_exists("conexion"))
    include ("conexion.php");

class Convocatoria 
{
    public $id_convocatoria;
    public $nombre_convocatoria;
    public $Fecha_creacion;
    public $Fecha_inicio;
    public $Fecha_fin;
    public $Estado;
    public $Vacantes;
    public $Requisitos;

    private $bd;

    function __construct()
    {
        $this->bd = new Conexion();
    }

    function registrar_convocatoria($nombre_convocatoria, $Fecha_inicio, $Fecha_fin, $Estado, $Vacantes, $Requisitos)
    {
        $registros = $this->bd->Consulta("INSERT INTO convocatorias (nombre_convocatoria, Fecha_creacion, Fecha_inicio, Fecha_fin, Estado, Vacantes, Requisitos) VALUES ('$nombre_convocatoria', NOW(), '$Fecha_inicio', '$Fecha_fin', '$Estado', '$Vacantes', '$Requisitos')");
        return $this->bd->numFila_afectada() > 0;
    }

    // Modificar una convocatoria existente
    function modificar_convocatoria($id_convocatoria, $nombre_convocatoria, $Fecha_inicio, $Fecha_fin, $Estado, $Vacantes, $Requisitos)
    {
        $registros = $this->bd->Consulta("UPDATE convocatorias SET nombre_convocatoria='$nombre_convocatoria', Fecha_inicio='$Fecha_inicio', Fecha_fin='$Fecha_fin', Estado='$Estado', Vacantes='$Vacantes', Requisitos='$Requisitos' WHERE id_convocatoria=$id_convocatoria");
        return $this->bd->numFila_afectada() > 0;
    }

    // Obtener una convocatoria por su ID
    function get_convocatoria($id_convocatoria)
    {
        $registros = $this->bd->Consulta("SELECT * FROM convocatorias WHERE id_convocatoria=$id_convocatoria");
        $registro = $this->bd->getFila($registros);

        if ($registro) {
            $this->id_convocatoria = $registro['id_convocatoria'];
            $this->nombre_convocatoria = $registro['nombre_convocatoria'];
            $this->Fecha_creacion = $registro['Fecha_creacion'];
            $this->Fecha_inicio = $registro['Fecha_inicio'];
            $this->Fecha_fin = $registro['Fecha_fin'];
            $this->Estado = $registro['Estado'];
            $this->Vacantes = $registro['Vacantes'];
            $this->Requisitos = $registro['Requisitos'];
        }
    }

    // Obtener todas las convocatorias con un criterio
    function get_all($criterio = "")
    {
        $where = empty($criterio) ? "" : " WHERE $criterio";
        $registros = $this->bd->Lista("SELECT * FROM convocatorias $where");
        return $registros;
    }

    // Eliminar una convocatoria
    function eliminar_convocatoria($id_convocatoria)
    {
        $registros = $this->bd->Consulta("DELETE FROM convocatorias WHERE id_convocatoria=$id_convocatoria");
        return $this->bd->numFila_afectada() > 0;
    }

    // Cambiar el estado de la convocatoria (habilitar o deshabilitar)
    function cambiar_estado($id_convocatoria, $nuevo_estado)
    {
        $registros = $this->bd->Consulta("UPDATE convocatorias SET Estado=$nuevo_estado WHERE id_convocatoria=$id_convocatoria");
        return $this->bd->numFila_afectada() > 0;
    }

    function __destroy()
    {
        $this->bd->Cerrar();
    }
}
?>

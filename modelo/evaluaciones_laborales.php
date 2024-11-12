<?php
if (!class_exists("conexion"))
    include("conexion.php");

class EvaluacionesLaborales
{
    public $id_evaluacion;
    public $id_convocatoria;
    public $id_trabajador;
    public $pregunta;
    public $observaciones;

    private $bd;

    function __construct()
    {
        $this->bd = new Conexion();
    }

    // Método para agregar una evaluación laboral
    function agregar_evaluacion($id_convocatoria, $id_trabajador, $pregunta, $observaciones)
    {
        $registros = $this->bd->Consulta("INSERT INTO evaluaciones_laborales (id_convocatoria, id_trabajador, pregunta, observaciones) 
                                          VALUES ('$id_convocatoria', '$id_trabajador', '$pregunta', '$observaciones')");
        return $this->bd->numFila_afectada($registros) > 0;
    }

    // Método para editar una evaluación laboral
    function editar_evaluacion($id_evaluacion, $pregunta, $observaciones)
    {
        $registros = $this->bd->Consulta("UPDATE evaluaciones_laborales 
                                          SET pregunta = '$pregunta', observaciones = '$observaciones' 
                                          WHERE id_evaluacion = $id_evaluacion");
        return $this->bd->numFila_afectada($registros) > 0;
    }

    // Método para eliminar una evaluación laboral
    function eliminar_evaluacion($id_evaluacion)
    {
        $registros = $this->bd->Consulta("DELETE FROM evaluaciones_laborales WHERE id_evaluacion = $id_evaluacion");
        return $this->bd->numFila_afectada($registros) > 0;
    }

    // Método para obtener una evaluación específica por su ID
    function get_evaluacion($id_evaluacion)
    {
        $registros = $this->bd->Consulta("SELECT * FROM evaluaciones_laborales WHERE id_evaluacion = " . intval($id_evaluacion));
        if ($registro = $this->bd->getFila($registros)) {
            $this->id_evaluacion = $registro['id_evaluacion'];
            $this->id_convocatoria = $registro['id_convocatoria'];
            $this->id_trabajador = $registro['id_trabajador'];
            $this->pregunta = $registro['pregunta'];
            $this->observaciones = $registro['observaciones'];
        } else {
            throw new Exception("Evaluación no encontrada");
        }
    }

    // Método para obtener todas las evaluaciones laborales (puede filtrar usando el criterio opcional)
    function get_all($criterio = "")
    {
        $where = empty($criterio) ? "" : " WHERE $criterio";
        $registros = $this->bd->Lista("SELECT * FROM evaluaciones_laborales $where");
        return $registros;
    }

    function __destroy()
    {
        $this->bd->Cerrar();
    }
}
?>

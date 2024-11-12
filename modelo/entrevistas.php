<?php
if (!class_exists("conexion"))
    include("conexion.php");

class Entrevistas
{
    public $id_entrevista;
    public $id_convocatoria;
    public $id_trabajador;
    public $pregunta;

    private $bd;

    function __construct()
    {
        $this->bd = new Conexion();
    }

    // Método para agregar una pregunta de entrevista
    function agregar_pregunta($id_convocatoria, $id_trabajador, $pregunta, $respuesta = null)
{
    // Inserta la pregunta y la respuesta (si se proporciona)
    $registros = $this->bd->Consulta("INSERT INTO entrevistas (id_convocatoria, id_trabajador, pregunta, respuesta) 
                                      VALUES ('$id_convocatoria', '$id_trabajador', '$pregunta', '$respuesta')");
    return $this->bd->numFila_afectada($registros) > 0;
}


    // Método para editar una pregunta de entrevista
    function editar_pregunta($id_entrevista, $pregunta, $respuesta = null)
{
    $registros = $this->bd->Consulta("UPDATE entrevistas 
                                      SET pregunta='$pregunta', respuesta='$respuesta' 
                                      WHERE id_entrevista=$id_entrevista");
    return $this->bd->numFila_afectada($registros) > 0;
}

    // Método para eliminar una pregunta de entrevista
    function eliminar_pregunta($id_entrevista)
    {
        $registros = $this->bd->Consulta("DELETE FROM entrevistas WHERE id_entrevista=$id_entrevista");
        return $this->bd->numFila_afectada($registros) > 0;
    }

    // Método para obtener todas las preguntas de entrevistas (puede filtrar usando el criterio opcional)
    function get_all($criterio = "")
    {
        $where = empty($criterio) ? "" : " WHERE $criterio";
        $registros = $this->bd->Lista("SELECT * FROM entrevistas $where");
        return $registros;
    }



    // Dentro de la clase Entrevistas
function getPreguntasPorConvocatoriaYTrabajador($id_convocatoria, $id_trabajador)
{
    $consulta = "SELECT pregunta, respuesta FROM entrevistas 
                 WHERE id_convocatoria = $id_convocatoria AND id_trabajador = $id_trabajador";
    return $this->bd->Lista($consulta);
}


    // Método para obtener una pregunta específica por su ID en entrevistas
    function get_pregunta($id_entrevista)
{
    $registros = $this->bd->Consulta("SELECT * FROM entrevistas WHERE id_entrevista = " . intval($id_entrevista));
    if ($registro = $this->bd->getFila($registros)) {
        $this->id_entrevista = $registro['id_entrevista'];
        $this->id_convocatoria = $registro['id_convocatoria'];
        $this->id_trabajador = $registro['id_trabajador'];
        $this->pregunta = $registro['pregunta'];
        $this->respuesta = $registro['respuesta'];  // Asignar la respuesta
    } else {
        throw new Exception("Pregunta de entrevista no encontrada");
    }
}


    function __destroy()
    {
        $this->bd->Cerrar();
    }
}
?>

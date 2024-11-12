<?php
if (!class_exists("conexion"))
    include("conexion.php");

class Respuestas
{
    public $id_respuestas;
    public $id_preguntas;
    public $opcion;
    public $respuesta;
    private $bd;

    function __construct()
    {
        $this->bd = new Conexion();
    }

    // Método para registrar una respuesta abierta
    function registrar_respuesta_abierta($id_pregunta, $respuesta)
    {
        $registros = $this->bd->Consulta("INSERT INTO respuestas (id_preguntas, respuesta) 
                                          VALUES ('$id_pregunta', '$respuesta')");
        return $this->bd->numFila_afectada($registros) > 0;
    }

    // Método para registrar una respuesta cerrada (múltiple o verdadero/falso)
    function registrar_respuesta_cerrada($id_pregunta, $opcion, $respuesta)
    {
        $registros = $this->bd->Consulta("INSERT INTO respuestas (id_preguntas, opcion, respuesta) 
                                          VALUES ('$id_pregunta', '$opcion', '$respuesta')");
        return $this->bd->numFila_afectada($registros) > 0;
    }

    // Método para editar respuesta abierta
    function editar_respuesta_abierta($id_respuesta, $respuesta)
    {
        $registros = $this->bd->Consulta("UPDATE respuestas 
                                          SET respuesta='$respuesta' 
                                          WHERE id_respuestas=$id_respuesta");
        return $this->bd->numFila_afectada($registros) > 0;
    }

    // Método para editar respuesta cerrada
    function editar_respuesta_cerrada($id_respuesta, $opcion, $respuesta)
    {
        $registros = $this->bd->Consulta("UPDATE respuestas 
                                          SET opcion='$opcion', respuesta='$respuesta' 
                                          WHERE id_respuestas=$id_respuesta");
        return $this->bd->numFila_afectada($registros) > 0;
    }

    // Método para eliminar una respuesta
    function eliminar_respuesta($id_respuesta)
    {
        $registros = $this->bd->Consulta("DELETE FROM respuestas WHERE id_respuestas=$id_respuesta");
        return $this->bd->numFila_afectada($registros) > 0;
    }

    function __destroy()
    {
        $this->bd->Cerrar();
    }
    // Método para obtener todas las respuestas de una pregunta específica
function get_respuestas_por_pregunta($id_pregunta)
{
    $registros = $this->bd->Lista("SELECT * FROM respuestas WHERE id_preguntas = " . intval($id_pregunta));
    return $registros;
}




function get_all($filtro = "")
    {
        // Consulta SQL base
        $sql = "SELECT * FROM respuestas";

        // Si hay un filtro, agrégalo a la consulta
        if (!empty($filtro)) {
            $sql .= " WHERE $filtro";
        }

        // Ejecutar la consulta
        $registros = $this->bd->Consulta($sql);

        // Retornar los registros obtenidos
        return $registros;
    }



    
}
?>

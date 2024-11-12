<?php
if (!class_exists("conexion"))
    include("conexion.php");

class Preguntas
{
    public $id_pregunta;
    public $id_convocatoria;
    public $id_trabajador;
    public $pregunta;
    public $tipo_respuesta;

    private $bd;

    function __construct()
    {
        $this->bd = new Conexion();
    }

    // Método para crear una pregunta abierta
    function crear_pregunta($id_convocatoria, $id_trabajador, $pregunta,$tipo_respuesta)
    {
        $registros = $this->bd->Consulta("INSERT INTO preguntas (id_convocatoria, id_trabajador, pregunta, tipo_respuesta) 
                                          VALUES ('$id_convocatoria', '$id_trabajador', '$pregunta', '$tipo_respuesta')");
        return $this->bd->numFila_afectada($registros) > 0;
    }

 
    // Método para eliminar una pregunta
    function eliminar_pregunta($id_pregunta)
    {
        $registros = $this->bd->Consulta("DELETE FROM preguntas WHERE id_preguntas=$id_pregunta");
        return $this->bd->numFila_afectada($registros) > 0;
    }

    // Método para editar solo la pregunta
    function editar_pregunta($id_pregunta, $pregunta)
    {
        $registros = $this->bd->Consulta("UPDATE preguntas 
                                          SET pregunta='$pregunta' 
                                          WHERE id_preguntas=$id_pregunta");
        return $this->bd->numFila_afectada($registros) > 0;
    }

    function __destroy()
    {
        $this->bd->Cerrar();
    }



    function get_all($filtro = "")
    {
        // Consulta SQL base
        $sql = "SELECT * FROM preguntas";

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

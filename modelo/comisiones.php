<?php
if (!class_exists("conexion"))
    include("conexion.php");

class Comision 
{
    public $id_miembro_comision;
    public $id_convocatoria;
    public $id_trabajador;

    private $bd;

    function __construct()
    {
        $this->bd = new Conexion();
    }

    // Método para registrar un nuevo miembro en una comisión
    function registrar_miembro($id_convocatoria, $id_trabajador)
    {
        $registros = $this->bd->Consulta("INSERT INTO comision (id_convocatoria, id_trabajador) 
                                          VALUES ('$id_convocatoria', '$id_trabajador')");
        return $this->bd->numFila_afectada($registros) > 0;
    }


    // Método para eliminar un miembro específico de una comisión
    function eliminar_miembro($id_trabajador, $id_convocatoria) {
        $registros = $this->bd->Consulta("DELETE FROM comision WHERE id_trabajador = $id_trabajador AND id_convocatoria = $id_convocatoria");
        return $this->bd->numFila_afectada($registros) > 0;
    }
    

    // Método para obtener todos los miembros de una comisión específica por `id_convocatoria`
    function get_miembros_por_convocatoria($id_convocatoria)
    {
        $registros = $this->bd->Lista("SELECT * FROM comision WHERE id_convocatoria = $id_convocatoria");
        return $registros;
    }

    // Método para obtener todas las comisiones y sus miembros (opcionalmente filtrado por algún criterio)
    function get_all($criterio = "")
    {
        $where = empty($criterio) ? "" : " WHERE $criterio";
        $registros = $this->bd->Lista("SELECT * FROM comision $where");
        return $registros;
    }

    // Método para obtener una comisión específica por su ID
    function get_comision($id_miembro_comision) {
        $registros = $this->bd->Consulta("SELECT * FROM comision WHERE id_miembro_comision = " . intval($id_miembro_comision));
        if ($registro = $this->bd->getFila($registros)) {
            $this->id_miembro_comision = $registro['id_miembro_comision'];
            $this->id_convocatoria = $registro['id_convocatoria'];
            $this->id_trabajador = $registro['id_trabajador'];
        } else {
            throw new Exception("Comisión no encontrada");
        }
    }

    function __destroy() {
        $this->bd->Cerrar();
    }
}
?>


<?php
if (!class_exists("conexion")) {
    include("conexion.php");
}

class ConvLista 
{
    public $id_conv_lista;
    public $id_convocatoria;
    public $id_postulante;

    private $bd;

    function __construct()
    {
        $this->bd = new Conexion();
    }

    function registrar_asignacion($id_convocatoria, $id_postulante)
    {
        $existe = $this->bd->Consulta("SELECT * FROM conv_lista WHERE id_convocatoria = $id_convocatoria AND id_postulante = $id_postulante");
        
        if ($this->bd->numFila_afectada() > 0) {
            return false; 
        }

        $registros = $this->bd->Consulta("INSERT INTO conv_lista (id_convocatoria, id_postulante) VALUES ('$id_convocatoria', '$id_postulante')");
        return $this->bd->numFila_afectada() > 0;
    }

    function eliminar_asignacion($id_conv_lista)
{
    // Comprobar si el registro existe
    $existe = $this->bd->Consulta("SELECT * FROM conv_lista WHERE id_conv_lista = '$id_conv_lista'");
    if (mysql_num_rows($existe) == 0) {
        echo "El ID especificado no existe.";
        return false;
    }

    $registros = $this->bd->Consulta("DELETE FROM conv_lista WHERE id_conv_lista = '$id_conv_lista'");
    
    if (!$registros) {
        // Mostrar el error
        echo "Error en la consulta: " . mysql_error();
    }
    
    return $this->bd->numFila_afectada() > 0;
}




    // Obtener todas las asignaciones de postulantes a convocatorias
    function get_asignaciones()
    {
        $registros = $this->bd->Lista("SELECT * FROM conv_lista");
        return $registros;
    }

    // Modificar una asignación existente
    function modificar_asignacion($id_conv_lista, $id_convocatoria, $id_postulante)
    {
        $registros = $this->bd->Consulta("UPDATE conv_lista SET id_convocatoria='$id_convocatoria', id_postulante='$id_postulante' WHERE id_conv_lista=$id_conv_lista");
        return $this->bd->numFila_afectada() > 0;
    }

    function __destruct()
    {
        $this->bd->Cerrar();
    }
}
?>


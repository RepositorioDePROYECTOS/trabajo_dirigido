<?php
    include("../../modelo/proveedor.php");
    include("../../modelo/funciones.php");
    $id = security($_GET[id]);
    $proveedor = new proveedor;
    $result = $proveedor->eliminar($id);
    if($result)
    {
        echo "Acci&oacute;n completada con &eacute;xito";
    }
    else
    {
        echo "Ocurri&oacute; un error.";
    }
?>
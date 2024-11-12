<?php 
    include("modelo/expediente.php");
    include("modelo/usuario_elapas.php");
    
    $expediente = new expediente();
    $usuario_elapas = new usuario_elapas();
    $id=$_GET[id];
    $registros = $expediente->get_expediente($id);
    $usuario_elapas->get_usuario_elapas($expediente->id_usuario_elapas);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Vistas</title>
    </head>
    <a href="#" class="cancelar btn btn-green btn-icon">
    Volver <i class="entypo-back"></i>
    </a>
    <CENTER>
    <body>
                <iframe src="archivo/expediente/<?php echo $usuario_elapas->numero_cuenta."/".$expediente->archivo; ?>" width="1000" height="600"></iframe>
                        
 
    </body>
    </CENTER>
</html>

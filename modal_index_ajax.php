<?php   
    session_start();
    $url_actual = $_SERVER["QUERY_STRING"];
    include("modelo/conexion.php");
    include("modelo/funciones.php");

    $bd = new conexion();
    
    $page = security($_GET['pag']);                              
    $mod = security($_GET['mod']);
?>
<!--<script type="text/javascript" src="assets/js/select2/select2.min.js"></script>-->
<script type="text/javascript" src="assets/js/neon-modal-scripts.js"></script>
<?php    
    if (isset($_GET['mod']) && isset($_GET['pag'])) {
        
    if ($mod != '' && $page !='') {
        if (file_exists('vista/'.$mod.'/' . $page . '.php')) {
            include ('vista/'.$mod.'/' . $page . '.php');
        }else {
            include ('vista/paginas/error.php');
        }
    } else {
        include ('vista/paginas/inicio.php');                                    
    }
         
    } else {
        include ('vista/paginas/inicio.php');
    } 
?>
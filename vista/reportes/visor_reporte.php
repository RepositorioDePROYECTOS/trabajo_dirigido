<?php
    session_start();
    include("../../modelo/funciones.php");
	$file = urldecode(security($_GET['f']));
    $_SESSION[id] = $_GET[id];    
    $_SESSION[fecha] = $_GET[fecha];    
    $_SESSION[mes] = $_GET[mes];
    $_SESSION[gestion] = $_GET[gestion];
    $_SESSION[tipo] = $_GET[tipo];
    $_SESSION[fecha_i]= $_GET[fecha_i];
    $_SESSION[fecha_f]= $_GET[fecha_f];
    $_SESSION[estado]= $_GET[estado];

    $_SESSION[codigo_ini] = $_GET[codigo_ini];
    $_SESSION[codigo_fin] = $_GET[codigo_fin];
    $_SESSION[nro_aguinaldo] = $_GET[nro_aguinaldo];
?>
<script src="../../assets/js/jquery.js"></script>
<style type="text/css">
<!--
	*{
	   margin: 0;
       padding: 0;
	}
-->
</style>
<iframe id="pdfFrame" name="pdfFrame" style="border: none; width: 100%; height: 100%; margin: 0; padding: 0; overflow: hidden;" src="../../assets/js/pdfjs/web/viewer.html?file=../../../../<?php echo $file; ?>"></iframe>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#pdfFrame').on('load', function() {
            //window.frames.pdfFrame.print(); 
        });
    });
</script>
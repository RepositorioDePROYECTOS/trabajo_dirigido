<?php
    session_start();

    require_once('../../lib/html2pdf/html2pdf.class.php');
    ob_start();
    
    require_once('../reportes/cabeza.php');
    include("../../modelo/descuentos.php");
    setlocale(LC_TIME,"es_ES");

    $descuentos = new descuentos();
   

    $mes  = $_SESSION[mes];
    $gestion = $_SESSION[gestion];


           
?>
<h1 align="center">PLANILLA DESCUENTOS</h1>
<h3 align="center">Periodo: <?php echo $mes."/".$gestion;?></h3>
<table class="cont" align="center" cellspacing="0">
    <tr class="titulo">
        <td>Item</td>
        <td>Trabajador</td>
<?php
    $registros_des = $bd->Consulta("select * from conf_descuentos where estado='HABILITADO'");
    while($registro_des = $bd->getFila($registros_des))
    {
        echo "<td>$registro_des[nombre_descuento]</td>";
    }
?>
        <td>Total</td>
    </tr>

<?php
    $registros = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on ac.id_trabajador=t.id_trabajador where ac.estado_asignacion='HABILITADO'");
    $sum = 0;
    while($registro = $bd->getFila($registros))
    {
        
        
        echo "<tr><td>$registro[item]</td><td>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</td>";
        $registros_tdes = $bd->Consulta("select * from conf_descuentos where estado='HABILITADO'");
        $suma = 0;
        while($registro_tdes = $bd->getFila($registros_tdes))
        {
            $registros_d = $bd->Consulta("select * from descuentos where id_asignacion_cargo=$registro[id_asignacion_cargo] and nombre_descuento='$registro_tdes[nombre_descuento]' and mes=$mes and gestion=$gestion");
            $registro_d = $bd->getFila($registros_d);
            
            echo "<td>$registro_d[monto]</td>";
            $suma = $suma + $registro_d[monto];
            
        }
        echo "<td>$suma</td></tr>";
        $sum = $sum + $suma;
    }

    echo "<tr><td colspan='6' align='center'>TOTAL</td><td>$sum</td></tr>";
    echo "</table>";
    echo "</page>";
    $content = ob_get_clean();

    try
    {
        $html2pdf = new HTML2PDF('P', array(215.9, 330), 'es', true, 'UTF-8', array(10, 0, 10, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('planilla_descuentos.pdf');
    }

    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

    unset($_SESSION[mes]);
     unset($_SESSION[gestion]);
?>
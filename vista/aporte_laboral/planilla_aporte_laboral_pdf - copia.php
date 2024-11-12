<?php
    session_start();

    require_once('../../lib/html2pdf/html2pdf.class.php');
    ob_start();
    
    require_once('../reportes/cabeza.php');
    include("../../modelo/aporte_laboral.php");
    setlocale(LC_TIME,"es_ES");

    $aporte_laboral = new aporte_laboral();
   

    $mes  = $_SESSION[mes];
    $gestion = $_SESSION[gestion];


           
?>
<h1 align="center">PLANILLA DE APORTES</h1>
<h3 align="center">Periodo: <?php echo $mes."/".$gestion;?></h3>
<table class="cont" align="center" cellspacing="0">
    <tr class="titulo">
        <td>Item</td>
        <td>Trabajador</td>
        <td>Total Ganado</td>
<?php
    $registros_ta = $bd->Consulta("select * from conf_aportes where estado='HABILITADO' and rango_inicial<=13000");
    while($registro_ta = $bd->getFila($registros_ta))
    {
        echo "<td>$registro_ta[tipo_aporte]<br>$registro_ta[porc_aporte]</td>";
    }
?>
        <td>Total aporte</td>
    </tr>

<?php
   //$registros = $bd->Consulta("select * from aporte_laboral al inner join asignacion_cargo ac on al.id_asignacion_cargo=ac.id_asignacion_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador where al.mes=$mes and al.gestion=$gestion order by ac.item asc");
    $registros = $bd->Consulta("select * from asignacion_cargo ac inner join trabajador t on ac.id_trabajador=t.id_trabajador where ac.estado_asignacion='HABILITADO'");
    $sum = 0;
    while($registro = $bd->getFila($registros))
    {
        $registros_tg = $bd->Consulta("select * from total_ganado where id_asignacion_cargo=$registro[id_asignacion_cargo] and mes=$mes and gestion=$gestion");
        $registro_tg = $bd->getFila($registros_tg);

        echo "<tr><td>$registro[item]</td><td>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</td><td>$registro_tg[total_ganado]</td>";
        $registros_tra = $bd->Consulta("select * from conf_aportes where estado='HABILITADO' and rango_inicial<=13000");
        $suma = 0;
        while($registro_tra = $bd->getFila($registros_tra))
        {
            $registros_apo = $bd->Consulta("select * from aporte_laboral where id_asignacion_cargo=$registro[id_asignacion_cargo] and tipo_aporte='$registro_tra[tipo_aporte]' and mes=$mes and gestion=$gestion");
            $registro_apo = $bd->getFila($registros_apo);
            if(empty($registro_apo))
            {
                echo "<td>0</td>";
            }
            else
            {
                echo "<td>$registro_apo[monto_aporte]</td>";
                $suma = $suma + $registro_apo[monto_aporte];
            }
        }
        echo "<td>$suma</td></tr>";
        $sum = $sum + $suma;
    }

    echo "<tr><td colspan='8' align='center'>TOTAL</td><td>$sum</td></tr>";
    echo "</table>";
    echo "</page>";
    $content = ob_get_clean();

    try
    {
        $html2pdf = new HTML2PDF('L', array(215.9, 330), 'es', true, 'UTF-8', array(10, 0, 10, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('planilla_aporte_laboral.pdf');
    }

    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

    unset($_SESSION[mes]);
     unset($_SESSION[gestion]);
?>
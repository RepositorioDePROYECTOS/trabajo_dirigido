<?php
    session_start();

    require_once('../../lib/html2pdf/html2pdf.class.php');
    ob_start();
    
    require_once('../reportes/cabeza.php');
    include("../../modelo/asistencia_refrigerio.php");
    setlocale(LC_TIME,"es_ES");

    $asistencia_refrigerio = new asistencia_refrigerio();
   

    $mes  = $_SESSION[mes];
    $gestion = $_SESSION[gestion];

           
?>
<h1 align="center">PLANILLA DE ASISTENCIA REFRIGERIO</h1>
<h3 align="center">Periodo: <?php echo $mes."/".$gestion;?></h3>
<table class="cont" align="center" cellspacing="0">
    <tr class="titulo">
        <td>Item</td>
        <td>Cargo</td>
        <td>Trabajador</td>
        <td>Dias laborables</td>
        <td>Dias trabajados</td>
    </tr>

<?php
    $registros_c = $bd->Consulta("select seccion from cargo group by seccion order by cast(item as unsigned) asc");
    $sum_d = 0;
    while($registro_c = $bd->getFila($registros_c))
    {
        echo "<tr><td colspan='8' align='center'>SECCION $registro_c[0]</td></tr>";

        $registros_ac = $bd->Consulta("select * from cargo c left join asignacion_cargo ac on c.id_cargo=ac.id_cargo where c.seccion='$registro_c[seccion]' order by cast(c.item as unsigned) asc"); 
        $sum_d_s = 0;
        while($registro_ac = $bd->getFila($registros_ac))
        {
            if($registro_ac[estado_asignacion] == 'HABILITADO')
            {
                $registros = $bd->Consulta("select * from cargo c right join asignacion_cargo ac on c.id_cargo=ac.id_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador inner join asistencia_refrigerio a on a.id_asignacion_cargo=ac.id_asignacion_cargo where a.mes=$mes and a.gestion=$gestion and c.seccion='$registro_c[0]' and c.item=$registro_ac[item] order by cast(ac.item as unsigned) asc");
                
                $registro = $bd->getFila($registros);
                    
                echo "<tr><td>$registro_ac[item]</td><td>$registro_ac[descripcion]</td><td>$registro[apellido_paterno] $registro[apellido_materno] $registro[nombres]</td><td>$registro[dias_laborables]</td><td>$registro[dias_asistencia]</td></tr>";
                $sum_d_s = $sum_d_s + $registro[dias_asistencia];
            }
            else
            {
                echo "<tr><td>$registro_ac[1]</td><td colspan='4' align='center'>ACEFALIA</td></tr>";
            }
                 
            
        }
        echo "<tr><td colspan='4' align='center'>SECCION $registro_c[0]</td><td align='center'>$sum_d_s</td></tr>";
        
        $sum_d = $sum_d + $sum_d_s;
        
    }
    echo "<tr><td colspan='4' align='center'>TOTAL DIAS ASISTENCIA DEL MES</td><td align='center'>$sum_d</td></tr>";
    echo "</table>";
    echo "</page>";
    $content = ob_get_clean();

    try
    {
        $html2pdf = new HTML2PDF('P', array(215.9, 330), 'es', true, 'UTF-8', array(10, 0, 10, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('planilla_asistencia_refrigerio.pdf');
    }

    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

    unset($_SESSION[mes]);
     unset($_SESSION[gestion]);
?>
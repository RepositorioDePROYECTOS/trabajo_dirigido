<?php
    session_start();

    require_once('../../lib/html2pdf/html2pdf.class.php');
    ob_start();
    
    require_once('../reportes/cabeza.php');
    include("../../modelo/bono_antiguedad.php");
    setlocale(LC_TIME,"es_ES");

    $bono_antiguedad = new bono_antiguedad();
   

    $mes  = $_SESSION[mes];
    $gestion = $_SESSION[gestion];

           
?>
<h1 align="center">PLANILLA DE BONO DE ANTIGUEDAD</h1>
<h3 align="center">Periodo: <?php echo $mes."/".$gestion;?></h3>
<table class="cont" align="center" cellspacing="0">
    <tr class="titulo">
        <td>Item</td>
        <td>Trabajador</td>
        <td>Otras Inst.</td>
        <td>Fecha ingreso</td>
        <td>Fecha calculo</td>
        <td>Antiguedad</td>
        <td>Porcentaje</td>
        <td>Total Bono</td>
    </tr>

<?php
    $registros_c = $bd->Consulta("select seccion from cargo group by seccion order by cast(item as unsigned) asc");
    $sum = 0;
    while($registro_c = $bd->getFila($registros_c))
    {
        echo "<tr><td colspan='8' align='center'>SECCION $registro_c[0]</td></tr>";
        $registros_ac = $bd->Consulta("select * from cargo c left join asignacion_cargo ac on c.id_cargo=ac.id_cargo where c.seccion='$registro_c[seccion]' order by cast(c.item as unsigned) asc"); 
        
        $sum_s = 0;
        while($registro_ac = $bd->getFila($registros_ac))
        {
            if($registro_ac[estado_asignacion] == 'HABILITADO' && $registro_ac[estado_cargo] == 'OCUPADO')
            {
                $registros = $bd->Consulta("select * from cargo c right join asignacion_cargo ac on c.id_cargo=ac.id_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador inner join bono_antiguedad ba on ba.id_asignacion_cargo=ac.id_asignacion_cargo where ba.mes=$mes and ba.gestion=$gestion and c.seccion='$registro_c[0]' and c.item=$registro_ac[item] order by cast(ac.item as unsigned) asc");
                
                $registro = $bd->getFila($registros);
                    
                echo "<tr><td>$registro_ac[item]</td><td>".utf8_encode($registro[apellido_paterno])." ".utf8_encode($registro[apellido_materno])." ".utf8_encode($registro[nombres])."</td><td>$registro[anios_arrastre] A&ntilde;os<br>$registro[meses_arrastre] Meses<br>$registro[dias_arrastre] D&iacute;as</td><td>$registro[fecha_ingreso]</td><td>$registro[fecha_calculo]</td><td>$registro[anios] A&ntilde;os<br>$registro[meses] Meses<br>$registro[dias] D&iacute;as</td><td>$registro[porcentaje] %</td><td>$registro[monto]</td></tr>";
                $sum_s = $sum_s + $registro[monto];
            }
            else
            {
                if($registro_ac[estado_cargo] != 'OCUPADO')
                echo "<tr><td>$registro_ac[1]</td><td colspan='7' align='center'>ACEFALIA</td></tr>";
            }
                 
            
        }
         echo "<tr><td colspan='7' align='center'>TOTAL SECCION $registro_c[0]</td><td>$sum_s</td></tr>";
            $sum = $sum + $sum_s;
        
    }
    echo "<tr><td colspan='7' align='center'>TOTAL BONOS DE ANTIGUEDAD DEL MES</td><td>$sum</td></tr>";
    echo "</table>";
    echo "</page>";
    $content = ob_get_clean();

    try
    {
        $html2pdf = new HTML2PDF('P', array(215.9, 330), 'es', true, 'UTF-8', array(10, 0, 10, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('planilla_bono_antiguedad.pdf');
    }

    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

    unset($_SESSION[mes]);
     unset($_SESSION[gestion]);
?>
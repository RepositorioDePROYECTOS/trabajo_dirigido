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
    $n = 0;
    while($registro_des = $bd->getFila($registros_des))
    {
        echo "<td>$registro_des[nombre_descuento]</td>";
        $n = $n + 1;
    }
    $n = $n + 2;
?>
        <td>Total</td>
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
            if($registro_ac[estado_asignacion] == 'HABILITADO')
            {
                $registros = $bd->Consulta("select * from cargo c right join asignacion_cargo ac on c.id_cargo=ac.id_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador inner join descuentos d on d.id_asignacion_cargo=ac.id_asignacion_cargo where d.mes=$mes and d.gestion=$gestion and c.seccion='$registro_c[0]' and c.item=$registro_ac[item] order by cast(ac.item as unsigned) asc");
                $registro = $bd->getFila($registros);
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
                $sum_s = $sum_s + $suma;
            }
            else
            {
                echo "<tr><td>$registro_ac[1]</td><td colspan='$n' align='center'>ACEFALIA</td></tr>";
            }
        }
        echo "<tr><td colspan='$n' align='center'>TOTAL SECCION $registro_c[0]</td><td>$sum_s</td></tr>";
        $sum = $sum + $sum_s;

    }    
    echo "<tr><td colspan='$n' align='center'>TOTAL DESCUENTOS DEL MES</td><td>$sum</td></tr>";
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
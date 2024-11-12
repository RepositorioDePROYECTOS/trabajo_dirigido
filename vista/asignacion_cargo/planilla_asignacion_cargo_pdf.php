<?php
    session_start();

    require_once('../../lib/html2pdf/html2pdf.class.php');
    ob_start();
    
    require_once('../reportes/cabeza.php');
    include("../../modelo/asignacion_cargo.php");
    setlocale(LC_TIME,"es_ES");

    $asignacion_cargo = new asignacion_cargo();
   

   
           
?>
<h1 align="center">PLANILLA ASIGNACION DE CARGOS</h1>

<table class="cont" align="center" cellspacing="0">
    <tr class="titulo">
        <td>Item</td>
        <td>Trabajador</td>
        <td>Cargo</td>
        <td>Fecha de Asignacion</td>
        <td>Aportante AFP</td>
        <td>Sindicalizado</td>
        <td>Socio F.E.</td>
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
                $registros = $bd->Consulta("select * from cargo c right join asignacion_cargo ac on c.id_cargo=ac.id_cargo inner join trabajador t on t.id_trabajador=ac.id_trabajador where  c.seccion='$registro_c[0]' and c.item=$registro_ac[item] order by cast(ac.item as unsigned) asc");
                
                $registro = $bd->getFila($registros);
                    
                echo "<tr><td>$registro_ac[item]</td><td>".utf8_encode($registro[apellido_paterno])." ".utf8_encode($registro[apellido_materno])." ".utf8_encode($registro[nombres])."</td><td>$registro[cargo]</td><td>$registro[fecha_ingreso]</td>";
                if($registro[aportante_afp] == 1)
                {
                    echo "<td>SI</td>";               
                }
                else
                {
                    echo "<td>NO</td>";
                }
                if($registro[sindicato] == 1)
                {
                    echo "<td>SI</td>";               
                }
                else
                {
                    echo "<td>NO</td>";
                }
                if($registro[socio_fe] == 1)
                {
                    echo "<td>SI</td></tr>";               
                }
                else
                {
                    echo "<td>NO</td></tr>";
                }
            }
            else
            {
                echo "<tr><td>$registro_ac[1]</td><td colspan='6' align='center'>ACEFALIA</td></tr>";
            }    
        }
         echo "<tr><td colspan='7' align='center'>TOTAL SECCION $registro_c[0]</td></tr>";

        
    }
    echo "</table>";
    echo "</page>";
    $content = ob_get_clean();

    try
    {
        $html2pdf = new HTML2PDF('P', array(215.9, 330), 'es', true, 'UTF-8', array(10, 0, 10, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('planilla_puestos.pdf');
    }

    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

    unset($_SESSION[mes]);
     unset($_SESSION[gestion]);
?>
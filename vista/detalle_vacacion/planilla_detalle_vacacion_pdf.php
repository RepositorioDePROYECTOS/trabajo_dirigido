<?php
    session_start();

    require_once('../../lib/html2pdf/html2pdf.class.php');
    ob_start();
    
    require_once('../reportes/cabeza.php');
    include("../../modelo/detalle_vacacion.php");
    setlocale(LC_TIME,"es_ES");

    $detalle_vacacion = new detalle_vacacion();
    $id_vacacion  = $_SESSION[id_vacacion];

    $datos_tr = $bd->Consulta("select * from vacacion v inner join trabajador t on v.id_trabajador=t.id_trabajador inner join asignacion_cargo ac on t.id_trabajador=ac.id_trabajador where v.id_vacacion=$id_vacacion and ac.estado_asignacion='HABILITADO'");
    $dato_tr = $bd->getFila($datos_tr);

    $registros = $bd->Consulta("select * from vacacion v inner join detalle_vacacion dv on v.id_vacacion=dv.id_vacacion inner join trabajador t on t.id_trabajador=v.id_trabajador where v.id_vacacion=$id_vacacion order by dv.gestion_inicio desc");
           
?>
<h1 align="center">PLANILLA DE VACACIONES</h1>
<h3 align="center">Nombre del trabajador: <?php echo $dato_tr[nombres]." ".$dato_tr[apellido_paterno]." ".$dato_tr[apellido_materno];?></h3>
<h3 align="center">Cargo actual: <?php echo $dato_tr[cargo];?></h3>
<table class="cont" align="center" cellspacing="0">
    <tr class="titulo">
        <td>Nro.</td>
        <td>Gestion inicio</td>
        <td>Gestion fin</td>
        <td>Fecha calculo</td>
        <td>Cantidad dias</td>
        <td>Dias utilizados</td>
    </tr>

<?php
        $n = 0;
        $sum_cd = 0;
        $sum_du = 0;
        while($registro = $bd->getFila($registros))
        {
               $n ++;                 
                echo "<tr align='right'><td>$n</td><td>$registro[gestion_inicio]</td><td>$registro[gestion_fin]</td><td>$registro[fecha_calculo]</td><td>$registro[cantidad_dias]</td><td>$registro[dias_utilizados]</td></tr>";
                $sum_cd = $sum_cd + $registro[cantidad_dias];
                $sum_du = $sum_du + $registro[dias_utilizados];
        }
    echo "<tr><td></td><td colspan='3' align='center'>TOTALES</td><td align='center'>".number_format($sum_cd,2)."</td><td align='center'>".number_format($sum_du,2)."</td></tr>";
    $saldo = $sum_cd - $sum_du;   
    echo "<tr><td></td><td colspan='4' align='center'>SALDO DE VACACIONES</td><td align='center'>".number_format($saldo,2)."</td></tr>";
    echo "</table>";
    echo "</page>";
    $content = ob_get_clean();

    try
    {
        $html2pdf = new HTML2PDF('P', array(215.9, 330), 'es', true, 'UTF-8', array(10, 0, 10, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('planilla_vacaciones_trabajador.pdf');
    }

    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

    unset($_SESSION[id_vacacion]);
?>
<?php
    session_start();

    require_once('../../lib/html2pdf/html2pdf.class.php');
    ob_start();
    require_once('../reportes/cabeza_papeleta.php');
    include("../../modelo/salida.php");
    setlocale(LC_TIME,"es_ES");
    $id_salida=$_SESSION[id];
    $salida1 = new salida();
    setlocale(LC_TIME,"es_ES");
    ini_set('date.timezone','America/La_Paz');
    // $registro_chofer = $bd->Consulta("select * from salida s inner join trabajador t on t.id_trabajador=s.id_chofer where t.cargo='CHOFER' and s.id_salida=$id_salida");
    // $registro_ch = $bd->getFila($registro_chofer);
    $registro_salida = $bd->Consulta("SELECT nombre_apellidos,
                                    hora_retorno,
                                    hora_exac_llegada,
                                    hora_salida,
                                    tiempo_solicitado,
                                    direccion_salida,
                                    motivo,
                                    observaciones,
                                    fecha,
                                    placa,
                                    marca,
                                    modelo,
                                    nombre as tipo_salida,
                                    cargo
                                    FROM salida s
                                    INNER JOIN vehiculo v ON v.id_vehiculo = s.id_vehiculo
                                    INNER JOIN usuario u ON u.id_usuario = s.id_usuario
                                    INNER JOIN tipo_salida ts ON ts.id_tipo_salida = s.id_tipo_salida
                                    INNER JOIN trabajador t ON u.id_trabajador = t.id_trabajador
                                    INNER JOIN asignacion_cargo ac ON ac.id_trabajador = t.id_trabajador
                                    WHERE s.id_salida =$id_salida");
    $registro = $bd->getFila($registro_salida);
?>
<!-- nombre_apellidos,hora_retorno,hora_exac_llegada,hora_salida,tiempo_solicitado,direccion_salida,motivo,observaciones,fecha,placa,marca,modelo,nombre as tipo_salida from salida s inner join vehiculo v on v.id_vehiculo=s.id_vehiculo -->
<div></div>
<h1 align="center">PAPELETA DE SALIDA</h1>
<table class="papeleta">
        <tr>
            <td class="papeleta" colspan="4">Nombres y Apellidos <u><strong><?php echo $registro[0]; ?></strong></u></td>
        </tr>
        <tr>
            <td class="papeleta">Cargo:&nbsp;&nbsp;&nbsp;<u><strong><?php echo $registro[13]; ?></strong></u></td>
            <td class="papeleta" colspan="2">Ger. de area:&nbsp;&nbsp;&nbsp;<u><strong><?php echo ''; ?></strong></u></td>
            <td class="papeleta">Jefatura:&nbsp;&nbsp;&nbsp;<u><strong><?php echo ''; ?></strong></u></td>
        </tr>
        <tr>
            <td class="papeleta">Salida</td>
            <td class="papeleta">Oficial( <?php echo ('OFICIAL' == $registro[12]) ? '<u><strong>X</strong></u>' : ' '; ?> )</td>
            <td class="papeleta">Medica( <?php echo ('MEDICA' == $registro[12]) ? '<u><strong>X</strong></u>' : ' ';  ?>  )</td>
            <td class="papeleta">Particular( <?php echo ('PARTICULAR' == $registro[12]) ? '<u><strong>X</strong></u>' : ' '; ?> )
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Almuerzo( <?php echo ('ALMUERZO' == $registro[12]) ? '<u><strong>X</strong></u>' : ' '; ?> )
            </td>
        </tr>
        <tr>
            <td class="papeleta" colspan="2">Nombre del Chofer:
            <u><strong><?php
            if($registro[27]=="PARTICULAR"){
            echo "NINGUNO</strong></u>";
            
            }else{echo "</strong></u>";} ?>
            
            </td>
            <td class="papeleta" colspan="2">Placa: <u><strong><?php echo $registro[9]; ?></strong></u></td>
        </tr>
        <tr>
            <td class="papeleta" colspan="2">Tiempo Solicitado: <u><strong><?php echo $registro[4]; ?> horas</strong></u></td>
            <td class="papeleta">Hora de Salida: <u><strong><?php echo $registro[3]; ?></strong></u></td>
            <td class="papeleta">Hora de Retorno <u><strong><?php echo $registro[1]; ?></strong></u></td>
        </tr>
        <tr>
            <td class="papeleta" colspan="4">Direccion de la salida: <u><strong><?php echo $registro[5]; ?></strong></u></td>
        </tr>
        <tr>
            <td class="papeleta" colspan="4">Motivo de la Salida: <u><strong><?php echo $registro[6]; ?></strong></u></td>
        </tr>
        <tr>
            <td class="papeleta2" colspan="4">Observaciones: <u><strong><?php echo $registro[7]; ?></strong></u></td>
        </tr>
        <tr>
            <td class="papeleta" colspan="4"><strong>EL PRESENTE FORMULARIO <u><strong>NO SE TOMARA EN CUENTA</strong></u> SI NO SE CUENTA CON FIRMAS AUTORIZADAS DE SU INMEDIATO SUPERIOR</strong></td>
        </tr>
        <tr >
            <td class="papeleta" class="fecha" colspan="3"></td>
            <td >Sucre, <i><?php echo getFechaText($registro[8]) ?></i> </td>
        </tr>
        
</table>

<table>
    <tr class="firma" >
        <td class="firma1">________________________ <br><br>Firma Interesado</td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td ><br>_____________________________ <br><br>Autorizado por Gerente y/o jefatura<br> de Area</td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td><br>_____________________<br><br>&nbsp;&nbsp;Firma Jefe Administrativo y <br> de Personal</td>
    </tr>
</table>

<?php 
    $content = ob_get_clean();
    try
    {
        $html2pdf = new HTML2PDF('P', 'letter', 'es', true, 'UTF-8', array(10, 0, 10, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('Papeleta_de_salida.pdf');
    }

    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

    // unset($_SESSION[mes]);
    //  unset($_SESSION[gestion]);
?>
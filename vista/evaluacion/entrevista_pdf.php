<?php
session_start();

require_once('../../lib/html2pdf/html2pdf.class.php');
ob_start();

require_once('../reportes/cabeza.php');
include("../../modelo/entrevistas.php");

$entrevistasModel = new Entrevistas();


$id_convocatoria = $_GET['id_convocatoria'];
$id_trabajador = $_GET['id_trabajador'];

// Obtener las preguntas y respuestas de la entrevista
$preguntas_respuestas = $entrevistasModel->getPreguntasPorConvocatoriaYTrabajador($id_convocatoria, $id_trabajador);

?>

<h1 align="center">ENTREVISTA DE SELECCIÓN</h1>
<h3 align="center">Convocatoria: <?php echo $id_convocatoria; ?> | Trabajador: <?php echo $id_trabajador; ?></h3>

<table class="cont" align="center" cellspacing="0" border="1" cellpadding="5">
    <tr class="titulo">
        <td><strong>Pregunta</strong></td>
        <td><strong>Respuesta</strong></td>
    </tr>

<?php
// Mostrar las preguntas y respuestas
foreach ($preguntas_respuestas as $registro) {
    echo "<tr><td>{$registro['pregunta']}</td><td>{$registro['respuesta']}</td></tr>";
}
?>

</table>
</page>

<?php
$content = ob_get_clean();

try {
    $html2pdf = new HTML2PDF('P', array(215.9, 330), 'es', true, 'UTF-8', array(10, 0, 10, 0));
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('entrevista.pdf');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>

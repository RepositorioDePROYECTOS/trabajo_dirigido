<?php
    $id_convocatoria = $_GET['id_convocatoria'];
    $id_trabajador = $_GET['id_trabajador'];
    echo $id_convocatoria . " " . $id_trabajador;
?>

<h2>Tipos de Evaluación</h2>

<!-- Botón para Examen Escrito -->
<a href="?mod=evaluacion&pag=examen_escrito&id_convocatoria=<?php echo $id_convocatoria; ?>&id_trabajador=<?php echo $id_trabajador; ?>" class="btn btn-primary btn-icon">
    Crear  Examen Escrito <i class="entypo-doc-text"></i>
</a>

<!-- Botón para Entrevista -->
<a href="?mod=evaluacion&pag=entrevista&id_convocatoria=<?php echo $id_convocatoria; ?>&id_trabajador=<?php echo $id_trabajador; ?>" class="btn btn-success btn-icon">
    Crear Entrevista <i class="entypo-chat"></i>
</a>

<!-- Botón para Evaluación Laboral con texto en negro -->
<a href="?mod=evaluacion&pag=evaluacion_laboral&id_convocatoria=<?php echo $id_convocatoria; ?>&id_trabajador=<?php echo $id_trabajador; ?>" class="btn btn-warning btn-icon" >
    <p style="color: black;">Crear Evaluación Laboral </p><i class="entypo-briefcase"></i>
</a>
<p></p>
<!-- Botón de Regreso -->
<a href="?mod=evaluacion&pag=lista" class="btn btn-danger btn-icon" style="float: right;">
    Atrás <i class="entypo-back"></i>
</a>

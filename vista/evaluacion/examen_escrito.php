<?php
include("modelo/preguntas.php");
include("modelo/respuestas.php");

$bd = new Conexion();
$preguntaModel = new Preguntas();
$respuestaModel = new Respuestas();

// Obtener ID de convocatoria y trabajador desde la URL
$id_convocatoria = $_GET['id_convocatoria'];
$id_trabajador = $_GET['id_trabajador'];

// Insertar pregunta
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registrar_pregunta'])) {
    $pregunta = $_POST['pregunta'];
    $tipo_respuesta = $_POST['tipo_respuesta'];
    $preguntaModel->crear_pregunta($id_convocatoria, $id_trabajador, $pregunta, $tipo_respuesta);
    echo "Pregunta registrada correctamente!";
}

// Insertar respuesta
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registrar_respuesta'])) {
    $id_pregunta = $_POST['id_pregunta'];
    $tipo_respuesta = $preguntaModel->get_respuestas_por_pregunta($id_pregunta);

    if ($tipo_respuesta == 'abierta') {
        $respuesta = $_POST['respuesta'];
        $respuestaModel->registrar_respuesta_abierta($id_pregunta, $respuesta);
    } elseif ($tipo_respuesta == 'multiple') {
        // Para respuestas múltiples, verificamos cada opción
        $opciones = $_POST['opcion'];
        foreach ($opciones as $key => $opcion) {
            $es_correcta = $_POST['respuesta']["opcion$key"]; // 1 para correcta, 0 para incorrecta
            $respuestaModel->registrar_respuesta_cerrada($id_pregunta, $key, $opcion, $es_correcta);
        }
    } elseif ($tipo_respuesta == 'verdadero/falso') {
        $respuesta = $_POST['respuesta']['verdadero'];
        $respuestaModel->registrar_respuesta_verdadero_falso($id_pregunta, $respuesta);
    }
    echo "Respuesta registrada correctamente!";
}

// Obtener preguntas pendientes de respuestas
$preguntas = $preguntaModel->get_all("id_convocatoria = $id_convocatoria AND id_trabajador = $id_trabajador AND id_pregunta NOT IN (SELECT id_preguntas FROM respuestas)");

// Verifica si las preguntas se obtuvieron correctamente
if (!is_array($preguntas) || empty($preguntas)) {
    echo "No hay preguntas pendientes de respuesta.";
}

// Obtener todas las respuestas de las preguntas
$respuestas = $respuestaModel->get_all("id_convocatoria = $id_convocatoria AND id_trabajador = $id_trabajador");

// Verifica si las respuestas se obtuvieron correctamente
if (!is_array($respuestas) || empty($respuestas)) {
    echo "No hay respuestas registradas.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Examen Escrito</title>
</head>
<body>
    <h1>Examen Escrito</h1>
    
    <!-- Formulario para registrar preguntas -->
    <h2>Registrar Pregunta</h2>
    <form method="POST">
        <div>
            <label for="pregunta">Pregunta:</label>
            <input type="text" name="pregunta" required>
        </div>
        <div>
            <label for="tipo_respuesta">Tipo de Respuesta:</label>
            <select name="tipo_respuesta">
                <option value="abierta">Abierta</option>
                <option value="multiple">Múltiple (6 opciones)</option>
                <option value="verdadero/falso">Verdadero/Falso</option>
            </select>
        </div>
        <div>
            <button type="submit" name="registrar_pregunta">Registrar Pregunta</button>
        </div>
    </form>

    <!-- Formulario para registrar respuestas -->
    <h2>Registrar Respuestas</h2>
    <form method="POST">
        <?php
        if (is_array($preguntas) && !empty($preguntas)) {
            foreach ($preguntas as $pregunta) {
                echo "<h3>{$pregunta['pregunta']}</h3>";

                if ($pregunta['tipo_respuesta'] == 'abierta') {
                    echo "<textarea name='respuesta' required></textarea><br>";
                    echo "<input type='hidden' name='id_pregunta' value='{$pregunta['id_pregunta']}'>";
                } else if ($pregunta['tipo_respuesta'] == 'multiple') {
                    for ($i = 1; $i <= 6; $i++) {
                        echo "<label>Opción $i: <input type='text' name='opcion[$i]'></label><br>";
                        echo "<label>¿Es correcta? <input type='radio' name='respuesta[opcion$i]' value='1'> Sí</label>";
                        echo "<label><input type='radio' name='respuesta[opcion$i]' value='0'> No</label><br>";
                    }
                    echo "<input type='hidden' name='id_pregunta' value='{$pregunta['id_pregunta']}'>";
                } else if ($pregunta['tipo_respuesta'] == 'verdadero/falso') {
                    echo "<label><input type='radio' name='respuesta[verdadero]' value='1'> Verdadero</label><br>";
                    echo "<label><input type='radio' name='respuesta[verdadero]' value='0'> Falso</label><br>";
                    echo "<input type='hidden' name='id_pregunta' value='{$pregunta['id_pregunta']}'>";
                }
                echo "<hr>";
            }
        }
        ?>
        <button type="submit" name="registrar_respuesta">Registrar Respuestas</button>
    </form>

    <!-- Mostrar preguntas y respuestas registradas -->
    <h2>Preguntas y Respuestas Registradas</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Pregunta</th>
                <th>Respuestas</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (is_array($respuestas) && !empty($respuestas)) {
                foreach ($respuestas as $respuesta) {
                    echo "<tr>";
                    echo "<td>{$respuesta['pregunta']}</td>";
                    echo "<td>";

                    if ($respuesta['tipo_respuesta'] == 'abierta') {
                        echo "<textarea disabled>{$respuesta['respuesta']}</textarea>";
                    } else if ($respuesta['tipo_respuesta'] == 'multiple') {
                        for ($i = 1; $i <= 6; $i++) {
                            if (isset($respuesta['opcion'][$i])) {
                                $opcion = $respuesta['opcion'][$i];
                                echo "Opción $i: " . ($opcion == 1 ? "Correcta" : "Incorrecta") . "<br>";
                            }
                        }
                    } else if ($respuesta['tipo_respuesta'] == 'verdadero/falso') {
                        echo "<span style='color:blue;'>Respuesta: " . ($respuesta['respuesta'] == 1 ? "Verdadero" : "Falso") . "</span><br>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
</body>
</html>

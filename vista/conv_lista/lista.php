<?php
include("modelo/conv_lista.php");

$convocatoria = new Convocatoria();
$convocatorias = $convocatoria->get_convocatorias();
?>

<h2>Lista de Convocatorias
<?php if ($_SESSION['nivel'] == "rrhh") { ?>
        <a href="?mod=conv_asignar&pag=lista_asignar" class="btn btn-green btn-icon" style="float: right;">
            asignar listas
            <i class="entypo-plus"></i>
        </a>
    <?php } ?>
</h2>
<br>
<?php if (!empty($convocatorias)) { ?>
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th>Nombre Convocatoria</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Vacantes</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($convocatorias as $conv) {
                echo "<tr>";
                echo "<td class='convocatoria-nombre' id='convocatoria-" . $conv['id_convocatoria'] . "'>" . utf8_encode($conv['nombre_convocatoria']) . "</td>";
                echo "<td>" . utf8_encode($conv['Fecha_inicio']) . "</td>";
                echo "<td>" . utf8_encode($conv['Fecha_fin']) . "</td>";
                echo "<td>" . utf8_encode($conv['Vacantes']) . "</td>";
                echo "<td>
                    <button class='btn btn-blue' onclick='mostrarPostulantes(" . $conv['id_convocatoria'] . ", this)'>Ver Postulantes</button>
                </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
<?php } else { ?>
    <p>No hay convocatorias habilitadas.</p>
<?php } ?>

<!-- Contenedor del Pop-up -->
<div id="postulantes-popup" class="popup" style="display:none;">
    <div class="popup-content">
        <span class="close" onclick="cerrarPopup()">&times;</span>
        <h3>Postulantes</h3>
        <table class="table table-bordered" id="table-postulantes">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>CI </th>
                    <th>Gmail </th>
                    <th>Telefono </th>
                </tr>
            </thead>
            <tbody id="postulantes-list">
            </tbody>
        </table>
        <button class='btn btn-red' onclick="cerrarPopup()">Cerrar</button>
    </div>
</div>
<style>
.popup {
    display: none; 
    position: fixed; 
    z-index: 1000; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    background-color: rgba(0, 0, 0, 0.5); 
}

.popup-content {
    background-color: white;
    margin: 15% auto; 
    padding: 20px;
    border: 1px solid #888;
    width: 80%; 
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>
<script>
function mostrarPostulantes(idConvocatoria, btn) {
    const postulantesPopup = document.getElementById('postulantes-popup');
    const postulantesList = document.getElementById('postulantes-list');

    const nombresConvocatorias = document.querySelectorAll('.convocatoria-nombre');
    nombresConvocatorias.forEach(function(nombre) {
        nombre.style.color = ''; 
    });

    const convocatoriaNombre = document.getElementById('convocatoria-' + idConvocatoria);
    convocatoriaNombre.style.color = 'blue';

    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'control/obtener_pos/obtener_postulantes.php?id_convocatoria=' + idConvocatoria, true);
    xhr.onload = function() {
        if (this.status == 200) {
            const postulantes = JSON.parse(this.responseText);
            postulantesList.innerHTML = '';

            if (postulantes.length > 0) {
                postulantes.forEach(function(postulante) {
                    const row = `<tr>
                        <td>${postulante.nombre}</td>
                        <td>${postulante.apellido_paterno}</td>
                        <td>${postulante.apellido_materno}</td>
                        <td>${postulante.CI}</td>
                        <td>${postulante.Gmail}</td>
                        <td>${postulante.Telefono}</td>
                    </tr>`;
                    postulantesList.insertAdjacentHTML('beforeend', row);
                });
            } else {
                postulantesList.innerHTML = '<tr><td colspan="6">No hay postulantes registrados.</td></tr>';
            }

            postulantesPopup.style.display = 'block';
        }
    };
    xhr.send();
}
function cerrarPopup() {
    const postulantesPopup = document.getElementById('postulantes-popup');
    postulantesPopup.style.display = 'none';

    // Restablecer los colores de los nombres de las convocatorias
    const nombresConvocatorias = document.querySelectorAll('.convocatoria-nombre');
    nombresConvocatorias.forEach(function(nombre) {
        nombre.style.color = '';
    });
}

</script>
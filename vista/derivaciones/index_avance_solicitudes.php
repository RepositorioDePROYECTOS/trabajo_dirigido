<?php
include("modelo/derivaciones.php");
// include("../modelo/funciones.php");
setlocale(LC_TIME, "es_ES");
ini_set('date.timezone', 'America/La_Paz');
$fecha = date('Y-m-d H:i:s');
$entidad = new derivaciones();
$registros = $bd->Consulta("SELECT * from derivaciones ORDER BY id_derivacion DESC");
$hoy = date('Y-m-d');
?>
<h2>Derivaciones
  <!-- <a href="?mod=entidad&pag=form_entidad" class="btn btn-green btn-icon" style="float: right;">
    	Crear Entidad <i class="entypo-plus"></i>
    </a> -->
</h2>
<br />
<div class="table-responsive">
  <table class="table table-bordered datatable" id="table-1">
    <thead>
      <tr>
        <th>No</th>
        <th>Solicitud</th>
        <th>Fecha de <br>Solicitud</th>
        <th>Estado</th>
        <th width="160">Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $n = 0;
      while ($registro = $bd->getFila($registros)) {
        $estilo = '';
        $sin_obligacion = '';
        $n++;
        $origen = $registro[fecha_derivado];
        $diff = diferenciafechas($origen, $hoy);
        if ($registro[estado_derivacion] == 'solicitado') {
          if ($diff[2] > 1) {
            $estilo = '#FEB7B7'; // ALERTA DE RETRASO
          } else {
            $estilo = '#D0FCA4'; // Alerta de Notificacion
          }
        } elseif ($registro[estado_derivacion] == 'solicitar') {
          $estilo = "#F9F9A8"; // Solicitud Devuelta
        } elseif ($registro[estado_derivacion] == 'verificado') {
          $estilo = 'white'; // Solicitud Atendida
        }

        // $estilo != '' ? $estilo : $sin_obligacion;

      ?>
        <tr align="center" style="background-color: <?php echo $estilo; ?>;">
          <td>
            <?php echo $n ?>
          </td>
          <td>
            <button type="button" class="btn btn-info btn-lg btn-xs" data-toggle="modal" data-target="#myModal" data_id="<?php echo $registro[id_solicitud] . '-' . $registro[tipo_solicitud] ?>" id="vista" onclick="capturarDataId()">S<?php echo $registro[nro_solicitud] ?>-<?php echo strtoupper($registro[tipo_solicitud]) ?></button>
          </td>
          <td>
            <?php echo $registro[fecha_derivado] ?>
          </td>
          <td <?php if ($estilo == '#FEB7B7') echo "style='color: white;'" ?>><span style="color: white;">
              <?php if ($estilo == '#FEB7B7') echo '<strong>URGENTE</strong> '; ?></span><?php echo "<strong>" . strtoupper($registro[estado_derivacion]) . "</strong>" ?></td>
          <td>
            <?php if($registro[estado_derivacion] == 'solicitado') {?>
              <a 
                  href="control/derivaciones/eliminar_derivacion.php?id=<?php echo $registro[id_derivacion]; ?>" 
                  class='accion btn btn-red btn-icon btn-xs' 
                  style='float: right; margin-right: 5px;'
                >
                  Eliminar Derivacion&nbsp;<i class='entypo-cancel'></i>
                </a>
            <?php }?>
            <button class="accion btn btn-info btn-icon btn-xs" data-toggle="modal" data-target="#avance_solicitud" data_id="<?php echo $registro[id_solicitud] . '-' . $registro[tipo_solicitud] . '-' . $registro[id_derivacion] ?>" onclick="verificar()" style='float: right; margin-right: 5px;'>
              Ver avance
              <i class="entypo-cancel"></i>
            </button>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<!-- Vista de la Solicitud -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
    <!-- Vista de la Solicitud content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="titulo"></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-4" style="text-align: right;">
            <p><strong>Trabajador Solicitante:</strong></p>
          </div>
          <div class="col-sm-8">
            <p id="nombre"></p>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4" style="text-align: right;">
            <p><strong>Unidad Solicitante:</strong></p>
          </div>
          <div class="col-sm-8">
            <p id="unidad"></p>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4" style="text-align: right;">
            <p><strong>Fecha de Derivacion:</strong></p>
          </div>
          <div class="col-sm-8">
            <p id="fecha"></p>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4" style="text-align: right;">
            <p><strong>Derivado a:</strong></p>
          </div>
          <div class="col-sm-8">
            <p id="derivado_a"></p>
          </div>
        </div>

        <div>
          <table class="table table-bordered datatable" id="table-1">
            <thead>
              <tr>
                <th>#</th>
                <th>Descripcion</th>
                <th>Unidad De Medida</th>
                <th>Cantidad Solicitada</th>
                <div id="precio_u" style="display: none;">
                  <th>Precio Unitario</th>
                  <th>Precio Total</th>
                </div>
              </tr>
            </thead>
            <tbody id="tabla_detalle">

            </tbody>
          </table>
        </div>
        <p id="total" style="text-align: right;"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- existencia de la Solicitud -->
<div class="modal fade" id="avance_solicitud" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Avance de la Solicitud</h4>
      </div>
      <div class="modal-body">
        <div id="message_to_remove" class="hidden"></div>
        <div id="borrar_derivacion" class="hidden"></div>
        <!--  -->
        <div id="mostrar_tabla">
          <table class="table table-bordered datatable" id="table-1">
            <thead>
              <th>N</th>
              <th>Nro Solicitud</th>
              <th>Fecha Modificacion</th>
              <th>Estado</th>
            </thead>
            <tbody id="tabla_avance">
            </tbody>
          </table>
          <hr>
          <h3>Se puede eliminar pasos de la solicitud, desea volver a:</h3>
          <hr>
          <div class="row">
            <div class="col-sm-4 text-center">
              <input type="text" class="form-control sm-4" id="penultimo_estado_de_la_solicitud" readonly>
              <input type="hidden" name="ultimo_estado_de_la_solicitud" id="ultimo_estado_de_la_solicitud">
              <input type="hidden" name="cambios_id_solicitud" id="cambios_id_solicitud">
              <input type="hidden" name="cambios_id_derivacion" id="cambios_id_derivacion">
              <input type="hidden" name="cambios_tipo" id="cambios_tipo">
            </div>
            <div class="col-sm-4 text-center">
              <button type="button" id="volver_atras_solicitud" class="btn btn-info" onclick="cambio_estado()"><i class="entypo-back"></i>Retroceder Solicitud</button>
            </div>
            <div class="col-sm-4 text-center"><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>
          </div>
        </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div> -->
    </div>

  </div>
</div>
<script type="text/javascript">
  const formatoMoneda = new Intl.NumberFormat('es-BO', {
    style: 'currency',
    currency: 'BOB'
  });

  function verificar() {
    var boton = event.target;
    var dataId = boton.getAttribute("data_id");
    var partes = dataId.split("-");
    var id_solicitud = partes[0];
    var tipo = partes[1];
    var id_derivacion = partes[2];
    var datos_solicitud = [{
        name: "ID Solicitud",
        value: id_solicitud
      },
      {
        name: "Tipo Solicitud",
        value: tipo
      },
      {
        name: "ID Derivacion",
        value: id_derivacion
      }
    ];
    console.table(datos_solicitud);
    document.getElementById('penultimo_estado_de_la_solicitud').value = "";
    document.getElementById('ultimo_estado_de_la_solicitud').value = "";
    document.getElementById('cambios_id_solicitud').value = "";
    document.getElementById('cambios_id_derivacion').value = "";
    document.getElementById('cambios_tipo').value = "";
    var ruta = "control/derivaciones/avance_solicitudes.php";
    var datos = new FormData();
    let btn_delete = '';
    let message = '';
    datos.append('id_solicitud', id_solicitud);
    datos.append('id_derivacion', id_derivacion);
    datos.append('tipo_verificacion', tipo);
    fetch(ruta, {
        method: 'POST',
        body: datos
      })
      .then(response => response.json())
      .then(data => {
        if (data.success === true) {
          console.log(data);
          let tamanio_estados = decodeURIComponent(data.estados);
          console.log("PRUEBAS   ", tamanio_estados);
          let penultimo_estado_encontrado = decodeURIComponent(data.estados[1]);
          let ultimo_estado_encontrado = decodeURIComponent(data.estados[0]);
          console.log("penultimo: ", penultimo_estado_encontrado);
          console.log("ultimo: ", ultimo_estado_encontrado);
          let contador = 1;
          if (tamanio_estados.length === 0) {
            document.getElementById('mostrar_tabla').classList.add('hidden');
            document.getElementById('borrar_derivacion').classList.remove('hidden');
            document.getElementById('message_to_remove').classList.remove('hidden');
            message = `<h3>El registro no cuenta con avance mas que la derivacion, desea eliminarlo?</h3><hr>`
            btn_delete = `<a href='control/derivaciones/eliminar_derivacion.php?id=${id_derivacion}' class='accion btn btn-red btn-icon' align='center' title='Eliminar Derivacion'>Eliminar <i class='entypo-cancel'></i></a>`
            document.getElementById('message_to_remove').innerHTML = message;
            document.getElementById('borrar_derivacion').innerHTML = btn_delete;
          } else {
            // Hay resultados, mostrar la tabla y ocultar el botón
            document.getElementById('mostrar_tabla').classList.remove('hidden');
            document.getElementById('borrar_derivacion').classList.add('hidden');
            document.getElementById('message_to_remove').classList.add('hidden');
          }
          let tabla = '<tbody>';
          data.data.forEach(detalle => {
            tabla += `<tr align='center'>
            <td>${contador}</td>
            <td>${decodeURIComponent(detalle.nro_solicitud)}</td>
            <td>${decodeURIComponent(detalle.created_at)}</td>
            <td>${decodeURIComponent(detalle.estado)}</td>`;
            tabla += `</tr>`;
            contador++;
          });
          tabla += '</tbody>';
          document.getElementById('tabla_avance').innerHTML = tabla;

          document.getElementById('penultimo_estado_de_la_solicitud').append(penultimo_estado_encontrado);
          document.getElementById('penultimo_estado_de_la_solicitud').value = penultimo_estado_encontrado;
          document.getElementById('ultimo_estado_de_la_solicitud').value = ultimo_estado_encontrado;
          document.getElementById('cambios_id_solicitud').value = id_solicitud;
          document.getElementById('cambios_id_derivacion').value = id_derivacion;
          document.getElementById('cambios_tipo').value = tipo;
          // Resaltar la última fila en verde
          var ultimaFila = document.querySelector("#tabla_avance tr:last-child");
          ultimaFila.style.backgroundColor = "green";
          // jAlert("Se realizo la verificacion de la solicitud.", "Mensaje")
        } else {
          console.log("Error al buscar la informacion!");
          // alert(data.message);
          jAlert(data.message, "Mensaje")
        }
      })
      .catch(error => {
        console.log(error);
      });
  }

  document.getElementById("enviar_inexistencia").addEventListener("click", function() {
    agregar_inexxitencia(); // alert("Agregar_detalles");
  });

  function cambio_estado() {
    var estado = document.getElementById("ultimo_estado_de_la_solicitud").value;
    var id_solicitud = document.getElementById("cambios_id_solicitud").value;
    var id_derivacion = document.getElementById("cambios_id_derivacion").value;
    var tipo_verificacion = document.getElementById("cambios_tipo").value;
    var datos_solicitud = [{
        name: "ID Solicitud",
        value: id_solicitud
      },
      {
        name: "Tipo Solicitud",
        value: tipo_verificacion
      },
      {
        name: "ID Derivacion",
        value: id_derivacion
      },
      {
        name: "Estado Derivacion",
        value: estado
      }
    ];
    console.table(datos_solicitud);
    if (estado !== 'solicitado') {
      console.log(estado, 'estado');
      var ruta = "control/derivaciones/historicos.php";
      var datos = new FormData();
      datos.append('estado', estado);
      datos.append('id_solicitud', id_solicitud);
      datos.append('id_derivacion', id_derivacion);
      datos.append('tipo_verificacion', tipo_verificacion);
      fetch(ruta, {
          method: 'POST',
          body: datos
        })
        .then(response => response.json())
        .then(data => {
          console.log(data, 'respuesta');
          if (data.success === true) {
            console.log(data);
            window.location.reload();
            jAlert(data.message, "Mensaje")
          } else {
            jAlert(data.message, "Mensaje")
          }
        })
        .catch(error => console.error(error));
    } else {
      jAlert("No es posible realizar la acción", "Mensaje")
    }
  }
  document.getElementById("volver_atras_solicitud").addEventListener("click", function() {
    cambio_estado();
  });

  // Agregar un evento de clic al botón
  function agregar_inexxitencia() {
    // Obtener los elementos por sus IDs
    var id_solicitud = document.getElementById('id_solicitud').value;
    var id_verificacion = document.getElementById('id_verificacion').value;
    var tipo_verificacion = document.getElementById('tipo_verificacion').value;
    var id_usuario = document.getElementById('id_usuario').value;
    var fecha_respuesta = document.getElementById('fecha_respuesta').value;
    var file_input = document.getElementById('file_input').files[0];
    var inexistencia = document.getElementById('inexistencia').value;

    // Crear un objeto con los datos
    var data_show = [{
        name: "ID Solicitud",
        value: id_solicitud
      },
      {
        name: "ID Verificación",
        value: id_verificacion
      },
      {
        name: "Tipo",
        value: tipo_verificacion
      },
      {
        name: "ID Usuario",
        value: id_usuario
      },
      {
        name: "Fecha de Respuesta",
        value: fecha_respuesta
      },
      {
        name: "Archivo de Entrada",
        value: file_input
      },
      {
        name: "Inexistencia",
        value: inexistencia
      }
    ];
    console.table(data_show);

    if (file_input) {
      // Ruta de la direccion
      var ruta = "control/derivaciones/insertar_verificacion.php";
      var datos = new FormData();
      datos.append('id_solicitud', id_solicitud);
      datos.append('id_verificacion', id_verificacion);
      datos.append('tipo_verificacion', tipo_verificacion);
      datos.append('id_usuario', id_usuario);
      datos.append('fecha_respuesta', fecha_respuesta);
      datos.append('file_input', file_input); // Agregar el archivo a los datos del formulario
      datos.append('inexistencia', inexistencia);
      console.table(datos);
      fetch(ruta, {
          method: 'POST',
          body: datos
        })
        .then(response => response.json())
        .then(data => {
          console.log(data);
          if (data.success === true) {
            window.location.reload();
            jAlert("Se realizo la verificacion de la solicitud.", "Mensaje")
          } else {
            // alert(data.message);
            jAlert(data.message, "Mensaje")
          }
        })
        .catch(error => {
          console.log(error);
        });
    } else {
      jAlert("No se seleccionó un archivo, para evidenciar la inexistencia", "Mensaje")
    }
  }

  function capturarDataId() {
    var boton = event.target;
    var dataId = boton.getAttribute("data_id");
    var partes = dataId.split("-");
    var id = partes[0];
    var tipo = partes[1]; // console.log('ID: ' + id + " Tipo: " + tipo);
    fetch('control/derivaciones/buscar.php?id=' + id + '&tipo=' + tipo)
      .then(response => response.json())
      .then(data => {
        console.log(data);
        if (data.success === true) {
          console.log(data.detalles);
          /* This code is updating the HTML content of certain elements on the page with data retrieved
          from a server using a fetch request. */
          document.getElementById('fecha').innerHTML = decodeURIComponent(data.fecha);
          document.getElementById('derivado_a').innerHTML = decodeURIComponent(data.designado);
          document.getElementById('nombre').innerHTML = decodeURIComponent(data.nombre);
          document.getElementById('unidad').innerHTML = (data.unidad_solicitante) ? decodeURIComponent(data.unidad_solicitante) : decodeURIComponent(data.oficina_solicitante);
          document.getElementById('titulo').innerHTML = 'Solicitud de <strong>' + decodeURIComponent(data.tipo_buscador).toUpperCase() + '</strong>';

          let total = 0;

          let tabla = '<tbody>';
          data.detalles.forEach(detalle => {
            tabla += `<tr align='center'>
            <td>${decodeURIComponent(detalle.id)}</td>
            <td>${decodeURIComponent(detalle.descripcion)}</td>
            <td>${decodeURIComponent(detalle.unidad_medida)}</td>
            <td>${decodeURIComponent(detalle.cantidad_solicitada)}</td>`;
            tabla += `<td>${formatoMoneda.format(detalle.precio_unitario)}</td>
                <td>${formatoMoneda.format(detalle.precio_total)}</td>`;
            total = parseFloat(total) + parseFloat(detalle.precio_total);
            tabla += `</tr>`;
          });
          tabla += '</tbody>';
          document.getElementById('tabla_detalle').innerHTML = tabla;
          document.getElementById('total').innerHTML = formatoMoneda.format(total);
        }
      })
      .catch(error => console.error(error));
  }
  jQuery(document).ready(function($) {
    $("a.eliminar_lista").click(function(e) {
      e.preventDefault();
      dir = $(this).attr("href");
      jConfirm("¿Est&aacute; seguro de realizar la acci&oacute;n?", "Mensaje", function(resp) {
        if (resp) {
          $.ajax({
            type: "GET",
            url: dir,
          }).done(function(response) {
            var data = JSON.parse(response);
            console.log(response)
            if (data.success === true) {
              window.location.reload();
            } else {
              jAlert(data.message, "Mensaje")
            }
          }).fail(function(response) {
            console.log(response)
          })
        }
      });

    });
  })
</script>
<style>
  .uppercase {
    text-transform: uppercase;
  }

  .hidden {
    display: none;
  }
</style>
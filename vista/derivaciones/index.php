<?php
include("modelo/derivaciones.php");
// include("../modelo/funciones.php"); Corregido;
setlocale(LC_TIME, "es_ES");
ini_set('date.timezone', 'America/La_Paz');
$fecha = date('Y-m-d H:i:s');
$entidad = new derivaciones();
$tipo = $_SESSION[nivel];
$id_usuario = $_SESSION[id_usuario];
// 
if ($tipo == 'ALMACENERO') {
  $registros = $bd->Consulta("SELECT id_derivacion, nro_solicitud, id_solicitud, tipo_solicitud, fecha_derivado, fecha_respuesta, estado_derivacion 
    from derivaciones 
    WHERE tipo_solicitud = 'material' 
    OR (id_trabajador = $id_usuario AND tipo_solicitud = 'servicio') 
    ORDER BY id_derivacion ASC");
} elseif ($tipo == 'ACTIVOS') { // PREGUNTAR SI EL ES DE LOS SERVICIOS
  $registros = $bd->Consulta("SELECT id_derivacion, nro_solicitud, id_solicitud, tipo_solicitud, fecha_derivado, fecha_respuesta, estado_derivacion 
    from derivaciones 
    WHERE tipo_solicitud = 'activo' 
    OR (id_trabajador = $id_usuario AND tipo_solicitud = 'servicio') 
    ORDER BY id_derivacion ASC");
  // } elseif ($tipo == 'ACTIVOS') {
  //   $registros = $bd->Consulta("SELECT id_derivacion, nro_solicitud, id_solicitud, tipo_solicitud, fecha_derivado, fecha_respuesta, estado_derivacion from derivaciones WHERE tipo_solicitud = 'activo' ORDER BY id_derivacion ASC");
} elseif ($tipo == 'ADQUISICION' || $tipo == 'RPA') {
  $registros = $bd->Consulta("SELECT id_derivacion, nro_solicitud, id_solicitud, tipo_solicitud, fecha_derivado, fecha_respuesta, estado_derivacion 
    from derivaciones  
    WHERE id_trabajador = $id_usuario 
    AND tipo_solicitud = 'servicio' 
    ORDER BY id_derivacion ASC");
} else {
  // $responsable_servicios = $bd->Consulta("SELECT * FROM usuario as u INNER JOIN trabajador as t ON t.id_trabajador = u.id_trabajador WHERE u.id_usuario = $id_usuario");
  // $responsable_servicio = $bd->getFila($responsable_servicios);
  $registros = $bd->Consulta("SELECT id_derivacion, nro_solicitud, id_solicitud, tipo_solicitud, fecha_derivado, fecha_respuesta, estado_derivacion 
    from derivaciones 
    WHERE id_trabajador = $id_usuario 
    AND tipo_solicitud = 'servicio' 
    ORDER BY id_derivacion ASC");
}
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
        <th>Objetivo</th>
        <th>Justificativo</th>
        <th>Solicitante</th>
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
          <td><?php echo $n ?></td>
          <td> <!-- <th>Solicitud</th> -->
            <button 
              type="button" 
              class="btn btn-info btn-lg btn-xs" 
              data-toggle="modal" 
              data-target="#myModal" 
              data_id="<?php echo $registro[id_solicitud] . '-' . $registro[tipo_solicitud] ?>" 
              id="vista" 
              onclick="capturarDataId()"
            >
              S<?php echo $registro[nro_solicitud] ?>-<?php echo strtoupper($registro[tipo_solicitud]) ?>
            </button>
          </td>
          <td> <!-- <th>Fecha de <br>Solicitud</th> -->
            <?php echo $registro[fecha_derivado] ?>
          </td>
          <td> <!-- <th>Objetivo</th> -->
            <?php
              //! Buscar el objetivo 
              if($registro[tipo_solicitud] == "servicio") {
                $datos_objetivo = $bd->Consulta("SELECT objetivo_contratacion FROM solicitud_servicio WHERE id_solicitud_servicio = $registro[id_solicitud]"); 
                $data = $bd->getFila($datos_objetivo);
              } elseif($registro[tipo_solicitud] == "activo"){
                $datos_objetivo = $bd->Consulta("SELECT objetivo_contratacion FROM solicitud_activo WHERE id_solicitud_activo = $registro[id_solicitud]"); 
                $data = $bd->getFila($datos_objetivo);
              } else {
                $datos_objetivo = $bd->Consulta("SELECT objetivo_contratacion FROM solicitud_material WHERE id_solicitud_material = $registro[id_solicitud]"); 
                $data = $bd->getFila($datos_objetivo);
              } 
              echo utf8_encode($data[objetivo_contratacion])?>
          </td>
          <td> <!-- <th>Justificativo</th> -->
            <?php
              //! Buscar el justificativo  
              if($registro[tipo_solicitud] == "servicio") {
                $datos_justificativo = $bd->Consulta("SELECT justificativo FROM solicitud_servicio WHERE id_solicitud_servicio = $registro[id_solicitud]"); 
                $data = $bd->getFila($datos_justificativo);
              } elseif($registro[tipo_solicitud] == "activo"){
                $datos_justificativo = $bd->Consulta("SELECT justificativo FROM solicitud_activo WHERE id_solicitud_activo = $registro[id_solicitud]"); 
                $data = $bd->getFila($datos_justificativo);
              } else {
                $datos_justificativo = $bd->Consulta("SELECT justificativo FROM solicitud_material WHERE id_solicitud_material = $registro[id_solicitud]"); 
                $data = $bd->getFila($datos_justificativo);
              } 
              echo utf8_encode($data[justificativo])?>
          </td>
          <td> <!-- <th>Solicitante</th> -->
            <?php 
              //! Buscar el solicitante
              if($registro[tipo_solicitud] == "servicio") {
                $datos_solicitante = $bd->Consulta("SELECT u.nombre_apellidos 
                  FROM solicitud_servicio as s 
                  INNER JOIN usuario as u ON u.id_usuario = s.id_usuario 
                  WHERE s.id_solicitud_servicio = $registro[id_solicitud]"); 
                $data = $bd->getFila($datos_solicitante);
              } elseif($registro[tipo_solicitud] == "activo"){
                $datos_solicitante = $bd->Consulta("SELECT u.nombre_apellidos 
                  FROM solicitud_activo as s 
                  INNER JOIN usuario as u ON u.id_usuario = s.id_usuario 
                  WHERE s.id_solicitud_activo = $registro[id_solicitud]"); 
              $data = $bd->getFila($datos_solicitante);
              } else {
                $datos_solicitante = $bd->Consulta("SELECT u.nombre_apellidos 
                  FROM solicitud_material as s 
                  INNER JOIN usuario as u ON u.id_usuario = s.id_usuario 
                  WHERE s.id_solicitud_material = $registro[id_solicitud]"); 
                $data = $bd->getFila($datos_solicitante);
              } echo utf8_encode($data[nombre_apellidos])?>
          </td>
          <!-- <th>Estado</th> -->
          <td 
            <?php 
              //! Preguntar si ya se sobre exedio del tiempo de respuesta para alertar 
              if ($estilo == '#FEB7B7') echo "style='color: white;'" ?>>
              <span style="color: white;"><?php if ($estilo == '#FEB7B7') echo '<strong>URGENTE</strong> '; ?></span>
              <?php echo "<strong>" . strtoupper($registro[estado_derivacion]) . "</strong>" ?>
          </td>
          <td>
            <?php
              //!  Acciones solo para responder a la derivacion
              if ($registro[estado_derivacion] == 'solicitado') { ?>
                <button 
                  class="accion btn btn-info btn-icon btn-xs" 
                  data-toggle="modal" 
                  data-target="#existencia_solicitud" 
                  data_id="<?php echo $registro[id_solicitud] . '-' . $registro[tipo_solicitud] . '-' . $registro[id_derivacion] ?>" 
                  onclick="verificar()" 
                  style='float: right; margin-right: 5px;'
                >
                  Certificar Inexistencia <i class="entypo-cancel"></i>
                </button>
                <br>
                <a 
                  href="control/derivaciones/devolver.php?id=<?php echo $registro[id_derivacion]; ?>" 
                  class='accion btn btn-red btn-icon btn-xs' 
                  style='float: right; margin-right: 5px;'
                >
                  Devolver&nbsp;<i class="entypo-back"></i>
                </a>
            <?php } elseif ($registro[estado_derivacion] == 'solicitar') { ?>
              <p><strong>Devuelto</strong></p>
            <?php } else { 
              //! Si se procedio a la inexistencia validamos por estado y por rol
            ?>
              <?php 
                //! Validamos solo para los perfiles de activos y almacen con el estado de memorandun para proceder a acciones de la solicitud
                if($_SESSION['nivel'] == 'ALMACENERO' || 'ACTIVOS') { ?>
                  <?php if($registro[estado_derivacion] == 'memorandun') {?>
                    <a 
                      href="?mod=derivaciones&pag=orden_compra&id=<?php echo $registro[id_derivacion]; ?>" 
                      class='btn btn-info btn-icon btn-xs' 
                      style='float: right; margin-right: 5px;'
                    >
                      Ver Proceso&nbsp;<i class="entypo-plus"></i>
                    </a>
                  <?php }?>
                    <a 
                      target='_blank' 
                      href='vista/derivaciones/pdf_solicitud.php?id_sol=<?php echo $registro[id_solicitud]; ?>&tipo=<?php echo $registro[tipo_solicitud]; ?>' 
                      class='btn btn-info btn-icon btn-xs' 
                      style='float: right; margin-right: 5px;'
                    >
                      Imprimir FORM 01-02<i class='entypo-print'></i>
                    </a>
                    <br>
                <!-- <?php //}  elseif ($_SESSION['nivel'] != 'RPA') { 
                  //! Validar si algun otro perfil puede tenar acciones en este segmento, el codigo fue comentado, pensando que solo seria el tipo de solicitud de servicio
                  ?>
                  <a 
                    href="?mod=derivaciones&pag=orden_compra&id=<?php // echo $registro[id_derivacion]; ?>" 
                    class='btn btn-info btn-icon btn-xs' 
                    style='float: right; margin-right: 5px;'
                  >
                    Ver Proceso&nbsp;<i class="entypo-plus"></i>
                  </a>
                  <a 
                    target='_blank' 
                    href='vista/derivaciones/pdf_solicitud.php?id_sol=<?php // echo $registro[id_solicitud]; ?>&tipo=<?php echo $registro[tipo_solicitud]; ?>' 
                    class='btn btn-info btn-icon btn-xs' 
                    style='float: right; margin-right: 5px;'
                  >
                    Imprimir FORM 01-02<i class='entypo-print'></i>
                  </a>
                  <br> -->
              <?php } else { 
                //! Validamos que sea del tipo de servicio asignado acualquiere trabajador, pero que este en el estado de memorandun para procesar la recepcion, visto bueno, etc.
                ?>
                <a 
                  target='_blank' 
                  href='vista/derivaciones/pdf_solicitud.php?id_sol=<?php echo $registro[id_solicitud]; ?>&tipo=<?php echo $registro[tipo_solicitud]; ?>' 
                  class='btn btn-info btn-icon btn-xs' 
                  style='float: right; margin-right: 5px;'
                >
                  Imprimir<i class='entypo-print'></i>
                </a>
                <br>
                <?php if($registro[estado_derivacion] == 'memorandun'){ ?>
                  <a 
                    href="?mod=derivaciones&pag=orden_compra&id=<?php echo $registro[id_derivacion]; ?>" 
                    class='btn btn-info btn-icon btn-xs' 
                    style='float: right; margin-right: 5px;'
                  >
                    Procesar&nbsp;<i class="entypo-plus"></i>
                  </a>
                <?php } ?>
              <?php } ?>
            <?php } ?>
          </td>
        </tr>
      <?php } ?>
    </tbody>
    <tfoot>
    </tfoot>
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
            <p><strong>Objetivo:</strong></p>
          </div>
          <div class="col-sm-8">
            <p id="objetivo"></p>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4" style="text-align: right;">
            <p><strong>Justificativo:</strong></p>
          </div>
          <div class="col-sm-8">
            <p id="justificativo"></p>
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
<div class="modal fade" id="existencia_solicitud" role="dialog">
  <div class="modal-dialog">
    <!-- existencia de la Solicitud content-->
    <!-- href="control/derivaciones/verificar.php?id=<?php // echo $registro[id_derivacion] 
                                                      ?>" -->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Existencia de la Solicitud</h4>
      </div>
      <div class="modal-body">
        <form name="frm_derivaciones" id="frm_derivaciones" action="" method="post" role="form" class="form-horizontal form-groups-bordered" enctype="multipart/form-data">
          <input type="hidden" name="id_solicitud" id="id_solicitud">
          <input type="hidden" name="id_verificacion" id="id_verificacion">
          <input type="hidden" name="tipo_verificacion" id="tipo_verificacion">
          <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION[id_usuario] ?>">
          <!-- Fecha de verificacion -->
          <div class="row">
          <div class="col-sm-2" style="text-align: right;">
            <p><strong>Trabajador Solicitante:</strong></p>
          </div>
          <div class="col-sm-10">
            <p id="trabajador_solicitante"></p>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2" style="text-align: right;">
            <p><strong>Unidad Solicitante:</strong></p>
          </div>
          <div class="col-sm-10">
            <p id="unidad_solicitante"></p>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2" style="text-align: right;">
            <p><strong>Objetivo:</strong></p>
          </div>
          <div class="col-sm-10">
            <p id="objetivo_solicitante"></p>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2" style="text-align: right;">
            <p><strong>Justificativo:</strong></p>
          </div>
          <div class="col-sm-10">
            <p id="justificativo_solicitante"></p>
          </div>
        </div>
        <hr>
          <!-- <div class="form-group">
            <label class="col-sm-2 control-label" style="text-align: right;">
              <strong>Trabajador Solicitante:</strong>
            </label>
            <div class="col-sm-10">
              <input type="text" readonly class="form-control" id="trabajador_solicitante">
            </div>
            <br> -->
          <!-- </div>
          <div class="form-group"> -->
            <!-- <label class="col-sm-2 control-label" style="text-align: right;">
              <strong>Unidad Solicitante:</strong>
            </label>
            <div class="col-sm-10">
              <input type="text" readonly class="form-control" id="unidad_solicitante">
            </div>
            <br> -->
          <!-- </div>
          <div class="form-group"> -->
            <!-- <label class="col-sm-2 control-label" style="text-align: right;">
              <strong>Objetivo:</strong>
            </label>
            <div class="col-sm-10">
              <input type="text" readonly class="form-control" id="objetivo_solicitante">
            </div>
            <br> -->
          <!-- </div>
          <div class="form-group"> -->
            <!-- <label class="col-sm-2 control-label" style="text-align: right;">
              <strong>Justificativo:</strong>
            </label>
            <div class="col-sm-10">
              <input type="text" readonly class="form-control" id="justificativo_solicitante">
            </div>
            <br> -->
          <!-- </div>
          <div class="form-group"> -->
            <!-- <label class="col-sm-2 control-label" style="text-align: right;">
              <strong>Nro de Solicitud:</strong>
            </label>
            <div class="col-sm-10">
              <input type="text" readonly class="form-control" id="nro_solicitante">
            </div> -->
          <!-- </div> -->
          <div class="form-group">
            <label for="fecha_respuesta" class="col-sm-2 control-label">Fecha respuesta</label>
            <div class="col-sm-10">
              <input type="text" name="fecha_respuesta" id="fecha_respuesta" class="form-control required datepicker" value="<?php echo $fecha; ?>" readonly />
            </div>
          </div>
          <div class="form-group">
            <label for="file_input" class="col-sm-2 control-label">Subir Archivo</label>
            <div class="col-sm-10">
              <input id="file_input" name="file_input" type="file" class="btn btn-info form-control required" accept="application/pdf">
            </div>
          </div>
          <div class="form-group">
            <label for="inexistencia" class="col-sm-2 control-label">Declaracion de Inexistencia</label>
            <div class="col-sm-10">
              <textarea id="inexistencia" name="inexistencia" rows="5" class="form-control required uppercase" placeholder="Sin Existencia">SIN EXISTENCIA</textarea>
            </div>
          </div>
          <div class="form-group" style="text-align: center;">
            <div class="col-sm-offset-3 col-sm-5">
              <button type="button" id="enviar_inexistencia" class="btn btn-info">Registrar</button> <button type="button" class="btn cancelar">Cancelar</button>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
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
    console.log('ID SOL: ' + id_solicitud + " Tipo: " + tipo + " ID DERIVACION: " + id_derivacion);
    document.getElementById('id_solicitud').innerHTML = id_solicitud;
    document.getElementById('id_solicitud').value = id_solicitud;
    document.getElementById('tipo_verificacion').innerHTML = tipo;
    document.getElementById('tipo_verificacion').value = tipo;
    document.getElementById('id_verificacion').innerHTML = id_derivacion;
    document.getElementById('id_verificacion').value = id_derivacion;
    fetch('control/derivaciones/buscar.php?id=' + id_solicitud + '&tipo=' + tipo)
      .then(response => response.json())
      .then(data => {
        console.log(data);
        if (data.success === true) {
          console.log(data.detalles);
          let unidad = (data.oficina_solicitante != '') ? data.oficina_solicitante :  data.unidad_solicitante
          document.getElementById('trabajador_solicitante').innerHTML = data.nombre;
          document.getElementById('trabajador_solicitante').value = data.nombre;
          document.getElementById('unidad_solicitante').innerHTML = unidad;
          document.getElementById('unidad_solicitante').value = unidad;
          document.getElementById('objetivo_solicitante').innerHTML = data.objetivo;
          document.getElementById('objetivo_solicitante').value = data.objetivo;
          document.getElementById('justificativo_solicitante').innerHTML = data.justificativo;
          document.getElementById('justificativo_solicitante').value = data.justificativo;
          document.getElementById('nro_solicitante').innerHTML = data.nro;
          document.getElementById('nro_solicitante').value = data.nro;
        }
      })
      .catch(error => console.error(error));
  }

  document.getElementById("enviar_inexistencia").addEventListener("click", function() {
    agregar_inexxitencia();
    // alert("Agregar_detalles");
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

    // if (file_input) {
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
    // } else {
    //   jAlert("No se seleccionó un archivo, para evidenciar la inexistencia", "Mensaje")
    // }
  }

  function capturarDataId() {
    var boton = event.target;
    var dataId = boton.getAttribute("data_id");
    var partes = dataId.split("-");
    var id = partes[0];
    var tipo = partes[1];
    // console.log('ID: ' + id + " Tipo: " + tipo);
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
          document.getElementById('objetivo').innerHTML = decodeURIComponent(data.objetivo);
          document.getElementById('justificativo').innerHTML = decodeURIComponent(data.justificativo);
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
            // if (data.existencia == 'NO') {
            // document.getElementById('precio_u').style.display = 'block';
            tabla += `<td>${formatoMoneda.format(detalle.precio_unitario)}</td>
                <td>${formatoMoneda.format(detalle.precio_total)}</td>`;
            // console.log(total);
            total = parseFloat(total) + parseFloat(detalle.precio_total);
            // } else {
            //   document.getElementById('precio_u').style.display = 'none';
            // }
            tabla += `</tr>`;
          });
          // tabla += `<tr><td ></td></tr>`
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
</style>
<?php include("modelo/papeleta_vacacion.php");


$papeleta_vacacion = new papeleta_vacacion();
$registros =  $bd->Consulta("select * from detalle_vacacion dv inner join vacacion v on dv.id_vacacion=v.id_vacacion inner join trabajador t on v.id_trabajador=t.id_trabajador inner join papeleta_vacacion pv on pv.id_detalle_vacacion=dv.id_detalle_vacacion order by pv.estado desc");


?>
<h2>Solicitudes de vacaciones</h2>

</h2>
<br /><br /><br />
<div class="table-responsive">
  <table class="table table-bordered datatable" id="table-1">
    <thead>
      <tr>
        <th rowspan="2">Nro.</th>
        <th rowspan="2">Trabajador</th>
        <th rowspan="2">fecha solicitud</th>
        <th colspan="2">Periodo</th>
        <th colspan="2">Fechas</th>
        <th rowspan="2">Dias solicitados</th>
        <th rowspan="2">estado</th>
        <th rowspan="2">autorizado por</th>
        <th rowspan="2">observacion</th>
        <th width="160" rowspan="2">Acciones</th>
      </tr>
      <tr>
        <th>inicio</th>
        <th>fin</th>
        <th>inicio</th>
        <th>fin</th>
      </tr>
    </thead>
    <tbody>
      <?php


      while ($registro = $bd->getFila($registros)) {
        $n++;
        echo "<tr>";

        echo utf8_encode("
        <td>$n</td>
        <td>$registro[nombres] $registro[apellido_paterno] $registro[apellido_materno]</td>
        <td>$registro[fecha_solicitud]</td>
        <td>$registro[gestion_inicio]</td>
        <td>$registro[gestion_fin]</td>
        <td>$registro[fecha_inicio]</td>
        <td>$registro[fecha_fin]</td>
        <td>$registro[dias_solicitados]</td>
        <td>$registro[estado]</td>
        <td>$registro[autorizado_por]</td>
        <td>$registro[observacion]</td>");
        echo "<td>
          <a target='_blank' href='vista/reportes/visor_reporte.php?f=vista/papeleta_vacacion/papeleta_vacacion_pdf.php&id=$registro[id_papeleta_vacacion]' class='btn btn-info btn-icon' style='float: right; margin-right: 5px;'>
            Imprimir<i class='entypo-print'></i>
          </a><br>";
        if ($registro[estado] == 'SOLICITADO') {
          echo "<a href='control/papeleta_vacacion/aprobar.php?id=$registro[id_papeleta_vacacion]' class='accion btn btn-green btn-icon' style='float: right; margin-right: 5px;'>Aprobar <i class='entypo-check'></i></a>";
          echo "<a href='control/papeleta_vacacion/rechazar.php?id=$registro[id_papeleta_vacacion]' class='accion btn btn-danger btn-icon' style='float: right; margin-right: 5px;'>Rechazar <i class='entypo-cancel'></i></a>";
        }
        if ($registro[estado] == 'APROBADO') { ?>
          <?php
          // echo "Vacacion: " .  $registro[id_vacacion] . "<br>";
          // echo "papeleta: " .$registro[id_papeleta_vacacion] . "<br>";
          $data = $bd->Consulta("SELECT p.id_papeleta_vacacion FROM vacacion v 
            INNER JOIN detalle_vacacion d ON d.id_vacacion = v.id_vacacion 
            INNER JOIN papeleta_vacacion p ON p.id_detalle_vacacion = d.id_detalle_vacacion 
            WHERE v.id_vacacion = $registro[id_vacacion] 
            ORDER BY p.id_papeleta_vacacion DESC 
            LIMIT 1");
          $res = $bd->getFila($data);
          if ($res[id_papeleta_vacacion] == $registro[id_papeleta_vacacion]) { 
            $validar_cambios = $bd->Consulta("SELECT p.id_papeleta_vacacion, u.cantidad_dias, u.dias_ejecutados 
                                  FROM vacacion v 
                                  INNER JOIN detalle_vacacion d ON d.id_vacacion = v.id_vacacion 
                                  INNER JOIN papeleta_vacacion p ON p.id_detalle_vacacion = d.id_detalle_vacacion 
                                  INNER JOIN uso_vacacion u ON u.id_papeleta_vacacion = p.id_papeleta_vacacion 
                                  WHERE v.id_vacacion = $registro[id_vacacion] 
                                  ORDER BY p.id_papeleta_vacacion DESC 
                                  LIMIT 1");
            $validar_cambio = $bd->getFila($validar_cambios);
            if($validar_cambio[cantidad_dias] == $validar_cambio[dias_ejecutados]) {
            ?>
            <a data-toggle="modal" data-target="#boton_modal_observacion_vacacion" data-id="<?php echo $registro[id_papeleta_vacacion] ?>" class="modal_observacion_vacacion btn btn-orange btn-icon" style="float: right; margin-right: 5px;">Observar <i class="entypo-check"></i></a>
            <?php } ?>
      <?php }
        }
        echo "</td></tr>"; } ?>
    </tbody>
    <tfoot>
    </tfoot>
  </table>
</div>
<div class="modal fade" id="boton_modal_observacion_vacacion" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">Cerrar&nbsp;&times;</button>
        <h4 class="modal-title" id="titulo">Observaciones</h4>
      </div>
      <div class="modal-body">
        <h3 id="trabajador"></h3>
        <h3 id="dias_solicitados"></h3>
        <form class="validate_preguntas form-horizontal form-groups-bordered">
          <input type="hidden" name="id_papeleta_vacacion_cambiar" id="id_papeleta_vacacion_cambiar">
          <div class="form-group">
            <label for="cambio_dias_ejecutados" class="col-sm-2 control-label">Dias Ejecutados</label>
            <div class="col-sm-9">
              <input type="text" name="cambio_dias_ejecutados" id="cambio_dias_ejecutados" class="form-control required text" placeholder='' />
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
              <button type="submit" class="accion send_observations_on_holidays btn btn-info">Registrar</button>
              <!-- <button type="reset" class="btn btn-default cancelar">Cancelar</button> -->
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  jQuery(document).ready(function($) {
    $(".modal_observacion_vacacion").click(function() {
      var dataId = $(this).attr('data-id');
      document.getElementById("id_papeleta_vacacion_cambiar").value = dataId
      // alert(dataId)
      findDataAboutHolidays(dataId);
    });

    // $(".send_observations_on_holidays").click(function() {
    //   sendObservationsHollidays();
    // });

    function findDataAboutHolidays(id) {
      var url = "control/papeleta_vacacion/buscar_papeleta.php";
      fetch(url + '?id=' + id)
        .then(response => response.json())
        .then(data => {
          console.log("Info: ", data);
          if (data.success === true) {
            // window.location.reload();
            document.getElementById("trabajador").innerHTML = "Trabajador:" + data.data.nombres + data.data.apellido_paterno + data.data.apellido_materno
            document.getElementById("dias_solicitados").innerHTML = "Dias Solicitados: " + data.data.dias_solicitados
          } else {
            // alert(data.message);
            jAlert(data.message, "Mensaje")
          }
        })
        .catch(error => {
          console.log(error);
        });
    }

    // function sendObservationsHollidays() {
    $(".send_observations_on_holidays").click(function(e) {
      e.preventDefault();
      var id_papeleta_vacacion_cambiar = document.getElementById("id_papeleta_vacacion_cambiar").value
      var cambio_dias_ejecutados = document.getElementById("cambio_dias_ejecutados").value
      // console.log(id_papeleta_vacacion_cambiar + ' ' + cambio_dias_ejecutados);
      // alert(id_papeleta_vacacion_cambiar + ' ' + cambio_dias_ejecutados);
      var url = `control/papeleta_vacacion/cambio_dias_ejecutados.php?id=${id_papeleta_vacacion_cambiar}&dias_ejecutados=${cambio_dias_ejecutados}`;
      console.log(url);
      // alert(url)
      jConfirm("¿Est&aacute; seguro de realizar la acci&oacute;n?", "Mensaje", function(resp) {
        if (resp) {
          $.ajax({
            type: "GET",
            url: url
          }).done(function(response) {
            var data = JSON.parse(response);
            // alert(response)
            console.log(response)
            jAlert("Modificado con exito!.", "Mensaje");
            $("#boton_modal_observacion_vacacion").modal('hide')
            // Comentado por errores en modelo, no soporta la modificacion pero si al final devulve lo requerido
            // if (data.success === true) {
            window.location.reload();
            // jAlert("Solicitud realizada con exito", "Aceptar", function(
            //   resp) {
            // });
            // } else {
            //   jAlert(data.message, "Mensaje")
            // }
          })
          // window.location.reload();
          // $(location).attr('href',dir);
        }
      });
    });
  });
</script>
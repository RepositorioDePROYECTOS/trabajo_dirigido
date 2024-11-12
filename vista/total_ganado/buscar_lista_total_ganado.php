<?php
    $anio = date("Y");
?>
<h2>Total Ganado</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
    <div class="panel-heading">
        <div class="panel-title">
            Consultar
        </div>
    </div>

    <div class="panel-body">

        <form name="frm_buscar_total_ganado" id="frm_buscar_total_ganado" action="?mod=total_ganado&pag=lista" method="GET" role="form" class="form-horizontal form-groups-bordered">
            <input type="hidden" name="mod" value="total_ganado"/>
                <input type="hidden" name="pag" value="lista"/>
            <div class="form-group">
                <label for="fecha" class="col-sm-2 control-label">Mes</label>
                <div class="col-sm-2">
                    <select name="mes" id="mes" class="form-control required select">
                        <option value="">--Seleccione--</option>
                        <option value="1">ENERO</option>
                        <option value="2">FEBRERO</option>
                        <option value="3">MARZO</option>
                        <option value="4">ABRIL</option>
                        <option value="5">MAYO</option>
                        <option value="6">JUNIO</option>
                        <option value="7">JULIO</option>
                        <option value="8">AGOSTO</option>
                        <option value="9">SEPTIEMBRE</option>
                        <option value="10">OCTUBRE</option>
                        <option value="11">NOVIEMBRE</option>
                        <option value="12">DICIEMBRE</option>
                    </select>
                </div>
                <label for="fecha" class="col-sm-2 control-label">Gesti&oacute;n</label>
                <div class="col-sm-2">
                    <input type="text" name="gestion" id="gestion" class="form-control required enteros" style="text-align: left;" required="" autocomplete="off" value="<?php echo $anio;?>" />
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-info">Mostrar</button>
                </div>
            </div>
        </form>
        

    </div>

</div>

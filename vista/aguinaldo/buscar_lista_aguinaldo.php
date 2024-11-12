<?php
    $anio = date("Y");
?>
<h2>Planilla aguinaldo</h2>
  <br />
  <div class="panel panel-default panel-shadow" data-collapsed="0">
    <div class="panel-heading">
        <div class="panel-title">
            Consultar
        </div>
    </div>

    <div class="panel-body">

        <form name="frm_buscar_aguinaldo" id="frm_buscar_aguinaldo" action="?mod=aguinaldo&pag=lista" method="GET" role="form" class="form-horizontal form-groups-bordered">
            <input type="hidden" name="mod" value="aguinaldo"/>
                <input type="hidden" name="pag" value="lista"/>
            <div class="form-group">
                <label for="fecha" class="col-sm-2 control-label">Nro. de aguinaldo</label>
                <div class="col-sm-2">
                    <select name="nro_aguinaldo" id="nro_aguinaldo" class="form-control required select">
                        <option value="1" selected>PRIMER</option>
                        <option value="2">SEGUNDO</option>
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

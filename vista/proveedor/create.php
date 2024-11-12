<h2>Proveedores</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
    <div class="panel-heading">
        <div class="panel-title">
            Proveedor
        </div>
    </div>
    <div class="panel-body">
        <form name="frm_entidad" id="frm_entidad" action="control/proveedor/insertar.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
            <div class="form-group">
                <label for="nombre_proveedor" class="col-sm-3 control-label">Nombre Proveedor</label>
                <div class="col-sm-5">
                    <input type="text" name="nombre_proveedor" id="nombre_proveedor" class="form-control required text" />
                </div>
            </div>
            <div class="form-group">
                <label for="nit" class="col-sm-3 control-label">Nit</label>
                <div class="col-sm-5">
                    <input type="text" name="nit" id="nit" class="form-control required text" />
                </div>
            </div>
            <!-- <div class="form-group">
                <label for="contacto" class="col-sm-3 control-label">Contacto</label>
                <div class="col-sm-5">
                    <input type="text" name="contacto" id="contacto" placeholder="gracias a quien se conoce este proveedor" class="form-control required text" />
                </div>
            </div>
            <div class="form-group">
                <label for="doc_contacto" class="col-sm-3 control-label">Numero del Contacto</label>
                <div class="col-sm-5">
                    <input type="text" name="doc_contacto" id="doc_contacto" class="form-control required text" />
                </div>
            </div> -->
            <div class="form-group">
                <label for="direccion" class="col-sm-3 control-label">Direccion</label>
                <div class="col-sm-5">
                    <input type="text" name="direccion" id="direccion" class="form-control required text" />
                </div>
            </div>
            <div class="form-group">
                <label for="telefono" class="col-sm-3 control-label">Telefono</label>
                <div class="col-sm-5">
                    <input type="text" name="telefono" id="telefono" class="form-control required text" />
                </div>
            </div>
            <div class="form-group">
                <label for="celular" class="col-sm-3 control-label">Celular</label>
                <div class="col-sm-5">
                    <input type="text" name="celular" id="celular" class="form-control required text" />
                </div>
            </div>
            <!-- <div class="form-group">
                <label for="correo" class="col-sm-3 control-label">Correo</label>
                <div class="col-sm-5">
                    <input type="text" name="correo" id="correo" class="form-control required text" />
                </div>
            </div> -->
            <div class="form-group">
                <label for="observacion" class="col-sm-3 control-label">Observaciones</label>
                <div class="col-sm-5">
                    <input type="text" name="observacion" id="observacion" class="form-control required text" value="NINGUNA" />
                </div>
            </div>
            <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION[id_usuario] ?>">
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    <button type="submit" class="btn btn-info">Registrar</button> <button type="reset" class="btn btn-default cancelar">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>
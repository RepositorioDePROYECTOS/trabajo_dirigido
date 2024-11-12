<?php 
    
    $id = security($_GET[id]);
    $proveedores = $bd->Consulta("SELECT * FROM proveedores WHERE id_proveedor = $id");
    $proveedor = $bd->getFila($proveedores);
    // var_dump($proveedor);
?>
<h2>Proveedores</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
    <div class="panel-heading">
        <div class="panel-title">
            Actualizar Proveedor
        </div>
    </div>
    <div class="panel-body">
        <form name="frm_entidad" id="frm_entidad" action="control/proveedor/edit.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
            <div class="form-group">
                <label for="nombre_proveedor" class="col-sm-3 control-label">Nombre Proveedor</label>
                <div class="col-sm-5">
                    <input type="text" name="nombre_proveedor" id="nombre_proveedor" class="form-control required text" value="<?php echo $proveedor[nombre]; ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="nit" class="col-sm-3 control-label">Nit</label>
                <div class="col-sm-5">
                    <input type="text" name="nit" id="nit" class="form-control required text" value="<?php echo utf8_encode($proveedor[nit]);?>" />
                </div>
            </div>
            <!-- <div class="form-group">
                <label for="contacto" class="col-sm-3 control-label">Contacto</label>
                <div class="col-sm-5">
                    <input type="text" name="contacto" id="contacto" value="<?php echo utf8_encode($proveedor[contacto]); ?>" class="form-control required text" />
                </div>
            </div>
            <div class="form-group">
                <label for="doc_contacto" class="col-sm-3 control-label">Documento del Contacto</label>
                <div class="col-sm-5">
                    <input type="text" name="doc_contacto" id="doc_contacto" value="<?php echo utf8_encode($proveedor[doc_contacto]); ?>" class="form-control required text" />
                </div>
            </div> -->
            <div class="form-group">
                <label for="direccion" class="col-sm-3 control-label">Direccion</label>
                <div class="col-sm-5">
                    <input type="text" name="direccion" id="direccion" value="<?php echo utf8_encode($proveedor[direccion]); ?>" class="form-control required text" />
                </div>
            </div>
            <div class="form-group">
                <label for="telefono" class="col-sm-3 control-label">Telefono</label>
                <div class="col-sm-5">
                    <input type="text" name="telefono" id="telefono" value="<?php echo utf8_encode($proveedor[telefono]); ?>" class="form-control required text" />
                </div>
            </div>
            <div class="form-group">
                <label for="celular" class="col-sm-3 control-label">Celular</label>
                <div class="col-sm-5">
                    <input type="text" name="celular" id="celular" value="<?php echo utf8_encode($proveedor[celular]); ?>" class="form-control required text" />
                </div>
            </div>
            <!-- <div class="form-group">
                <label for="correo" class="col-sm-3 control-label">Correo</label>
                <div class="col-sm-5">
                    <input type="text" name="correo" id="correo" value="<?php echo utf8_encode($proveedor[correo]); ?>" class="form-control required text" />
                </div>
            </div> -->
            <div class="form-group">
                <label for="observacion" class="col-sm-3 control-label">Observaciones</label>
                <div class="col-sm-5">
                    <input type="text" name="observacion" id="observacion" value="<?php echo utf8_encode($proveedor[observacion]); ?>" class="form-control required text"/>
                </div>
            </div>
            <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION[id_usuario] ?>">
            <input type="hidden" name="id_proveedor" id="id_proveedor" value="<?php echo $id ?>">
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    <button type="submit" class="btn btn-info">Actualizar</button> <button type="reset" class="btn btn-default cancelar">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>
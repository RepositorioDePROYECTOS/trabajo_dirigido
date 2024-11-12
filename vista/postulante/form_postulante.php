<?php
include("modelo/postulante.php");
?>
<h2>Crear Postulante</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
    <div class="panel-heading">
        <div class="panel-title">
            Nuevo Postulante
        </div>
    </div>
    <div class="panel-body">
        <form name="frm_postulante" id="frm_postulante" action="control/postulante/insertar_postulante.php" method="post" role="form" class="validate form-horizontal form-groups-bordered">
            
            <!-- Nombre -->
            <div class="form-group">
                <label for="nombre" class="col-sm-3 control-label">Nombre</label>
                <div class="col-sm-5">
                    <input type="text" name="nombre" id="nombre" class="form-control required text" data-validate="required" data-message-required="Escriba el nombre" placeholder=""/>
                </div>
            </div>
            
            <!-- Apellido Paterno -->
            <div class="form-group">
                <label for="apellido_paterno" class="col-sm-3 control-label">Apellido Paterno</label>
                <div class="col-sm-5">
                    <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control required text" data-validate="required" data-message-required="Escriba el apellido paterno" placeholder=""/>
                </div>
            </div>

            <!-- Apellido Materno -->
            <div class="form-group">
                <label for="apellido_materno" class="col-sm-3 control-label">Apellido Materno</label>
                <div class="col-sm-5">
                    <input type="text" name="apellido_materno" id="apellido_materno" class="form-control required text" data-validate="required" data-message-required="Escriba el apellido materno" placeholder=""/>
                </div>
            </div>

            <!-- CI -->
            <div class="form-group">
                <label for="CI" class="col-sm-3 control-label">CI</label>
                <div class="col-sm-5">
                    <input type="number" name="CI" id="CI" class="form-control required text" data-validate="required" data-message-required="Escriba el CI" placeholder=""/>
                </div>
            </div>
            
            <!-- Gmail -->
            <div class="form-group">
                <label for="Gmail" class="col-sm-3 control-label">Gmail</label>
                <div class="col-sm-5">
                    <input type="email" name="Gmail" id="Gmail" class="form-control" placeholder=""/>
                </div>
            </div>
            
            <!-- Teléfono -->
            <div class="form-group">
                <label for="telefono" class="col-sm-3 control-label">Teléfono</label>
                <div class="col-sm-5">
                    <input type="number" name="telefono" id="telefono" class="form-control" placeholder=""/>
                </div>
            </div>

            
            <!-- Botones -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    <button type="submit" class="btn btn-info">Registrar</button> 
                    <button type="button" class="btn cancelar">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>

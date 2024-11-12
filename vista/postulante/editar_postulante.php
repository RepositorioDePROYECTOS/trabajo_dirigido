<?php
include("modelo/postulante.php");

$id_postulante = security($_GET['id']);
$postulante = new postulante();
$postulante->get_postulante($id_postulante); 
?>
<h2>Editar Postulante</h2>
<br />
<div class="panel panel-default panel-shadow" data-collapsed="0">
    <div class="panel-heading">
        <div class="panel-title">
            Modificar Postulante
        </div>
    </div>
    <div class="panel-body">
        <form name="frm_postulante" id="frm_postulante" action="control/postulante/editar_postulante.php" method="post" role="form" class="validate_edit form-horizontal form-groups-bordered">
            <input type="hidden" name="id_postulante" id="id_postulante" value="<?php echo $postulante->id_postulante; ?>"/>
            
            <!-- Nombre -->
            <div class="form-group">
                <label for="nombre" class="col-sm-3 control-label">Nombre</label>
                <div class="col-sm-5">
                    <input type="text" name="nombre" id="nombre" class="form-control required text" value="<?php echo $postulante->nombre; ?>" />
                </div>
            </div>

            <!-- Apellido Paterno -->
            <div class="form-group">
                <label for="apellido_paterno" class="col-sm-3 control-label">Apellido Paterno</label>
                <div class="col-sm-5">
                    <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control required text" value="<?php echo $postulante->apellido_paterno; ?>" />
                </div>
            </div>

            <!-- Apellido Materno -->
            <div class="form-group">
                <label for="apellido_materno" class="col-sm-3 control-label">Apellido Materno</label>
                <div class="col-sm-5">
                    <input type="text" name="apellido_materno" id="apellido_materno" class="form-control required text" value="<?php echo $postulante->apellido_materno; ?>" />
                </div>
            </div>

            <!-- CI -->
            <div class="form-group">
                <label for="CI" class="col-sm-3 control-label">CI</label>
                <div class="col-sm-5">
                    <input type="number" name="CI" id="CI" class="form-control required text" value="<?php echo $postulante->CI; ?>" />
                </div>
            </div>
            
            <!-- Gmail -->
            <div class="form-group">
                <label for="Gmail" class="col-sm-3 control-label">Gmail</label>
                <div class="col-sm-5">
                    <input type="email" name="Gmail" id="Gmail" class="form-control" value="<?php echo $postulante->Gmail; ?>" />
                </div>
            </div>
            
            <!-- Teléfono -->
            <div class="form-group">
                <label for="telefono" class="col-sm-3 control-label">Teléfono</label>
                <div class="col-sm-5">
                    <input type="number" name="telefono" id="telefono" class="form-control" value="<?php echo $postulante->telefono; ?>" />
                </div>
            </div>

            <!-- ID Convocatoria -->
            

            <!-- Botones -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    <button type="submit" class="btn btn-info">Guardar</button> 
                    <button type="button" class="btn cancelar">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>

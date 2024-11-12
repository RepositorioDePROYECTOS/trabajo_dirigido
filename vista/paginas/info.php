<div class="row" id="top-datos">		
    <!-- Profile Info -->
	<div class="col-md-12 clearfix">
		<ul class="list-inline links-list pull-left">
			<li class="profile-info dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">							
                    <i class="entypo-user"></i>
					<?php echo $_SESSION[nombre_usuario];  ?> <i class="entypo-down-open"></i>
				</a>
				<ul class="dropdown-menu">
                    <li class="caret"></li>
					<li>
						<a href="?mod=usuario&pag=editar_password&id=<?php echo $_SESSION[id_usuario];  ?>">									
							Modificar Datos
						</a>
					</li>
				</ul>
			</li>
            <li class="sep"></li>
            <li>
                <span><?php echo $_SESSION[nivel];  ?></span>
            </li>
            <?php
                if(isset($_SESSION[gestion])){
                    echo '<li class="sep"></li>';
                    echo "<li>
                            <strong>Gesti&oacute;n: </strong><span>$_SESSION[gestion]</span>
                          </li>";
                }
            ?>
		</ul>
        <ul class="list-inline links-list pull-right">
            <li>
				<a href="control/sesion/cerrar_sesion.php" class="salir btn btn-danger btn-icon">
					Salir <i class="entypo-logout right"></i>
				</a>
			</li>
		</ul>		
	</div>		
	<!-- Raw Links -->
</div>
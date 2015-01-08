				<li>
                        <a href="<?php echo base_url(); ?>panel/">Inicio</a>
                    </li>

                    <li class="dropdown">
               		         <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Facebook <span class="caret"></span></a>
		            	<ul class="dropdown-menu" role="menu">
						<li><a href="<?php echo base_url(); ?>panel/facebook">Cuentas</a></li>
						<li><a href="#">Publicar ahora</a></li>
						<li><a href="#">Programar</a></li>
					</ul>
			
               
                    </li>
                       <li>
                        <a href="<?php echo base_url() ?>panel/twitter">Twitter</a>
                    </li>
		<?php if($privilege_user_app=='prem')
		{
			?>
                    <li>
                        <a href="<?php echo base_url() ?>panel/basesdedatos">Bases de datos</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() ?>panel/anuncios">Anuncios</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() ?>panel/herramientas">Herramientas</a>
                    </li>
             <?php } ?>
		           <li CLASS="dropdown">  
		           	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Usuari <span class="caret"></span></a>
		            	<ul class="dropdown-menu" role="menu">
						<li><a href="<?php echo base_url() ?>panel/auth_public/update_account">Perfil</a></li>
						<li><a href="#">Pagos</a></li>
						<li><a href="#">Planes premuim</a></li>
						<li class="divider"></li>
						<li><a href="#">Salir</a></li>
					</ul>
				</li>
		            

				
				<li> <a href="">RSS</a></li>
				
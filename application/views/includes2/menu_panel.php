				<li>
                        <a href="<?php echo base_url(); ?>panel/">Inicio</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>panel/facebook">Facebook</a>
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
						<li><a href="#">Action</a></li>
						<li><a href="#">Another action</a></li>
						<li><a href="#">Something else here</a></li>
						<li class="divider"></li>
						<li><a href="#">Separated link</a></li>
						<li class="divider"></li>
						<li><a href="#">One more separated link</a></li>
					</ul>
				</li>
		            

				
				<li> <a href="">RSS</a></li>
				<li> <a href="">Salir</a></li>
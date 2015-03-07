				<li>
                        <a href="<?php echo base_url(); ?>panel/">Inicio</a>
                    </li>

                    <li class="dropdown">
               		<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" href="<?php echo base_url() ?>panel/facebook" aria-expanded="false">Facebook <span class="caret"></span></a>
		            	<ul class="dropdown-menu" role="menu">
						<li><a href="<?php echo base_url(); ?>panel/facebook">Cuentas</a></li>
						<li><a href="<?php echo base_url(); ?>panel/facebook/publicar">Publicar ahora</a></li>
						<li><a href="<?php echo base_url(); ?>panel/facebook/programar_facebook">Programar</a></li>
						<?php if($privilege_user_app=='prem')
						{
	
					?>
						<li><a href="<?php echo base_url(); ?>panel/facebook/prog_periodicas">Programaciones periódicas</a></li>
							<?php } ?>
					</ul>
			
               
                    </li>
                       <li  class="dropdown">
               		<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" href="<?php echo base_url() ?>panel/twitter">Twitter <span class="caret"></span></a>
		            	<ul class="dropdown-menu" role="menu">
						<li><a href="<?php echo base_url(); ?>panel/twitter">Cuentas</a></li>
						<li><a href="<?php echo base_url(); ?>panel/twitter/publicar">Publicar ahora</a></li>
						<li><a href="<?php echo base_url(); ?>panel/twitter/programar_twitter">Programar</a></li>
						<?php if($privilege_user_app=='prem')
						{
	
					?>
						<li><a href="<?php echo base_url(); ?>panel/twitter/prog_periodicas">Programaciones periódicas</a></li>
						<?php } ?>

					</ul>
                    </li>

				<li> <a href="<?php echo base_url() ?>panel/rss">RSS</a></li>
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
		           	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $username[0]->upro_first_name; ?> <span class="caret"></span></a>
		            	<ul class="dropdown-menu" role="menu">
						<li><a href="<?php echo base_url() ?>panel/perfil">Perfil</a></li>
						<li><a href="<?php echo base_url() ?>panel/perfil/pagos">Pagos</a></li>
						<li><a href="<?php echo base_url() ?>panel/perfil/planes">Planes premuim</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo base_url() ?>panel/logout">Salir</a></li>
					</ul>
				</li>
						<li><a href="<?php echo base_url() ?>panel/logout">Salir</a></li>

		            

				
				
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
                        <a href="<?php echo base_url() ?>panel/herramientas">herramientas</a>
                    </li>
             <?php } ?>
                    <li>  <!-- OMG NO SEMANTIC HTML, well, it help us to avoid JS in the menu slide in mobile -->

					<a class="link_dropdown" href="">Usuari</a>
                         <ul class="nav--top__list">
				
		            		<li><a href="<?php echo base_url() ?>panel/perfil">Perfil</a></li>
		              <li><a href="">item</a></li>
		              <li><a href="">item</a></li>
		              <li><a href="">item</a></li>
		              <li><a href="">item</a></li>
		          	</ul>

        
                    </li>
				
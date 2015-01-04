<script>
	var base_url='<?php echo base_url()?>'
</script>
    <div id="container">
        <header>
        <div class="container">
            <div class="row">
           <?php if( isset($section_app) && $section_app=='panel')
     		{?>
            <div class="col-sm-4">
            <?php }else{
            	?>
            	  <div class="col-sm-5">
            	<?php
            }
            ?>
                <div class="logo">
                    <h1>

                        <a href="<?php echo base_url_module(); ?>">Autopublicador<span class="color bold"> Social</span></a>
                    </h1>

					<?php 
					if(isset($section_app))
					{ 
						if($section_app=='admin')
						{
						?>
							<h1> Panel de administración</h1>
						<?php
						}
						elseif($section_app=='panel')
						{
						?>
							<h1> Panel de usuario</h1>
						<?php
						}
					}
						?>

                </div>
            </div>
           <?php if( isset($section_app) && $section_app=='panel')
     		{?>
            <div class="col-sm-8">
            <?php }else{
            	?>
            	  <div class="col-sm-7">
            	<?php
            }
            ?>
           

            <div class="navbar bs-docs-nav" role="banner">
            
          <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">

                <ul class="nav navbar-nav navbar-right">
                <?php if(isset($section_app) && $section_app=='admin')
                {
                	$this->load->view('includes2/menu_admin');
           	}
           	else if( isset($section_app) && $section_app=='panel')
     		{
     			$this->load->view('includes2/menu_panel');
   			}else{
   				?>
                <li>
                        <a href="<?php echo base_url(); ?>inicio">Inicio</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>panel/register_account">Regístrese</a>
                    </li>
                       <li>
                        <a href="<?php echo base_url() ?>premium">Premium</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url() ?>panel/login">Acceder</a>
                    </li>
                  <!--  <li>
                        <a href="<?php echo base_url() ?>blog">Blog</a>
                    </li>-->
			<?php }?>
                </ul>

                	</nav>
                    </div>
                </div>
                </div>
                </div>

        </header>
        <div class="sep"></div>


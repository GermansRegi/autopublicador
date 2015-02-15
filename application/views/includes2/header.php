<script>
	var base_url='<?php echo base_url()?>';
	var current_url='<?php echo base_url(uri_string())?>';
</script>
    <main id="container">
        <header>
        <section class="container">
            <section class="row">
           <?php if( isset($section_app) && $section_app=='panel')
     		{?>
            <section class="col-sm-3">
            <?php }else{
            	?>
            	  <section class="col-sm-6">
            	<?php
            }
            ?>
                <section class="logo">
                    <h1>

                        <a href="<?php echo base_url_module(); ?>">Autopublicador<span class="color bold"> Social</span></a>
                    </h1>

					<?php 
					if(isset($section_app))
					{ 
						if($section_app=='admin')
						{
						?>
							<h1 class="subheader"> Panel de administración</h1>
						<?php
						}
						elseif($section_app=='panel')
						{
						?>
							<h1 class="subheader"> Panel de usuario</h1>
						<?php
						}
					}
						?>

                </section>
            </section>
           <?php if( isset($section_app) && $section_app=='panel')
     		{?>
            <section class="col-sm-9">
            <?php }else{
            	?>
            	  <section class="col-sm-6">
            	<?php
            }
            ?>
           

            <section class="navbar bs-docs-nav" role="banner">
            
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
                    </section>
                </section>
                </section>
                </section>

        </header>
        <section class="sep"></section>
		   
            <section class="page-head">
              <section class="container">
                <section class="row">
                  <section class="col-md-12">
                    <h2><?php echo $titlepage?></h2>

                  </section>
                </section>
              </section>
              </section>
			<div class="container-main">
 				<div class="panel panel-default">
					<div class="panel-body">

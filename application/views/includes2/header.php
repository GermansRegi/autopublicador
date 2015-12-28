<script>
	var base_url='<?php echo base_url()?>';
	var current_url='<?php echo base_url(uri_string())?>';
</script>
    <main id="container">
        <header>
        <div class="top-header navbar-fixed-top">
        <div class="container">
            <div class="row">
            <div class="col-xs-12">
                   <div class="Tpl_NavBar">
                       <nav class="navbar navbar-default">
                            <div class="navbar-header">
                              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                              </button>
                                
                            </div>
                            <a  class="navbar-brand" href="<?php echo base_url_module(); ?>"><img src="<?php echo base_url() ?>includes/img/logo_socialsuites.png" width="180" /></a>
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                
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
                                
                            </div>                    
                        </nav>

					<?php /*
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
					}*/
						?>

          
        </header>
        
		   
          	<div class="container-main">
 				<div class="panel panel-default">
					<div class="panel-body">
                    </div>
                </div>
                </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
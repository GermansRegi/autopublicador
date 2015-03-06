<!DOCTYPE html>
<html>
	<head>
	    <title>Socialsuites</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta charset="UTF-8" />
	    <?php echo $this->load->view('includes2/head');?>
	</head>

	<body>
	    <?php echo $this->load->view('includes2/header'); ?>
	    <?php if(count($data['page'])==0 && count($data['user'])==0 && count($data['event'])==0  && count($data[''])==0)
		{
    		?>
			<div class="redbox">
    				<p>
				Para poder publicar debe añadir como mínimo una página de facebook. Desde la opción <?php  echo '<a href="'.base_url().'social_connect/fb_connect">Conectar con Facebook</a>';?>
    				</p>
			</div>
		<?php
		}
		else
		{
		?>
			<form  id='herramfb' action='<?php echo base_url()?>panel/herramientas/limpiador_facebook' method='post'>
			   <div class="message"></div>
			   <div class="col-lg-12">
			   	Con esta herramienta podrás limpiar una cuenta de Facebook.
			   </div>
			   <div class="col-lg-6">
			       <div class="form-group">
			       	<label class="control-label">Selecciona tipo de limpieza</label>
			       	<select class="form-control" name="type">
			       		<option value="1">Limpiar fotos</option>
			       		<option value="2">Limpiar spam</option>
			       		<option value="3">Limpiar todo</option>
			       	</select>
			       </div>
			   </div>
			   <div class="col-lg-6">	       
			       
				<div class="form-group col-lg-12">
					 <label class="control-label ">Cuentas a limpiar:</label>
					  
					<section class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					
					<?php
					
					$arraytypes=array(
						array("name"=>"group","title"=>"Grupos"),
						array("name"=>"user","title"=>"Usuarios"),
						array("name"=>"page","title"=>"Páginas"),
						array("name"=>"event","title"=>"Eventos"));
					for($i=0;$i<count($arraytypes);$i++)
					{
						if(count($data[$arraytypes[$i]["name"]])>0)
						{ 
						?>
							<section class="panel panel-default">
								<section class="panel-heading" role="tab" id="headingOne<?php echo $i; ?>">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $i; ?>" aria-expanded="false" aria-controls="collapseOne<?php echo $i; ?>">
											<?php echo $arraytypes[$i]['title']; ?>
										</a>
									</h4>
								</section>
								<section id="collapseOne<?php echo $i; ?>" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne<?php echo $i; ?>">
									<section class="panel-body">
									<?php
									foreach($data[$arraytypes[$i]['name']] as $page)
									{
										
										echo " <input type='checkbox' name='ck_group_ap[".(($arraytypes[$i]['name']=="user")?'user':'account')."][]' value='".(($arraytypes[$i]['name']=="user")?$page->user_id:$page->idaccount)."' />&nbsp;&nbsp;&nbsp; <span >".(($arraytypes[$i]['name']=="user")?$page->username:$page->name)."</span>&nbsp;&nbsp;<br>";
									}
									?>
									</section>
								</section>
							</section>
						<?php	
						} 
					}
					?>      
				</section>
				
				<section class="col-lg-12">
						<input data-active="active..." data-loading="loading..." data-complete="completed..." type='submit' name='publicar' class="btn btn-primary" value='Limpiar'/>
						<a class="btn btn-default" id='cancel_crear_bbdd' href="<?php echo base_url()?>panel/herramietas" >Cancelar</a>
				</section>
				
			</div>
			</div>
		</form>
    <?php }?>       
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>

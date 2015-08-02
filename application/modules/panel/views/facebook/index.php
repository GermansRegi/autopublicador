<!DOCTYPE html>
<html>
<head>
	<title>Socialsuites</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8" />
	<?php echo $this->load->view('includes2/head');?>
</head>
<body>
	<?php $socialNamesAr=array('face'=>"Facebook","twt"=>"Twitter");$tradArray=array('sentence'=>"Texto",'image'=>'Imágenes','link'=>'Enlaces');
	?>
	<?php echo $this->load->view('includes2/header');
	$arraytypes=array(array("name"=>"user","title"=>"Usuarios"),array("name"=>"group","title"=>"Grupos"),array("name"=>"page","title"=>"Páginas"),array("name"=>"event","title"=>"Eventos"))
	?>
	<div class="clearfix ">
		<div class="col-lg-3"><a href="<?php echo base_url(); ?>panel/facebook/connectar_facebook" class="btn btn-primary">Conectar con Facebook</a></div>
		<div class="col-lg-2"><a class="btn btn-default showHide" >Crear Carpeta</a></div>
		
		<div  class="col-lg-6 divCreateFolder clearfix  hidden"  >
			<form id="createFolder" action="" class="form-horitzonal">
				<div class="message"></div>
				<div class="col-lg-12 form-group">
					<label for="" class="label-control col-lg-4">Nombre:</label>
					<div class="col-lg-7">
						<input name="name" class="form-control" type="text">
					</div>
				</div>
				<div class="col-lg-12 form-group">
					<label for="" class="label-control col-lg-4">Carpeta para:</label>
					<div class="col-lg-7">
						<select name="type" class="select form-control">
							<option value="">Selecciona un tipo</option>
							<option value="event">Eventos</option>
							<option value="user">Usuarios</option>
							<option value="group">Grupos</option>
							<option value="page">Páginas</option>
						</select>
					</div>
				</div>
				<div class="form-group  col-lg-12">
					<input type="submit"  class=" col-lg-offset-5  btn btn-primary" value="Crear carpeta"/>
				</div>
			</form>
		</div>
		
	</div>	
	<div role="tabpanel">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<?php for($i=0;$i<count($arraytypes);$i++){ 

				?>
				
				<li class="<?php echo (($i==0)?"active":""); ?>" role="presentation" >
					<a href="#<?php echo $arraytypes[$i]['name']; ?>" aria-controls="home"  role="tab" data-toggle="tab">
						<?php echo $arraytypes[$i]['title']; ?>
						<span class="badge">
							<?php
							$numc=0;
							for ($m=0;$m<count($arraydata[$arraytypes[$i]['name']]['folders']);$m++)
							{
								$numc=$numc+count($arraydata[$arraytypes[$i]['name']]['folders'][$m]['rows']);
							}
							echo (count($arraydata[$arraytypes[$i]['name']]['nofolder'])+$numc); ?>
						</span>
					</a>
				</li>
				<?php } ?>	
			
		</ul>			
		<!-- Tab panes -->
		<div class="tab-content">
			<?php 
			for($i=0;$i<count($arraytypes);$i++){
				?>
				<div role="tabpanel" class="tab-pane <?php echo (($i==0)? "active":""); ?>" id="<?php echo $arraytypes[$i]['name'];?>">	
					<div class="panel  panel-default">
						
						<div class="panel-body">
							<?php
							//Si es la tab de grups mostrem el boto añadir grupo
							if($arraytypes[$i]['name']=="group")
							{?>
							<div class="clearfix"><a class="btn btn-default showHideAddGroup" >Añadir grupo</a></div>
								<div  class="col-lg-6 divAddGroup clearfix  hidden"  >
									<form id="addGroup" action="" class="form-horitzonal">
										<div class="message2"></div>
										<div class="col-lg-12 form-group">
											<p>Introduzca el identificador del grupo y seleccione el usuario con el que quiere publicar en el grupo. El identificador es el numero de 16 cifras que aparece en la url de facebook del grupo. (Por ejemplo: https://www.facebook.com/groups/1400615130264706/, en éste caso seria: 1400615130264706).</p><p> Para que pueda publicar en el grupo desde socialsuites, el grupo debe tener permisos Público y el usuario seleccionado debe pertenecer al grupo.</p>
										</div>
										<div class="col-lg-12 form-group">
											<label for="" class="label-control col-lg-4">Identificador de grupo:</label>
											<div class="col-lg-7">
												<input name="name" class="form-control" type="text">
											</div>
										</div>
										<div class="col-lg-12 form-group">
											<label for="" class="label-control col-lg-4">Usuario del grupo:</label>
											<div class="col-lg-7">
												<select name="usuario" class="select form-control">
													<option value="">Selecciona un usuario</option>
													<?php 
													foreach ($arraydata['user']['nofolder'] as $pagenofolder) {
														?>
														<option value="<?php echo ((!isset($pagenofolder->idaccount))?$pagenofolder->user_id:$pagenofolder->idaccount); ?>">
														<?php echo ((!isset($pagenofolder->name))?$pagenofolder->username:$pagenofolder->name); ?>
														</option>
														<?php
													 }
													 foreach ($arraydata['user']['folders'] as $folder) {
													 	foreach ($folder['rows'] as $page) {
													 		
													 	
													 	?>
														<option value="<?php echo $page->user_id; ?>">
														<?php echo $page->username; ?>
														</option>
														<?php
														}
													 }

													?>

												</select>
											</div>
										</div>
										<div class="form-group  col-lg-12">
											<input type="submit"  class=" col-lg-offset-5  btn btn-primary" value="Añadir grupo"/>
										</div>
									</form>
								</div>
							</div>
							<?php

							}
							if(count($arraydata[$arraytypes[$i]['name']]['nofolder'])>=0)
							{		
								?>
								<div class="panel panel-default panel-accounts-nofolder">
									<div class="panel-heading"><?php echo $arraytypes[$i]['title']; ?> sin carpeta </div>

									<div class="panel-body ">
										<table class="table table-striped accounts">
											<?php
											foreach ($arraydata[$arraytypes[$i]['name']]['nofolder'] as $pagenofolder) {
												?>
												
												<tr class="item" >
													<td>
														<?php if($arraytypes[$i]['name']!='group'){
	?>
														<img src="http://graph.facebook.com/v2.2/<?php echo ((!isset($pagenofolder->idaccount))?$pagenofolder->user_id:$pagenofolder->idaccount); //$pagenofolder->idaccount ?>/picture?width=50&height=50">
														<?php
													}else{
														$res=file_get_contents('https://graph.facebook.com/v2.2/'.((!isset($pagenofolder->idaccount))?$pagenofolder->user_id:$pagenofolder->idaccount).'?fields?icon&access_token='.$pagenofolder->access_token);
														$res=json_decode($res);
														
													?>
													<img src="<?php echo $res->icon?>">

													<?php }?>

													</td>
													<td class="name">
														<?php echo ((!isset($pagenofolder->name))?$pagenofolder->username:$pagenofolder->name); ?>
													</td>
													<td>
														<a href="https:/www.facebook.com/<?php echo ((!isset($pagenofolder->idaccount))?$pagenofolder->user_id:$pagenofolder->idaccount); ?>" target="_blank" class="btn btn-default btn-ms"><i  class="fa fa-eye"></i></a>
														<!--<a href="<?php echo base_url()?>panel/commonsocial/editar/<?php echo ((!isset($pagenofolder->idaccount))?$pagenofolder->user_id.'/u':$pagenofolder->idaccount.'/a'); ?>" class="btn btn-default btn-ms" data-toggle='ajaxModal'> <i  class="fa fa-edit"></i></a>-->
														<a data-user="<?php echo ((!isset($pagenofolder->idaccount))?'true':'false') ?>" data-id="<?php echo $pagenofolder->id ?>" class="btn btn-danger deleteaccount" data-type="false" data-social="fb"><i class="fa fa-trash-o"></i></a>
														
													</td>
												</tr>

												<?php   			

								        				# code...
											}
											?>
										</table>
									</div>
								</div>
								<?php
							}
							if(count($arraydata[$arraytypes[$i]['name']]['folders'])>0)
							{	

								?>
								<div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
									<?php
									foreach ($arraydata[$arraytypes[$i]['name']]['folders'] as $folder) {
										?>
										<div class="panel panel-default panel-accounts-folder">
											<div class="panel-heading  " role="tab" id="headerfold<?php echo $folder['data']->id; ?>">
												<!--<h4 class=" clearfix panel-title">-->
													<a  class="accordion-toggle clearfix" data-toggle="collapse" data-parent="#accordion" aria-expanded="false" href="#fold<?php echo $folder['data']->id; ?>"  aria-controls="fold<?php echo $folder['data']->id; ?>">
														<span><?php echo $folder['data']->name; ?> <span class="badge"> <?php echo count($folder['rows']); ?></span></span>
														<div class="pull-right btn btn-danger deleteaccount"  data-user="<?php echo (($arraytypes[$i]['name']=="user")?'true':'false'); ?>" data-type="true" data-social="fb"  data-id="<?php echo $folder['data']->id; ?>"><i class="fa fa-trash-o"></i></div>
													</a>

												<!--</h4>-->
											</div>
											
											<div id="fold<?php echo $folder['data']->id; ?>" data-idfolder='<?php echo $folder['data']->id; ?>' class="panel-collapse collapse" role="tabpanel" aria-labelledby="headerfold<?php echo $folder['data']->id; ?>">
											<div class="panel-body">	


										<table class="table table-striped accounts">
											<?php
												foreach ($folder['rows'] as $pagefolder) 
												{
											?>

											<tr  class='folderrow'>
												<td>
													<img src="http://graph.facebook.com/v2.2/<?php echo ((!isset($pagefolder->idaccount))?$pagefolder->user_id:$pagefolder->idaccount);///$pagefolder->idaccount ?>/picture?width=50&height=50">

												</td>
												<td class="name">
												<?php echo ((!isset($pagefolder->name))?$pagefolder->username:$pagefolder->name); ?>
													<!--<?php// echo $pagefolder->name; ?>-->
												</td>
												<td>
													<a href="https:/www.facebook.com/<?php echo ((!isset($pagefolder->idaccount))?$pagefolder->user_id:$pagefolder->idaccount);//$pagefolder->idaccount ?>" target="_blank" class="btn btn-default btn-ms"><i  class="fa fa-eye"></i></a>
													
												 	<a  data-user="<?php echo ((!isset($pagefolder->idaccount))?'true':'false') ?>" data-id="<?php echo $pagefolder->id ?>" data-type="false" data-social="fb" class="btn btn-danger deleteaccount"><i class="fa fa-trash-o"></i></a>
												</td>
											</tr>
											<?php   			
											}
											?>
										</table>
									</div>
								</div>
							</div>
							<?php		
							}
							?>
						</div>
						<?php   			
						}
						?>
					</div>
				</div>
			</div>		
			<?php
			}
			?>	    	
		</div>
	</div>

		<script type="text/javascript">
			var deletecontent_url='<?php echo base_url()?>panel/commonsocial/deletecontent';
			var current_url='<?php echo base_url().$this->uri->uri_string();?>';
			var createfolder_url=base_url+'panel/facebook/createFolder';
			var addgroup_url=base_url+'panel/facebook/addGroup';
		</script>
		<?php
		echo $this->load->view('includes2/footer');
		?>
		<?php echo $this->load->view('includes2/scripts');?>
		 
</html>
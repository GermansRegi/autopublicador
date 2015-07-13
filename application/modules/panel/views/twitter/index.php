<!doctype html>
<html>
<head>
	<title>Socialsuites</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8" />
	<?php echo $this->load->view('includes2/head');?>
</head>
<body>
	
	<?php echo $this->load->view('includes2/header');
	?>
	<div class="clearfix ">
		<div class="col-lg-3"><a href="<?php echo base_url(); ?>panel/twitter/connectar_twitter" class="btn btn-primary">Conectar con Twitter</a></div>
		<div class="col-lg-2"><a class="btn btn-default showHide" >Crear Carpeta</a></div>

		<div  class="col-lg-6 clearfix  hidden"  >
			<form id="createFolder" action="" class="form-horitzonal">
				<div class="message"></div>
				<div class="col-lg-12 form-group">
					<label for="" class="label-control col-lg-4">Nombre:</label>
					<div class="col-lg-7">
						<input name="name" class="form-control" type="text">
					</div>
				</div>
				<!--<div class="col-lg-12 form-group">
					<label for="" class="label-control col-lg-4">Carpeta para:</label>
					<div class="col-lg-7">
						<select name="type" class="select form-control">
							<option value="">Selecciona un tipo</option>
							<option value="event">Event</option>
							<option value="user">Usuario</option>
							<option value="group">Grupo</option>
							<option value="page">Página</option>
						</select>
					</div>
				</div>-->
				<div class="form-group  col-lg-12">
					<input type="submit"  class=" col-lg-offset-5  btn btn-primary" value="Crear carpeta"/>
				</div>
			</form>
		</div>
	</div><?php
							if(count($arraydata['nofolder'])>=0)
							{		
								?>
								<div class="panel panel-default panel-accounts-nofolder">
									<div class="panel-heading">Cuentas sin carpeta </div>

									<div class="panel-body ">
										<table class="table table-striped accounts">
											<?php
											foreach ($arraydata['nofolder'] as $pagenofolder) {
												?>
												
												<tr class="item" >
													<td>
														<img src="<?php echo $pagenofolder->img_profile; ?>">

													</td>
													<td class="name">
														<?php echo $pagenofolder->username; ?>
													</td>
													<td>
														<a href="http://www.twitter.es/<?php echo $pagenofolder->username; ?>" target="_blank" class="btn btn-default btn-ms"><i  class="fa fa-eye"></i></a>
									<!--					<a href="<?php echo base_url()?>panel/commonsocial/editar/<?php echo $pagenofolder->user_id ?>/u" data-toggle='ajaxModal' class="btn btn-default btn-ms"> <i  class="fa fa-edit"></i></a>-->
														<a data-user='true' data-id="<?php echo $pagenofolder->id ?>" class="btn btn-danger deleteaccount" data-type="false" data-social="fb"><i class="fa fa-trash-o"></i></a>
														
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
							
							if(count($arraydata['folders'])>0)
							{	

								?>
								<div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
									<?php
									foreach ($arraydata['folders'] as $folder) {
										?>
										<div class="panel panel-default panel-accounts-folder">
											<div class="panel-heading  " role="tab" id="headerfold<?php echo $folder['data']->id; ?>">
												<!--<h4 class=" clearfix panel-title">-->
													<a class="accordion-toggle clearfix" data-toggle="collapse" data-parent="#accordion" aria-expanded="false" href="#fold<?php echo $folder['data']->id; ?>"  aria-controls="fold<?php echo $folder['data']->id; ?>">
														<span><?php echo $folder['data']->name; ?> <span class="badge"> <?php echo count($folder['rows']); ?></span></span>
														<div class="pull-right btn btn-danger deleteaccount" data-user="true"   data-type="true" data-social="fb"  data-id="<?php echo $folder['data']->id; ?>"><i class="fa fa-trash-o"></i></div>
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
															<img src="<?php echo $pagefolder->img_profile; ?>">

														</td>
														<td class="name">
														<?php echo $pagefolder->username; ?>
															<!--<?php// echo $pagefolder->name; ?>-->
														</td>
														<td>
															<a href="https:/www.twitter.es/<?php echo $pagefolder->username;//$pagefolder->idaccount ?>" target="_blank" class="btn btn-default btn-ms"><i  class="fa fa-eye"></i></a>
															<!--<a href="<?php echo base_url()?>panel/commonsocial/editar/<?php echo $pagefolder->user_id ?>/u" data-toggle='ajaxModal' class="btn btn-default btn-ms"> <i  class="fa fa-edit"></i></a>-->
														 	<a  data-user="true" data-id="<?php echo $pagefolder->id ?>" data-type="false" data-social="fb" class="btn btn-danger deleteaccount"><i class="fa fa-trash-o"></i></a>
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

		<script type="text/javascript">
			var deletecontent_url='<?php echo base_url()?>panel/commonsocial/deletecontent';
			var current_url='<?php echo base_url().$this->uri->uri_string();?>';
			var createfolder_url=base_url+'panel/twitter/createfolder';
		</script>
		<?php
		echo $this->load->view('includes2/footer');
		?>
		<?php echo $this->load->view('includes2/scripts');?>
	</body>
</html>

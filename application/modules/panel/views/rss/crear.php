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
 			
						<section  id='crearrss' class="clearfix">
		 					<section class="col-sm-12">
			 					<form action="<?php echo base_url(); ?>panel/rss/crear" method="post" id="addrss" > 
			 						<section class="message">


			 						</section>

			 						<section class="form-group col-sm-6">
			 							<label class="col-sm-2 control-label">Url:</label>
			 							<section class="col-sm-10">
			 								<input type='text' class="form-control"  name='rss_url'>
			 							</section>
			 						</section>
			 						<section class="form-group col-sm-6">
			 							<label class="col-sm-3 control-label">Frases permanentes:</label>
			 							<section class="col-sm-9">
			 								<textarea name="rss_perm_sentences" class="form-control"></textarea>
			 							</section>
			 						</section>
			 						<section class="form-group col-sm-6">
			 							<label class="col-sm-5 control-label">Cuentas de facebook:</label>
			 							<section class="col-sm-7">
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
																	
																	echo " <input type='checkbox' name='ck_group_ap[fb][".(($arraytypes[$i]['name']=="user")?'user':'account')."][]' value='".(($arraytypes[$i]['name']=="user")?$page->user_id:$page->idaccount)."' />&nbsp;&nbsp;&nbsp; <span >".(($arraytypes[$i]['name']=="user")?$page->username:$page->name)."</span>&nbsp;&nbsp;<br>";
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
											
											
			 							</section>
			 						</section>
			 						<section class="form-group col-md-6">
			 							<label class="control-label col-sm-5">Cuentas de twitter:</label>
			 							<section class="col-sm-7">
			 									<?php
													foreach($userstw as $page)
													{
														
														echo " <input type='checkbox' name='ck_group_ap[tw][]' value='".$page->user_id."' /> <span >".$page->username."</span><br>";
													}
													?>
													
									</section>
			 							</section>
			 							<section class="form-group col-md-9">
			 								<section class="col-sm-9 col-sm-offset-4">
			 									<input id="addbbdd-btn" type="submit"  class="btn btn-primary" name='addnew' value='Crear'>
			 										
			 									</input>
			 									<a  class="btn btn-default" id='cancel_crear_bbdd' href="<?php echo base_url()?>panel/rss">Cancelar'</a>
			 								</section>
			 							</section>      
			 						</section>
			 					</form>
		 					</section>
	 					</section>
 					</section>
				</section>
 			</section>
 		</section>
 		<?php
 		echo $this->load->view('includes2/footer');
 		?>
 		<?php echo $this->load->view('includes2/scripts');?>
 	</body>
 	</html>
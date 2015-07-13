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
			 					<form action="<?php echo base_url(); ?>panel/rss/editar/<?php echo $rssedit->id ?>" method="post" id="addrss" > 
			 						<section class="message">


			 						</section>

			 						<section class="form-group col-sm-6">
			 							<label class="col-sm-2 control-label">Url:</label>
			 							<section class="col-sm-10">
			 								<input type='text' class="form-control"  value="<?php echo $rssedit->url_rss?>" name='rss_url'>
			 							</section>
			 						</section>
			 						<section class="form-group col-sm-6">
			 							<label class="col-sm-3 control-label">Frases permanentes:</label>
			 							<section class="col-sm-9">
			 								<textarea name="rss_perm_sentences" value="" class="form-control"><?php echo nl2br($rssedit->perm_sentences); ?></textarea>
			 							</section>
			 						</section>
			 						<section class="form-group col-sm-6">
			 							<label class="control-label">Cuentas de facebook:</label>
			 									<?PHP
			 									$accordionfb['input']="ck_group_ap[fb]";
			 									$accordionfb['values']=$rssedit->ids_fb;
			 									 ECHO $this->load->view('facebook/accordion_accounts2',$accordionfb);?>
			 						
			 						</section>
			 						<section class="form-group col-md-6">
			 							<label class="control-label col-sm-5">Cuentas de twitter:</label>
			 							<section class="col-sm-7">
			 									<?php
													$accordiontw['input']="ck_group_ap[tw]";
													$accordiontw['values']=$rssedit->ids_twt;
			 									 ECHO $this->load->view('twitter/accordion_accounts2',$accordiontw);
			 						
													?>
													
									</section>
			 							</section>
			 							<section class="form-group col-md-9">
			 								<section class="col-sm-9 col-sm-offset-4">
			 									<input id="addbbdd-btn" type="submit"  class="btn btn-primary" name='addnew' value='Guardar'>
			 									<a class="btn btn-default" id='cancel_crear_bbdd' href="<?php echo base_url()?>panel/rss" >Cancelar</a>
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
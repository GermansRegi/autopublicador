<!DOCTYPE html>
<html>
	<head>
	    <title>Autopublicador Social</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta charset="UTF-8" />
	    <?php echo $this->load->view('includes2/head');?>
	</head>
	<body>
		<?php $socialNamesAr=array('face'=>"Facebook","twt"=>"Twitter");$tradArray=array('sentence'=>"Texto",'image'=>'Imágenes','link'=>'Enlaces');
		?>
	    <?php echo $this->load->view('includes2/header');
	    	$arraytypes=array(array("name"=>"group","title"=>"Grupos"),array("name"=>"page","title"=>"Páginas"),array("name"=>"event","title"=>"Eventos"))
		?>
		       
		<section class="container">
			<section class="row">
				<section class="col-sm-12 panel panel-body">
					<div role="tabpanel">
						<!-- Nav tabs -->
						<ul class="nav nav-tabs" role="tablist">
						  	<?php for($i=0;$i<count($arraytypes);$i++){ ?>
						  		<li role="presentation" ><a href="#<?php echo $arraytypes[$i]['name']; ?>" aria-controls="home" role="tab" data-toggle="tab"><?php echo $arraytypes[$i]['title']; ?></a></li>
						  	<?php } ?>	
						    <!--!<li role="presentation" class="pages"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Páginas</a></li>
						    <li role="presentation"><a href="#groups" aria-controls="profile" role="tab" data-toggle="tab">Grupos</a></li>
						    <li role="presentation"><a href="#events" aria-controls="messages" role="tab" data-toggle="tab">Eventos</a></li>
						    -->
						</ul>			
						<!-- Tab panes -->
			  			<div class="tab-content">
						<?php 
							for($i=0;$i<count($arraytypes);$i++){
								?>
								    <div role="tabpanel" class="tab-pane <?php echo (($i==0)? "active":""); ?>" id="<?php echo $arraytypes[$i]['name'];?>">	
								    		<div class="panel panel-default">
								    			<div class="panel-heading"></div>
											<div class="panel-body">
										    	<?php
										    		if(count($arraydata[$arraytypes[$i]['name']]['nofolder'])>0)
										    		{		
									     	   		?>
									     	   		<table class="table table-striped">
									     	   		<?php
									        			foreach ($arraydata[$arraytypes[$i]['name']]['nofolder'] as $pagenofolder) {
									        				?>
													
													<tr >
														<td>
															<img src="http://graph.facebook.com/v2.2/<?php echo $pagenofolder->idaccount ?>/picture?width=50&height=50">

														</td>
														<td >
															<?php echo $pagenofolder->name; ?>
														</td>
														<td>
															<a href="https:/www.facebook.com/<?php echo $pagenofolder->idaccount ?>" target="_blank" class="btn btn-default btn-ms"><i  class="fa fa-eye"></i></a>
															<a href="<?php echo base_url()?>panel/facebook/editar/<?php echo $pagenofolder->idaccount ?>" class="btn btn-default btn-ms"> <i  class="fa fa-edit"></i></a>
															<a  data-id="<?php echo $pagenofolder->id ?>" class="btn btn-danger deletefbaccount"><i class="fa fa-trash-o"></i></a>
															
														</td>
													</tr>

									        			<?php   			

									        				# code...
									        			}
									        			?>
									        			</table>
									        			<?php

									        			
									        			

									        		}
									        		if(count($arraydata[$arraytypes[$i]['name']]['folders'])>0)
									        		{	

									        			?>
									        			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
										        			<?php
										        			foreach ($arraydata[$arraytypes[$i]['name']]['folders'] as $folder) {
										        				?>
																<div class="panel panel-default">
																    <div class="panel-heading" role="tab" id="headerfold<?php echo $folder['data']->id; ?>">
																      <h4 class=" clearfix panel-title">
																        <a data-toggle="collapse" data-parent="#accordion" href="#fold<?php echo $folder['data']->id; ?>"  aria-controls="fold<?php echo $folder['data']->id; ?>">
																          <?php echo $folder['data']->name; ?>

																        </a>
																        <div class="pull-right btn btn-danger delete" data-type="true" data-social="fb" data-id="<?php echo $folder['data']->id; ?>"><i class="fa fa-trash-o"></i></div>
																      </h4>
																    </div>
																    <div id="fold<?php echo $folder['data']->id; ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headerfold<?php echo $folder['data']->id; ?>">
																      <div class="panel-body">
																        
																        	
															     	   		<table class="table table-striped">
															     	   		<?php
															        			foreach ($folder['rows'] as $pagefolder) {
															        				?>
																			
																			<tr id="line<?php echo $pagefolder->id ?>">
																				<td>
																					<img src="http://graph.facebook.com/v2.2/<?php echo $pagefolder->idaccount ?>/picture?width=50&height=50">

																				</td>
																				<td >
																					<?php echo $pagefolder->name; ?>
																				</td>
																				<td>
																					<a href="https:/www.facebook.com/<?php echo $pagefolder->idaccount ?>" target="_blank" class="btn btn-default btn-ms"><i  class="fa fa-eye"></i></a>
																					<a href="<?php echo base_url()?>panel/facebook/editar/<?php echo $pagefolder->idaccount ?>" class="btn btn-default btn-ms"> <i  class="fa fa-edit"></i></a>
																					<a data-id="<?php echo $pagefolder->id ?>" data-type="false" data-solial="fb" class="btn btn-danger delete"><i class="fa fa-trash-o"></i></a>
																					
																				</td>
																			</tr>

															        			<?php   			

															        				# code...
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
					</section>
					</section>
			 <!--   <div role="tabpanel" class="tab-pane active" id="pages">
			    		
				

			    </div>
			    <div role="tabpanel" class="tab-pane" id="groups">
			    	      <table class="table table-striped">
				        	<?php 
				     
				        		foreach ($groups as $page)
				        		{
				        		?>
								<tr id="line<?php echo $page->id ?>">
									<td>
										<img src="http://graph.facebook.com/v2.2/<?php echo $page->idaccount ?>/picture?width=50&height=50">;

									</td>
									<td >
										<?php echo $page->name; ?>
									</td>
									<td>
										<a href="https:/www.facebook.com/<?php echo $page->idaccount ?>" target="_blank" class="btn btn-default btn-ms"><i  class="fa fa-eye"></i></a>
										<a href="<?php echo base_url()?>panel/facebook/editar/<?php echo $page->idaccount ?>" class="btn btn-default btn-ms"> <i  class="fa fa-edit"></i></a>
										<a data-id="<?php echo $page->id ?>" class="btn btn-danger deletefb"><i class="fa fa-trash-o"></i></a>
										
									</td>
								</tr>
				        			<?php
				        			
				        		}
				        	?>
				        </table>
				      
			    </div>
			    <div role="tabpanel" class="tab-pane" id="messages">
						<table class="table table-striped">
				        	<?php 
				       
				        		foreach ($events as $page)
				        		{
				        			?>
								<tr id="line<?php echo $page->id ?>">
									<td>
										<img src="http://graph.facebook.com/v2.2/<?php echo $page->idaccount ?>/picture?width=50&height=50">;

									</td>
									<td >
										<?php echo $page->name; ?>
									</td>
									<td>
										<a href="https:/www.facebook.com/<?php echo $page->idaccount ?>" target="_blank" class="btn btn-defaultbtn-ms"><i  class="fa fa-eye"></i></a>
										<a href="<?php echo base_url()?>panel/facebook/editar/<?php echo $page->idaccount ?>" class="btn btn-default btn-ms"> <i  class="fa fa-edit"></i></a>
										<a data-id="<?php echo $page->id ?>" class="btn btn-danger deletefb"><i class="fa fa-trash-o"></i></a>
										
									</td>
								</tr>
				        			<?php
				        		}
				        	?>
				        </table>
				      
			    </div>
			    <div role="tabpanel" class="tab-pane" id="settings">...</div>
			  </div>
-->
			</div>
				      
				      
	</section>
</section>              
<script type="text/javascript">
	var deletecontent_url='<?php echo base_url()?>panel/facebook/deletecontent';
	var current_url='<?php echo base_url().$this->uri->uri_string();?>';
</script>

<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>
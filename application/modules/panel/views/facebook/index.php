<!DOCTYPE html>
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

	?>
       
<section class="container">
	<section class="row">
		<section class="col-sm-12">
			

				<section class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				  
				
				  <section class="panel panel-default">
				    <section class="panel-heading" role="tab" id="headingOne">
				      <h4 class="panel-title">
				        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
				          Páginas
				        </a>
				      </h4>
				    </section>
				    <section id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
				      <section class="panel-body">
				        <table class="table table-striped">
				        	<?php 
				        
				        		foreach ($pages as $page)
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
				      </section>
				    </section>
				  </section>
				  <section class="panel panel-default">
				    <section class="panel-heading" role="tab" id="headingTwo">
				      <h4 class="panel-title">
				        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
				          Grupos
				        </a>
				      </h4>
				    </section>
				    <section id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
				      <section class="panel-body">
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
				      </section>
				    </section>
				  </section>
				  <section class="panel panel-default">
				    <section class="panel-heading" role="tab" id="headingThree">
				      <h4 class="panel-title">
				        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
				          Eventos
				        </a>
				      </h4>
				    </section>
				    <section id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
				      <section class="panel-body">
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
				        
				      </section>
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
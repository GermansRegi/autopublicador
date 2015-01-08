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
			<form action="<?php echo base_url();?>panel/facebook/anadir_paginas" method="POST">

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
				        	$i=0;
				        		foreach ($pages as $page)
				        		{
				        			?>
								<tr>
									<td>
										<img src="http://graph.facebook.com/v2.2/<?php echo $page->id ?>/picture?width=50&height=50">;

									</td>
									<td >
										<?php echo $page->name; ?>
									</td>
									<td>
										<input type="hidden" name='page[<?php echo $i; ?>][id]' value="<?php echo $page->id; ?>">
											<input type="hidden" name='page[<?php echo $i; ?>][access_token]' value="<?php echo $page->access_token; ?>">
											<input type="hidden" name='page[<?php echo $i; ?>][name]' value="<?php echo $page->name; ?>">
										<input type="checkbox" value="0" name="page[<?php echo $i; ?>][checked]"  >
									</td>
								</tr>
				        			<?php
				        			$i++;
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
				        	$i=0;
				        		foreach ($groups as $page)
				        		{
				        			?>
								<tr>
									<td>
										<img src="http://graph.facebook.com/v2.2/<?php echo $page->id ?>/picture?width=50&height=50">;

									</td>
									<td >
										<?php echo $page->name; ?>
									</td>
									<td>
										<input type="hidden" name='group[<?php echo $i; ?>][id]' value="<?php echo $page->id; ?>">
											<!--<input type="hidden" name='groups[<?php echo $i; ?>][access_token]' value="<?php echo $page->access_token; ?>">-->
											<input type="hidden" name='group[<?php echo $i; ?>][name]' value="<?php echo $page->name; ?>">
										<input type="checkbox" value="0" name="group[<?php echo $i; ?>][checked]"  >
									</td>
								</tr>
				        			<?php
				        			$i++;
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
				        	$i=0;
				        		foreach ($events as $page)
				        		{
				        			?>
								<tr>
									<td>
										<img src="http://graph.facebook.com/v2.2/<?php echo $page->id ?>/picture?width=50&height=50">;

									</td>
									<td >
										<?php echo $page->name; ?>
									</td>
									<td>
										<input type="hidden" name='event[<?php echo $i; ?>][id]' value="<?php echo $page->id; ?>">
										
											<input type="hidden" name='event[<?php echo $i; ?>][name]' value="<?php echo $page->name; ?>">
										<input type="checkbox" value="0" name="event[<?php echo $i; ?>][checked]"  >
									</td>
								</tr>
				        			<?php
				        			$i++;
				        		}
				        	?>
				        </table>
				        
				      </section>
				    </section>
				  </section>
				</section>
				<input type="submit" name="submit" value="Añadir Páginas">
				<a href=""> cancelar</a>
			</form>

		</section>
	</section>
</section>              
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>
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
       
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<form action="<?php echo base_url();?>panel/facebook/anadir_paginas" method="POST">

				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				  
				  <?php
			
		///		  $array=array("sections"=>array("Páginas","Grupos","Eventos"),"sendSecction"=>array("pages",));?>

				  <div class="panel panel-default">
				    <div class="panel-heading" role="tab" id="headingOne">
				      <h4 class="panel-title">
				        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
				          Páginas
				        </a>
				      </h4>
				    </div>
				    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
				      <div class="panel-body">
				        <table class="table table-striped">
				        	<?php 
				        	$i=0;
				        		foreach ($pages['data'] as $page)
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
										<input type="hidden" name='pages[<?php echo $i; ?>][id]' value="<?php echo $page->id; ?>">
											<input type="hidden" name='pages[<?php echo $i; ?>][access_token]' value="<?php echo $page->access_token; ?>">
											<input type="hidden" name='pages[<?php echo $i; ?>][name]' value="<?php echo $page->name; ?>">
										<input type="checkbox" value="0" name="pages[<?php echo $i; ?>][checked]"  >
									</td>
								</tr>
				        			<?php
				        			$i++;
				        		}
				        	?>
				        </table>
				      </div>
				    </div>
				  </div>
				  <div class="panel panel-default">
				    <div class="panel-heading" role="tab" id="headingTwo">
				      <h4 class="panel-title">
				        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
				          Grupos
				        </a>
				      </h4>
				    </div>
				    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
				      <div class="panel-body">
				            <table class="table table-striped">
				        	<?php 
				        	$i=0;
				        		foreach ($groups['data'] as $page)
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
										<input type="hidden" name='groups[<?php echo $i; ?>][id]' value="<?php echo $page->id; ?>">
											<!--<input type="hidden" name='groups[<?php echo $i; ?>][access_token]' value="<?php echo $page->access_token; ?>">-->
											<input type="hidden" name='groups[<?php echo $i; ?>][name]' value="<?php echo $page->name; ?>">
										<input type="checkbox" value="0" name="groups[<?php echo $i; ?>][checked]"  >
									</td>
								</tr>
				        			<?php
				        			$i++;
				        		}
				        	?>
				        </table>
				      </div>
				    </div>
				  </div>
				  <div class="panel panel-default">
				    <div class="panel-heading" role="tab" id="headingThree">
				      <h4 class="panel-title">
				        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
				          Eventos
				        </a>
				      </h4>
				    </div>
				    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
				      <div class="panel-body">
				      	<table class="table table-striped">
				        	<?php 
				        	$i=0;
				        		foreach ($events['data'] as $page)
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
										<input type="hidden" name='events[<?php echo $i; ?>][id]' value="<?php echo $page->id; ?>">
										
											<input type="hidden" name='events[<?php echo $i; ?>][name]' value="<?php echo $page->name; ?>">
										<input type="checkbox" value="0" name="events[<?php echo $i; ?>][checked]"  >
									</td>
								</tr>
				        			<?php
				        			$i++;
				        		}
				        	?>
				        </table>
				        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
				      </div>
				    </div>
				  </div>
				</div>
				<input type="submit" name="submit" value="Añadir Páginas">
				<a href=""> cancelar</a>
			</form>

		</div>
	</div>
</div>              
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>
<!DOCTYPE html>
<head>

    <title>Autopublicador Social</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="UTF-8" />
    <?php echo $this->load->view('includes2/head');?>




</head>

<body>
<?php $socialNamesAr=array('face'=>"Facebook","twt"=>"Twitter");$tradArray=array('sentence'=>"Texto",'image'=>'Imágenes','link'=>'Enlaces');
$arr=array("group","user","event","page")
?>
    <?php echo $this->load->view('includes2/header');

	?>
       
<section class="container">
	<section class="row">
		<section class="panel panel-default">
		<div class="col-lg-12 panel panel-body">
			<form action="<?php echo current_url(); ?>" class="form-horizontal" method="POST">
				<section class="col-lg-6">
					<div class="form-group ">
						<label class="col-lg-12" for="">Fecha i Hora</label>
						<div class="col-lg-12">
							<input type="date"><input type="time">
						</div>
					</div>
					<div class="form-group ">
						<label class="col-lg-12"for="">Texto a programar</label>
						<div class="col-lg-12">
							<textarea name="" id="" cols="30" rows="10"></textarea>
						</div>
					</div>
					<div class="form-group ">
						<label class=" col-lg-12s" for="">Selecciona las paguinas de Fabebook</label>
						<div class="col-lg-12">
							<section class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
							<?php  for($m=0;$m<count($arr);$m++){
								?>
         
									  <section class="panel panel-default">
									    <section class="panel-heading" role="tab" id="headingOne">
									      <h4 class="panel-title">
									        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
									          <?php echo $arr[$m]; ?>
									        </a>
									      </h4>
									    </section>
									    <section id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
									      <section class="panel-body">
					                    
								<?php
								for($i=0;$i<count($user_accounts);$i++){ 
									
								?>
								<?php 
					                        if($user_accounts[$i]->type_account==$arr[$m])
					                        {
								?><input name="accounts[]" value="<?php echo $user_accounts[$i]->id; ?>" type="checkbox">	<?php					                                  
					                               /*     foreach($pages as $page)
					                                    {
					                                            echo " <input type='checkbox' name='ck_group_ap[]' value='".$page->idaccount."' />&nbsp;&nbsp;&nbsp; <span >".$page->name."</span>&nbsp;&nbsp;<br>";
					                                            
					                                    }*/
					                                    }
					                                     ?>              
                        


							<?php } ?>
							      </section>
									    </section>
									  </section>
									<?php } ?>

							</section>		
						</div>
					</div>
				</section>
				<section class="col-lg-6">
					
				</section>	
				</form>
			</section>
		</div>
		</section>
	</section>
</section>              
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</
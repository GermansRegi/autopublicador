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
      

	<form method="post" id="periodicasmultiple" action="<?php echo base_url()?>panel/twitter/prog_periodicas" >
		<div class="message">
			
		</div>
		<div role="tabpanel">
			<ul class="nav nav-tabs nav-justified" role="tablist"> 
				<li role="presentation" class="active"><a href="#bbdd" role="tab" aria-controls="bbdd" data-toggle="tab">Bases de datos</a></li> 
				<li role="presentation" ><a href="#anuncios" role="tab" aria-controls="anuncios" data-toggle="tab">Bases de anuncios</a></li> 
			</ul>
			
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="bbdd">  
					<div class="row">
						<div class="col-sm-6"> 
							<strong> Bases de datos</strong><br>
							<select name="datos[asociard][]" multiple="" style="width:270px;" class="form-control">
								<option value="">Selecciona una opción</option>
									<?php foreach ($basesdedatos as $bd)
									{

										echo "<option value='".$bd->id."'>".$bd->name."</option>";



									}
									?>
										</select>                
						</div>
						<div class="col-sm-6">
							<strong>Frecuencia</strong><br>
							<select name="datos[frecuencia]" class="form-control">
								<option  value="0">Selecciona una opción</option>
								<option  value="0.02">2 minutos</option>
								<option  value="0.10">10 minutos</option>
								<option value="0.15">15 minutos</option>
								<option value="0.20">20 minutos</option>
								<option value="0.30">30 minutos</option>
								<option value="1">1 hora</option>
								<option value="2">2 horas</option>
								<option value="3">3 horas</option>
								<option value="4">4 horas</option>
								<option value="6">6 horas</option>
								<option value="12">12 horas</option>
								<option value="24">24 horas</option>			

								

							
							</select> 
							
							

						</div>

					</div>
				
					<div class="row">
						<div class="col-sm-12">
								<strong>Frases permantentes</strong><br>
								<textarea  class="form-control" name="datos[frases_perm]"></textarea>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 text-center">
							<strong>¿Qué días quieres publicar?</strong><br>
							<?php 
							
						
							$DAYS=array("lunes","martes","miércoles","jueves","viernes","sábado","domingo");
							for($i=0;$i<count($DAYS);$i++){ 
								
																?>

								<input type="checkbox" name="datos[diasp][]" class="diasp" value="<?php echo $DAYS[$i] ?>"/> <?php echo ucfirst($DAYS[$i]); ?>
							<?php } ?>
						
				         </div>

					</div>
					
					<div class="row">
						<div class="col-sm-12 text-center">
							<strong>Horas publicación:</strong><br>
							<div class="row">
								<div class="col-sm-6">
									<strong>De </strong><br>
									<select name="datos[hora_inicio]" class="form-control">
										
				                        <?php for($i=1;$i<25;$i++)
				                        {
				                            
				                                echo sprintf("<option value='%02s'>%02d:00</option>",$i,$i);
				                                
				                        }
				                        ?>
									</select>
								</div>

								
								<div class="col-sm-6">
									<strong> a </strong><br>
									<select name="datos[hora_fin]" class="form-control">
									
					                        <?php for($i=1;$i<25;$i++)
					                        {
					                            
					                                echo sprintf("<option value='%02s'>%02d:00</option>",$i,$i);
					                                
					                        }
					                        ?>
					                        </select>
								</div>
							</div>
						</div>
					</div>
					<div class="row"	>
						<div class="col-lg-3">
							<input type="submit" name='datos[enviar]' value="Guardar Bases de datos" class="btn btn-primary">
						</div>
						<div class="col-lg-9">
							<label class="control-label ">Cuentas:</label>
					  
								<section >
								<?php
									foreach($users as $page)
									{
										
										echo " <input type='checkbox' name='datos[user][]' value='".$page->user_id."' /> <span >".$page->username."</span><br>";
									}
									?>
									
						</div>
						
					</div>
					<div class="row">
						<table class="table table-striped">
							<thead>
								<tr>
									<td>Programaciones periodicas de bases de datos </td><td></td>
								</tr>
							</thead>
							<tbody>
								<?php 
								foreach ($autoprog['basededatos'] as $prog) {
									echo "<tr>";
									echo "<td>".$prog->name."</td>";
									?>
									<td><a href="<?php echo base_url()?>panel/commonsocial/editar_basesdedatos/<?php echo $prog->accountid.(($prog->type=='user')?'/u':'/a').'/'.$prog->id; ?>" class="btn btn-default btn-ms" data-toggle='ajaxModal'> <i  class="fa fa-edit"></i></a>
										<a  class="btn btn-danger deleteautoprog" data-account-id="<?php echo $prog->accountid?>" data-type-prog='basededatos' data-prog-id="<?php  echo $prog->id; ?>"  > <i  class="fa fa-trash-o"></i></a>
									</td>
									<?php
									echo "</tr>";
								}
								?>
							</tbody>
						</table>		
					</div>
					
				</div>
				<div role="tabpanel" class="tab-pane" id="anuncios">  
					<div class="row">
						<div class="col-sm-4"> 
							<strong> Bases de datos</strong><br>
							<select name="anuncios[asociard]"   class="form-control">
								<option value="">Selecciona una opción</option>
							            <?php foreach ($anuncios as $an)
				                         {
				                                
				                                   echo "<option value='".$an->id."'>".$an->name."</option>";
				                                
				                            
				                           
				                        }?>
								
							</select>       
										
							
							
						
	    
						</div>
						<div class="col-sm-4">
							<strong>Frecuencia</strong><br>
							<select name="anuncios[frecuencia]" class="form-control">
								
								<option  value="0">Selecciona una opción</option>
								<option  value="0.02">2 minutos</option>
								<option  value="0.10">10 minutos</option>
								<option value="0.15">15 minutos</option>
								<option value="0.20">20 minutos</option>
								<option value="0.30">30 minutos</option>
								<option value="1">1 hora</option>
								<option value="2">2 horas</option>
								<option value="3">3 horas</option>
								<option value="4">4 horas</option>
								<option value="6">6 horas</option>
								<option value="12">12 horas</option>
								<option value="24">24 horas</option>			
								
							</select>               
						</div>
						<div class="col-sm-4">
							<strong>Frecuencia de borrado</strong><br>
							<select name="anuncios[frecuencia_borrado]" class="form-control">
							 <option  value="0">Selecciona una opción</option>
							 	<option  value="0.02">2 minutos</option>
								<option  value="0.10">10 minutos</option>
								<option value="0.15">15 minutos</option>
								<option value="0.20">20 minutos</option>
								<option value="0.30">30 minutos</option>
								<option value="1">1 hora</option>
								<option value="2">2 horas</option>
								<option value="3">3 horas</option>
								<option value="4">4 horas</option>
								<option value="6">6 horas</option>
								<option value="12">12 horas</option>
								<option value="24">24 horas</option>			

							</select>               

						</div>
							
					</div>
					
					<div class="row">
						<div class="col-sm-12">
								<strong>Frases permantentes</strong><br>
								<textarea class="form-control" name="anuncios[frases_perm]"></textarea>

						</div>

					</div>
					<div class="row">
						<div class="col-sm-12 text-center">
							<strong>¿Qué días quieres publicar?</strong><br>
							<?php 
							
							
							
							$DAYS=array("lunes","martes","miércoles","jueves","viernes","sábado","domingo");
							for($i=0;$i<count($DAYS);$i++){ 
								?>
							
								<input type="checkbox" name="anuncios[diasp][]" class="diasp" value="<?php echo $DAYS[$i] ?>"/> <?php echo ucfirst($DAYS[$i]); ?>
							<?php } ?>
						</div>

					</div>
					<br>
					<div class="row">
						<div class="col-sm-12 text-center">
							<strong>Horas publicación:</strong><br>
							<div class="row">
								<div class="col-sm-6">
									<strong>De </strong><br>
									<select name="anuncios[hora_inicio]" class="form-control">
										
				                        <?php for($i=1;$i<25;$i++)
				                        {
				                                echo sprintf("<option value='%02s'>%02d:00</option>",$i,$i);
				                                
				                        }
				                        ?>
									</select>
								</div>
								<div class="col-sm-6">
									<strong> a </strong><br>
									<select name="anuncios[hora_fin]" class="form-control">
									
					                        <?php for($i=1;$i<25;$i++)
					                        {
					                            
					                                echo sprintf("<option value='%02s'>%02d:00</option>",$i,$i);
					                                
					                        }
					                        ?>
									</select>
								</div>
							</div>
						
						</div>
					</div>
					<div class="row">
						<div class="col-lg-3">
							<input type="submit" name='anuncios[enviar]' value="Guardar bases de  anuncios" class="btn btn-primary">
						</div>
						<div class="col-lg-9">
							 <label class="control-label ">Cuentas:</label>
					  
								<section >
								<?php
									foreach($users as $page)
									{
										
										echo " <input type='checkbox' name='anuncios[user][]' value='".$page->user_id."' /> <span >".$page->username."</span><br>";
									}
									?>
									
				   
						</div>
						
					</div>
					<div class="row">
						<table class="table table-striped">
					<thead>
						<tr>
							<td>Programaciones periodicas de anuncios</td><td></td>
						</tr>
					</thead>
					<tbody>
						<?php 
						foreach ($autoprog['anuncios'] as $prog) {
							echo "<tr>";
							echo "<td>".$prog->name."</td>";
							?>
							<td><a href="<?php echo base_url()?>panel/commonsocial/editar_anuncios/<?php echo $prog->accountid.(($prog->type=='user')?'/u':'/a').'/'.$prog->id; ?>" class="btn btn-default btn-ms" data-toggle='ajaxModal'> <i  class="fa fa-edit"></i></a>
								<a  class="btn btn-danger deleteautoprog btn-ms" data-account-id="<?php echo $prog->accountid?>" data-type-prog='anuncios' data-prog-id="<?php  echo $prog->id; ?>" > <i  class="fa fa-trash-o"></i></a>
							</td>
							<?php
							echo "</tr>";
						}
						?>
					</tbody>
			</table>			
					</div>
				</div> 
			</div>
		</div>

	
		<div class="col-lg-12">
		</div>

	</form>
	
		<div class="col-lg-6">
			
		</div>



<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>
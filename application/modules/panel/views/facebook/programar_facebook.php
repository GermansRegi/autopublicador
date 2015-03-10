<!DOCTYPE html>
<head>

    <title>Socialsuites</title>

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
       
			<form id="programar" action="<?php echo current_url(); ?>" method="POST">
			<div class="message"></div>
				<section class="col-lg-6">
					<div class="form-group ">
						<label class="col-lg-12" for="">Fecha y Hora</label>
						<div class="col-lg-6">
						<?php
								$fecha=new DateTime('now',new DatetimeZone($this->session->userdata('timezone')));
					
									
						 ?>
							<div class="input-group date">
							<input class='form-control' value="<?php echo $fecha->format('d-m-Y'); ?>" name='date' type="text">
							<span class="input-group-addon"><i class="fa fa-th"></i></span>
							</div>
						</div>
						<div class="col-lg-6">
						
							<div class=" input-group" id="time">
							<input class='form-control'  value="<?php echo $fecha->format('H:i'); ?>" name='time'  type="text">
							<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group ">
						<label class="col-lg-12" for="">Frecuencia de borrado(opcional)</label>
						<div class="col-lg-12">
							<select class='form-control' name="fechaBorrado">
	               				<option value="">Seleccione borrado</option>
               	                    <option value="0.02">2 minutos</option>
								<option value="0.1">10 minutos</option>
								<option value="0.15">15 minutos</option>
								<option value="0.30">30 minutos</option>
								<option value="1">1 hora</option>
								<option value="2">2 horas</option>
								<option value="3">3 horas</option>
								<option value="4">4 horas</option>
								<option value="5">5 horas</option>
								<option value="6">6 horas</option>
								<option value="8">8 horas</option>
								<option value="10">10 horas</option>
								<option value="12">12 horas</option>
								<option value="14">14 horas</option>
								<option value="16">16 horas</option>
								<option value="18">18 horas</option>
								<option value="20">20 horas</option>
								<option value="22">22 horas</option>
								<option value="24">24 horas</option>
								<option value="30">30 horas</option>
								<option value="36">36 horas</option>
								<option value="40">40 horas</option>
								<option value="44">44 horas</option>
								<option value="48">48 horas</option>

							</select>
								
						</div>
						
					</div>
					

					<div class="form-group ">
						<label class="col-lg-12"for="">Texto a programar</label>
						<div class="col-lg-12">
							<textarea name="texto_facebook" class='form-control' ></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class=" col-lg-12 control-label">Imagen(jpg,png,gif):</label>
						<div class="col-lg-12">
				            <input class='filestyle' data-buttonText="Escoja una imagen" data-buttonName="btn-default" data-icon="false" class="filestyle" accept="image/x-png,image/png, image/gif, image/jpeg , image/jpg" type='file' id="filetoup"  name='imagen'>
				             <a href="" id="clearFile">Eliminar imagen a publicar</a>
				           </div>
					</div>
					<div class="form-group">
						<label class=" col-lg-12 control-label">Enlace:</label>
				           <div class="col-lg-12 ">
				           	<input class='form-control' type='text' name='link'>
				           </div>
					</div>
				</section>
				<div class="col-lg-6">
						<div class="form-group">
							<label class=" col-lg-12 control-label">Anuncios:</label>
					          <div class="col-lg-12">
					               <select data-typeselect="anuncis" class='form-control generate-select' name="anuncis" id="select-anuncis"  >
					        			<option value=''> Seleccione una base de datos de anuncios</option>
					           		<?php
					                    foreach ($anuncios as $anunci)
					                    {
					                         echo "<option value='".$anunci->id."'>".$anunci->name."</option>";
					                    }
					           		?>
					               </select>
					          	<div id="generate-anuncis"></div>
					          </div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-12 ">Bases de datos:</label>
					           <div class="col-lg-12">
					           
						           <select data-typeselect="bbdd" class='form-control generate-select' name="bbdd"  id="select-bbdd" >
							          <option value=''> Seleccione una base de datos</option>
						       		<?php
						               foreach ($basesdedatos as $bbdd)
						               {
						                   echo "<option value='".$bbdd->id."'>".$bbdd->name."</option>";
						             	}
						       		?>
						          </select>
						     	<div id="generate-bbdd"></div>
						     </div>
						</div>
						<div class="form-group col-lg-12">
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
																	echo " <input type='checkbox' name='ck_group_ap[".(($arraytypes[$i]['name']=="user")?'user':'account')."][]' value='".(($arraytypes[$i]['name']=="user")?$page->user_id:$page->idaccount)."' />&nbsp;&nbsp;&nbsp; <span >".(($arraytypes[$i]['name']=="user")?$page->username:$page->name)."</span>&nbsp;&nbsp;<br>";
											}
											?>
											</section>
										</section>
									</section>
								<?php	
								} 
							}
							?>      
						</div>
						<section class="col-lg-12">
								<input type='submit' name='publicar' class="btn btn-primary" value='Programar'/>
						</section>
						<div>
							<p>Facebook no permite publicar en una misma publicación imágenes y enlaces</p>
						</div>
					</div>	
					</form>
					<div class="col-lg-12">
						<?php if(count($programaciones)>0)
						{?>
						<table class="table table-striped">
							<thead>
								<tr>
									<td>Cuenta</td><td>Fecha</td><td>	Fecha Borrado</td><td>Estado</td><td></td>
								</tr>	
							</thead>
							<tbody>

								<?php
								$arrayStates=array('process'=>'En proceso','finished'=>"Terminado",'finisherase'=>'Terminado','nocomplete'=>"No completado",'toerase'=>'Pendiente de borrar'); 
								foreach ($programaciones as $prog) {
								?>
									<tr>
									<td><?php echo $prog->name ?></td>
									<td><?php 

									$fecha=new DateTime("@".$prog->fecha);
									$fecha->setTimezone(new DateTimezone($this->session->userdata('timezone')));
									if(!empty($prog->fechaBorrado))
									{
										$fechaB=new DateTime("@".$prog->fechaBorrado);
										$fechaB->setTimezone(new DatetimeZone($this->session->userdata('timezone')));
									}
									else
									{
										$fechaB=null;
									}

									echo $fecha->format('d-m-Y H:i:s');?></td>
									<td><?php echo (isset($fechaB)?$fechaB->format('d-m-Y H:i:s'):'-')?></td>
									<td><?php echo $arrayStates[$prog->state]; ?></td>
									<td>
										<div class="btn-group" role="group">
											 <a href="<?php echo base_url()?>panel/commonsocial/ver_programacion/<?php echo $prog->id;?>" data-toggle="ajaxModal" class="btn btn-primary" role="button" >Ver </a><a data-id="<?php echo $prog->id; ?>" role="button" class="btn deleteprog btn-danger" ><i class="fa fa-trash-o"></i></a></td>
										</div>

									</tr>

								<?php } ?>
								

							</tbody>
						</table>
						<?php
						}
						?>
					</div>

<script type="text/javascript">

	var current_url='<?php echo base_url().$this->uri->uri_string();?>';
</script>

<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>
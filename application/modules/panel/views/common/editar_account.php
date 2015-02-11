<form method="post" action="<?php echo $url ?>" >
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">Editando <?php echo (($accountedit->type=='user')?" el usuario":" la cuenta").": ".(($accountedit->type=='user')?$accountedit->username:$accountedit->name); ?></h4>
	</div>
	<div class="modal-body">
		<div id="resultsave">
			
		</div>
		<ul class="nav nav-tabs nav-justified"> 
			<li role="presentation" class="active"><a href="#bbdd" role="tab" aria-controls="bbdd" data-toggle="tab">Bases de datos</a></li> 
			<li role="presentation" ><a href="#anuncios" role="tab" aria-controls="anuncios" data-toggle="tab">Bases de anuncios</a></li> 
		</ul>
		<div class="panel-body"> 
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="bbdd">  
					<div class="row">
						<div class="col-sm-6"> 
							<strong> Bases de datos</strong><br>
							<select name="datos[asociard][]" multiple="" style="width:270px;" class="form-control">
								<option value="">Selecciona una opción</option>
								 <?php foreach ($basesdedatos as $bd)
			                         {
			                                if(in_array($bd->id,  json_decode($conf_bbdd->ids))){
			                                    echo "<option selected='selected' value='".$bd->id."'>".$bd->name."</option>";
			                                }else{
			                                   echo "<option value='".$bd->id."'>".$bd->name."</option>";
			                                }    
			                            
			                           
			                        }
			                        ?>
							</select>                
						</div>
						<div class="col-sm-6">
							<strong>Frecuencia</strong><br>
							<select name="datos[frecuencia]" class="form-control">
								 <option  <?php echo ($conf_bbdd->frequency==0?"selected='selected'":"");?> value="0">Selecciona una opción</option>
				                        <option <?php echo ($conf_bbdd->frequency==0.10?"selected='selected'":"");?> value="0.10">10 minutos</option>
				                        <option <?php echo ($conf_bbdd->frequency==0.15?"selected='selected'":"");?> value="0.15">15 minutos</option>
				                        <option <?php echo ($conf_bbdd->frequency==0.20?"selected='selected'":"");?>value="0.20">20 minutos</option>
				                        <option <?php echo ($conf_bbdd->frequency==0.30?"selected='selected'":"");?>value="0.30">30 minutos</option>
				                        <option <?php echo ($conf_bbdd->frequency==1?"selected='selected'":"");?>value="1">1 hora</option>
				                        <option <?php echo ($conf_bbdd->frequency==2?"selected='selected'":"");?>value="2">2 horas</option>
				                        <option <?php echo ($conf_bbdd->frequency==3?"selected='selected'":"");?>value="3">3 horas</option>
				                        <option <?php echo ($conf_bbdd->frequency==4?"selected='selected'":"");?> value="4">4 horas</option>
				                        <option <?php echo ($conf_bbdd->frequency==6?"selected='selected'":"");?>value="6">6 horas</option>
				                        <option <?php echo ($conf_bbdd->frequency==12?"selected='selected'":"");?>value="12">12 horas</option>
				                        <option <?php echo ($conf_bbdd->frequency==24?"selected='selected'":"");?>value="24">24 horas</option>			
								
						
							
							</select>               
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-sm-12">
								<strong>Frases permantentes</strong><br>
								<textarea  class="form-control" name="datos[frases_perm]"><?php  echo nl2br($conf_bbdd->perm_sentences); ?></textarea>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 text-center">
							<strong>¿Qué días quieres publicar?</strong><br>
							<?php 
							$daysweelbd=json_decode($conf_bbdd->weekdays);
						
							$DAYS=array("lunes","martes","miércoles","jueves","viernes","sábado","domingo");
							for($i=0;$i<count($DAYS);$i++){ 
								$hies=false;
							
									

									$hies=in_array($DAYS[$i],$daysweelbd);
								
																?>

								<input type="checkbox" name="datos[diasp][]" class="diasp" value="<?php echo $DAYS[$i] ?>" <?php echo (($hies==true)?"checked='checked'":''); ?>/><?php echo ucfirst($DAYS[$i]); ?>
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
										<select name="datos[hora_inicio]" class="form-control">
											
					                        <?php for($i=1;$i<25;$i++)
					                        {
					                            if($conf_bbdd->time_start==$i)
					                            {
					                            echo    sprintf("<option selected='selected' value='%02s'>%02d:00</option>",$i,$i);
					                            }
					                            else 
					                                {
					                                echo sprintf("<option value='%02s'>%02d:00</option>",$i,$i);
					                                }
					                        }
					                        ?>
									</select>
								</div>
								<div class="col-sm-6">
									<strong> a </strong><br>
									<select name="datos[hora_fin]" class="form-control">
									
					                        <?php for($i=1;$i<25;$i++)
					                        {
					                            if($conf_bbdd->time_end==$i)
					                            {
					                            echo    sprintf("<option selected='selected' value='%02s'>%02d:00</option>",$i,$i);
					                            }
					                            else 
					                                {
					                                echo sprintf("<option value='%02s'>%02d:00</option>",$i,$i);
					                                }
					                        }
					                        ?>
					                        </select>
								</div>
							</div>
						</div>
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
				                                if($an->id==$conf_anunci->ids){
				                                    echo "<option selected='selected'  value='".$an->id."'>".$an->name."</option>"; 
				                                }else{
				                                   echo "<option value='".$an->id."'>".$an->name."</option>";
				                                }    
				                            
				                           
				                        }?>
								
							</select>                
						</div>
						<div class="col-sm-4">
							<strong>Frecuencia</strong><br>
							<select name="anuncios[frecuencia]" class="form-control">
								
								 <option  <?php echo ($conf_anunci->frequency==0?"selected='selected'":"");?> value="0">Selecciona una opción</option>
				                        <option <?php echo ($conf_anunci->frequency==0.10?"selected='selected'":"");?> value="0.10">10 minutos</option>
				                        <option <?php echo ($conf_anunci->frequency==0.15?"selected='selected'":"");?> value="0.15">15 minutos</option>
				                        <option <?php echo ($conf_anunci->frequency==0.20?"selected='selected'":"");?>value="0.20">20 minutos</option>
				                        <option <?php echo ($conf_anunci->frequency==0.30?"selected='selected'":"");?>value="0.30">30 minutos</option>
				                        <option <?php echo ($conf_anunci->frequency==1?"selected='selected'":"");?>value="1">1 hora</option>
				                        <option <?php echo ($conf_anunci->frequency==2?"selected='selected'":"");?>value="2">2 horas</option>
				                        <option <?php echo ($conf_anunci->frequency==3?"selected='selected'":"");?>value="3">3 horas</option>
				                        <option <?php echo ($conf_anunci->frequency==4?"selected='selected'":"");?> value="4">4 horas</option>
				                        <option <?php echo ($conf_anunci->frequency==6?"selected='selected'":"");?>value="6">6 horas</option>
				                        <option <?php echo ($conf_anunci->frequency==12?"selected='selected'":"");?>value="12">12 horas</option>
				                        <option <?php echo ($conf_anunci->frequency==24?"selected='selected'":"");?>value="24">24 horas</option>			
								
							</select>               
						</div>
						<div class="col-sm-4">
							<strong>Frecuencia de borrado</strong><br>
							<select name="anuncios[frecuencia_borrado]" class="form-control">
							 <option  <?php echo ($conf_anunci->frequency_erase==0?"selected='selected'":"");?> value="0">Selecciona una opción</option>
				                        <option <?php echo ($conf_anunci->frequency_erase==0.10?"selected='selected'":"");?> value="0.10">10 minutos</option>
				                        <option <?php echo ($conf_anunci->frequency_erase==0.15?"selected='selected'":"");?> value="0.15">15 minutos</option>
				                        <option <?php echo ($conf_anunci->frequency_erase==0.20?"selected='selected'":"");?>value="0.20">20 minutos</option>
				                        <option <?php echo ($conf_anunci->frequency_erase==0.30?"selected='selected'":"");?>value="0.30">30 minutos</option>
				                        <option <?php echo ($conf_anunci->frequency_erase==1?"selected='selected'":"");?>value="1">1 hora</option>
				                        <option <?php echo ($conf_anunci->frequency_erase==2?"selected='selected'":"");?>value="2">2 horas</option>
				                        <option <?php echo ($conf_anunci->frequency_erase==3?"selected='selected'":"");?>value="3">3 horas</option>
				                        <option <?php echo ($conf_anunci->frequency_erase==4?"selected='selected'":"");?> value="4">4 horas</option>
				                        <option <?php echo ($conf_anunci->frequency_erase==6?"selected='selected'":"");?>value="6">6 horas</option>
				                        <option <?php echo ($conf_anunci->frequency_erase==12?"selected='selected'":"");?>value="12">12 horas</option>
				                        <option <?php echo ($conf_anunci->frequency_erase==24?"selected='selected'":"");?>value="24">24 horas</option>			
								
							</select>               
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-sm-12">
								<strong>Frases permantentes</strong><br>
								<textarea class="form-control" name="anuncios[frases_perm]"><?php  echo nl2br($conf_anunci->perm_sentences); ?></textarea>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 text-center">
							<strong>¿Qué días quieres publicar?</strong><br>
							<?php 
							$daysweel=json_decode($conf_anunci->weekdays);
							
							
							$DAYS=array("lunes","martes","miércoles","jueves","viernes","sábado","domingo");
							for($i=0;$i<count($DAYS);$i++){ 
								$hies=false;
								$hies=in_array($DAYS[$i],$daysweel);
								?>
							
								<input type="checkbox" name="anuncios[diasp][]" class="diasp" value="<?php echo $DAYS[$i] ?>" <?php echo (($hies==true)?"checked='checked'":''); ?>/><?php echo ucfirst($DAYS[$i]); ?>
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
				                            if($conf_anunci->time_start==$i)
				                            {
				                            echo    sprintf("<option selected='selected' value='%02s'>%02d:00</option>",$i,$i);
				                            }
				                            else 
				                                {
				                                echo sprintf("<option value='%02s'>%02d:00</option>",$i,$i);
				                                }
				                        }
				                        ?>
								</select>
								</div>
								<div class="col-sm-6">
									<strong> a </strong><br>
									<select name="anuncios[hora_fin]" class="form-control">
									
					                        <?php for($i=1;$i<25;$i++)
					                        {
					                            if($conf_anunci->time_end==$i)
					                            {
					                            echo    sprintf("<option selected='selected' value='%02s'>%02d:00</option>",$i,$i);
					                            }
					                            else 
					                                {
					                                echo sprintf("<option value='%02s'>%02d:00</option>",$i,$i);
					                                }
					                        }
					                        ?>
									</select>
								</div>
							</div>
						
						</div>
					</div>
				</div>
			</div> 
		</div> 
	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
		<input type="submit" value="Guardar" class="btn btn-primary">
	</div>
</form>
<form method="post" action="" >
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
							<select name="datos_asociard[]" multiple="" style="width:270px;" class="form-control">
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
							<select name="dades[frecuencia]" class="form-control">
											
								
								<?php

								$str2="true";
								$str="0.";
								 for($i=15,$m=0;$i<24,$m<3;$m++,$i++){ 
								 	?><option  <?php echo ((((int)$conf_bbdd->frequency)==(int)($m.$i))?"selected='selected'":""); ?> value="<?php echo $m.$i; ?>"> <?php echo $i."".(($m!="")?"minutos":"horas"); ?></option>
									<?php
								 	if($i==15)
								 		$i=$i+5;
								 	else if($i==20)
								 		$i=$i+10;
								 	else if($i==30)
								 		$i=(($i/10)*3)+0.1;
								 	else if($i==1 || $i==2 || $i==3)
								 		$i=$i+1;
								 	else if($i==4)
								 		$i=$i+2;
								 	else
								 		$i=$i*2;
								 	if($m=3)
								 		$str="";
								 		$str2="";	
								 } ?>
								<!---<option value="0.15">15 minutos</option>
								<option value="0.20">20 minutos</option>
								<option value="0.30">30 minutos</option>
								<option value="1">1 horas</option>
								<option value="2">2 horas</option>
								<option value="3">3 horas</option>
								<option value="4">4 horas</option>
								<option value="6">6 horas</option>
								<option value="12">12 horas</option>
								<option value="24">24 horas</option>-->
							</select>               
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-sm-12">
								<strong>Frases permantentes</strong><br>
								<textarea  class="form-control" name="datos_frases_perm"><?php  echo nl2br($conf_bbdd->perm_sentences); ?></textarea>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 text-center">
							<strong>¿Qué días quieres publicar?</strong><br>
							<input type="checkbox" name="datos_diasp[]" class="diasp" value="lunes" checked=""> Lunes
							 <input type="checkbox" name="datos_diasp[]" class="diasp" value="martes" checked=""> Martes 
							 <input type="checkbox" name="datos_diasp[]" class="diasp" value="miercoles" checked=""> Miercoles 
							 <input type="checkbox" name="datos_diasp[]" class="diasp" value="jueves" checked=""> Jueves 
							 <input type="checkbox" name="datos_diasp[]" class="diasp" value="viernes" checked=""> Viernes 
							 <input type="checkbox" name="datos_diasp[]" class="diasp" value="sabado" checked=""> Sabado 
							 <input type="checkbox" name="datos_diasp[]" class="diasp" value="domingo" checked=""> Domingo        
				         </div>

						</div>
						<br>
						<div class="row">
							<div class="col-sm-12 text-center">
								<strong>Horas publicación:</strong><br>
								<div class="row">
									<div class="col-sm-6">
										<strong>De </strong><br>
										<select name="datos_hora_inicio" class="form-control">
											
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
									<select name="datos_hora_fin" class="form-control">
									
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
							<select name="anuncios_asociard"   class="form-control">
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
							<select name="anuncios_frecuencia" class="form-control">
								
								
								<?php

								$str2="true";
								$str="0.";
								 for($i=15,$m=0;$i<24,$m>3;$m++,$i++){ 
								 	?><option  <?php echo ((((int)$conf_anunci->frequency)==(int)($m.$i))?"selected='selected'":""); ?> value="<?php echo $m.$i; ?>"> <?php echo $i."".(($m!="")?"minutos":"horas"); ?></option>								<?php
								 	if($i==15)
								 		$i=$i+5;
								 	else if($i==20)
								 		$i=$i+10;
								 	else if($i==30)
								 		$i=(($i/10)*3)+0.1;
								 	else if($i==1 || $i==2 || $i==3)
								 		$i=$i+1;
								 	else if($i==4)
								 		$i=$i+2;
								 	else
								 		$i=$i*2;
								 	if($m=3)
								 		$str="";
								 		$str2="";	
								 } ?>
								<!--<option value="0.15">15 minutos</option>
								<option value="0.20">20 minutos</option>
								<option value="0.30">30 minutos</option>
								<option value="1">1 horas</option>
								<option value="2">2 horas</option>
								<option value="3">3 horas</option>
								<option value="4">4 horas</option>
								<option value="6">6 horas</option>
								<option value="12">12 horas</option>
								<option value="24">24 horas</option>
									-->
							</select>               
						</div>
						<div class="col-sm-4">
							<strong>Frecuencia de borrado</strong><br>
							<select name="anuncios_frecuencia" class="form-control">
								<option  <?php echo (((int)$conf_anunci->frequency_erase==0)?"selected='selected'":"") ?> value="">Seleccionba una opcion</option>
								<?php

								$str2="true";
								$str="0.";
								 for($i=15,$m=0;$i<24,$m>3;$m++,$i++){ 
								 	?><option  <?php echo ((((int)$conf_anunci->frequency_erase)==(int)($m.$i))?"selected='selected'":""); ?> value="<?php echo $m.$i; ?>"> <?php echo $i."".(($m!="")?"minutos":"horas"); ?></option>
									<?php
								 	if($i==15)
								 		$i=$i+5;
								 	else if($i==20)
								 		$i=$i+10;
								 	else if($i==30)
								 		$i=(($i/10)*3)+0.1;
								 	else if($i==1 || $i==2 || $i==3)
								 		$i=$i+1;
								 	else if($i==4)
								 		$i=$i+2;
								 	else
								 		$i=$i*2;
								 	if($m=3)
								 		$str="";
								 		$str2="";	
								 } ?>
								<!--<option value="0.15">15 minutos</option>
								<option value="0.20">20 minutos</option>
								<option value="0.30">30 minutos</option>
								<option value="1">1 horas</option>
								<option value="2">2 horas</option>
								<option value="3">3 horas</option>
								<option value="4">4 horas</option>
								<option value="6">6 horas</option>
								<option value="12">12 horas</option>
								<option value="24">24 horas</option>-->
							</select>               
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-sm-12">
								<strong>Frases permantentes</strong><br>
								<textarea class="form-control" name="anuncios_frases_perm"><?php  echo nl2br($conf_anunci->perm_sentences); ?></textarea>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 text-center">
							<strong>¿Qué días quieres publicar?</strong><br>
							<input type="checkbox" name="anuncios_diasp[]" class="diasp" value="lunes" checked=""> Lunes 
							<input type="checkbox" name="anuncios_diasp[]" class="diasp" value="martes" checked=""> Martes 
							<input type="checkbox" name="anuncios_diasp[]" class="diasp" value="miercoles" checked=""> Miercoles 
							<input type="checkbox" name="anuncios_diasp[]" class="diasp" value="jueves" checked=""> Jueves 
							<input type="checkbox" name="anuncios_diasp[]" class="diasp" value="viernes" checked=""> Viernes 
							<input type="checkbox" name="anuncios_diasp[]" class="diasp" value="sabado" checked=""> Sabado 
							<input type="checkbox" name="anuncios_diasp[]" class="diasp" value="domingo" checked=""> Domingo
						</div>

					</div>
					<br>
					<div class="row">
						<div class="col-sm-12 text-center">
							<strong>Horas publicación:</strong><br>
							<div class="row">
								<div class="col-sm-6">
									<strong>De </strong><br>
									<select name="anuncios_hora_inicio" class="form-control">
										
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
									<select name="anuncios_hora_fin" class="form-control">
									
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
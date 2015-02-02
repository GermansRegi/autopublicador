<!DOCTYPE html>
<html>
	<head>
	    <title>Autopublicador Social</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta charset="UTF-8" />
	    <?php echo $this->load->view('includes2/head');?>
	</head>

	<body>
	    <?php echo $this->load->view('includes2/header'); ?>
	    <?php if(count($users)==0)
		{
    		?>
			<div class="redbox">
    				<p>
				Para poder publicar debe añadir como mínimo una cuenta de twitter. Desde la opción <?php  echo '<a href="'.base_url().'panel/twitter/connectar_twitter">Conectar con Twitter</a>';?>
    				</p>
			</div>
		<?php
		}
		else
		{
		?>
			<form id="publicarahora"  action='<?php echo base_url()?>panel/twitter/publicar' method='post' enctype="multipart/form-data">
			   <div class="message"></div>
			   <div class="col-lg-6">
			       <div class="form-group">  
			           <label class=" col-lg-12  control-label">Texto:</label>
			           <div class="col-lg-12">
				           <textarea maxlength="140" class='form-control' id="tweet_txt" name='texto_facebook'></textarea>
				           <p id="contadorTaComentario"></p>
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
			      <div class="form-group ">
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
			   </div>
			   <div class="col-lg-6">	       
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
					 <label class="control-label ">Cuentas:</label>
					  
					<section >
					<?php
									foreach($users as $page)
									{
										
										echo " <input type='checkbox' name='ck_group_ap[]' value='".$page->user_id."' /> <span >".$page->username."</span><br>";
									}
									?>
									
				   
				</section>
				
				<section class="col-lg-12">
						<input type='submit' name='publicar' class="btn btn-primary" value='Publicar'/>
				</section>
				
			</div>
			</div>
		</form>
    <?php }?>       
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>

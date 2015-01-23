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
	    <?php if(count($data['page'])==0 && count($data['user'])==0 && count($data['event'])==0  && count($data[''])==0)
		{
    		?>
			<div class="redbox">
    				<p>
				Para poder publicar debe añadir como mínimo una página de facebook. Desde la opción <?php  echo '<a href="'.base_url().'social_connect/fb_connect">Conectar con Facebook</a>';?>
    				</p>
			</div>
		<?php
		}
		else
		{
		?>
			<form id="publicarahora"  action='<?php echo base_url()?>facebook/publicar' method='post' enctype="multipart/form-data">
			   <div id="resultadopublicar"></div>
			   <div class="col-lg-6">
			       <div class="form-group">  
			           <label class=" col-lg-12  control-label">Texto:</label>
			           <div class="col-lg-12">
				           <textarea class='form-control' name='texto_facebook'></textarea>
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
			               <select  class='form-control' name="anuncis"  id="select-anuncis" >
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
			           
				           <select  class='form-control' name="bbdd"  id="select-bbdd" >
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
										echo " <input type='checkbox' name='ck_group_ap[]' value='".(($arraytypes[$i]['name']=="user")?$page->user_id:$page->idaccount)."' />&nbsp;&nbsp;&nbsp; <span >".(($arraytypes[$i]['name']=="user")?$page->username:$page->name)."</span>&nbsp;&nbsp;<br>";
									}
									?>
									</section>
								</section>
							</section>
						<?php	
						} 
					}
					?>      
				</section>
				<section class="col-lg-12">
						<input type='submit' name='publicar' class="btn btn-primary" value='Publicar'/>
				</section>
				</div>
					<p>Facebook no permite poner en una misma publicación imágenes y enlaces</p>
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
<script id="personTpl" type="text/template">
<ul>
{{#/data}}
<li>{{id}}</li>
{{#/data}}
</ul>
</script>
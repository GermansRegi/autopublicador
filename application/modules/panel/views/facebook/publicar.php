<!DOCTYPE html>
<head>

    <title>Autopublicador Social</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="UTF-8" />
    <?php echo $this->load->view('includes2/head');?>




</head>

<body>
    <?php echo $this->load->view('includes2/header');

?>

<div class="container">
<div class="row">
<div class="col-md-12 panel panel-default">

<?php if(count($pages)==0 && count($users)==0 && count($events)==0  && count($groups)==0)
{
    ?>
<div class="redbox">
    <p>
Para poder publicar debe añadir como mínimo una página de facebook. Desde la opción <?php  echo '<a href="'.base_url().'social_connect/fb_connect">Conectar con Facebook</a>';?>
        
    </p>
</div>
<?php
}
else{
?>
        
    <div class="row">
    <div class="cwell">
    <form id="publicarahora"  action='<?php echo base_url()?>facebook/publicar' method='post' enctype="multipart/form-data">
        <div id="resultadopublicar">
            
            
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="col-sm-12">
                <label>Texto:</label>
                
                <textarea class='form-control' name='texto_facebook'></textarea>
                </div>
            </div>
            <div class="form-group">
                
			<div class="col-sm-10">
               	<label>Imagen(jpg,png,gif):</label>
               	
                  <input class='filestyle' data-buttonText="Escoja una imagen" data-buttonName="btn-default" data-icon="false" class="filestyle" accept="image/x-png,image/png, image/gif, image/jpeg , image/jpg" type='file' id="filetoup"  name='imagen'>
                  <a href="" id="clearFile">Eliminar imagen a publicar</a>
                </div>
                
            </div>
            <div class="form-group col-sm-12">
                <label>Enlace:</label><br><input class='form-control' type='text' name='link'>
            </div>
            <div class="form-group col-sm-12">


                    <label>Anuncios:</label><br><select  class='form-control' name="anuncis"  id="select-anuncis" >
                <option value=''> Seleccione una base de datos de anuncios</option>
                <?php
                        foreach ($anuncis as $anunci)
                        {
                            echo "<option value='".$anunci->id."'>".$anunci->name."</option>";
                        }
                
                ?>
                        
                    </select>
                    <div id="generate-anuncis"></div>
            </div>
        </div>
        <div class="col-md-6">
        
            
            <div class="form-group col-sm-12">
                <label>Bases de datos:</label><br><select class='form-control' name="bbdd"  id="select-bbdd" >
                  <option value=''> Seleccione una base de datos</option>
            <?php
                    foreach ($bbdds as $bbdd)
                    {
                        echo "<option value='".$bbdd->id."'>".$bbdd->name."</option>";
                    }
            
            ?>
            
            </select>
        

            <div id="generate-bbdd"></div>
        </div>    
        <div class="form-group col-sm-12">
           
				<section class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				  
				<?php 

                        if(count($pages)>0)
                        {
                             ?>
                        
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
				      
				       
                                    <?php
                                    foreach($pages as $page)
                                    {
                                            echo " <input type='checkbox' name='ck_group_ap[]' value='".$page->idaccount."' />&nbsp;&nbsp;&nbsp; <span >".$page->name."</span>&nbsp;&nbsp;<br>";
                                            
                                    }
                                    ?>
                          </section>
				    </section>
				  </section>

				     <?php
                        }

                        

                
                        if(count($groups)>0)
                        {
                            ?>
                            
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
				     
                                        <?php
                                        foreach($groups as $page)
                                        {
                                                echo " <input type='checkbox' name='ck_group_ap[]' value='".$page->idaccount."' />&nbsp;&nbsp;&nbsp; <span >".$page->name."</span>&nbsp;&nbsp;<br>";
                                                
                                        }
                                        ?>
                            
                         </section>
				    </section>
				  </section>
				
				  <?php
                        }
                        
                        if(count($events)>0)
                        {


                            ?> 
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

                                        <?php
                                        foreach($events as $page)
                                        {
                                                echo " <input type='checkbox' name='ck_group_ap[]' value='".$page->idaccount."' />&nbsp;&nbsp;&nbsp; <span >".$page->name."</span>&nbsp;&nbsp;<br>";
                                                
                                        }
                                        ?>
                           </section>
				    </section>
				  </section>
				

                            <?php
                        }
                        ?>

         		</section>
		    </div>
            <p>Facebook no permite poner en una misma publicación imágenes y enlaces</p>
        </div>
            
        </div>
        <input type='submit' name='publicar' value='Publicar'/>
    </form>
    
    
    </div>
    </div>
    <?php }?>
</div>
</div>
</div>

          
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>
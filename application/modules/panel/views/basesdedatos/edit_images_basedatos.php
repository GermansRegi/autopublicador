<!DOCTYPE html>
<head>

    <title>Socialsuites</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="UTF-8" />
    <?php echo $this->load->view('includes2/head');?>




</head>

<body>
    <?php echo $this->load->view('includes2/header');

?>

          
		
	            		<div class='namebd'>
    <p>Inserte imágenes en: <span class='bold'> <?php echo $bbdd->name."</span> <span class='right'> Tiene ".$total." imágenes creadas. El máximo de imágenes son ".$this->config->item('max-images').".</span>";?></p>
</div>

<div class="message"></div>
<form  method="post"  enctype='multipart/form-data'>	
	<div id="uploader">
		<p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
                
        </div>
    <input type='hidden' id='image_add_id' name='bbdd_add' value='<?php echo $bbdd->id; ?>'>
</form>
<br class='clearfix'>
<script type="text/javascript">
var url_plupload='<?php echo base_url()?>panel/basesdedatos/editar/<?php echo $bbdd->id; ?>';
var flash_swf_urlfile='<?php echo base_url()?>public/js/Moxie.swf';
var silverlight_xap_urlfile='<?php echo base_url()?>public/js/Moxie.xap';
var idUploader='#uploader'
var checkmaxelements_url="<?php echo base_url()?>panel/basesdedatos/ismaxelementsimages/<?php echo $bbdd->id; ?>"
var deletecontent_url='<?php echo base_url()?>panel/basesdedatos/deletecontent/<?php echo $bbdd->id; ?>'
var current_url='<?php echo base_url().$this->uri->uri_string();?>';
</script>
		<div class="row">
			<div class='namebd col-lg-6'>
				<p>Elimine imágenes de: <span class='bold'><?php echo $bbdd->name;?></span></p>    
			</div>
		
				<div class="col-sm-6 text-right">
	     <input type="button" id="toggle" value="Marcar todos" class="btn btn-primary" >           	
	                	<input type="button" class="btn btn-danger deletemulti" value="Borrar">
	              </div>
			</div>
			<div id="contenido" >
				<?php if(count($elements)>0){
					?>
				

				<div>
				    <?php
				    foreach ($elements as $element)
				    {
				        ?>
				        <div class="col-sm-2">
				        <?php
							if(filter_var($element->path,FILTER_VALIDATE_URL))
							{
												 ?>
												 <a href="<?php echo $element->path; ?>" class="image-link">        
				        		<img width="60" height="60" src="<?php echo $element->path; ?>"/>
				        		</a>

				        	<?php
							}
							else
							{


				         ?>
				         <a href="<?php echo base_url()?>upload/<?php echo $this->flexi_auth->get_user_identity()."/".$element->filename;?>" class="image-link">
				        	<img width="60"  height="60" src="<?php echo base_url()?>upload/<?php echo $this->flexi_auth->get_user_identity()."/".$element->filename;?>"/>
				        	</a>
				        	<?php }?>
						<a data-id='<?php echo $element->id; ?>' class='btn btn-danger deletecontent'><i class='fa fa-trash-o'></i></a> 
						<input type='checkbox' value='<?php echo $element->id; ?>' name='hk_group_bf[]'>
				        </div>
				        <?php
				    }
				    ?>
				    </div>
				    <div >
						<?php echo $link_pager; ?>
					</div>
				    <?php
				 }else{
				    ?>
				
				   <div class="col-lg-12">
				    	No hay ningún elemento en esta base de datos
				   </div>

				 	<?php
				 } ?>
	

                    
       
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>
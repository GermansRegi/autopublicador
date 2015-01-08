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
            
            <section class="content">
              <section class="container">
            		<section class='namebd'>
    <p>Inserte imágenes en: <span class='bold'> <?php echo $bbdd->name."</span> <span class='right'> Tiene ".$total." imágenes creadas. El máximo de imágenes son ".$this->config->item('max-images').".</span>";?></p>
</section>

<section class="message"></section>
<form  method="post"  enctype='multipart/form-data'>	
	<section id="uploader">
		<p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
                
        </section>
    <input type='hidden' id='image_add_id' name='bbdd_add' value='<?php echo $bbdd->id; ?>'>
</form>
<br class='clearfix'>
<script type="text/javascript">
var url_plupload='<?php echo base_url()?>admin/basesdedatos/editar/<?php echo $bbdd->id; ?>';
var flash_swf_urlfile='<?php echo base_url()?>public/js/Moxie.swf';
var silverlight_xap_urlfile='<?php echo base_url()?>public/js/Moxie.xap';
var idUploader='#uploader'
var checkmaxelements_url="<?php echo base_url()?>admin/basesdedatos/ismaxelementsimages/<?php echo $bbdd->id; ?>"
var deletecontent_url='<?php echo base_url()?>admin/basesdedatos/deletecontent/<?php echo $bbdd->id; ?>'
var current_url='<?php echo base_url().$this->uri->uri_string();?>';
</script>
		<section class="row">
				<section class="col-sm-12 text-right">
	                	
	                	<input type="button" class="btn btn-danger deletemulti" value="Borrar">
	              </section>
			</section>
			<section class "row" id="contenido">
				<?php if(count($elements)>0){
					?>
				<section class='namebd'>
				<p>Elimine frases de: <span class='bold'><?php echo $bbdd->name;?></span></p>    
				</section>

				<section class="row">
				    <?php
				    foreach ($elements as $element)
				    {
				        ?>
				        <section class="col-sm-2">
				        	<img width="60" height="60" src="<?php echo base_url()?>upload/<?php echo $element->filename;?>"/>
						<a data-id='<?php echo $element->id; ?>' class='btn btn-danger deletecontent'><i class='fa fa-trash-o'></i></a> 
						<input type='checkbox' value='<?php echo $element->id; ?>' name='hk_group_bf[]'>
				        </section>
				        <?php
				    }
				    ?>
				    </section>
				    <section class="row">
						<?php echo $link_pager; ?>
					</section>
				    <?php
				 }else{
				    ?>
				
				   
				    		<td colspan="4">No hay ningún elemento en esta base de datos</td>
				   

				 	<?php
				 } ?>
	

                    
                   
                </section>
            </section>
<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>
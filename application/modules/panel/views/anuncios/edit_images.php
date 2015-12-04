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

	<section class='namebd'>
		<p>Inserte imágenes en: <span class='bold'> <?php echo $anuncio->name."</span> <span class='right'> Tiene ".$total." imágenes creadas. El máximo de imágenes son ".$this->config->item('max-images').".</span>";?></p>
	</section>

	<section class="message"></section>
	<form  method="post"  enctype='multipart/form-data'>
		
		<section id="uploader">
			<p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>

		</section>
		<input type='hidden' id='image_add_id' name='anuncio_add' value='<?php echo $anuncio->id; ?>'>
	</form>
	<br class='clearfix'>
	<script type="text/javascript">
		var url_plupload='<?php echo base_url()?>panel/anuncios/editar/<?php echo $anuncio->id; ?>';
		var flash_swf_urlfile='<?php echo base_url()?>public/js/Moxie.swf';
		var silverlight_xap_urlfile='<?php echo base_url()?>public/js/Moxie.xap';
		var idUploader='#uploader'
		var checkmaxelements_url="<?php echo base_url()?>panel/anuncios/ismaxelementsimages/<?php echo $anuncio->id; ?>"
		var deletecontent_url='<?php echo base_url()?>panel/anuncios/deletecontent/<?php echo $anuncio->id; ?>'
		var current_url='<?php echo base_url().$this->uri->uri_string();?>';
	</script>

	<section class="row">
		<section class='namebd col-lg-6'>
			<p>Elimine imágenes de: <span class='bold'><?php echo $anuncio->name;?></span></p>    
		</section>

		<section class="col-lg-6 text-right">
			<input type="button" id="toggle" value="Marcar todos" class="btn btn-primary" >          	
			<input type="button" class="btn btn-danger deletemulti" value="Borrar">

		</section>
	</section>
	
	<section id="contenido">
		<?php if(count($elements)>0){
			?>

		<div>
				<?php
				foreach ($elements as $element)
				{
					?>
					<section class="col-sm-2">
					<a href="<?php echo base_url()?>upload/<?php echo $this->flexi_auth->get_user_identity()."/".$element->filename;?>" class="image-link">
						<img width="60" height="60" src="<?php echo base_url()?>upload/<?php echo $this->flexi_auth->get_user_identity()."/".$element->filename;?>"/>
						</a>
						<a data-id='<?php echo $element->id; ?>' class='btn btn-danger deletecontent'><i class='fa fa-trash-o'></i></a> 
						<input type='checkbox' value='<?php echo $element->id; ?>' name='hk_group_bf[]'>
					</section>
					<?php
				}
				?>
			</div>
			<section>
				<?php echo $link_pager; ?>
			</section>
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
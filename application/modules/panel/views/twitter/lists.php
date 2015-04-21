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
	<?php if(count($users)==0)
		{
    		?>
			<div class="redbox">
    				<p>
				Para poder gestionar listas de twitter debe añadir como mínimo una cuenta de twitter. Desde la opción <?php  echo '<a href="'.base_url().'panel/twitter/connectar_twitter">Conectar con Twitter</a>';?>
    				</p>
			</div>
		<?php
		}
		else
		{
		?>
			<form  action="<?php echo base_url(); ?>panel/twitter/gestion_listas" method="get">
				<select name="userlist">
						<?php
							foreach($users as $page)
							{
								
								echo " <option value='".$page->user_id."' /> ".$page->username."</value>";
							}
										
						?>
				</select>
				<input type="submit" value="Gestionar listas" class="btn btn-primary"/>
			</form>

       
<?php }?>
<script type="text/javascript">
	
	var current_url='<?php echo base_url().$this->uri->uri_string();?>';
</script>

<?php
    echo $this->load->view('includes2/footer');
?>
 <?php echo $this->load->view('includes2/scripts');?>
</body>
</html>
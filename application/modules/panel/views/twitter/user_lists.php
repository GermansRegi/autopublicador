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
		<a class="btn btn-primary"  href="<?php echo base_url()?>panel/twitter/getLists/<?php echo $user_id ?>" data-toggle="ajaxModal"> <i  class="fa fa-plus"></i> Agregar listas  </a>
		<div class="savedlists">
			<?php foreach ($lists as $list) {
				?>
				<div class="list">
					<div 
					<div class="listfeed">
					</div>
					<div class="listbuttons">
					</div>
				</div>
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
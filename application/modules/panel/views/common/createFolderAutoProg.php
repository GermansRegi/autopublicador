<form id="" method="post" action="<?php echo base_url()?>panel/commonsocial/createFolderAutoProg/<?php echo $socialnetwork."/".$content; ?>"  class="form-horitzonal">
				
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		Crear Carpeta
	</div>
	<div class="modal-body">
		<div class="clearfix">
					<div class="messagefolder"></div>
					<div class="col-lg-12 form-group">
						<label for="" class="label-control col-lg-4">Nombre:</label>
						<div class="col-lg-7">
							<input name="name" class="form-control" type="text">
						</div>
					</div>
					<div class="form-group  col-lg-12">
		
					</div>
				
		</div>				
	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
						<input type="submit"  class=" col-lg-offset-5  btn btn-primary" value="Crear carpeta"/>
	</div>
</form>
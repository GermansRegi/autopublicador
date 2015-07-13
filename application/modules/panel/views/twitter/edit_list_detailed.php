<form class="form-horizontal" id='update-list' role="form">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">×</button>
	<h4 class="modal-title">Edicion de lista <?php echo $datalist->name;?> por <?php echo $datalist->user->name ?></h4>
</div>
<div class="modal-body clearfix edit-detail-list" data-listid="<?php echo $datalist->id ?>"  data-userid="<?php echo $datalist->user->id ?>">
	<div class="panel panel-default clearfix">
		
			<div class="form-group">
				<label for="ejemplo_email_3" class="col-lg-2 control-label">Cuenta</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" disabled="" value="<?php echo $datalist->user->name ?>"  id="ejemplo_email_3">
				</div>
			</div>
			<div class="form-group">
				<label for="ejemplo_password_3" class="col-lg-2 control-label">Nombre</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" name="name_list" value="<?php echo $datalist->name; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="ejemplo_password_3" class="col-lg-2 control-label">Descripción</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" name="desc_list" value="<?php echo $datalist->description; ?>" >
				</div>
			</div>

			<div class="form-group">
				<div class="col-lg-offset-2 col-lg-10">
<label class="checkbox-inline">
  <input type="radio" id="checkboxEnLinea2" <?php if($datalist->mode=='public') echo "checked='checked'" ?>name="privacidad" value="public"> Pública
</label>
<label class="checkbox-inline">
  <input type="radio" id="checkboxEnLinea3"  <?php if($datalist->mode=='private') echo "checked='checked'" ?>  name="privacidad" value="private"> Privada
</label>			</div>
		
	</div>
</div>
<div class="modal-footer">
		
	<input type="submit" value="Guardar"   class="btn btn-primary"/>
</div>
</form>

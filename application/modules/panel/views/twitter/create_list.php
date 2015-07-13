<form class="form-horizontal" id='create-list' role="form">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">×</button>
	<h4 class="modal-title">Crear Lista</h4>
</div>
<div class="modal-body clearfix create-list"  data-userid="<?php echo $usertwtid->user_id ?>">
<div class="messagemodal"></div>
	<div class="panel panel-default clearfix">
		
			<div class="form-group">
				<label for="ejemplo_email_3" class="col-lg-2 control-label">Cuenta</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" disabled="" value="<?php echo $usertwtid->username ?>"  id="ejemplo_email_3" placeholder="Email">
				</div>
			</div>
			<div class="form-group">
				<label for="ejemplo_password_3" class="col-lg-2 control-label">Nombre</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" name="name_list" value="" placeholder="Nombre">
				</div>
			</div>
			<div class="form-group">
				<label for="ejemplo_password_3" class="col-lg-2 control-label">Descripción</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" name="desc_list" value="" placeholder="Descripción">
				</div>
			</div>

			<div class="form-group">
				<div class="col-lg-offset-2 col-lg-10">
<label class="checkbox-inline">
  <input type="radio" id="checkboxEnLinea2" name="privacidad" value="public"> Pública
</label>
<label class="checkbox-inline">
  <input type="radio" id="checkboxEnLinea3"  name="privacidad" value="private"> Privada
</label>			</div>
		
	</div>
</div>
<div class="modal-footer">
		
	<input type="submit" value="Guardar"   class="btn btn-primary"/>
</div>
</form>

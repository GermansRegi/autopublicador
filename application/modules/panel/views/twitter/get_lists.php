
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title">Listas</h4>
	</div>
	<div class="modal-body clearfix" >
		<div ><a href="" class="btn btn-primary">Crear lista</a> </div>
		<div class="listsToAdd col-lg-12" data-user-id="<?php echo $usertwtid;?>">
			
			<div class="ownlists col-lg-6">
				<h5>Tus listas</h5>				
				<ul class="js-list-container list-group">
				<?php

				foreach ($ownlists->lists as $list) {
					?>
					<a href="#" data-id='<?php echo $list->id;?>' class="list-group-item clearfix">
						<div class="col-lg-9"> 
						<strong><?php echo $list->name; ?></strong> by <?php echo $list->user->name ?>
							<p><?php echo $list->description; ?></p>
							<span><?php echo $list->member_count; ?> miembros</span>
						</div>
						<img class="col-lg-3" src="<?php echo $list->user->profile_image_url_https; ?>"/>


					</a>
					<?php
				}
				
				?>
				</ul>
			</div>
			<div class="subslists col-lg-6">
				<h5> Suscribido a</h5>
				<ul class="js-list-container list-group">
				<?php

				foreach ($subslists->lists as $list) {
					?>
					<a href="#" data-id='<?php echo $list->id;?>' class="list-group-item clearfix">
						<div class="col-lg-9"> 
						<strong><?php echo $list->name; ?></strong> by <?php echo $list->user->name ?>
							<p><?php echo $list->description; ?></p>
							<span><?php echo $list->member_count; ?> miembros</span>
						</div>
						<img class="col-lg-3" src="<?php echo $list->user->profile_image_url_https; ?>"/>


					</a>
					<?php
				}
				
				?>
				</ul>
				
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
		<buton type="submit" value="Añadir " class="btn btn-primary addtwtlists">Añadir</buton>
	</div>

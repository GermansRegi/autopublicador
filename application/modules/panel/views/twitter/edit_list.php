<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">×</button>
	<h4 class="modal-title"><?php echo $datalist->name;?> por <?php echo $datalist->user->name ?></h4>
</div>
<div class="modal-body clearfix edit-list" data-listid="<?php echo $datalist->id ?>" >
	<div class="panel panel-default clearfix">
		<div class="col-lg-6 user-search-container" >
			<div class="input-search-env">
				<input type="text" class="input-search" id="user-search" placeholder="Introduce un nombre o @nombre"/>
			</div>
			<div class="list-search">
				<ul class="list-container">
				</ul>

			</div>
		</div>
		<div class="col-lg-6 members-container" >
			<div class="members-list-header">
				Miembros

			</div>
			<div class="list-members">
				<ul class="list-container">
				<?php foreach ($members->users as $key) {
					?>
					<li class="list-listmember cf" data-usersearchid="<?php echo $key->id; ?>"> 
				 		<img src="<?php echo $key->profile_image_url_https?>" alt="<?php echo $key->name?>" class="avatar"> 
				 		<button class="js-add-remove btn btn-square s-member"> 
				 			<div class="working action-btn"> <span> <img src="https://ton.twimg.com/tweetdeck-web/web/assets/global/backgrounds/spinner_small_trans.c401042ab9.gif" alt="Loading…"> </span> </div> 
				 			<div class="member action-btn"><i class="fa fa-trash-o icon-small"></i></div> 
				 			<div class="checked action-btn"><i class="fa fa-check icon-small"></i></div> 
				 			<div class="nonmember action-btn"><i class="fa fa-plus icon-small"></i></div> 
				 		</button>
				 		<div class="content"> 
				 			<strong class="fullname"><?php echo $key->name?></strong> 
				 			<span class="username"><?php echo $key->screen_name?></span>  
				 			<p class="bio"><?php echo $key->description;?>
				 			</p> 
				 		</div> 
				 	</li>
 		<?php
				}
				?>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="modal-footer">
	<a class="btn btn-default" data-toggle='ajaxModal' type="button" href="<?php echo base_url()?>panel/twitter/editdetailslist/<?php echo $datalist->id ?>">Editar detalles</a>
	<a class="btn btn-danger" type="button" href="<?php echo base_url()?>panel/twitter/deletelist/<?php echo $datalist->id ?>" onclick="if(!confirm('Seguro que quiere eliminar la lista de twitter?')){ return false;}"  >Eliminar lista</a>
	<buton type="submit" value="Añadir " data-dismiss="modal" class="btn btn-primary ">Terminado</buton>
</div>


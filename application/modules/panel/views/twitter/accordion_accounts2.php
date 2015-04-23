					<div><?php
							foreach($arraydata['nofolder'] as $page)
							{
								
								echo " <input type='checkbox' name='".$input."[]' ".(isset($values)?(in_array($page->user_id, json_decode($values))?"checked='checked'":""):'')." value='".$page->user_id."' /> <span >".$page->username."</span><br>";
							}
							?>
							</div>
							<?php
							if(count($arraydata['folders'])>0)
							{
								?>
										<section class="panel-group" id="3accordion" role="tablist" aria-multiselectable="true">						
											<?php
												foreach ($arraydata['folders'] as $folder) {
														if(count($folder['rows'])>0)
														{
															?>
															<section class="panel panel-default">
																<section class="panel-heading" role="tab" id="3headingInnerOne<?php echo $folder['data']->id; ?>">
																	<h4 class="panel-title">
																		<a data-toggle="collapse" data-parent="#3accordion" href="#3collapseInnerOne<?php echo $folder['data']->id; ?>" aria-expanded="false" aria-controls="3collapseInnerOne<?php echo $folder['data']->id; ?>">
																			<?php echo $folder['data']->name ?>
																		</a>
																	</h4>
																</section>
																<section id="3collapseInnerOne<?php echo $folder['data']->id; ?>" class="panel-collapse collapse " role="tabpanel" aria-labelledby="3headingInnerOne<?php echo $folder['data']->id; ?>">
																	<section class="panel-body">
																	<?php
																	foreach($folder['rows'] as $page)
																	{
																		
																			echo " <input type='checkbox' ".(isset($values)?(in_array($page->user_id, json_decode($values))?"checked='checked'":""):'')." name='".$input."[]' value='".$page->user_id."' /> <span >".$page->username."</span><br>";
																	}
																	?>
																	</section>
																</section>
															</section>										
															<?php


														}



												}
													?>				
												</section>
											
										<?php

									}
									?>
									

									</section>
								</section>
							</section>
								<?php			
							
				<section class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					
												<?php
									if(isset($values))
									{
										$values=json_decode($values);
									}
												
												$arraytypes=array(
													array("name"=>"group","title"=>"Grupos"),
													array("name"=>"user","title"=>"Usuarios"),
													array("name"=>"page","title"=>"Páginas"),
													array("name"=>"event","title"=>"Eventos"));
												for($i=0;$i<count($arraytypes);$i++)
					{
						
							
							
							if($arraydata[$arraytypes[$i]['name']]['count']>0)
							{
								?>
									<section class="panel panel-default">
								<section class="panel-heading" role="tab" id="2headingOne<?php echo $i; ?>">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#2accordion" href="#2collapseOne<?php echo $i; ?>" aria-expanded="false" aria-controls="2collapseOne<?php echo $i; ?>">
											<?php echo $arraytypes[$i]['title']; ?>
										</a>
									</h4>
								</section>
								<section id="2collapseOne<?php echo $i; ?>" class="panel-collapse collapse " role="tabpanel" aria-labelledby="2headingOne<?php echo $i; ?>">
									<section class="panel-body">
									<?php
									foreach($arraydata[$arraytypes[$i]['name']]['nofolder'] as $page)
									{
										$val=(($arraytypes[$i]['name']=="user")?$page->user_id:$page->idaccount);
										$check="";
										$table=(($arraytypes[$i]['name']=="user")?'user':'account');
																	
										if(isset($values->$table))
										{
											
											if(in_array($val, $values->$table))
											{
												$check="checked='checked'";
											}	
										}

										echo " <input type='checkbox' ".$check." name='".$input."[".(($arraytypes[$i]['name']=="user")?'user':'account')."][]' value='".(($arraytypes[$i]['name']=="user")?$page->user_id:$page->idaccount)."' />&nbsp;&nbsp;&nbsp; <span >".(($arraytypes[$i]['name']=="user")?$page->username:$page->name)."</span>&nbsp;&nbsp;<br>";
									}
									if(count($arraydata[$arraytypes[$i]['name']]['folders'])>0)
									{
										?>
												<section class="panel-group" id="2accordion<?php echo $i; ?>" role="tablist" aria-multiselectable="true">						
													<?php
														foreach ($arraydata[$arraytypes[$i]['name']]['folders'] as $folder) {
																if(count($folder['rows'])>0)
																{
																	?>
																	<section class="panel panel-default">
																		<section class="panel-heading" role="tab" id="2headingInnerOne<?php echo $folder['data']->id; ?>">
																			<h4 class="panel-title">
																				<a data-toggle="collapse" data-parent="#2accordion<?php echo $i; ?>" href="#2collapseInnerOne<?php echo $folder['data']->id; ?>" aria-expanded="false" aria-controls="2collapseInnerOne<?php echo $folder['data']->id; ?>">
																					<?php echo $folder['data']->name ?>
																				</a>
																			</h4>
																		</section>
																		<section id="2collapseInnerOne<?php echo $folder['data']->id; ?>" class="panel-collapse collapse " role="tabpanel" aria-labelledby="2headingInnerOne<?php echo $folder['data']->id; ?>">
																			<section class="panel-body">
																			<?php
																			foreach($folder['rows'] as $page)
																			{
																				$val=(($arraytypes[$i]['name']=="user")?$page->user_id:$page->idaccount);
																				$check="";
																				$table=(($arraytypes[$i]['name']=="user")?'user':'account');
																											
																				if(isset($values->$table))
																				{
																					
																					if(in_array($val, $values->$table))
																					{
																						$check="checked='checked'";
																					}	
																				}
																				echo " <input type='checkbox' ".$check." name='".$input."[".(($arraytypes[$i]['name']=="user")?'user':'account')."][]' value='".(($arraytypes[$i]['name']=="user")?$page->user_id:$page->idaccount)."' />&nbsp;&nbsp;&nbsp; <span >".(($arraytypes[$i]['name']=="user")?$page->username:$page->name)."</span>&nbsp;&nbsp;<br>";
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
							}
						}
							?>      
						</section>
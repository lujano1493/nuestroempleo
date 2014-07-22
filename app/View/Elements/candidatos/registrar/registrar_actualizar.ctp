<div class="row-fluid" > 
		<div class="info_completa" style="display:none"> 
			
Tu registro se llevo a cabo de manera exitosa, se ha enviado una contraseña a su correo electrónico; con ella podra acceder a NuestroEmpleo .
		</div>
	<div class="span12 formulario" title="Datos Personales"  data-form="Candidato" > 				
		<?= 
			$this->Form->create('Candidato', array('action'=>"actualizar",'id'=>'form_candidato_edit' ));  
		 ?>
			<input id="config_form_edita_perfil_candidato" class="" value=""  type="hidden" />
			<input type="hidden" name="data[type]" value="simple" />
			<?php echo $this->Form->input("Candidato.candidato_cve",
				array( 
					'id'=> 'candidato_cve_edit',
					'class'=>"candidato_cve",
					"type"=>'hidden'
					));   ?>

					<div class="row-fluid">
						<div class="span12 "> 
							<?php echo $this->Form->input("Candidato.candidato_perfil",
								array( 
									"label"=>"Titulo de Perfil*",
									"class"=>"span11 ",
									"placeholder"=>'Agrega titulo de perfil'
									)
									);   ?>
								</div>

							</div>

							<div class="row-fluid"> 

								<div class="span4 "> 
									<?php 	echo $this->Form->input ('Candidato.candidato_nom', array(
										'id'=>'candidato_nom_edit',
										'class'=>'input-medium ',
										'label'=>'Nombre*:',							
										'placeholder' => ''));  

										?>		
									</div>

									<div class="span4 "> 
										<?php 	echo $this->Form->input ('Candidato.candidato_pat', array(
											'id'=>'candidato_pat_edit',
											'class'=>'input-medium ',
											'label'=>'Apellido Paterno*:',	
											'placeholder' => ''));  ?>		
										</div>
										<div class="span4"> 
											<?php 	echo $this->Form->input ('Candidato.candidato_mat', array(
												'id'=>'candidato_mat_edit',
												'class'=>'input-medium ',
												'label'=>'Apellido Materno:',	
												'placeholder' => ''));  ?>		
											</div>
										</div>



										<div class="row-fluid"> 
											<div class="span4 "> 
												<label> Genero </label>


												<?php 	echo $this->Form->input ('Candidato.candidato_sex', array(
													'type'=>'radio',
													'options'=> array ("M"=>"Masculino","F"=>"Femenino"),
													'legend'=> false,
													'div'=> array ('class'=>"group-radio" ),
													'placeholder' => ''));  ?>		

												
											</div>
											<div class="span4 "> 
												<?php 	echo $this->Form->input ('Candidato.candidato_fecnac', array(
													'id'=>'candidato_fecnac_edit',
													'type'=>'text',
													'class'=>'input-small date-picker',
													'label'=>'Fecha de Nacimiento*:',	
													'placeholder' => ''));  ?>		
												</div> 
												<div class="span4 "> 
													<?php echo $this->CodigoPostal->inputCodigoPostal("DirCandidato.CodigoPostal.cp_cp","cp_cp_edit","Codigo Postal*:"); ?>	

												</div> 


											</div>

											<div class="row-fluid"> 
												<div class="span4 "> 
													<?php 	echo $this->Form->input ('DirCandidato.CodigoPostal.Estado.est_nom', array(
														'disabled'=>true,
														'class'=>'input-medium est_nom',	
														'label'=>'Estado:',		
														'placeholder' => '' ));  ?>		

													</div>
													<div class="span4 "> 
														<?php 	echo $this->Form->input ('DirCandidato.CodigoPostal.Ciudad.ciudad_nom', array(
															'disabled'=>true,
															'class'=>'input-medium ciudad_nom',
															'label'=>'Ciudad',	
															'placeholder' => '' ));  ?>

														</div>
														<div class="span4 "> 
															<label>Colonia </label>
															<?php 											

															echo $this->Form->input ('DirCandidato.CodigoPostal.cp_asentamiento', array(
																'options'=>array (""=>"Selecciona Opción")+ $asentamientos_list,
																'class'=>'input-medium cp_asentamiento',
																'value'=>$this->data['DirCandidato']['cp_cve'],
																'label' => false,
																));
															echo $this->Form->input ('DirCandidato.candidato_cve', array(
																'class'=>'candidato_cve',
																'type'=>'hidden',

																));  
															echo $this->Form->input ('DirCandidato.cp_cve', array(
																'class'=>'cp_cve',
																'type'=>'hidden',

																));  
															echo $this->Form->input ('DirCandidato.dir_cve', array(
																'class'=>'dir_cve',
																'type'=>'hidden',

																)); 
																?>



															</div>

														</div>
														<div class="row-fluid"> 

															<div class="span4 "> 
																<?php 
																echo $this->Form->input('Candidato.candidato_movil',array( 
																	'id'=>'candidato_movil_edit',										
																	'class'=>'input-medium ',
																	'label'=>array ("class"=>"","text"=>"Teléfono Movil*:"),
																	
																	'div' => array ("class"=>false ))) ;  

																	?>
																</div>

																<div class="span4 "> 
																	<?php 
																	echo $this->Form->input('Candidato.candidato_tel',array( 
																		'id'=>'candidato_tel_edit',										
																		'class'=>'input-medium ',
																		'label'=>array ("class"=>"","text"=>"Teléfono Fijo:"),

																		'div' => array ("class"=>false ))) ;  

																		?>
																	</div>

																<div class="span4 "> 
																	<?php 
																	echo $this->Form->input('Candidato.edo_civil',array( 									
																		'class'=>'input-medium ',
																		'label'=>array ("class"=>"","text"=>"Estado Civil:"),
																		'options'=>$estado_civil_arr,
																		'div' => array ("class"=>false ))) ;  

																		?>
																	</div>

																</div>

																<div class="row-fluid "> 
																	<div class="span12">
																		<div class="control"> 
																			<div class="area clearfix">

																				<div class="bottons text-left float-left" > 
																					<button class='btn btn-success  guardar_actualizacion'> 
																						Guardar Datos Personales
																					</button>
																				</div>
																				<div class="loading float-left"> 
																					<img src='<?php echo $this->webroot;?>img/candidatos/load.gif'  />  
																				</div> 
																				<div class="text-center float-left">

																					<div class="status">  </div> 							
																				</div>
																			</div>
																		</div>									
																	</div>
																</div>


															<?=$this->Form->end()?>

														</div>

													</div>
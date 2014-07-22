						<div class="row-fluid"> 
							<div class="span6  "> 
									<?php 	echo $this->form->input ('CandidatoUsuario.cc_email', array(
																			'id'=>'cc_email',
																			'class'=>'',
																			'label'=>'Correo*:',	
																			 'placeholder' => '' ));  ?>		
							
								
							</div>
							
							<div class="span6 "> 
									<?php 	echo $this->form->input ('CandidatoUsuario.cc_email_', array(
																			'id'=>'cc_email_',
																			'class'=>'',
																			'label'=>'Confirma Correo*:',	
																			 'placeholder' => '' ));  ?>		
							
								
							</div>
							
						</div>
						
						
						<div class="row-fluid"> 
						
							<div class="span4 "> 
									<?php 	echo $this->form->input ('Candidato.candidato_nom', array(
																			'id'=>'candidato_nom',
																			'class'=>'input-medium ',
																			'label'=>'Nombre*:',	
																			 'placeholder' => ''));  ?>		
							</div>
						
							<div class="span4 "> 
									<?php 	echo $this->form->input ('Candidato.candidato_pat', array(
																			'id'=>'candidato_pat',
																				'class'=>'input-medium ',
																			'label'=>'Apellido Paterno*:',	
																			 'placeholder' => ''));  ?>		
							</div>
							<div class="span4"> 
									<?php 	echo $this->form->input ('Candidato.candidato_mat', array(
																			'id'=>'candidato_mat',
																			'class'=>'input-medium ',
																			'label'=>'Apellido Materno:',	
																			 'placeholder' => ''));  ?>		
							</div>
						</div>
						
						<div class="row-fluid"> 
							<div class="span4 "> 
								<label> Genero </label>
								<div id="div_radio_genero"  class="group_radio"> 
								
									<input type="radio" id="persona_sexM" name="data[Candidato][candidato_sex]" checked="checked" value="M" /><label for="persona_sexM">M</label>
									<input type="radio" id="persona_sexF" name="data[Candidato][candidato_sex]"  value="F" /><label for="persona_sexF">F</label>
								</div>
							</div>
							<div class="span4 "> 
									<?php 	echo $this->form->input ('Candidato.candidato_fecnac', array(
																			'id'=>'candidato_fecnac',
																			'type'=>'text',
																			'class'=>'input-small',
																			'label'=>'Fecha de Nacimiento*:',	
																			 'placeholder' => ''));  ?>		
							</div> 
							<div class="span4 "> 
								<?php echo $this->CodigoPostal->inputCodigoPostal("DirCandidato.CodigoPostal.cp_cp","cp_cp_Edit","Codigo Postal*:"); ?>	
								
							</div> 
							
							
						</div>
						<div class="row-fluid"> 
							<div class="span4 "> 
								<?php 	echo $this->form->input ('DirCandidato.CodigoPostal.Estado.est_nom', array(
																		'class'=>'input-medium est_nom',	
																		'disabled'=>true,	
																		'label'=>'Estado:',		
																		 'placeholder' => '' ));  ?>		
								
							</div>
							<div class="span4 "> 
								<?php 	echo $this->form->input ('DirCandidato.CodigoPostal.Ciudad.ciudad_nom', array(
																	'class'=>'input-medium ciudad_nom',
																	'disabled'=>true,
																	'label'=>'Ciudad',	
																	 'placeholder' => '' ));  ?>
								
							</div>
							<div class="span4 "> 
								<label>Colonia </label>
								<?php 	echo $this->form->input ('DirCandidato.CodigoPostal.cp_asentamiento', array(
																	'options'=>array (""=>"Selecciona Opción"),
																	'class'=>'input-medium cp_asentamiento',
																	'label' => false,
																	
																	 ));
										echo $this->form->input ('DirCandidato.candidato_cve', array(
																'class'=>'candidato_cve',
																'type'=>'hidden',

																));  
										echo $this->form->input ('DirCandidato.cp_cve', array(
																'class'=>'cp_cve',
																'type'=>'hidden',

																));  
										echo $this->form->input ('DirCandidato.dir_cve', array(
																'class'=>'dir_cve',
																'type'=>'hidden',

																)); 


																	 ?>
																	 
								
								
							</div>
						
						</div>
						<div class="row-fluid"> 
						
							<div class="span4 "> 
									<?php 
											echo $this->form->input('Candidato.candidato_movil',array( 
																	'id'=>'candidato_movil',										
																	'class'=>'input-medium ',
																	'label'=>array ("class"=>"","text"=>"Teléfono Movil*:"),
																	
																	'div' => array ("class"=>false ))) ;  
									
									?>
							</div>
							<div class="span8  ">
								<?php echo $this->element('Candidatos/tool/captcha'); ?>	
							</div>
						</div>
						
						<div class="row-fluid"> 
							
							<div class="span4 offset4"> 								
								<div class="group_radio ">	
									<div> &nbsp;</div>
									<input type='checkbox' name="data[Candidato][terminos]" value="S"  /> <a href="#">Acepto términos y condiciones </a>
								</div>
							</div>
							
						</div>
<div  class="formulario explaboral <?=$save?>" title="Experiencia Laboral" data-form="ExpLabCan"  > 
	<form >
		<input type="hidden" id="areas_interes"  />
		<div class="row-fluid">					
			<div class="span11 ">

				<label> &nbsp;</label> 
				<?php 	

				echo $this->form->input ('ExpLabCan.'.$i.'.candidato_cve',
					array(
						'value'=>$candidato_cve ,
						'class'=>"candidato_cve",
						'type'=>'hidden'));  


				echo $this->form->input ('ExpLabCan.'.$i.'.explab_cve',
					array(
						'class'=>"explab_cve",
						'type'=>'hidden'));  					

						?>		
						<?php
							$type="radio";
							$options_input=array(		
								'before' => "<label> ¿Trabaja Actualmente? </label>",
								'class'=>"explab_actual",							
								'div' => array("class"=>"explab_actual_div group-radio"),
								'legend' => false,
								"type"=>'radio',
								'options'=> $siono
								);
							if($i>0){
								$options_input["before"]="";
								$options_input["type"]="hidden";
								$options_input["value"]="N";
							}?>
							
							<?php							
							echo $this->form->input ('ExpLabCan.'.$i.'.explab_actual',$options_input);   ?>

							</div>
							<div class="span1"> 
								<div class=" tool">  
									<a href="#" class="eliminar_registro" title="Eliminar Referencia">x</a>
								</div>
							</div>

						</div>

						<div class="row-fluid">					

							<?php

							echo $this->form->input ('ExpLabCan.'.$i.'.explab_empresa',
								array(		
									'class'=>"input-large explab_empresa",
									'div' =>array("class"=>"span4 "),
									'label'=>"Empresa*:"
									));  

							echo $this->form->input ('ExpLabCan.'.$i.'.giro_cve',
								array(		
									'class'=>"input-large giro_cve",
									'div' =>array("class"=>"span4 "),
									'label'=>"Giro*:",
									'options'=> $giro_cve_arr
									));  
							echo $this->form->input ('ExpLabCan.'.$i.'.explab_puesto',
								array(		
									'class'=>"input-large explab_puesto",
									'div' =>array("class"=>"span4 "),
									'label'=>"Puesto*:"
									));  

									?>

								</div>


								<div class="row-fluid">			
									<div class="span4 "> 
										<label> Fecha Inicial*: </label>
										<div  id="actualizarExpLabCan<?=$i?>explab_fecini" name="data[ExpLabCan][<?=$i?>][explab_fecini]"  class="explab_fecini date-picker date-picker-month-year date-start"> 
											<?=$this->form->input("ExpLabCan.$i.explab_fecini",
											array("class"=>' hide','type'=>'hidden')) ?>
										</div>
									</div>
									<div class="span4 "> 

											<?php 
													$hide="";$disabled="";
														if($i<$count){
															$explab_actual=$this->data['ExpLabCan'][$i]['explab_actual'];
															$hide=($explab_actual=="S")?"hide":"";
															$disabled=($explab_actual=="S")?"disabled":"";
														}
											?>
										<label> Fecha Final: </label>
										<div  id="actualizarExpLabCan<?=$i?>explab_fecfin"  name="data[ExpLabCan][<?=$i?>][explab_fecfin]" class="explab_fecfin date-picker date-picker-month-year date-end <?=$hide ?>"  > 


											<?=$this->form->input("ExpLabCan.$i.explab_fecfin",
											array("class"=>' hide','type'=>'hidden')) ?>

										</div>
									</div>
								 		
								
								</div>
												<div class="row-fluid"> 

													<?= $this->form->input ('ExpLabCan.'.$i.'.explab_web',
														array(		
															'class'=>"imput-large explab_web",
															'div'=>array ("class"=>"span4 "),
															'label' =>"Pagina Web:"
															));   ?>

													<?= $this->form->input ('ExpLabCan.'.$i.'.explab_funciones',
														array(								
															'class'=>"textarea-xlarge explab_funciones",	
																
															'div' => array("class"=>"span8 "),						
															'label' => 'Funciones*:'
															))

															?>
														</div>


													</form >
</div > 
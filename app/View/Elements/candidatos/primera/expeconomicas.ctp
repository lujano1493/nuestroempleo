
<div class="row-fluid"> 
	<div class="span12">
		<div class="title margin_title text-left" >Disponibilidad y expectativas de Trabajo </div>
	</div>
</div>

<div class="row-fluid ">
	<div class="span1"> </div>

	<div class="span10 formulario" title="Expectativas de Trabajo"  data-form="ExpEcoCan"  data-save="Guardar"  > 
		<form  id="form_actualizar_expeco" class="">
			<input id="config_validation_edit_ecoexp" type='hidden'  /> 
			<input type="hidden" name="data[type]" value="simple" />
			<div class="row-fluid"> 

				<div class="span4 "> 
					<?php 	

					echo $this->form->input ('ExpEcoCan.candidato_cve',
						array(
							'value'=>$this->data['Candidato']['candidato_cve'] ,
							'class'=> "candidato_cve",
							'name'=>"data[ExpEcoCan][candidato_cve]",
							'type'=>'hidden'));  


					echo $this->form->input ('ExpEcoCan.explab_cve',
						array(
							"class"=>"explab_cve",
							'type'=>'hidden'));  



					echo $this->form->input ('ExpEcoCan.expeco_tipoe', array(
						'options'=>$tipo_empleo_arr,
						'class'=>'input-medium expeco_tipoe',
						'label'=>'Disponibilidad*:',	
						'placeholder' => '')); 

						?>		

					</div> 
					<div class="span4 "> 
						<?php 	echo $this->form->input ('ExpEcoCan.explab_sa', array(		
							'options'=>$elsueldo_cve_arr,
							'class'=>'input-medium explab_sa',
							'label'=>'Sueldo Actual*:',	
							'placeholder' => ''));  ?>		

						</div> 
						<div class="span4 "> 
							<?php 	echo $this->form->input ('ExpEcoCan.explab_sd', array(								
								'options'=>$elsueldo_cve_arr,
								'class'=>'input-medium explab_sd',
								'label'=>'Sueldo Deseado*:',	
								'placeholder' => ''));  ?>		

							</div> 


						</div>

						<div class="row-fluid"> 
							<div class="span4 "> 

								<?php 	

								echo  $this->Form->label('explab_viajar_edit', 'Dispuesto a Viajar*:');
								echo $this->form->input ('ExpEcoCan.explab_viajar', array(
									'type'=>'radio',
									'legend'=>false,
									'options'=>$siono,
									'class'=>'input-medium ',
									'div'=> array ("class"=>"group-radio text-center"),
									'label'=>'Dispuesto a Viajar*:',	
									'placeholder' => ''));  ?>		

								</div> 

								<div class="span4 "> 
									<?php 	


									echo $this->Form->label('explab_reu_edit', 'Dispuesto a Reubicarse*:');
									echo $this->form->input ('ExpEcoCan.explab_reu', array(
										'type'=>'radio',
										'legend'=>false,
										'options'=>$siono,
										'class'=>'input-medium ',
										'div'=> array ("class"=>"group-radio text-center" ),
										'placeholder' => ''));  ?>		

									</div> 

								</div>

						


							</form>

						</div> 

						<div class="span1"> </div>
					</div>
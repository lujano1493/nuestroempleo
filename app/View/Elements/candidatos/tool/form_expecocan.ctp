

<?php  
	$form_begin= "primera"!=$action?  "<div class='formulario expecocan' > ".
	$this->Form->create("ExpEcoCan",  array( 'url'=>  array('controller'=>'Candidato','action' => 'guardar_actualizar/ExpEcoCan'),
			        "class"=>'form-horizontal well',
			        'data-component' => 'validationform ajaxform' 
			         ) )  
			           :"";
	$form_end=  "primera"!=$action?  $this->Form->submit("Guardar", array("class"=>'btn_color pull-right',
																		  "div"=>array("class"=>'form-actions'))
																	). $this->Form->end()."</div>" :"";



?>

<?=$form_begin ?> 

		<?php if  ("primera" == $action  )  : ?>
			<h4>Expectativas  Económicas y Tipo de Empleo </h4>
		<?php endif;  ?>
		<input id="config_validation_edit_ecoexp" type='hidden'  /> 
		<input type="hidden" name="data[type]" value="simple" />
		<div class="row-fluid"> 

			<div class="span4 "> 
				<?php 	

				echo $this->Form->input('ExpEcoCan.candidato_cve',
					array(
						'value'=>$candidato_cve, 
						'class'=> "candidato_cve"));  



				echo $this->Form->input('ExpEcoCan.expeco_tipoe', array(
					'options'=>$list['tipo_empleo'],
					'class'=>'input-medium-formulario-formulario expeco_tipoe',
					'label'=>'Tipo de Empleo*:',	
					'placeholder' => '')); 

					?>		

				</div> 
				<div class="span4 "> 
					<?php 	echo $this->Form->input('ExpEcoCan.explab_sueldoa', array(		
						'options'=>$list['elsueldo_cve'],
						'class'=>'input-medium-formulario explab_sueldoa',
						'label'=>'Sueldo Actual*:',	
						'placeholder' => ''));  ?>		

					</div> 
					<div class="span4 "> 
						<?php 	echo $this->Form->input('ExpEcoCan.explab_sueldod', array(
							'class'=>'input-medium-formulario explab_sueldod',
							'options'=>$list['elsueldo_cve'],
							'label'=>'Sueldo Deseado*:',	
							'placeholder' => ''));  ?>		

						</div> 


					</div>

					<div class="row-fluid"> 
						<div class="span4 "> 

							<?php 	

							echo  $this->Form->label('explab_viajar_edit', 'Dispuesto a Viajar*:');
							echo $this->Form->input('ExpEcoCan.explab_viajar', array(
								'type'=>'radio',
								'hiddenField'=>false, 
								'legend'=>false,
								'options'=>$list['siono'],
								'class'=>'input-medium-formulario ',
								'div'=> array ("class"=>"group-radio text-center"),
								'label'=>true,	
								'placeholder' => ''));  ?>		

							</div> 

							<div class="span4 "> 
								<?php 	


								echo $this->Form->label('explab_reu_edit', 'Dispuesto a Reubicarse*:');
								echo $this->Form->input('ExpEcoCan.explab_reu', array(
									'type'=>'radio',
									'hiddenField'=>false, 
									'legend'=>false,
									'options'=>$list['siono'],
									'class'=>'input-medium-formulario ',
									'label'=>true,
									'div'=> array ("class"=>"group-radio text-center" )));  ?>		

								</div> 

							</div>

						

						
<?=$form_end ?> 
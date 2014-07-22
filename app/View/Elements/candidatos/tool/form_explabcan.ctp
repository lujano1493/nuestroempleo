<?php 
	$options_hiddenform=json_encode( array("options"=>array("S"=>"N","N"=>"S"),
									  "name"=>"explab_actual","hasdate"=>true,"target"=>".fecha_final_explab"));


?>




	

		<div class="row-fluid">				
			<div class="span4"> 

					<?php if($i==0) :?>
							<label> ¿Trabajas Actualmente?</label> 
					<?php endif ?>
				
				<?php 	

				echo $this->Form->input ('ExpLabCan.'.$i.'.candidato_cve',
					array(
						'value'=>$candidato_cve ,
						'class'=>"candidato_cve",
						'type'=>'hidden'));  


				echo $this->Form->input ('ExpLabCan.'.$i.'.explab_cve',
					array(
						'class'=>"explab_cve",
						'class'=>"primary-key explab_cve",
						'data-primarykey'=> json_encode(array("name_model"=>"ExpLabCan") ),
						'type'=>'hidden'));  					

						?>		
						<?php
							$type="radio";
							$options_input=array(		
								'class'=>"explab_actual",	
								'hiddenField'=>false,						
								'div' => array("class"=>"explab_actual_div group-radio"),
								'legend' => false,
								"type"=>'radio',
								'options'=> $list['siono'],
								'label'=>true
								);
							if($i>0){
								$options_input["before"]="";
								$options_input["type"]="hidden";
								$options_input["value"]="N";
							}						
							echo $this->Form->input ('ExpLabCan.'.$i.'.explab_actual',$options_input);   ?>
			</div>
			<div class="span4">
				<?=$this->Form->input ('ExpLabCan.'.$i.'.explab_empresa',
					array(		
						'class'=>"input-medium-formulario explab_empresa",
						'div' =>array("class"=>"controls "),
						'label'=>"Empresa*:"
						)) ?>
			</div>
			<div class="span4">
				<?=$this->Form->input ('ExpLabCan.'.$i.'.giro_cve',
					array(		
						'class'=>"input-medium-formulario giro_cve",
						'div' =>array("class"=>"controls "),
						'label'=>"Giro*:",
						'options'=> $list['giro_cve']
						)) ?>
			</div>
		

		</div>


				<div class="row-fluid">			
					<div class="span4">
						<?=$this->Form->input ('ExpLabCan.'.$i.'.explab_puesto',
							array(		
								'class'=>"input-medium-formulario explab_puesto",
								'div' =>array("class"=>"controls "),
								'label'=>"Puesto*:"
								))?>
					</div>

					<div class="span4 "> 
						<label> Fecha Inicial*: </label>
						<div  id="actualizarExpLabCan<?=$i?>explab_fecini" name="data[ExpLabCan][<?=$i?>][explab_fecini]"  class="explab_fecini date-picker date-picker-month-year date-start"> 
							<?=$this->Form->input("ExpLabCan.$i.explab_fecini",
							array("class"=>' hide','type'=>'hidden')) ?>
						</div>
					</div>
					<div class="span4 "> 

							<?php 
									$hide="";$disabled="";
										if($i<$count){
											if(!empty($this->data['ExpLabCan'])){
												$explab_actual=$this->data['ExpLabCan'][$i]['explab_actual'];
												$hide=($explab_actual=="S")?"hide":"";
												$disabled=($explab_actual=="S")?"disabled":"";
											}
											
										}
							?>
						<div class="fecha_final_explab">
								<label> Fecha Final: </label>
						<div  id="actualizarExpLabCan<?=$i?>explab_fecfin"  name="data[ExpLabCan][<?=$i?>][explab_fecfin]" class="explab_fecfin date-picker date-picker-month-year date-end"  > 


							<?=$this->Form->input("ExpLabCan.$i.explab_fecfin",
							array("class"=>' hide','type'=>'hidden')) ?>
						</div>
					

						</div>
					</div>
					
				
				</div>
<div class="row-fluid"> 
	<div class="span4">
						<?= $this->Form->input ('ExpLabCan.'.$i.'.explab_web',
											array(		
											'class'=>"input-medium-formulario explab_web",
											'div'=>array ("class"=>"controls "),
											'label' =>"Página Web:"
											)); ?>


	</div>
	<div class="span7">

	<?php 
			$options=array(								
											'class'=>"input-medium-formulario explab_funciones",											
											'div' => array("class"=>"controls "),						
											'label' => 'Funciones*:'
											);

			if($action == "primera") {
				$options['data-component']="tooltip";
				$options['data-placement']="bottom";
				$options['data-title'] ="   Redacta de forma concisa las funciones y/o actividades realizadas en tu puesto. Ejemplo: Planificación de base de datos,  Realización de reportes de Hacienda y Conciliaciones Bancarias. ";

			}


	?>

		<?= $this->Form->input ('ExpLabCan.'.$i.'.explab_funciones',
											$options)
		?>
	</div>


</div>

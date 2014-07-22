<?php  $i=0; $model=""; $save="" ; $count=0;?>
<div  class="formulario educacion_escolar" title="Educación" data-form="EscCan"  > 
	<div class="title"> Último Nivel de Estudios </div>

	<form >
		<input type="hidden" id="escolar"  />


		<div class="row-fluid">					
			<div class="span11 ">
			<label> &nbsp;</label> 
			<?php
				$type="radio";
				$options_input=array(		
					'before' => "<label> ¿Estudias Actualmente? </label>",
					'class'=>"ec_actual",							
					'div' => array("class"=>"ec_actual_div group-radio"),
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
					echo $this->form->input ('EscCan.'.$i.'.ec_actual',$options_input);  
				?>

			</div>
		

		</div>

		
		<div class="row-fluid">					
			<div class="span6 ">			
				<?php 	

				echo $this->form->input ('EscCan.'.$i.'.candidato_cve',
					array(
						'value'=>$candidato_cve ,
						'class'=>"candidato_cve",
						'type'=>'hidden'));  


				echo $this->form->input ('EscCan.'.$i.'.ec_cve',
					array(
						'class'=>"ec_cve",
						'type'=>'hidden'));  

				echo  $this->form->input ('EscCan.'.$i.'.ec_nivel',
					array(								
						'class'=>" input-xlarge ec_nivel",
						'options' => $ec_nivel_arr,				
						'div' => false,
						'label' => 'Max. Nivel Estudio*:'
						));


						?>		
						

					</div>
					<div class="span6 ">			
						<?php 
						echo  $this->form->input ('EscCan.'.$i.'.ec_institucion',
							array(								
								'class'=>" input-xlarge ec_institucion",			
								'div' => false,
								'label' => 'Institución*:'
								));

								?>

					</div>

		</div>

		<div class="row-fluid">					
			<div class="span4 "> 
				<label> Fecha Inicial*: </label>
				<div  id="actualizarEscCan<?=$i?>Ec_fecini" name="data[EscCan][<?=$i?>][ec_fecini]"  class="ec_fecini date-picker date-picker-month-year date-start"> 
					<?=$this->form->input("EscCan.$i.ec_fecini",
									array("class"=>' hide','type'=>'hidden')) ?>
				</div>
			</div>
			<div class="span4 "> 
				<label> Fecha Final: </label>
				<div  id="actualizarEscCan<?=$i?>Ec_fecfin"  name="data[EscCan][<?=$i?>][ec_fecfin]" class="ec_fecfin date-picker date-picker-month-year date-end"> 
					<?=$this->form->input("EscCan.$i.ec_fecfin",
									array("class"=>' hide','type'=>'hidden')) ?>

				</div>
			</div>
		</div>
		<div class="row-fluid">				
			<?php 
					$disabled=false;
					if($i< $count){	
						$EscCan=$this->data['EscCan'][$i];
						if($EscCan['ec_nivel']<=2){											
							$disabled=true;
							$model="";
						}
					}

					echo $this->form->input ('EscCan.'.$i.'.cespe_cve',
								array(								
									'class'=>" cespe_cve",
									'disabled'=>$disabled,
									'type' => 'text',															
									'label' => 'Carrera:'
									));
			?>
		</div>	
	


	</form >
</div>


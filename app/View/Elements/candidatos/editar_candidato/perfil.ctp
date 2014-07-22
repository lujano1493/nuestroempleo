<form id="perfil" class="view_">
	<input type="hidden" name="config_form" id="config_form_perfil" onchange="configurar_form_referencias(this);"  class='no_clear' />  	
	<div class="row-fluid">
		<div class="span1"> </div> 
		<div class="span3 ">
				<?php 
						echo $this->form->input('Perfil.empty',array(
																	'id'=>'empty',
																	'value'=>$this->data['Perfil']['empty'],
																	'type'=>'hidden'
																	));
						
						echo $this->form->input ('Perfil.Candidato.gpo_cve', array(
															'id'=>'gpo_cve',
															'class'=>'',
															'type'=>'hidden',															
															'label'=>false														
														));
			
			
						echo $this->form->input ('Perfil.Candidato.persona_cve', array(
															'id'=>'persona_cve',
															'type'=>'hidden',
															'label'=>false														
														));
			
						
						echo $this->form->input ('Perfil.Candidato.persona_nom', array(
															'id'=>'persona_nom',
															
															'type'=>'text',
															'label'=>array ("class"=>"label_","text"=>"Nombre(s) *"),	
															'class'=>'input-medium',
															"div"=>false,
															 'placeholder' => 'Nombre',															
															'onblur'=>'javascript:mayus(this);' )); 
				?>		
		</div>
	
	
		<div class="span3 "> 
		<?php 	echo $this->form->input ('Perfil.Candidato.persona_pat', array(
															'id'=>'persona_pat',
															
															'type'=>'text',
															'label'=>array ("class"=>"label_","text"=>"Primer Apellido *"),	
															'class'=>'input-medium',
															 'placeholder' => 'Primer Apellido *  ',
															'onblur'=>'javascript:mayus(this);' ));  ?>		
	
		</div>
		<div class="span3 "> 
		<?php 	echo $this->form->input ('Perfil.Candidato.persona_mat', array(
																'id'=>'persona_mat',
																
																'type'=>'text',
																'label'=>array ("class"=>"label_","text"=>"Segundo Apellido"),	
																'class'=>'input-medium ',
																 'placeholder' => 'Segundo Apellido',
																'onblur'=>'javascript:mayus(this);' ));  ?>			
	
		</div>
		
	</div>
	<div class="row-fluid">
		<div class="span1">  </div>
			<div class="span3 ">  
				<label for="" class="label_">Genero  </label>
				<?php 
					echo $this->form->input('Perfil.Candidato.persona_sex', array(
						'div' => array ('id'=>'div_radio_genero'),												
						'class'=> '',
						'legend' => false,
						'options' => array('M'=>'M', 'F'=>'F'),
						'type' => 'radio'
					));
				?>
			</div>
			<div class="span3 ">  		
				 	<?php 		echo $this->form->input('Perfil.Candidato.edocivil_cve',array(
																		 'class'=> 'input-medium ',
																		 
																		 'id'=>'edocivil_cve',
																		 'options'=> $edo_civil ,
																		 'label'=>array ("class"=>"label_","text"=>"Estado Civil"),	
																		 'div' => false)) ;   ?>		
			</div>
			<div class="span3 ">  		
						<?php 	
				echo $this->form->input ('Perfil.Candidato.persona_nac', array( 
					 'id'=>'persona_nac',					 
					 'class'=>'input-small',
					 'placeholder' => 'Fecha de Nacimiento',
					 'type'=>'text',
					 'label'=>array ("class"=>"label_","text"=>"Fecha de Nacimiento"),	
					 'value'=> $this->data['Perfil']['Candidato']['fecha_nacimiento'],'onchange'=>'calcularEdad(this)'  ));  ?>	
			</div>
	
	</div>
	<div class="row-fluid">
	<div class="span1">  </div>
		<div class="span3 ">  
			 <?php 	
			echo $this->form->input('Perfil.Estado.est_cve',array( 
															'id'=>'est_cve',
															
															'class'=>'input-medium ',
															'options'=> $estados ,
															 'label'=>array ("class"=>"label_","text"=>"Estado"),	
															'div' => false,
															'onchange'=>'javascript:getCiudad(this,"#ciudad_cve")')) ;  ?>	
		</div>
		<div class="span3 ">  
		 <?php 	
			echo $this->form->input('Perfil.Candidato.ciudad_cve',array( 
															'id'=>'ciudad_cve',
															
															'class'=>'input-medium ',
															'options'=> $ciudad_cve ,
															 'label'=>array ("class"=>"label_","text"=>"Ciudad"),	
															'div' => false   )) ;  ?>	

		</div>
		<div class="span3 ">  
		 	<?php 	echo $this->form->input ('Perfil.Candidato.persona_curp', array(
															'id'=>'persona_curp',
															
															'class'=>'input-medium ',
															'type'=>'text',
															'label'=>array ("class"=>"label_","text"=>"CURP"),	
															 'placeholder' => 'CURP',
															'onblur'=>'javascript:mayus(this);' ));  ?>		
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4">  
		
			
		</div>
		<div class="span4 ">  
			<?php 	echo $this->form->input ('Perfil.Candidato.persona_imss', array(
															'id'=>'persona_imss',
															
															'class'=>'input-medium ',
															'type'=>'text',
															 'label'=>array ("class"=>"label_","text"=>"IMSS"),	
															 'placeholder' => 'IMSS' ));  ?>	
		</div>
		<div class="span4">  
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
			
		</div>
	</div>	
	<div class="row-fluid" id="control">
		<div class="span1"> </div>
		<div class="span9">
			<button id="boton_" class="btn pull-right">Cargando</button> 
		</div>
	</div>	
	<div class="row-fluid">
		<div class="span12">
			
		</div>
	</div>	
</form>


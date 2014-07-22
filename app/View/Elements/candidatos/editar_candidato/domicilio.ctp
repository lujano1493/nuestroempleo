<form id="domicilio" class="view_ "  >		
	<input type="hidden" name="config_form" id="config_form_domicilio" onchange="configurar_form_referencias(this);"  class='no_clear' />  
	<div class="row-fluid">
	
		<div class="span1"> </div>
	
		<div class="span3 ">
				<?php 
							echo $this->form->input('Direccion.empty',array(
																	'id'=>'empty',
																	'type'=>'hidden'
																	));

		
					echo $this->form->input ('Direccion.DirPersona.persona_cve', array(
															'id'=>'persona_cve',
															'type'=>'hidden',
															'label'=>false ));  
					
					echo $this->form->input ('Direccion.CodigoPostal.cp_cp', array(
															'id'=>'cp_cp',
															'class'=>'input-small',
															
															'type'=>'text',
															'onblur'=>'buscar_codigo("cp_cp")',
															'label'=>array ("class"=>"label_","text"=>"Código Postal"),	
															 'placeholder' => 'Código Postal' ));  ?>	
		</div>
	
	
		<div class="span3"> <div id="load_info"> </div> 
	
		</div>
		<div class="span3 "> 
		<?php 	echo $this->form->input ('Direccion.Pais.pais_nom', array(
															'id'=>'pais_nom',
															'type'=>'text',
															'class'=>'input-medium disabled_',
															'disabled'=>true,
															'label'=>array ("class"=>"label_","text"=>"Pais"),
															 'placeholder' => 'Pais' ));  ?>
	
		</div>
		
	</div>
	<div class="row-fluid">
			<div class="span1"> </div>
			<div class="span3 ">  
			<?php 	echo $this->form->input ('Direccion.Estado.est_nom', array(
															'id'=>'est_nom',
															'type'=>'text',
															'class'=>'input-medium disabled_',
															'disabled'=>true,
															'label'=>array ("class"=>"label_","text"=>"Estado"),
															 'placeholder' => 'Estado' ));  ?>		
			</div>
			<div class="span3 ">  		
							<?php 	echo $this->form->input ('Direccion.Municipio.ciudad_nom', array(
															'id'=>'ciudad_nom',
															'type'=>'text',
															'class'=>'input-medium disabled_',
															'disabled'=>true,
															'label'=>array ("class"=>"label_","text"=>"Ciudad"),
															 'placeholder' => 'Ciudad' ));  ?>
			</div>
				<div class="span3 ">  		
					<label class="label_">Colonia </label>				
				<?php 	echo $this->form->input ('Direccion.CodigoPostal.cp_asentamiento', array(
															'id'=>'cp_asentamiento',
															'type'=>'text',
															'class'=>'edit_to_label',
															'readonly'=>true,
															'label'=>false,
															'placeholder' => 'Colonia',
															
															 ));  ?>
				<?php 	echo $this->form->input ('Direccion.DirPersona.cp_cve', array(
															'id'=>'cp_cve',
															'type'=>'hidden',
															'label'=>false

															 ));  ?>
				
				
			</div>
	
	</div>
	<div class="row-fluid">	
		<div class="span1"> </div>
		<div class="span3 ">  
			<?php 	echo $this->form->input ('Direccion.DirPersona.dirper_callenum', array(
															'id'=>'dirper_callenum',
															'type'=>'text',
															'label'=>array ("class"=>"label_","text"=>"Calle"),
															'class'=>'input-medium',
															 'placeholder' => 'Calle', 
															 'onblur'=>'javascript:mayus(this);' 
															 ));  ?>		 
		</div>
		<div class="span3 ">  
			<?php 	echo $this->form->input ('Direccion.DirPersona.dirper_numext', array(
															'id'=>'dirper_numext',
															'class'=>'input-small',
															'type'=>'text',
															
																'label'=>array ("class"=>"label_","text"=>"Número Exterior"),
															 'placeholder' => 'Número Exterior' ));  ?>

		</div>
		<div class="span3 ">  
			<?php 	echo $this->form->input ('Direccion.DirPersona.dirper_numint', array(
															'id'=>'dirper_numint',
															'class'=>'input-small',
															'type'=>'text',
															
																'label'=>array ("class"=>" label_","text"=>"Número Interior"),
															'placeholder' => 'Número Interior',

															 ));  ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span1"> </div>
		<div class="span3 ">  
		<?php echo $this->form->input ('Direccion.DirPersona.dirper_tel', array(
															'id'=>'dirper_tel',
															'type'=>'text',
															'class'=>'input-medium',
														'label'=>array ("class"=>" label_","text"=>"Teléfono"),
															 'placeholder' => 'Teléfono' ));  ?>	
			
		</div>
		<div class="span3 ">  
			 	<?php 	echo $this->form->input ('Direccion.DirPersona.dirper_movil', array(
															'id'=>'dirper_movil',
															'type'=>'text',
															'class'=>'input-medium',
															'label'=>array ("class"=>" label_","text"=>"Teléfono Móvil"),
															 'placeholder' => 'Teléfono Móvil' ));  ?>
		</div>
		<div class="span3">  
		
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

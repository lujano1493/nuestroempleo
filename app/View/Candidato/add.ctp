<?php echo $this->html->css(array('jquery-ui','validation/screen','Candidatos/validacion_errores/error_'));  ?>

<div class="wrapper form span9 formulario">

	<?php echo $this->form->create('Candidato',array('id' => 'form_candidato','class'=>'sliding clearfix'));?>
	<input id="config_form_registra_candidato" class="" value=""  type="hidden" />
	<?php echo $this->Session->flash(); ?>
	<fieldset>
		<legend>Registrar Candidato </legend>	
		 <div class="row-fluid">
			<div class="span4 ">
				<?php 	echo $this->form->input ('candidato_nom', array(
															'id'=>'candidato_nom',
															'type'=>'text',
															'label'=>' Nombre (s)*:',	
															 'placeholder' => 'Nombre',
															'onblur'=>'javascript:mayus(this);' ));  ?>		

			</div>
			<div class="span4 ">
				<?php 	echo $this->form->input ('candidato_pat', array(
															'id'=>'candidato_pat',
															'type'=>'text',
															'label'=>' Primer Apellido*',	
															'placeholder' => 'Primer apellido:',															
															'onblur'=>'javascript:mayus(this);' ));  ?>		

			</div>
			<div class="span4 ">
				<?php 	echo $this->form->input ('candidato_mat', array(
															'id'=>'candidato_mat',
															'type'=>'text',
															'label'=>' Segundo Apellido:',	
															'placeholder' => 'Segundo Apellido',	
															'class' => 'input-medium',
															'onblur'=>'javascript:mayus(this);' ));  ?>		
			</div>
		</div>	 
		<div class="row-fluid">
			<div class="span4 ">
			<!--
			
			<?php 
				
					echo $this->form->input('candidato_sex', array(
						'before' => $this->Form->label('candidato_sex', 'Género:'),
						'div' => array ('id'=>'div_radio_genero'),
						'legend' => false,
						'hidden' =>false,
						'options' => array('M'=>'M', 'F'=>'F'),
						'type' => 'radio'
					));
				?>
			-->
			<div id="div_radio_genero"> 
					<label> Genero </label>
					 <input type="radio" id="persona_sexM" name="data[Candidato][candidato_sex]" checked="checked" value="M" /><label for="persona_sexM">M</label>
					 <input type="radio" id="persona_sexF" name="data[Candidato][candidato_sex]"  value="F" /><label for="persona_sexF">F</label>
				</div>
				
				
			</div>			
			<div class="span4 ">
			<?php 	
				echo $this->form->input ('candidato_fecnac', array( 
					 'id'=>'candidato_fecnac',
					 'class'=> 'input-small',
					 'placeholder' => 'Fecha de Nacimiento',
					 'type'=>'text','label'=>'Fecha de Nacimiento:' ));  ?>		

			</div>
			<div class="span4 ">
				<?php 	echo $this->form->input ('cuentacan_email', array(
															'id'=>'cuentacan_email',
															'type'=>'text',
															'label'=>'Correo Electrónico*:',	
															 'placeholder' => 'Correo Electrónico',
															 'class'=> 'input-medium'));  ?>		
			</div>
		</div>
		<div class="row-fluid">
			<div class="span4 ">
			<?php 	echo $this->form->input ('cuentacan_email_', array(
															'id'=>'cuentacan_email_',
															'type'=>'text',
															'label'=>'Confirma Correo Electrónico*:',	
															 'placeholder' => 'Confirma Correo Electrónico',															 
															 'class'=> 'input-medium' ));  ?>		

			</div>
			<div class="span4 "> 
				
			</div>
		</div>
	
		 <div class="row-fluid">
	  	<div class="span10">
		<?php 
    	echo $this->Form->submit('Aceptar', array( 'class' => 'btn btn-success btn-large pull-right', 'div' => false));
		?>
		</div>
		</div>
	</fieldset>
	
		<?php echo $this->Form->end(); ?>
</div>


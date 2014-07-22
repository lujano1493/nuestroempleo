<div class="wrapper form span9">
	<?php 
		 echo $this->form->create('ImageCrop', array(  'url' => array('controller' => 'candidatos', 'action' => 'iniciar_sesion')));
	?>

	<fieldset>
		<legend>Registro Completo </legend>	
		 <div class="row-fluid">
			<div class="span9">
				 <p>&iexcl;Gracias por registrarte en Nuestro Empleo!</p>
				 <p>Recuerda que este registro te ayudar&aacute; a encontrar el empleo ideal para ti.  </p>
			</div>
		
		<div class="row-fluid">
	  	<div class="span9">
		<?php 
			echo $this->Form->submit('Iniciar', array( 'class' => 'btn btn-success btn-large pull-center', 'div' => false));
		?>
		</div>
		</div>
	</fieldset>

	<?php 
				echo   $this->form->end(); ?>
</div>
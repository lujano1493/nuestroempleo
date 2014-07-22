<div id="change_pass1" class="modal hide fade " data-component="modalform" >
	<div class="modal-header">
	    <h3 class="text-left title">Cambiar Contraseña</h3>
	 </div>
	 <div class="modal-body ">

		<div class="hide ajax-done">
			<h5 class="well">La contraseña ha sido cambiada con éxito.</h5>				

		</div>	
	 	<div class="formulario">
	 			<?=$this->Form->create('CandidatoUsuario',  array( 'url'=>  array('controller'=>'ConfigCan','action' => 'cambiar_contrasena'),
	        "class"=>'form-horizontal  well',
	        'data-component'=>"validationform ajaxform",
	        'id'=>'form-cambiopass01', 
	        'inputDefaults' => array(
	          'label' => false,
	          'div' => false
	          ) ) );
          ?>
			<input type="hidden" id="config_validation_login_candidato"  name="" />
			<div class="text-center ">			
			<?php 
						echo $this->Form->input('CandidatoUsuario.contrasena_vieja', array(
							'class'=>'contrasena_vieja',
							'data-rule-required'=>'true',
							'data-msg-required'=>'Ingresa la contraseña actual',
							'label' => "Contraseña actual*:",
							'div'=> array ('id'=>'div_correo','class'=>" input-prepend" ),
							'between'=>  "<span class='add-on' > <i class='icon-lock'> </i> </span>",							
							'type' => 'password',	
							'placeholder' => 'Contraseña anterior'
						)); ?>
			</div>
			<div class="text-center">		
						<?php				
						echo $this->Form->input('CandidatoUsuario.contrasena', array(
							'label' => "Contraseña nueva:",
							'class'=>'contrasena',
							'div'=> array ('id'=>'div_pass','class'=>" input-prepend" ),
							'between'=>  "<span class='add-on' > <i class='icon-lock'> </i> </span>",
							'type' => 'password',				
							'placeholder' => 'Contraseña nueva'
						));
					?>
			</div>

			<div class="text-center">		
						<?php				
						echo $this->Form->input('CandidatoUsuario.contrasena_confirma', array(
							'label' => "Repita contraseña nueva*:",
							'class'=>'contrasena_confirma',
							'div'=> array ('id'=>'div_pass','class'=>" input-prepend" ),
							'between'=>  "<span class='add-on' > <i class='icon-lock'> </i> </span>",
							'type' => 'password',				
							'placeholder' => 'Repita contraseña nueva'
						));
					?>
			</div>
					
				
					
					
				<?=$this->Form->submit("Cambiar Contraseña", array ("class"=>'btn_color',"div"=>array("class"=>'form-actions')));  ?>
			<?= $this->Form->end();  ?>
	 	</div>
	 
					<a  class="" data-dismiss="modal" aria-hidden="true" href="" >Cerrar formulario</a>
	</div>

</div>
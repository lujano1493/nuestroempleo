
<?php 
		$id=$oferta['Oferta']['oferta_cve'];
		$options_refresh=json_encode( array(  
							
												array(
														"target" =>"#header-ne",
														"url" => $this->Html->url(array(
																"controller" => "candidato",
																"action" => "view_header"
																)
															) 
													),
												array(
														"target" =>"#oferta_detalles01 .refresh-area",
														"url" => $this->Html->url(array(
																"controller" => "postulacionesCan",
																"action" => "oferta_detalles",
																"id" => $id
																)
															) ,

													),
												array(
														"target" =>"#oferta-vista",
														"url" =>$this->Html->url(array(
																"controller" => "postulacionesCan",
																"action" => "oferta_detalles",
																"id" => $id
																)
															),
												)												
			));

?>


<div id="login_form02" class="hide formulario-style01" data-component="slideform"  data-action-callback-done="done-login-refresh"  data-element-refresh='<?=$options_refresh?>'  >

	<div class="formulario">


	 			<?=$this->Form->create('CandidatoUsuario',  array( 'url'=>  array('controller'=>'Candidato','action' => 'iniciar_sesion'),
	        "class"=>'form-horizontal  well',
	        'data-component'=>"validationform ajaxform",
	        'id'=>'form-login02', 
	        'inputDefaults' => array(
	          'label' => false,
	          'div' => false
	          ) ) );
          ?>
			<input type="hidden" id="config_validation_login_candidato"  name="" />
			<div class="" style="height:40px" >
				<button type="button" class="close"   data-trigger-slide="#login_form02"  >×</button>
			</div>


			<div class="text-center ">			
			<?php 
						echo $this->Form->input('CandidatoUsuario.cc_email', array(
							'data-rule-required'=>'true',
							'data-msg-required'=>'Ingresa Correo Electrónico',
							'label' => "Correo Electrónico*:",
							'div'=> array ('id'=>'div_correo ','class'=>" input-prepend " ),
							'between'=>  " <div class='parent_'><span class='add-on' > <i class='icon-envelope'> </i> </span>",		
							'after' => "</div>",
							'type' => 'text',	
							'placeholder' => 'Correo Electrónico'
						)); ?>
			</div>
			<div class="text-center ">		
						<?php				
						echo $this->Form->input('CandidatoUsuario.cc_password', array(
							'label' => "Ingresa Contraseña*:",
							'class'=>'contrasena',
							'data-rule-required'=>'true',
							'data-msg-required'=>'Ingresa Correo Electrónico',
							'div'=> array ('id'=>'div_pass ','class'=>" input-prepend " ),
							'between'=>  "<div class='parent_'> <span class='add-on' > <i class='icon-lock'> </i> </span>",
							'after' => "</div>",
							'type' => 'password',				
							'placeholder' => 'Contraseña'
						));
					?>
			</div>

		
				
					
					
				<?=$this->Form->submit("Ingresar", array ("class"=>'btn btn-info',"div"=>array("class"=>'row-fluid')));  ?>
			<?= $this->Form->end();  ?>
	 	</div>
</div>
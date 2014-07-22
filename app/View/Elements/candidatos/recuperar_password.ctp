<div id="recuperar_pass" class="modal hide fade " data-component="modalform">


	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h3 class="text-left title">Recuperación de Contraseña</h3>
	 </div>

	<div class='modal-body'>

		<div class="hide ajax-done">
			<h5 class="well">El correo de recuperación ha sido enviado, por favor revisa tu Bandeja de entrada</h5>
		</div>	

	<div class="formulario">
			<?=$this->Form->create('CandidatoUsuario',  array( 'url'=>  array('controller'=>'Tickets','action' => 'recuperar_contrasena/candidatos'),
	        "class"=>'form-horizontal  well',
	        'data-component'=>"validationform ajaxform",
	        'data-onvalidationerror'=>  json_encode(array(array("action"=>"click","target"=>".refresh-captcha-image" ) )),
	        'id'=>'recuparar-correo01', 
	        'inputDefaults' => array(
	          'label' => false,
	          'div' => false
	          ) ) );
	          ?>


				<div class="row-fluid">
					<?= $this->Form->input('CandidatoUsuario.cc_email', array(
							"name"=>"data[Usuario][email]",
							'id' =>"email_recuperar",
				            'label'=>'Ingresa correo electrónico*:',
				            'div'=>  array('class'=>'controls'),
				            'class'=>' input-medium-formulario'));  
		            ?>
				</div>
				<?=$this->element("candidatos/tool/captcha_image",array("status"=> false )) ?>
				<?=$this->Form->submit("Enviar Correo", array ("class"=>'btn_color',"div"=>array("class"=>'pull-center')));  ?>
		
		<?=$this->Form->end() ?>

	</div>


		<a  class="" data-dismiss="modal" aria-hidden="true" href="" >Cerrar formulario</a>
	</div>

	<div class="modal-footer"> </div>
</div>





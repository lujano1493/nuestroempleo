<div class="modal hide "  data-component="modalform" data-auto="true" data-backdrop="static" data-keyboard="false"  data-close-done="true">
		


	<div class="modal-header">
		<h4 class="modal-title forma_genral_tit"> Nuevo Registro  </h4>
	</div>
	<div class="modal-body">
		<div class="row-fluid">
			<div class="span12">
				<div class="alert-container clearfix">
					  <div class="alert alert-info alert-dismissable fade in popup" data-alert="alert">
					 		Agregue una contraseña para acceder a Nuestro Empleo 
					   </div>
					</div>

			</div>
			
		</div>
		<?=$this->Form->create('CandidatoUsuario',  array( 'url'=>  array('controller' => 'candidato','action' => 'agregarPsw'),
				"class"=>'form-search',
				'data-component'=>"validationform ajaxform",
				'id'=>'add_psw01',
				) )?>
		<div class="row-fluid">

			<div class="offset3 span6">
				<?= $this->Form->input('CandidatoUsuario.contrasena', array(
				'label'=>'Ingresa Contraseña*:',
				"name" => "data[Usuario][contrasena]",
				'data-component' => 'tooltip',
				'data-placement' =>'bottom',
				'title' =>'La contraseña debe estar conformada por letras y números con un rango 8 a 15 caracteres',
				'div'=>  array('class'=>'controls'),
				'type'=> 'password',
				'class'=>' input-medium-formulario  contrasena no-edit'));  
				?>

			</div>
			
		</div>
		<div class="row-fluid">
			<div class="offset3 span6">
				<?= $this->Form->input('CandidatoUsuario.contrasena_confirma', array(
				'label'=>'Confirma tu  Contraseña*:',     			    
				'data-rule-equalto' =>'.contrasena',
				'data-msg-equalto'  => 'Ingresa de nuevo tu contraseña',
				'type'=> 'password', 
				'div'=>  array('class'=>'controls'),
				'class'=>' input-medium-formulario no-edit'));  
				?>					
			</div>
				

		</div>
		<div class="row-fluid">
			
	     <?=$this->Form->submit( 'Agregar',array(
            'label'=>false,
            'div'=> array("class" => "center"),
            'class'=>'btn btn_color'))?>

		</div>


		<?= $this->Form->end()?>

	</div>
	<div class="modal-footer">
	</div>



</div>


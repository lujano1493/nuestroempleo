<?=$this->Form->create("CandidatoUsuario",array(
	"url" =>array(
		"controller" => "candidato",
		"action" => "registro_rapido"
		),
	'class'=>'form-horizontal well',
	'data-component' => 'validationform ajaxform',   
	'id' => "registro-rapido",
	'data-onsucces-action'=> json_encode(array(array("action"=>"hide")  )),
	'data-onvalidationerror'=>json_encode(array(array("action"=>"click","target"=>".refresh-captcha-image" ) ))
	)
)?>



<fieldset> 
    <h4>Datos Personales</h4>
   <div class="row-fluid">
      <div class="span4">
        <?= $this->Form->input('Candidato.candidato_cve', array(
          'class'=>'candidato_cve'));  
          ?>

        <?= $this->Form->input('Candidato.candidato_nom', array(
          'label'=>'Nombre*:',
          'div'=>  array('class'=>'controls'),
          'class'=>' input-medium-formulario candidato_nom'));  
          ?>
        </div>
        <div class="span4">

          <?= $this->Form->input('Candidato.candidato_pat', array(
            'label'=>'Apellido Paterno*:',
            'div'=>  array('class'=>'controls'),
            'class'=>' input-medium-formulario candidato_pat'));  
            ?>


          </div>
          <div class="span4">
            <?= $this->Form->input('Candidato.candidato_mat', array(
              'label'=>'Apellido Materno:',
              'div'=>  array('class'=>'controls'),
              'class'=>' input-medium-formulario candidato_mat'));  
              ?>
            </div>
        </div>

	<div class="row-fluid">
        <div class="span6">
          <?= $this->Form->input('CandidatoUsuario.cc_email', array(
            'label'=>'Ingresa Correo Electrónico*:',
            'div'=>  array('class'=>'controls'),
            'class'=>' input-medium-formulario cc_email no-edit'));  
            ?>
          </div>
          <div class="span6">
            <?= $this->Form->input('CandidatoUsuario.cc_email_confirm', array(
              'label'=>'Confirma tu correo Electrónico*:',
              'div'=>  array('class'=>'controls'),
              'class'=>' input-medium-formulario cc_email_confirm no-edit'));  
              ?>
            </div>
    </div>


    <div class="row-fluid">
        <div class="span6">
           <?= $this->Form->input('CandidatoUsuario.contrasena', array(
            'label'=>'Ingresa Contraseña*:',
            'data-component' => 'tooltip',
            'data-placement' =>'bottom',
            'title' =>'La contraseña debe estar conformada por letras y números con un rango 8 a 15 caracteres',
            'div'=>  array('class'=>'controls'),
            'type'=> 'password',
            'class'=>' input-medium-formulario  contrasena no-edit'));  
            ?>
        </div>
        <div class="span6">
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
  			<div class="span6 offset3">
  				 <?=$this->element("candidatos/tool/captcha_image",array ("status"=> false ) ) ?>
  			</div>
  		   
  	</div>

 	<div class="row-fluid">
	    <div class="offset1 span10 left">
	      <label class="checkbox">
	        <input type="checkbox" value="option1" name="data[Candidato][terminos]" data-rule-required="true" data-msg-required="debes aceptar los términos y condiciones."   id="terminos_con">
	         Acepto transferencia de datos personales.
	      </label>
	      <div class="alert alert-block">
	          <h4>Política de transferencia de datos personales</h4>
	          Por la naturaleza de "EL SITIO", NUESTRO EMPLEO podrá transferir a favor de los "usuarios empleadores", las autoridades e instituciones que resulten necesarias para el cumplimiento de las finalidades descritas en el presente Aviso, los datos personales de los candidatos registrados y activos.
	      </div>
	    </div>
                          
                              
    </div>
    <div class=" pull-center">
   
      	<?=$this->Form->submit("Registrar", array ("class"=>'btn_color',"div"=>false));  ?>
    	  <br/>  <br/>
	      <label> Al hacer clic en Registrar aceptas  los  <a href="/terminos_condiciones" target="_blank">  Términos y Condiciones </a> </label>
      
    </div>



</fieldset>
<?=$this->Form->end()?>
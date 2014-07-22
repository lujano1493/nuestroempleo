<div id="over" class="overbox" >
  <div class="lightboxint candidato-registro">
    <div class="lightboxint-title">
      <h3>Registro de nuevo candidato</h3>
    </div>
    <br>
    <div class="info_after hide">
      <div class="row-fluid" > 
        <div class="span1"> </div>
        <div class="span10"> 
            <div class="row-fluid"> 
              <div class="span12 well"> 
                Tu registro se llevo a cabo de manera exitosa, se ha enviado una contraseña a su correo electrónico; con ella 
                podra acceder a <a href="/"> <strong> NuestroEmpleo </strong> </a>.
              </div>
            </div>
        </div>
        <div class="span1"> </div>  
      </div>
    </div>


      <?=$this->Form->create('CandidatoUsuario.Candidato',  array( 'url'=>  array('controller'=>'Candidato','action' => 'registrar'),
        "class"=>'form-horizontal form-validation well',
        'data-component' => 'elastic-input ajaxform',
        'id'=>'login_form', 
        'inputDefaults' => array(
          'label' => false,
          'div' => false
          ) ) );
          ?>
          <fieldset>
            <div class="row-fluid">
              <div class="span5">
                <?= $this->Form->input('CandidatoUsuario.cc_email', array(
                  'label'=>'Ingresa Correo Electronico',
                  'div'=>  array('class'=>'controls'),
                  'class'=>' input-medium-formulario cc_email'));  
                  ?>
              </div>
              <div class="span5">
                <?= $this->Form->input('CandidatoUsuario.cc_email_confirm', array(
                  'label'=>'Confirmar tu correo electronico',
                  'div'=>  array('class'=>'controls'),
                  'class'=>' input-medium-formulario cc_email_confirm'));  
                  ?>
              </div>
            </div>
                <h3>Datos personales</h3>
                <div class="row-fluid">
                  <div class="span4">
                      <?= $this->Form->input('Candidato.candidato_nom', array(
                        'label'=>'Nombre*:',
                        'div'=>  array('class'=>'controls'),
                        'class'=>' input-medium-formulario candidato_nom'));  
                      ?>
                  </div>
                  <div class="span3">

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
                  <div class="span4">
                    <?= $this->Form->input('Candidato.candidato_fecnac', array(
                        'label'=>'Fecha de Nacimiento*:',
                        'type'=> 'text',
                        'div'=>  array('class'=>'controls'),
                        'class'=>' input-medium-formulario date-picker candidato_fecnac'));  
                      ?>
                  </div>
                  <div class="span3">
                       <?= $this->Form->input('Candidato.candidato_sex', array(
                        'legend'=>false,
                        'before'=> '<label>Género: </label>',
                        'type' =>'radio',
                        'options'=>  $list['genero'],
                        'div'=>  array('class'=>'controls'),
                        'class'=>' input-medium-formulario candidato_sex'));  
                       ?>
                  
                  </div>

                   <div class="span4">
                    <?= $this->Form->input('Candidato.edo_civil', array(
                        'label'=>'Estado Civil:',
                        'options'=> $list['edo_civil'],
                        'required'=>true,
                        'empty'=>'Selecciona ...',
                        'div'=>  array('class'=>'controls'),
                        'class'=>' input-medium-formulario edo_civil'));  
                      ?>
                  </div>
                </div>
                <h3>Dirección Actual</h3>
                <div class="row-fluid">
                  <div class="span4">

                    <?= $this->Form->input('DirCandidato.CodigoPostal.cp_cp', array(
                        'label'=>'Codigo Postal*:',
                        'div'=>  array('class'=>'controls'),
                        'class'=>'input-small cp_cp'));  
                      ?>

                  </div>
                  <div class="span3">

                    <?= $this->Form->input('DirCandidato.CodigoPostal.Estado.est_nom', array(
                        'label'=>'Estado:',
                        'disabled'=>true,
                        'div'=>  array('class'=>'controls'),
                        'class'=>' input-medium-formulario est_nom'));  
                      ?>

               
                  </div>
                  <div class="span4">
                       <?= $this->Form->input('DirCandidato.CodigoPostal.Ciudad.ciudad_nom', array(
                        'label'=>'Ciudad:',
                         'disabled'=>true,
                        'div'=>  array('class'=>'controls'),
                        'class'=>' input-medium-formulario ciudad_nom'));  
                      ?>            
                  </div>
                </div>
                <div class="row-fluid">
                  <div class="span4">
                     <?= $this->Form->input('DirCandidato.CodigoPostal.cp_asentamiento', array(
                        'label'=>'Colonia*:',
                        'data-rule-required' => 'true',
                        'data-msg-required' => 'selecciona una colonia',                        
                        'div'=>  array('class'=>'controls'),
                        'options'=> array(),
                        'empty' =>'selecciona ...',
                        'class'=>' input-medium-formulario cp_asentamiento'));  
                      ?>  

                       <?= $this->Form->input('DirCandidato.cp_cve', array(
                        'type'=> 'hidden',
                        'class'=>'cp_cve'));  
                      ?>             
                 
                  </div>
                  <div class="span3">
                    <?= $this->Form->input('Candidato.candidato_movil', array(
                        'label'=>'Teléfono Móvil:',
                        'div'=>  array('class'=>'controls'),
                        'class'=>' input-medium-formulario candidato_movil'));  
                      ?>     

                   
                  </div>
                  <div class="span4">
                    <label class="checkbox">
                      <input type="checkbox" value="option1" name="data[Candidato][terminos]"  id="terminos1">
                      Acepto términos y condiciones
                    </label>
                  </div>
                </div>
                <div class="row-fluid">
                    <?= $this->element("candidatos/tool/captcha"); ?>
                </div>
                <?=$this->Form->submit("Registrar", array ("class"=>'btn_color',"div"=>array("class"=>'form-actions')));  ?>

            </fieldset>
          <?= $this->Form->end();  ?>

    <a href="javascript:hideLightbox();">Cerrar formulario</a>
  </div>
</div>
<div id="fade" class="fadebox"></div>
<?php 
  $options_form=array( 
              'url'=>  array('controller'=>'Candidato','action' =>"registrar"   ),
              'class'=>'form-horizontal well',
              'data-component' => 'validationform ajaxform',   
              'id'=>'registro-candidato01') ;

  if("actualizar"== $action ){
    $options_form['url']['action']="guardar_actualizar/Candidato" ;
    $model_name='Candidato';
  }
  if("registrar"== $action ){
        $options_form['data-onsucces-action']=json_encode(array(array("action"=>"hide")  ));
     $options_form['data-onvalidationerror']=json_encode(array(array("action"=>"click","target"=>".refresh-captcha-image" ) ));   
      $model_name='CandidatoUsuario';
  }




 
 if($action=="primera"){
   $form_begin="";
   $form_end= "";
 }
 else if($action=="actualizar"){
   $form_begin="<div class='formulario'>".$this->Form->create($model_name, $options_form  );
   $form_end=$this->Form->end()."</div>";
 }
 else if ($action=="registrar" ){
    $form_begin=$this->Form->create($model_name, $options_form  );
    $form_end=$this->Form->end();
 }





?>

<?=$form_begin?>
  <fieldset>
    <?php  if ($action=="registrar" )  :?>



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

    <?php endif; ?>
    <?php if('primera'==$action || 'actualizar'==$action) :?>
      <h4>Datos Personales</h4>
      <label>Título de Perfil*:</label>
      <div class="row-fluid"> 

        <div class="span12">
            <?php 
                $title= "Captura tu Puesto, Profesión u Oficio. Este título atraerá la atención del reclutador en tu Currículum.Ejemplo: Coordinador de logística, Contador,  Plomero, etc.";
            ?>

            <?= $this->Form->input('Candidato.candidato_perfil', array(
              'label'=>false,
              'div'=>  array('class'=>'controls'),
              'title' => $title,
              "data-component" => "tooltip",
              "data-placement" => "bottom",
              'class'=>' input-medium-formulario candidato_perfil'));  
              ?>


        </div>

          

      </div>
    <?php endif; ?>

     <?php if('registrar'==$action) :?>   
       <h4>Datos Personales</h4>
    <?php endif; ?>
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
            <div class="span4">
              <?= $this->Form->input('Candidato.candidato_fecnac', array(
                'label'=>'Fecha de Nacimiento*:',
                'type'=> 'text',
                'div'=>  array('class'=>'controls'),
                'class'=>' input-medium-formulario date-picker date-birth candidato_fecnac'));  
                ?>
              </div>
              <div class="span4">
                <label> Género*: </label>

                <?= $this->Form->input('Candidato.candidato_sex', array(
                  'legend'=>false,      
                  'hiddenField'=>false, 
                  'label'=>true,                
                  'type' =>'radio',
                  'options'=>  $list['genero'],
                  'div'=>  array('class'=>'controls  group-radio',"id"=>"pruebas")
                  ));  
                  ?>

                </div>

           

                <div class="span4">
                  <?= $this->Form->input('Candidato.edo_civil', array(
                    'label'=>'Estado Civil*:',
                    'options'=> $list['edo_civil'],
                    'empty'=>'Selecciona ...',
                    'div'=>  array('class'=>'controls'),
                    'class'=>' input-medium-formulario edo_civil'));  
                    ?>
                  </div>
                </div>
                <?php if("registrar" !=$action) : ?>
                  <h4>Dirección Actual</h4>
                <?php else : ?>
                   <h4>Dirección Actual</h4>
                <?php  endif; ?>
                <div class="row-fluid">
                  <div class="span4">

                    <?= $this->Form->input('CodigoPostal.cp_cp', array(
                      'label'=>'Código Postal*:',
                      'div'=>  array('class'=>'controls'),
                      'class'=>'input-medium-formulario cp_cp'));  
                      ?>

                    </div>
                    <div class="span4">

                      <?= $this->Form->input('Estado.est_nom', array(
                        'label'=>'Estado:',
                        'disabled'=>true,
                        'div'=>  array('class'=>'controls'),
                        'class'=>' input-medium-formulario est_nom'));  
                        ?>


                      </div>
                      <div class="span4">
                        <?= $this->Form->input('Ciudad.ciudad_nom', array(
                          'label'=>'Ciudad:',
                          'disabled'=>true,
                          'div'=>  array('class'=>'controls'),
                          'class'=>' input-medium-formulario ciudad_nom'));  
                          ?>            
                        </div>
                      </div>
                      <div class="row-fluid">
                        <div class="span4">
                           <?php 

                             $options= array(
                                        'label'=>'Colonia*:',                                         
                                        'div'=>  array('class'=>'controls'),
                                        'options'=> array(),
                                        "data-rule-required"=>"true",
                                        "data-msg-required"=>"Selecciona una colonia",
                                        'empty' =>'selecciona ...',
                                        'class'=>' input-medium-formulario cp_asentamiento');         
                              if($action!='registrar') {
                                  $options['options']=$asentamientos_list;
                                  $options['value']=$this->data['DirCandidato']['cp_cve'];
                              }
                              else{
                                $candidato_cve="";
                              }

                           ?> 
                              
                             <?= $this->Form->input('CodigoPostal.cp_asentamiento',$options) ?>
                         

                            <?=$this->Form->input ('DirCandidato.candidato_cve', array(
                                  'class'=>'candidato_cve',
                                  'value' => $candidato_cve,
                                  'type'=>'hidden',
                                  ));      ?>          
                            <?= $this->Form->input('DirCandidato.cp_cve', array(
                              'type'=> 'hidden',
                              'class'=>'cp_cve'));  
                              ?>             

                            </div>
                            <div class="span4">
                              <?= $this->Form->input('Candidato.candidato_movil', array(
                                'label'=>'Teléfono Móvil*:',
                                'title' => '10 dígitos ejemplo  1234567890. ',
                                'maxlenght' =>"10",
                                'data-component' => 'tooltip',
                                'data-placement' => 'bottom',
                                'data-rule-digits' => "true",
                                "data-msg-digits" => "Verifica el número de celular",
                                'div'=>  array('class'=>'controls'),
                                'class'=>' input-medium-formulario candidato_movil'));  
                                ?>     



                              </div>
                              <?php if($action== "registrar")  :?>
                              <div class="span4">
                                <?=$this->element("candidatos/tool/captcha_image",array ("status"=> false ) ) ?>

                              </div>                                  
                              
                              <?php else : ?>
                              <div class="span4">
                                <?= $this->Form->input('Candidato.candidato_tel', array(
                                  'label'=>'Teléfono Fijo: (Lada) + Número',
                                  'div'=>  array('class'=>'controls'),
                                  'maxlenght' =>"10",
                                  'data-rule-digits' => "true",
                                  "data-msg-digits" => "Verifica el número teléfonico",
                                  'class'=>' input-medium-formulario candidato_tel'));  
                                  ?>     
                              </div>

                              <?php endif; ?>
                            </div>
                         <?php if($action=="registrar")  :?>
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
                              <label> Al hacer clic en Registrar aceptas  los <a href="/terminos_condiciones" target="_blank">  Términos y Condiciones </a> </label>
                              
                            </div>
                           
                          <?php elseif($action=="actualizar") : ?>
                            <?=$this->Form->submit("Guardar", array ("class"=>'btn_color pull-right',"div"=>array("class"=>'form-actions')));  ?>

                          <?php endif; ?>
                            

  </fieldset>

<?=$form_end ?>
<div class="container" style="padding-top:10px;" data-component='slideform' data-action-callback-done="modalshow" data-target-callback-done="#completo01">
  <div class="forma_genral_tit">
    <h2>Más información</h2>
  </div>


  <div class="hide ajax-done" style="height:200px">
    <div class="row-fluid">
    </div>
    <div class="row-fluid">
      <h4>Tu información fue enviado con éxito</h4> 
    </div>
  </div>




  <div class="row">
    <?=$this->Form->create("ContactoE", array( 
      'url'=>  array('controller'=>'informacion','action' =>"guardar_contacto_general/educacion"   ),
      'class'=>'',
      'data-component' => 'validationform ajaxform',   
      'id'=>'registro-contacto-general
      ')   
      )?>
      <fieldset>
      <div class="thumbnail   ">
        <div class="rapido-menu2">

          <i class="icon-envelope-alt icon-5x"></i>
        </div>

        <div class="caption without-space" >


          <fieldset>

            <div class="row-fluid">
              <div style="background-color:#eaeaea;">
                <p style="padding-left:20px;padding-right:20px;text-align:justify">
                  Nuestro Empleo impulsa la formación educativa en México, promoviendo a las instituciones con las que realizamos convenios. Si usted está  interesado en saber más acerca de lo que ofrece el convenio, contáctenos y un Ejecutivo lo atenderá a la  brevedad. Para nosotros es un compromiso fomentar la educación, y brindar oportunidades a todos los buscadores de empleo.                         
                </p>
              </div>                       
            </div>


            

            <div class="form-horizontal well" >
              <div class="row-fluid ">
                <div class="span12 contactenos tabular">
                  Contáctenos
                </div>
              </div>

              <div class="row-fluid">
              <div class="span6">

                <div class="row-fluid">
                  <div class="span12">
                    <?= $this->Form->input('ContactoE.contacto_nombre', array(
                      'label'=> 'Nombre del contacto*:',
                      'div'=>  array('class'=>'controls'),

                      'class'=>' input-medium-formulario  '))
                      ?>             

                    </div>

                  </div>

                  <div class="row-fluid">
                    <div class="span12">
                      <?= $this->Form->input('ContactoE.contacto_apellidos', array(
                        'label'=> 'Apellidos del contacto*:',
                        'div'=>  array('class'=>'controls'),

                        'class'=>' input-medium-formulario  '))
                        ?>             

                      </div>
                    </div>

                    <div class="row-fluid">
                      <div class="span12">
                        <?= $this->Form->input('ContactoE.contacto_institucion', array(
                          'label'=> 'Nombre de la institución:',
                          'div'=>  array('class'=>'controls'),

                          'class'=>' input-medium-formulario  '))
                          ?>                           

                        </div>
                      </div>

                      <div class="row-fluid">
                        <div class="span12">

                          <?php 
                            $opciones= ClassRegistry::init("Catalogo")->get_list('TIPO_INSTITUCION_EDUCATIVA');  
                          ?>

                          <?= $this->Form->input('ContactoE.contacto_tipo', array(
                            'label' => "Tipo de institución:",
                            'options' => $opciones,
                            'empty' => 'Selecione ...',
                            'data-component' => "triggerelementselect",
                            'data-target' =>".otros",
                            'data-value-change' => 4,
                            'div'=>  array('class'=>'controls '),
                            'class'=>' input-medium-formulario  trigger-element-select-show '))
                            ?>

                          </div>
                        </div>

                        <div class="row-fluid">
                          <div class="span12">
                            <div class="otros">

                              <?= $this->Form->input('ContactoE.contacto_otro', array(
                                'label' => "En caso de seleccionar \"Otro\" especificar el tipo:",
                                'div'=>  array('class'=>'controls'),
                                'class'=>' input-medium-formulario  '))
                                ?>                               
                              </div>

                            </div>
                          </div>


                        </div>

                        <div class="span6">

                          <div class="row-fluid">
                            <div class="span2">
                              <?= $this->Form->input('ContactoE.contacto_lada', array(
                                'label'=> 'Lada*:',
                                'div'=>  array('class'=>'controls'),

                                'class'=>' input-medium-formulario  '))
                                ?>        
<fieldset>
                            </div>

                            <div class="span8">
                                <?= $this->Form->input('ContactoE.contacto_tel', array(
                                  'label'=> 'Teléfono*:',
                                  'div'=>  array('class'=>'controls'),

                                  'class'=>' input-medium-formulario  '))
                                  ?>        
                              </div>
                              <div class="span2">
                                <?= $this->Form->input('ContactoE.contacto_ext', array(
                                  'label'=> 'Extensión:',
                                  'div'=>  array('class'=>'controls'),

                                  'class'=>' input-medium-formulario  '))
                                  ?>    

                              </div>                                
                            </div>
                            <div class="row-fluid">
                                <div class="span8">
                                        <?= $this->Form->input('ContactoE.contacto_email', array(
                                          'label'=> 'Correo electrónico*:',
                                          'div'=>  array('class'=>'controls'),
                                    
                                          'class'=>' input-medium-formulario span12  '))
                                          ?>
                                </div>
                                <div class="span4">
                                   <?= $this->Form->input('ContactoE.CodigoPostal.cp_cp', array(
                                        'label'=> 'Código postal*:',
                                        'div'=>  array('class'=>'controls'),
                                        'class'=>' input-medium-formulario cp_cp '))
                                        ?>

                                      <?= $this->Form->input('ContactoE.cp_cve', array(
                                        'type' => 'hidden',
                                        'class'=>' input-medium-formulario cp_cve '))
                                        ?>
                                </div>
                            </div>

                            <div class="row-fluid">
                              <div class="span4">
                                   <?= $this->Form->input('Estado.est_nom', array(
                                    'label' => "Estado:",
                                    'disabled' => true,
                                    'div'=>  array('class'=>'controls'),
                                    'class'=>' input-medium-formulario est_nom span12'))
                                    ?>
                              </div>
                              <div class="span4">
                                <?= $this->Form->input('Ciudad.ciudad_nom', array(
                                    'label' => "Ciudad:",
                                    'disabled' => true,
                                    'div'=>  array('class'=>'controls'),
                                    'class'=>' input-medium-formulario ciudad_nom span10'))
                                    ?>
                              </div>
                              <div class="span4">
                                  <?= $this->Form->input('CodigoPostal.cp_asentamiento', array(
                                    'label' => "Colonia:",
                                    'empty' => 'Seleccione ...',
                                    'options' => array(),
                                    'div'=>  array('class'=>'controls'),
                                    'class'=>' input-medium-formulario cp_asentamiento span12'))
                                    ?>
                              </div>
                            </div>

                            <div class="row-fluid">


                          <?php 
                            $opciones= ClassRegistry::init("Catalogo")->get_list('MEDIO_CVE');  
                          ?>

                                <?= $this->Form->input('ContactoE.medio_cve', array(
                                    'label' => "¿Como se enteró de nuestro empleo?:",
                                    'options' =>$opciones,
                                    'empty' => 'Selecione ...',
                                    'div'=>  array('class'=>'controls'),
                                    'class'=>' input-medium-formulario span11'))
                                    ?>
                            </div>
                            <div class="row-fluid">


                                <?= $this->Form->input('ContactoE.contacto_mensaje', array(
                                  'label' => "Mensaje*:",
                                  'div'=>  array('class'=>'controls'),
                                  'class'=>' input-medium-formulario span11 '))
                                  ?>          

                              
                            </div>
                       

                        </div>

            </div>
            <div class="row-fluid">
              <div class="span6 offset3">
                <?=$this->element("candidatos/tool/captcha_image",array ("status"=> true ) ) ?>
              </div>
              
                           
            </div>

            <div class="row-fluid">
              
                            <?=$this->Form->submit("Enviar", array(
                              "class"=>'btn_color  btn-large',
                              "div"=>
                              array("class"=>'row-fluid')
                              )
                              )  ?>
            </div>
              
            </div>
   
          </fieldset>
        </div>
      </div>
    </fieldset>
    <?=$this->Form->end()?>
  </div>
</div>


<?=$this->element("inicio/modalinfo",array(
                                          "id"=> "completo01",
                                          "title" => "Registro Completo",
                                          "content" =>'La información fue enviada con éxito. En breve nos pondremos en contacto.',
                                          "back" =>"<a  data-dismiss='modal' aria-hidden='true' href=''>Cerrar formulario</a>"

  ))?>

<div class="content">

  <div class="forma_genral_tit">
  <h2>Contacto</h2>
</div>

<?php 
  $estados=array();

?>


<div id='formulario_contacto' data-component='slideform' data-action-callback-done="modalshow" data-target-callback-done="#completo01">


<div class="hide ajax-done" style="height:200px">

 <div class="row-fluid">
   
 </div>

  <div class="row-fluid">

    <h4>La información fue enviada con éxito. <br/>En breve nos pondremos en contacto.</h4> 
    
  </div>
</div>



<?=$this->Form->create("ContactoG", array( 
'url'=>  array('controller'=>'informacion','action' =>"guardar_contacto_general"   ),
'class'=>'form-horizontal well',
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
                  Nos interesa saber tu opinión, si tienes alguna duda o comentario sobre el portal, registra tus datos en el formulario y en breve un representate te contactará. Los campos con (*) son obligatorios.                     
                </p>
              </div>                       
            </div>
   <!-- <div class="alert-container clearfix">   
          <div class="alert alert-info" fade="" in="">  
             Nos interesa saber tu opinión, si tienes alguna duda o comentario sobre el portal, registra tus datos en el formulario y en breve un representate te contactará. Los campos con (*) son obligatorios.
          </div>
      </div>
-->
<!-- <div class="form-horizontal well" > -->
              <div class="row-fluid ">
                <div class="span12 contactenos tabular">
                Formulario de Contacto General
                </div>
              </div>
    <div class="row-fluid">


       <div class="span6">
            <?= $this->Form->input('ContactoG.contactog_nom', array(
              'label'=> 'Nombre(s)*:',
              'div'=>  array('class'=>'controls'),
        
              'class'=>' input-medium-formulario  '))
              ?>

        </div>


       <div class="span1">

            <?= $this->Form->input('ContactoG.contactog_lada', array(
              'label'=> 'Lada*:',
              'div'=>  array('class'=>'controls'),
        
              'class'=>' input-medium-formulario  '))
              ?>

       </div>
       <div class="span3">
               <?= $this->Form->input('ContactoG.contactog_tel', array(
                          'label'=> 'Teléfono de contacto*:',
                          'div'=>  array('class'=>'controls'),
                    
                          'class'=>' input-medium-formulario  span12'))
                          ?>
           
       </div>
       <div class="span2">
             <?= $this->Form->input('ContactoG.contactog_ext', array(
                          'label'=> 'Extensión:',
                          'div'=>  array('class'=>'controls'),
                    
                          'class'=>' input-medium-formulario  '))
                          ?>
           
       </div>
    </div>
    <div class="row-fluid">

        <div class="span6">
           <?= $this->Form->input('ContactoG.contactog_apellidos', array(
                  'label'=> 'Apellidos :',
                  'div'=>  array('class'=>'controls'),
            
                  'class'=>' input-medium-formulario  '))
                  ?>
           

        </div>
        <div class="span4">

            <?= $this->Form->input('ContactoG.contactog_email', array(
                  'label'=> 'Correo electrónico*:',
                  'div'=>  array('class'=>'controls'),
            
                  'class'=>' input-medium-formulario span12  '))
                  ?>
          
        </div>


        <div class="span2">

               <?= $this->Form->input('ContactoG.CodigoPostal.cp_cp', array(
                  'label'=> 'Código postal*:',
                  'div'=>  array('class'=>'controls'),
                  'class'=>' input-medium-formulario cp_cp '))
                  ?>

                <?= $this->Form->input('ContactoG.cp_cve', array(
                  'type' => 'hidden',
                  'class'=>' input-medium-formulario cp_cve '))
                  ?>
       
            
        </div>
 
    </div>
    <div class="row-fluid">
       <div class="span6">
                    <?= $this->Form->input('ContactoG.medio_cve', array(
                      'label' => "¿Como se enteró de nuestro empleo?:",
                      'options' =>$medio,
                      'empty' => 'Selecione ...',
                      'div'=>  array('class'=>'controls'),
                      'class'=>' input-medium-formulario '))
                      ?>

      </div>
       <div class="span2">
               <?= $this->Form->input('Estado.est_nom', array(
                      'label' => "Estado:",
                      'disabled' => true,
                      'div'=>  array('class'=>'controls'),
                      'class'=>' input-medium-formulario est_nom '))
                      ?>
          
        </div>
      <div class="span2">
            <?= $this->Form->input('Ciudad.ciudad_nom', array(
                      'label' => "Ciudad:",
                      'disabled' => true,
                      'div'=>  array('class'=>'controls'),
                      'class'=>' input-medium-formulario ciudad_nom '))
                      ?>
      </div>
      <div class="span2">
           <?= $this->Form->input('CodigoPostal.cp_asentamiento', array(
                      'label' => "Colonia:",
                      'empty' => 'Seleccione ...',
                      'options' => array(),
                      'div'=>  array('class'=>'controls'),
                      'class'=>' input-medium-formulario cp_asentamiento '))
                      ?>
        
      </div>
    </div>

    <div class="row-fluid">
        <div class="span6">
           <?= $this->Form->input('ContactoG.contactog_comentario', array(
                      'label' => "Mensaje*:",
                      'div'=>  array('class'=>'controls'),
                      'class'=>' input-medium-formulario span9 '))
                      ?>
        
          

        </div>

        <div class="span6">
            <?=$this->element("candidatos/tool/captcha_image",array ("status"=> true ) ) ?>

        </div>

    </div>


    <?=$this->Form->submit("Enviar", array(
                                            "class"=>'btn_color  btn-large',
                                            "div"=>
                                                  array("class"=>'')
                                          )
      
                          )  ?>
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
                                          "content" =>' La información fue enviada con éxito. En breve nos pondremos en contacto.',
                                          "back" => "<a  data-dismiss='modal' aria-hidden='true' href=''>Cerrar formulario</a>"

  ))?>

<?php 
     $medio= ClassRegistry::init('Catalogo')->get_list("MEDIO_CVE");

?>


<div id='formulario_contacto' data-component='slideform' data-action-callback-done="modalshow" data-target-callback-done="#completo_contacto_empresa_01">


  <?=$this->Form->create("ContactoEmpresa", array( 
  'url'=>  array('controller'=>'informacion','action' =>"guardar_contacto_general/empresa"   ),
  'class'=>'form-horizontal well',
  'data-component' => 'validationform ajaxform',
  'id'=>'registro-contacto-general-empresas')   
  )?>

    <fieldset>
      <div class="row-fluid">
        <?= $this->Form->input('ContactoEmpresa.contacto_nombre', array(
              'label'=> 'Nombre(s)*:',
              'div'=>  array('class'=>'controls'),
        
              'class'=>' input-medium-formulario  '))
              ?>
      </div>

       <div class="row-fluid">
        <?= $this->Form->input('ContactoEmpresa.contacto_apellidos', array(
              'label'=> 'Apellidos*:',
              'div'=>  array('class'=>'controls'),
        
              'class'=>' input-medium-formulario  '))
              ?>
      </div>

    <div class="row-fluid">
       <?= $this->Form->input('ContactoEmpresa.contacto_empresa', array(
              'label'=> 'Nombre de la Empresa*:',
              'div'=>  array('class'=>'controls'),
        
              'class'=>' input-medium-formulario  '))
              ?>

    </div>
     

    <div class="row-fluid">

        <div class="span8">
           <?= $this->Form->input('ContactoEmpresa.contacto_email', array(
              'label'=> 'Correo electrónico*:',
              'div'=>  array('class'=>'controls'),
        
              'class'=>' input-medium-formulario  '))
              ?>

        </div>
    
           
        <div class="span4">

             <?= $this->Form->input('ContactoEmpresa.CodigoPostal.cp_cp', array(
                'label'=> 'Código postal*:',
                'div'=>  array('class'=>'controls'),
                'class'=>' input-medium-formulario cp_cp '))
                ?>

              <?= $this->Form->input('ContactoEmpresa.cp_cve', array(
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
                      'class'=>' input-medium-formulario est_nom '))
                      ?>
          
        </div>
      <div class="span4">
            <?= $this->Form->input('Ciudad.ciudad_nom', array(
                      'label' => "Ciudad:",
                      'disabled' => true,
                      'div'=>  array('class'=>'controls'),
                      'class'=>' input-medium-formulario ciudad_nom '))
                      ?>
      </div>
      <div class="span4">
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
            <div class="span2">
                <?= $this->Form->input('ContactoEmpresa.contacto_lada', array(
                  'label'=> 'Lada*:',
                  'div'=>  array('class'=>'controls'),            
                  'class'=>' input-medium-formulario  '))
                  ?>

        </div>
        <div class="span7">
         <?= $this->Form->input('ContactoEmpresa.contacto_telefono', array(
                              'label'=> 'Teléfono*:',
                              'div'=>  array('class'=>'controls'),
                        
                              'class'=>' input-medium-formulario  span12'))
                              ?>       
        </div>
         <div class="span3">
                 <?= $this->Form->input('ContactoEmpresa.contacto_ext', array(
                  'label'=> 'Extensión:',
                  'div'=>  array('class'=>'controls'),
                  'data-rule-digits'=> 'true',
                  'data-msg-digits' => 'Formato no válido',
                  'class'=>' input-medium-formulario  '))
                  ?>

        </div>        
    </div>

    <div class="row-fluid">
          <?= $this->Form->input('ContactoEmpresa.contacto_mensaje', array(
                'label' => "Mensaje*:",
                'div'=>  array('class'=>'controls'),
                'class'=>' input-medium-formulario span9 '))
                ?>

    </div>


    <div class="row-fluid">

        <?= $this->Form->input('ContactoEmpresa.medio_cve', array(
                    'label' => "¿Como se enteró de nuestro empleo?:",
                    'options' =>$medio,
                    'empty' => 'Selecione ...',
                    'div'=>  array('class'=>'controls'),
                    'class'=>' input-medium-formulario '))
                    ?>

      
    </div>


    <div class="row-fluid">
      
      <?=$this->element("candidatos/tool/captcha_image",array ("status"=> true ) ) ?>
    </div>
    
    <?=$this->Form->submit("Enviar", array(
                                              "class"=>'btn_color  btn-large',
                                              "div"=>
                                                    array("class"=>'row-fluid')
                                            )
        
                            )  ?>  
    </fieldset>
  <?=$this->Form->end()?>


</div>


<?php 
    $this->Html->scriptBlock( 
            '
  $(document).ready(function (){      
    $("#completo_contacto_empresa_01").on("hidden",function (event){
      $("#registro-contacto-general-empresas .alert.alert-success").remove();
      $("#tab_der").trigger("click");
    });
  });

            '
      ,array("inline" =>false));

?>
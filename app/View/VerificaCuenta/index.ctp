  <div style="width:800px;margin:auto;">


   <?=$this->Form->create('CandidatoUsuario',  array( 
                    'url'=>  array('controller' => 'verificaCuenta',
                    'action' => 'login',
                    'facebook'
                    ),
            "class"=>'row-fluid form-search',                    
            'id'=>'login_form_candidato',
            'data-component' => "ajaxform validationform",
            'inputDefaults' => array(
              'label' => false,
              'div' => false
              ) ) )?>


        <div class="row-fluid">
          <div class="span12">
             <h3 class="text-left title">Enlace de Nuestro Empleo con Facebook</h3>
          </div>
        </div>


        <div class="row-fluid">
          <div class="span12">
            <div class="alert alert-info fade in popup" data-alert="alert">
              Utiliza una cuenta existente de Nuestro Empleo para poder enlazarla con Facebook, si no cuentas con una debes crearla.
            </div>
          </div>
        </div>
          <div class="row-fluid">
            <div class="span6 " style="text-align:right">
              <label for="#cc_mail01">Correo Electrónico*: </label>
            </div>
            
            <?=$this->Form->input('CandidatoUsuario.cc_email', array(
              'label'=> false,
              "id" => "cc_mail01",
              'div'=> array( "class"=>"span2 parent_"  ),
              'class'=>'input-medium ',
              'placeholder' => 'Correo Electrónico'))?>
          </div>

          <div class="row-fluid">
             <div class="span6 "  style="text-align:right" >
              <label for="#cc_password01">Contraseña *:</label>
            </div>
            
            <?=$this->Form->input('CandidatoUsuario.cc_password', array(
              'label'=>false,
              "id" => "cc_password01",
              'div'=> array( "class"=>"span2 parent_" ),
              'class'=>'input-medium ',
              'type' => 'password',       
              'placeholder' => 'Contraseña'));

              ?>


          </div>

          
          <div class="row-fluid">
            <?=$this->Form->submit( 'Enlazar',array(
            'label'=>false,
            'div'=> false ,
            'class'=>'btn btn-info'));
            ?>

            <?=$this->Html->link("Cancelar","#",array(
                                "class"=> "btn revoke-fb",
                                "data-redirect"=> "/" ) )?>
          </div>
          <div class="row-fluid">
            
            <?=$this->Html->link("Crear una Cuenta de Nuestro Empleo","#",array(
                    "data-component" =>"triggerelement",
                    "data-target" =>".option-registrate-candidato",
                    "class" => "btn btn_color btn-link"                    

            ))?>

          </div>
  
      <?=$this->Form->end()?>
    


  </div>

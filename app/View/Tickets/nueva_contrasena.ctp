  <?php 
  if (isset($userFound)): 
    ?>

<div style="height:300px">
  
</div>


 <div id="formulario_recupara01" class="modal hide fade " data-component="modalform" data-auto="true" data-backdrop="static" data-keyboard="false" >

  <div class="modal-header">

      <h3 class="text-left title">Cambio de Contraseña</h3>
   </div>

  <div class='modal-body'>

    <div class="hide ajax-done">
      <h5 class="well">El cambio de contraseña se ha realizado con éxito.</h5>
        <div>  <a href="/"  class="btn btn_color" > Inicio </a> </div>

    </div>  

  <div class="formulario">

      <?=$this->Form->create('Usuario', 
          array("class"=>'form-horizontal  well',
          'data-component'=>"validationform ajaxform",
          'data-onvalidationerror'=>  json_encode(array(array("action"=>"click","target"=>".refresh-captcha-image" ) )),
          'id'=>'form-nueva-contraseña01', 
          'inputDefaults' => array(
            'label' => false,
            'div' => false
            ) ) );
            ?>
        <div class="row-fluid">
          <div class="offset3 span6">
              <div class="parent_">
                <?php 
                  echo $this->Form->input('password', array(
                    'icon' => 'key',
                    'class' => 'contrasena',
                    'placeholder' => 'Ingresa tu nueva contraseña',
                    'data-rule-required'=>"true",
                    'data-msg-required' =>'Ingresa contraseña nueva'
                  ));
                  ?>
              </div>
            
          </div>
        
        </div>
        <div class="row-fluid">
            <div class="offset3 span6">
                   <div class="parent_">
              <?php      
              echo $this->Form->input('confirm_password', array(
                'icon' => 'key',
                'placeholder' => 'Repite la contraseña',
                'type' => 'password',
                'data-rule-required'=>"true",
                'data-msg-required' =>'Repite la contraseña',
                'data-rule-equalto'=> '.contrasena',
                'data-msg-equalto'=> 'No coenciden los campos'
              ));
            ?>
            </div>
          </div>
          

        </div>
        <?=$this->element("candidatos/tool/captcha_image", array("status"=>true  )) ?>
        <?=$this->Form->submit("Aceptar", array ("class"=>'btn_color',"div"=>array("class"=>'pull-center')));  ?>
    
    <?=$this->Form->end() ?>

  </div>


   
  </div>

  <div class="modal-footer"> </div>
</div>
    


    
<?php
  endif; 
?>

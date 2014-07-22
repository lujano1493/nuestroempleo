<div id='recuperar_contrasena_empresas' class='modal hide fade ' data-component='modalform'>
  <div class='modal-header'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
    <h3 class='text-left title'>Recuperación de Contraseña</h3>
  </div>
  <div class='modal-body'>
    <div class='hide ajax-done'>
      <h5 class='well'>El correo de recuperación ha sido enviado, por favor revisa tu Bandeja de entrada</h5>
    </div>  
    <div class='formulario'>
      <?php
        echo $this->Form->create('Usuario', array(
          'url'=>  array(
            'controller' => 'tickets',
            'action' => 'recuperar_contrasena/empresas'
          ),
          'class' => 'form-horizontal  well',
          'data-component' => 'validationform ajaxform',
          'data-onvalidationerror' => json_encode(array(array(
            'action'=>'click',
            'target'=>'.refresh-captcha-image'
          ))),
          'id' => 'recuparar-correo01', 
          'inputDefaults' => array(
            'label' => false,
            'div' => false
          )
        ));
      ?>
      <div class='row-fluid'>
        <?php
          echo $this->Form->input('Usuario.email', array(
            'id' => 'email_recuperar',
            'label' => 'Ingresa correo electrónico*:',
            'div' =>  array(
              'class' => 'controls'
            ),
            'class' => ' input-medium-formulario'
          ));  
        ?>
      </div>
      <?php
        echo $this->element('candidatos/tool/captcha_image',array("status"=> false ));
        echo $this->Form->submit('Enviar Correo', array(
          'class' => 'btn_color',
          'div' => array(
            'class'=>'form-actions'
          )
        ));
        echo $this->Form->end();
      ?>
    </div>
    <a class='' data-dismiss='modal' aria-hidden='true' href='' >Cerrar formulario</a>
  </div>
  <div class='modal-footer'></div>
</div>





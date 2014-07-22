<div id='reenvio_mail_empresas' class='modal hide fade '  data-component='modalform'  >
  <div class='modal-header'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
    <h3 class='text-left title'>Reenviar Correo de Activación</h3>
  </div>
  <div class='modal-body'>
    <div class='hide ajax-done'>
      <h5 class='well'>Su correo de activación fue enviado con éxito, verifique en la bandeja de entrada.</h5>
    </div>  
    <div class='formulario'>
      <?php echo $this->Form->create('Usuario', array(
          'url' => array(
            'controller' => 'empresas',
            'action' => 'enviar_activacion'
          ),
          'class'=>'form-horizontal  well',
          'data-component'=>'validationform ajaxform',
          'data-onvalidationerror'=> '[{"action":"click","target":".refresh-captcha-image"}]',
          'id'=>'renviar-correo01', 
          'inputDefaults' => array(
            'label' => false,
            'div' => false
          )));
      ?>
      <div class='row-fluid'>
        <?php
          echo $this->Form->input('email', array(
            'label' => 'Ingresa Correo Electrónico*:',
            'div' =>  array('class'=>'controls'),
            'class' => 'input-medium-formulario '));  
        ?>
      </div>
      <div class='row-fluid'>
        <?php echo $this->element('candidatos/tool/captcha_image',array("status"=> false )); ?>
      </div>
      <?php
        echo $this->Form->submit('Enviar Correo', array(
          'class'=>'btn_color',
          'div'=>array(
            'class'=>'form-actions'
          ))
        );
      ?>
      <?php echo $this->Form->end(); ?>
    </div>
  </div>
  <div class='modal-footer'><a  class='' data-dismiss='modal' aria-hidden='true' href='' >Cerrar formulario</a></div>
</div>





<?php
  echo $this->Form->create('UsuarioEmpresa', array(
    'class' => 'modal fade',
    'id' => 'cambiar-contrasena',
    'url' => array(
      'controller' => 'mi_espacio',
      'action' => 'cambiar_contrasena',
      $this->Session->read('Auth.User.keycode')
    ),
    //'data-component' => 'ajaxform',
  ));
?>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4>Cambiar contraseña</h4>
      </div>
      <fieldset class="modal-body">
        <div class="alerts-container"></div>
        <div class="row">
          <div class="col-xs-8 col-md-offset-2">
            <?php
              echo $this->Form->input('UsuarioEmpresa.old_password', array(
                'class' => 'form-control input-block-level',
                'label' => 'Contraseña actual',
                'type' => 'password',
                'required' => true,
              ));
              echo $this->Form->input('UsuarioEmpresa.new_password', array(
                'class' => 'form-control input-block-level new_password',
                'label' => 'Ingresa tu nueva contraseña',
                'type' => 'password',
                'required' => true,
              ));
              echo $this->Form->input('UsuarioEmpresa.confirm_password', array(
                'class' => 'form-control input-block-level',
                'label' => 'Repita la contraseña',
                'type' => 'password',
                'required' => true,
              ));
            ?>
          </div>
        </div>
      </fieldset>
      <div class="modal-footer">
        <button class="btn btn-sm btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        <?php
          echo $this->Html->link(__('Aceptar'), '#', array(
            'data-submit' => true,
            'class' => 'btn btn-sm btn-success'
          ));
        ?>
      </div>
    </div>
  </div>
<?php
  echo $this->Form->end();
?>
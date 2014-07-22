<?php
  $u = $this->request->data['UsuarioAdmin'];
  $c = $this->request->data['Contacto'];
  $isReclutador = (int)$u['per_cve'] === 2;
?>

<div class="btn-actions text-right">
  <div class="alert alert-danger">
    <p>
      Debes estar seguro al borrar la cuenta de <?php echo $c['con_nombre'] . ' ' . $c['con_paterno'] ?>
      (<strong><?php echo $u['cu_sesion']; ?></strong>), ya que esta acción no se puede deshacer.
    </p>
    <?php
      echo $this->Html->link('Borrar Cuenta', '#borrar-cuenta' , array(
        'class' => 'btn btn-danger btn-xs',
        'data-toggle' => 'slidemodal',
        'icon' => 'trash'
      ));
    ?>
  </div>
</div>

<?php
  echo $this->Form->create(false, array(
    'class' => 'slidemodal',
    'data' => array(
      'copycat-autoload' => true,
      'slide-from' => 'right',
      'slides' => true
    ),
    'id' => 'borrar-cuenta',
    'url' => array(
      'admin' => $isAdmin,
      'controller' => 'cuentas',
      'action' => 'eliminar',
      'id' => $u['cu_cve'],
      'slug' => Inflector::slug($u['cu_sesion'], '-'),
      'keycode' => $u['keycode']
    ),
  ));
?>
  <div class="alerts-container"></div>
  <div class="slidemodal-dialog">
    <div class="slidemodal-header">
      <button type="button" class="close" data-dismiss="modal" data-close="slidemodal" aria-hidden="true">×</button>
      <h4 id="modal-title"><?php echo __('Eliminar Cuenta'); ?></h4>

    </div>
    <div class="slidemodal-body">
      <div class="sliding" data-navi-class="false">
        <!-- Wrapper for slides -->
        <!-- <div class="carousel-inner"> -->
          <div class="slide">
            <fieldset class="container">
              <legend><?php echo __('Asegúrate de querer realizar esta acción'); ?></legend>
              <div class="alert alert-warning">
                <h4>
                  <?php echo __('Esto es muy importante, lee con atención antes de continuar.'); ?>
                </h4>
                <ul>
                  <li><?php echo __('No es posible deshacer la eliminación de una cuenta.'); ?></li>
                  <li>
                    <?php echo __('El correo electrónico %s ya no estará disponible para futuros registros.', '<strong>' . $u['cu_sesion'] . '</strong>'); ?>
                  </li>
                  <li>
                    <?php echo __('Tienes que reasignar los clientes que que %s tiene asignados.', '<strong>' . $u['cu_sesion'] . '</strong>') ?>
                  </li>
                </ul>
              </div>
              <div class="btn-actions">
                <?php
                  echo $this->Html->link(__('Cancelar'), '#', array(
                    'class' => 'btn btn-default',
                    'data-close' => 'slidemodal'
                  ));

                  echo $this->Html->link(__('Comprendo muy bien y deseo continuar.'), '#', array(
                    'class' => 'btn btn-primary',
                    'data-slide-nav' => 'next'
                  ));
                ?>
              </div>
            </fieldset>
            <fieldset class="container">
            </fieldset>
          </div>
          <div class="slide">
            <fieldset class="container">
              <legend><?php echo __('Reasignación de clientes'); ?></legend>
              <div class="row">
                <div class="col-xs-6 col-md-offset-3">
                  <?php
                    echo $this->Form->input('Reassignments.clientes', array(
                      'class' => 'form-control input-sm input-block-level',
                      'label' => __('Reasignar clientes a'),
                      'required' => true,
                      'options' => $usuarios
                    ));
                  ?>
                </div>
              </div>
            </fieldset>
            <fieldset class="container">
              <legend>Confirmación</legend>
              <div class="row">
                <div class="col-xs-6 col-md-offset-3">
                  <?php
                    echo $this->Form->input('confirm_email', array(
                      'class' => 'form-control input-lg input-block-level',
                      'label' => __('Correo de la cuenta que estás por eliminar:'),
                      'required' => true,
                    ));
                  ?>
                </div>
              </div>
              <div class="btn-actions">
                <?php
                  echo $this->Html->link(__('Eliminar a %s', $u['cu_sesion']), '#', array(
                    'class' => 'btn btn-success',
                    'data' => array(
                      'submit' => true
                    ),
                    'icon' => 'trash'
                  ));
                ?>
              </div>
            </fieldset>
          </div>
        <!-- </div> -->
      </div>
    </div>
    <div class="slidemodal-footer footer">
      <div class="btn-actions">
        <?php
          echo $this->Form->button(__('Cancelar'), array(
            'aria-hidden' => 'true',
            'class' => 'btn btn-default',
            'data' => array(
              'dismiss' => 'modal',
              'close' => 'slidemodal'
            ),
            'type' => 'button'
          ));
        ?>
      </div>
    </div>
  </div>
<?php
  echo $this->Form->end();
?>
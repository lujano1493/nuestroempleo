<?php
  echo $this->Form->create('FormularioContactoPremium', array(
    'class' => 'modal fade on-success-hide',
    'id' => 'contacto-premium',
    'url' => array(
      'controller' => 'mis_cuentas',
      'action' => 'premium'
    ),
  ));
?>
  <div class="modal-dialog" style="width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="text-center"><?php echo __('Solicitud Empresa Premium'); ?></h4>
      </div>
      <div class="modal-body">
        <div class="alerts-container"></div>
        <div class="row">
          <div class="col-xs-8">
            <?php
              echo $this->Html->image('assets/logo.png', array(
                'width' => 300
              ));
            ?>
          </div>
          <div class="col-xs-4">
            <h5 class="subtitle">
              <i class="icon-asterisk"></i><?php echo __('Datos de Solicitud'); ?>
            </h5>
            <p>
              <strong class="block">Fecha de solicitud:</strong><?php echo $this->Time->d(); ?>
            </p>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-8">
            <h5 class="subtitle">
              <i class="icon-user"></i><?php echo __('Datos del Cliente'); ?>
            </h5>
            <?php
              $empresa = $authUser['Empresa'];
            ?>
            <div class="row">
              <div class="col-xs-6">
                <div>
                  <h5><?php echo __('Número de Socio'); ?></h5>
                  <strong><?php echo $empresa['cia_cve']; ?></strong>
                </div>
                <div>
                  <h5><?php echo __('Nombre del Cliente'); ?></h5>
                  <strong><?php echo $authUser['fullName']; ?></strong>
                </div>
              </div>
              <div class="col-xs-6">
                <div>
                  <h5><?php echo __('Fecha de Registro'); ?></h5>
                  <strong><?php echo $this->Time->d($empresa['created']); ?></strong>
                </div>
                <div>
                  <h5><?php echo __('Correo Electrónico'); ?></h5>
                  <strong><?php echo $authUser['cu_sesion']; ?></strong>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xs-4">
            <h5 class="subtitle">
              <i class="icon-building"></i><?php echo __('Tipo de Empresa'); ?>
            </h5>
            <?php
              echo $this->Form->input('FormularioContactoPremium.tipo_cia', array(
                'class' => 'form-control input-sm input-block-level',
                'empty' => false,
                'label' => false,
                'options' => $tipos_compania,
              ));
            ?>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-8">
            <h5 class="subtitle">
              <i class="icon-ok-circle"></i><?php echo __('Sello de Empresa Premium'); ?>
            </h5>
            <table class="table table-bordered ">
              <thead>
                <tr>
                  <th style="width:80%;"></th>
                  <th>Si</th>
                  <th>No</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-left">Declaro que mi Empresa está totalmente constituída</td>
                  <td>
                    <?php
                      echo $this->Form->input('FormularioContactoPremium.pregunta1', array(
                        'legend' => false,
                        'separator' => '</td><td>',
                        'hiddenField' => false,
                        'options' => array(
                          's' => '', 'n' => '',
                        ),
                        'div' => false,
                        'type' => 'radio',
                        'default' => 'n'
                      ));
                    ?>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">Autorizo recibir una inspección en las instalaciones de mi compañía</td>
                  <td>
                    <?php
                      echo $this->Form->input('FormularioContactoPremium.pregunta2', array(
                        'legend' => false,
                        'separator' => '</td><td>',
                        'hiddenField' => false,
                        'options' => array(
                          's' => '', 'n' => '',
                        ),
                        'div' => false,
                        'type' => 'radio',
                        'default' => 'n'
                      ));
                    ?>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">Deseo que mis publicaciones tengan un sello de Empresa Premium</td>
                  <td>
                    <?php
                      echo $this->Form->input('FormularioContactoPremium.pregunta3', array(
                        'legend' => false,
                        'separator' => '</td><td>',
                        'hiddenField' => false,
                        'options' => array(
                          's' => '', 'n' => '',
                        ),
                        'div' => false,
                        'type' => 'radio',
                        'default' => 'n'
                      ));
                    ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-xs-4">
            <h5 class="subtitle">
              <i class="icon-asterisk"></i><?php echo __('Tipo de Servicio'); ?>
            </h5>
            <?php
              $membresiaName = $authUser['Perfil']['membresia'];
              echo __('Membresía %s', $membresiaName);
            ?>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <h5 class="subtitle">
              <i class="icon-asterisk"></i><?php echo __('Comentarios'); ?>
            </h5>
            <?php
              echo $this->Form->input('comentarios', array(
                'class' => 'input-sm form-control',
                'label' => false,
                'type' => 'textarea'
              ));
            ?>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default btn-sm" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        <?php
          echo $this->Html->link('Aceptar', '#', array(
            'class' => 'btn btn-default btn-sm btn-success',
            'data-submit' => true,
          ));
        ?>
      </div>
    </div>
  </div>
<?php
  echo $this->Form->end();
?>
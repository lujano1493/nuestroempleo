<?php
  echo $this->Form->create('FormularioContacto', array(
    'class' => 'modal fade',
    'id' => 'contacto-ejecutivo',
    'url' => array(
      'controller' => 'empresas',
      'action' => 'contacto'
    ),
    //'style' => 'width:640px;margin-left:-320px'
  ));

  $medios = array(
    'Teléfono',
    'E-mail'
  );

  $motivos = array(
    'Comprar un producto' => 'Deseo comprar un producto',
    'Aclarar dudas sobre los servicios y costos' => 'Deseo aclarar mis dudas sobre los servicios y/o costos',
    'Mayor información' => 'Deseo mayor información',
    'Solucionar problemas técnicos' => 'Tengo problemas técnicos',
    'Otros' => 'Otros',
  );
?>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="text-center"><?php echo __('Contacta a un Ejecutivo'); ?></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12">
            <h4 class="text-center"><?php echo $authUser['Empresa']['cia_razonsoc']; ?></h4>
            <p class="left">
              <strong>Nombre de la cuenta:</strong><?php echo $authUser['fullName']; ?>
            </p>
            <p class="left"><strong>Num de socio:</strong><?php echo $authUser['cu_cve']; ?></p>
            <p class="left"><strong>Fecha de solicitud:</strong><?php echo $this->Time->d(); ?></p>
          </div>
        </div>
        <fieldset class="well">
          <strong>Medio por el que desea ser contactado</strong>
          <div class="row">
            <div class="col-xs-6">
              <?php
                echo $this->Form->input('FormularioContacto.medio.', array(
                  'div' => 'input-block-level',
                  'hiddenField' => false,
                  'id' => 'FormularioContactoMedioTel',
                  'label' => __('Teléfono'),
                  'type' => 'checkbox',
                  'value' => 'tel'
                ));
              ?>
            </div>
            <div class="col-xs-6">
              <?php
                echo $this->Form->input('FormularioContacto.medio.', array(
                  'div' => 'input-block-level',
                  'hiddenField' => false,
                  'id' => 'FormularioContactoMedioEmail',
                  'label' => __('E-mail'),
                  'type' => 'checkbox',
                  'value' => 'email'
                ));
              ?>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <?php
                echo $this->Form->input('FormularioContacto.motivo', array(
                  'class' => 'form-control input-sm input-block-level',
                  'empty' => false,
                  'label' => __('Por favor indique el motivo.'),
                  'options' => $motivos,
                ));
              ?>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <?php
                echo $this->Form->input('FormularioContacto.mensaje', array(
                  'class' => 'form-control input-sm input-block-level',
                  'style' => 'height: 150px;',
                  'type' => 'textarea',
                  'label' => __('Ingrese el mensaje')
                ));
              ?>
            </div>
          </div>
        </fieldset>
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
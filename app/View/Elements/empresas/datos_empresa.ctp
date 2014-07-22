<?php
  echo $this->Form->create('Empresa', array(
    'class' => 'form-inline no-bordered row',
    'novalidate' => true,
    'url' => array(
      'controller' => 'mi_espacio',
      'action' => 'mi_empresa'
    )
  ));
?>
  <fieldset class="col-xs-12">
    <legend class="subtitle">
      Datos de la Empresa
    </legend>
    <div class="row">
      <div class="col-xs-4">
        <?php
          echo $this->Form->input('DatosEmpresa.0.datos_cve', array(
            'type' => 'hidden'
          ));
          echo $this->Form->input('DatosEmpresa.0.cia_cve', array(
            'type' => 'hidden'
          ));
          echo $this->Form->input('Empresa.cia_nombre', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => 'Nombre de la Empresa:',
            'placeholder' => ''
          ));
        ?>
      </div>
      <div class="col-xs-4">
        <?php
          echo $this->Form->input('Empresa.cia_razonsoc', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => 'Razón Social:',
            'placeholder' => ''
          ));
        ?>
      </div>
      <div class="col-xs-4">
        <?php
          echo $this->Form->input('Empresa.giro_cve', array(
            'class' => 'form-control input-sm input-block-level',
            'data' => array(
              // 'component' => 'sourcito',
              'default-value' => !empty($this->request->data['Empresa']['giro_cve']) ? $this->request->data['Empresa']['giro_cve'] : '1',
              'json-name' => 'giro',
              'source-autoload' => true,
              'source-name' => 'giros',
              'source-self' => true
            ),
            //'data-component' => 'sourcito',
            //'data-source-autoload' => true,
            //'data-source-name' => 'giros',
            'label' => 'Giro de la empresa:',
            'placeholder' => '',
            'options' => array(),
            //'data-default-value' => !empty($this->request->data['Empresa']['giro_cve']) ? $this->request->data['Empresa']['giro_cve'] : '1',
            //'data-no-change' => true
          ));
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4">
        <?php
          echo $this->Form->input('Empresa.cia_rfc', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => 'RFC:',
            'placeholder' => ''
          ));
        ?>
      </div>
      <div class="col-xs-4">
        <?php echo $this->Form->input('DatosEmpresa.0.cp_cp', array(
          'class' => 'form-control input-sm input-block-level',
          'data' => array(
            'source-scope' => 'form',
            'source-autoload' => true,
            'source-name' => 'codigo_postal',
          ),
          'label' => 'Código Postal',
          'max' => '99999',
          'min' => '0',
          'pattern' => '[0-9]*',
          'placeholder' => 'Código Postal',
          'required' => true,
          'type' => 'number',
          'value' => !empty($cp_cp) ? $cp_cp : ''
        )); ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4">
        <?php echo $this->Form->input('DatosEmpresa.0.estado', array(
          'class' => 'form-control input-sm input-block-level',
          'data-json-name' => 'estado',
          'label' => 'Estado',
          'placeholder' => 'Estado',
          'disabled' => true
        )); ?>
      </div>
      <div class="col-xs-4">
        <?php echo $this->Form->input('DatosEmpresa.0.ciudad', array(
          'class' => 'form-control input-sm input-block-level',
          'data-json-name' => 'municipio',
          'label' => 'Municipio',
          'placeholder' => 'Ciudad',
          'disabled' => true
        )); ?>
      </div>
      <div class="col-xs-4">
        <?php echo $this->Form->input('DatosEmpresa.0.cp_cve', array(
          'class' => 'form-control input-sm input-block-level',
          'data-default-value' => !empty($cp_cve) ? $cp_cve : '',
          'data-json-name' => 'colonias',
          'empty' => '↑ Primero escriba el Código Postal',
          'label' => 'Colonia',
          'options' => array(),
          'placeholder' => 'Colonia',
          'required' => true,
        )); ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6">
        <?php
          echo $this->Form->input('DatosEmpresa.0.calle', array(
            'data-json-name' => 'calle',
            'class' => 'form-control input-sm input-block-level',
            'label' => 'Calle',
            'placeholder' => 'Escribe la calle en dónde se encuentra tu empresa.',
            'disabled' => false
          ));
        ?>
      </div>
      <div class="col-xs-3">
        <?php echo $this->Form->input('DatosEmpresa.0.num_ext', array(
          'data-json-name' => 'num_exterior',
          'class' => 'form-control input-sm input-block-level',
          'label' => 'Núm. Exterior',
          'placeholder' => 'Núm. Exterior',
          'disabled' => false
        )); ?>
      </div>
      <div class="col-xs-3">
        <?php echo $this->Form->input('DatosEmpresa.0.num_int', array(
          'data-json-name' => 'num_interior',
          'class' => 'form-control input-sm input-block-level',
          'label' => 'Núm. Interior',
          'placeholder' => 'Núm. Exterior',
          'required' => false,
        )); ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4">
        <?php
          echo $this->Form->input('DatosEmpresa.0.cia_tel', array(
            'class' => 'form-control input-sm input-block-level numeric',
            'label' => 'Teléfono de la Empresa:',
            'placeholder' => ''
          ));
        ?>
      </div>
      <div class="col-xs-4">
        <?php
          echo $this->Form->input('DatosEmpresa.0.cia_web', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => 'Sitio Web:',
            'placeholder' => ''
          ));
        ?>
      </div>
    </div>
    <div class="btn-actions text-right">
      <?php
        echo $this->Html->link(__('Aceptar'), '#', array(
          'class' => 'btn btn-success',
          'data-submit' => true
        ));
      ?>
    </div>
  </fieldset>
<?php
  echo $this->Form->end();
?>
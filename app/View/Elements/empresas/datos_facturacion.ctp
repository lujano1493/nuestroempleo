<?php
  // $_list = !empty($_list);
  echo $this->Form->create('FacturacionEmpresa', array(
    'class' => 'form-inline no-bordered row',
    'novalidate' => true,
    'url' => $isAdmin ? array(
      'admin' => $isAdmin,
      'controller' => 'empresas',
      'action' => 'facturacion',
      'id' => $empresa['cia_cve'],
      'slug' => Inflector::slug($empresa['cia_nombre'], '-')
    ) : array(
      'controller' => 'mi_espacio',
      'action' => 'mi_empresa',
      'facturacion'
    )
  ));
?>
  <fieldset class="col-xs-12" style="position:relative;">
    <?php
      echo $this->Form->input('__facturacion', array(
        'class' => 'form-control input-sm',
        'data' => array(
          'source-autoload' => true,
          'source-scope' => 'fieldset',
          'source-name' => 'datos_facturacion',
          'source-controller' => $isAdmin ? 'admin/empresas' : 'empresas',
        ),
        'div' => 'absolute-top-right',
        'label' => false,
        'options' => $opcionesFacturacion
      ));
    ?>
    <legend class="subtitle">
      <?php echo __('Datos de Facturación'); ?>
    </legend>
    <div class="row">
      <div class="col-xs-4">
        <?php
          echo $this->Form->input('DatosFacturacionEmpresa.datos_cve', array(
            'data' => array(
              'json-name' => 'datos_id'
            ),
            'type' => 'hidden'
          ));
          echo $this->Form->input('DatosFacturacionEmpresa.cia_cve', array(
            'type' => 'hidden'
          ));
          echo $this->Form->input('FacturacionEmpresa.cia_nombre', array(
            'data-json-name' => 'empresa_nombre',
            'class' => 'form-control input-sm input-block-level',
            'label' => 'Nombre de la Empresa:',
            'placeholder' => ''
          ));
        ?>
      </div>
      <div class="col-xs-4">
        <?php
          echo $this->Form->input('FacturacionEmpresa.cia_razonsoc', array(
            'data-json-name' => 'razon_social',
            'class' => 'form-control input-sm input-block-level',
            'label' => 'Razón Social:',
            'placeholder' => ''
          ));
        ?>
      </div>
      <div class="col-xs-4">
        <?php
          if (empty($giro_cve)) {
            $giro_cve = !empty($this->request->data['FacturacionEmpresa']['giro_cve']) ? $this->request->data['FacturacionEmpresa']['giro_cve'] : '1';
          }

          echo $this->Form->input('FacturacionEmpresa.giro_cve', array(
            'class' => 'form-control input-sm input-block-level',
            'data' => array(
              'default-value' => $giro_cve,
              'json-name' => 'giro',
              'source-autoload' => true,
              'source-name' => 'giros',
              'source-self' => true
            ),
            'label' => 'Giro de la empresa:',
            'placeholder' => '',
            'options' => array()
          ));
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4" data-copycat-autoload>
        <?php
          echo $this->Form->input('FacturacionEmpresa.cia_rfc', array(
            'class' => 'form-control input-sm input-block-level',
            'data' => array(
              'json-name' => 'rfc',
              'target-name' => 'rfc',
            ),
            'label' => 'RFC:',
            'placeholder' => '',
            'type' => 'text'
          ));
        ?>
      </div>
      <div class="col-xs-4">
        <?php echo $this->Form->input('DatosFacturacionEmpresa.cp_cp', array(
          'class' => 'form-control input-sm input-block-level',
          'data' => array(
            'json-name' => 'codigo_postal',
            'source-scope' => 'fieldset',
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
          'value' => !empty($cp_cp_fact) ? $cp_cp_fact : ''
        )); ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4">
        <?php echo $this->Form->input('DatosFacturacionEmpresa.estado', array(
          'class' => 'form-control input-sm input-block-level',
          'data-json-name' => 'estado',
          'label' => 'Estado',
          'placeholder' => 'Estado',
          'disabled' => true
        )); ?>
      </div>
      <div class="col-xs-4">
        <?php echo $this->Form->input('DatosFacturacionEmpresa.ciudad', array(
          'class' => 'form-control input-sm input-block-level',
          'data-json-name' => 'municipio',
          'label' => 'Municipio',
          'placeholder' => 'Ciudad',
          'disabled' => true
        )); ?>
      </div>
      <div class="col-xs-4">
        <?php echo $this->Form->input('DatosFacturacionEmpresa.cp_cve', array(
          'class' => 'form-control input-sm input-block-level',
          'data-default-value' => !empty($cp_cve_fact) ? $cp_cve_fact : '',
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
          echo $this->Form->input('DatosFacturacionEmpresa.calle', array(
            'data-json-name' => 'calle',
            'class' => 'form-control input-sm input-block-level',
            'label' => 'Calle',
            'placeholder' => 'Escribe la calle en dónde se encuentra tu empresa.',
            'disabled' => false
          ));
        ?>
      </div>
      <div class="col-xs-3">
        <?php echo $this->Form->input('DatosFacturacionEmpresa.num_ext', array(
          'data-json-name' => 'num_exterior',
          'class' => 'form-control input-sm input-block-level',
          'label' => 'Núm. Exterior',
          'placeholder' => 'Núm. Exterior',
          'disabled' => false
        )); ?>
      </div>
      <div class="col-xs-3">
        <?php echo $this->Form->input('DatosFacturacionEmpresa.num_int', array(
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
          echo $this->Form->input('DatosFacturacionEmpresa.cia_tel', array(
            'class' => 'form-control input-sm input-block-level numeric',
            'data-json-name' => 'telefono',
            'label' => 'Teléfono:',
            'placeholder' => ''
          ));
        ?>
      </div>
      <div class="col-xs-4">
        <?php
          echo $this->Form->input('DatosFacturacionEmpresa.cia_web', array(
            'data-json-name' => 'web',
            'class' => 'form-control input-sm input-block-level',
            'label' => 'Sitio Web:',
            'placeholder' => ''
          ));
        ?>
      </div>
    </div>
    <?php if (!isset($submit) || $submit === true) { ?>
      <div class="btn-actions text-right">
        <?php
          echo $this->Html->link(__('Aceptar'), '#', array(
            'class' => 'btn btn-success',
            'data-submit' => true,
          ));
        ?>
      </div>
    <?php } ?>
  </fieldset>
<?php
  echo $this->Form->end();
?>
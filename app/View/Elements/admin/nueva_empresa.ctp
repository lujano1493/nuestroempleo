<div id="new-empresa-form" class="form-hide well" style="display:none;">
  <?php
    echo $this->Form->create('Empresa', array(
      'class' => '',
      //'id' => 'empresa-registrar',
      'url' => array(
        'controller' => 'empresas',
        'action' => 'registrar',
        'admin' => true
      ),
      //'novalidate' => true
    ));
  ?>
    <fieldset>
      <h5 class="subtitle">
        <?php echo __('Registro de nueva Empresa'); ?>
      </h5>
      <div class="alert alert-info">
        Complete los datos que se solicitan a continuación para crear una nueva Empresa.
      </div>
      <div class="row">
        <div class="col-xs-4">
          <?php echo $this->Form->input('Empresa.cia_nombre', array(
            'class' => 'form-control input-sm input-block-level',
            // 'icon' => 'briefcase',
            'label' => 'Nombre de la Empresa*:',
            'required' => true
            ));
          ?>
        </div>
        <div class="col-xs-4">
          <?php echo $this->Form->input('Empresa.cia_rfc', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => 'R.F.C.*:',
            'required' => true
            ));
          ?>
        </div>
        <div class="col-xs-4">
          <?php
            echo $this->Form->input('Empresa.giro_suggest', array(
              'class' => 'form-control input-sm input-block-level',
              'label' => 'Giro de la Empresa*:',
              'id' => 'giros',
              'div' => array(
                'style' => 'padding-right:50px;'
              )
            ));
            echo $this->Form->input('Empresa.giro_cve', array(
              'label' => false,
              'type' => 'hidden',
              'id' => 'EmpresaGiroCve'
            ));
          ?>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-4">
          <?php
            echo $this->Form->input('UsuarioEmpresa.cu_sesion', array(
              'class' => 'form-control input-sm input-block-level cu_sesion',
              // 'icon' => 'envelope',
              'label' => 'Correo Electrónico*:',
              'required' => true,
              'type' => 'email'
            ));
          ?>
        </div>
        <div class="col-xs-4">
          <?php
            echo $this->Form->input('UsuarioEmpresa.cu_sesion_confirm', array(
              'class' => 'form-control input-sm input-block-level no-edit',
              // 'icon' => 'envelope',
              'label' => 'Correo Electrónico*:',
              'required' => true,
              'type' => 'email'
            ));
          ?>
        </div>
        <div class="col-xs-4">
          <?php
            echo $this->Form->input('Empresa.cia_tel', array(
              'class' => 'form-control input-sm input-block-level numeric',
              // 'icon' => 'phone',
              'label' => 'Teléfono de la Empresa*:',
              'required' => false
            ));
          ?>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-4">
          <?php
            echo $this->Form->input('Empresa.cia_tipo', array(
              'class' => 'form-control input-sm input-block-level',
              'label' => 'Tipo de Empresa:',
              'required' => true,
              'options' => array(
                __('Comercial'), __('Convenio')
              )
            ));
          ?>
        </div>
        <div class="col-xs-4">
          <?php
            echo $this->Form->input('Empresa.ejecutivo_cve', array(
              'class' => 'form-control input-sm input-block-level',
              'label' => 'Ejecutivo:',
              'required' => true,
              'options' => $usuarios
            ));
          ?>
        </div>
        <div class="col-xs-4">
          <?php
            echo $this->Form->input('Empresa.cp', array(
              'class' => 'form-control input-sm input-block-level',
              // 'data-component' => 'sourcito',
              'data-source-name' => 'codigo_postal',
              // 'icon' => 'map-marker',
              'pattern' => '[0-9]*',
              'label' => 'Código Postal*:',
              'required' => true,
            ));
          ?>
        </div>

      </div>
      <div class="row">
        <div class="col-xs-4">
          <?php
            echo $this->Form->input('Empresa.estado', array(
              'class' => 'form-control input-sm input-block-level',
              'data-json-name' => 'estado',
              // 'icon' => 'map-marker',
              'label' => 'Estado*:',
              'disabled' => true
            ));
          ?>
        </div>
        <div class="col-xs-4">
          <?php
            echo $this->Form->input('Empresa.ciudad', array(
              'class' => 'form-control input-sm input-block-level',
              'data-json-name' => 'municipio',
              // 'icon' => 'map-marker',
              'label' => 'Ciudad*:',
              'disabled' => true
            ));
          ?>
        </div>
        <div class="col-xs-4">
          <?php
            echo $this->Form->input('Empresa.colonia', array(
              'class' => 'form-control input-sm input-block-level',
              'data-json-name' => 'colonias',
              'empty' => '↑ Primero escriba el Código Postal',
              // 'icon' => 'map-marker',
              'label' => 'Colonia*:',
              'required' => true,
              'type' => 'select'
            ));
          ?>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-4">
          <?php echo $this->Form->input('UsuarioEmpresaContacto.con_nombre', array(
            'class' => 'form-control input-sm input-block-level',
            // 'icon' => 'user',
            'label' => 'Nombre(s)*:',
            'required' => true
          )); ?>
        </div>
        <div class="col-xs-4">
          <?php echo $this->Form->input('UsuarioEmpresaContacto.con_paterno', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => 'Apellido Paterno*:',
            'required' => true
          )); ?>
        </div>
        <div class="col-xs-4">
          <?php echo $this->Form->input('UsuarioEmpresaContacto.con_materno', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => 'Apellido Materno:',
            'required' => false
          )); ?>
        </div>
      </div>
      <br><br>
      <div class="btn-actions text-right">
        <?php
          echo $this->Html->link('Cancelar', $_referer, array(
            'class' => 'btn btn-danger',
            'div' => false,
            'data' => array(
              'open-form' => 'new-empresa-form'
            )
          ));
          echo $this->Html->link(__('Aceptar'), '#', array(
            'class' => 'btn btn-success',
            'data-submit' => true,
          ));
        ?>
      </div>
    </fieldset>
  <?php echo $this->Form->end(); ?>
</div>
<div id="new-account-form" class="form-hide well" style="display:none;">
  <div class="alert alert-info">
    <?php echo __('Complete los datos solicitados para crear una nueva cuenta.'); ?>
  </div>
  <?php
    echo $this->Form->create('UsuarioAdmin', array(
      'class' => '',
      'url' => array(
        'controller' => 'cuentas',
        'action' => 'nueva',
        'admin' => $isAdmin
      )
    ));
  ?>
    <?php echo $this->Session->flash(); ?>
    <fieldset>
      <legend class="subtitle">Datos de la Cuenta</legend>
      <div class="row">
        <div class="col-xs-4">
          <?php
            echo $this->Form->input('UsuarioAdmin.per_cve', array(
              'class' => 'form-control input-sm input-block-level',
              'label' => 'Tipo de Cuenta',
              'placeholder' => 'Perfil',
              'required' => true,
              'options' => array(
                2 => 'Administrador',
                'Ventas'
              )
            ));
          ?>
        </div>
        <div class="col-xs-8">
          <?php
            // echo $this->Form->input('UsuarioAdmin.cu_cvesup', array(
            //   'class' => 'form-control input-sm input-block-level',
            //   'label' => 'Asignar a',
            //   'required' => true,
            //   'options' => $usuarios
            // ));
          ?>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-4">
          <?php echo $this->Form->input('Contacto.con_nombre', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => 'Nombre',
            'required' => true
            ));
          ?>
        </div>
        <div class="col-xs-4">
          <?php echo $this->Form->input('Contacto.con_paterno', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => 'Primer Apellido',
            'required' => true
            ));
          ?>
        </div>
        <div class="col-xs-4">
          <?php echo $this->Form->input('Contacto.con_materno', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => 'Segundo Apellido',
            //'required' => true
            ));
          ?>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-4">
          <?php
            echo $this->Form->input('UsuarioAdmin.cu_sesion', array(
              'class' => 'form-control input-sm input-block-level cu_sesion',
              //'icon' => 'envelope',
              'label' => 'Correo Electrónico',
              'required' => true,
              'type' => 'email',
            ));
          ?>
        </div>
        <div class="col-xs-4">
          <?php
            echo $this->Form->input('UsuarioAdmin.cu_sesion_confirm', array(
              'class' => 'form-control input-sm input-block-level no-edit',
              //'icon' => 'envelope',
              'label' => 'Confirma el correo electrónico',
              'required' => true,
              'type' => 'email',
            ));
          ?>
        </div>
        <div class="col-xs-4">
          <div class="input no-label">
            <p class="input-sm">Con este correo, el usuario iniciar&aacute; sesi&oacute;n</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-6">
          <?php
            echo $this->Form->input('Contacto.con_ubicacion', array(
              'class' => 'form-control input-sm input-block-level',
              'label' => 'Ubicación',
              'required' => true,
            ));
          ?>
        </div>
        <div class="col-xs-3">
          <?php
            echo $this->Form->input('Contacto.con_tel', array(
              'class' => 'form-control input-sm input-block-level numeric',
              'label' => 'Teléfono',
              'required' => true,
            ));
          ?>
        </div>
        <div class="col-xs-3">
          <?php
            echo $this->Form->input('Contacto.con_ext', array(
              'class' => 'form-control input-sm input-block-level',
              'label' => 'Extensión',
              'type' => 'number'
            ));
          ?>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="btn-actions">
            <?php
              echo $this->Html->link('Aceptar', '#', array(
                'class' => 'btn btn-success',
                'data-submit' => true,
              ));

              echo $this->Html->link('Cancelar', $_referer, array(
                'class' => 'btn btn-danger',
                'div' => false,
                'data' => array(
                  'open-form' => 'new-account-form'
                )
              ));
            ?>
          </div>
        </div>
      </div>
    </fieldset>
  <?php echo $this->Form->end(); ?>

  <?php
    // $this->AssetCompress->addScript(array(
    //   'app/empresas/cuentas.js'
    // ), 'cuentas.js');
  ?>
</div>
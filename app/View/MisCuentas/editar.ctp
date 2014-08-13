<?php
  echo $this->element('empresas/title');
  $u = $this->request->data['UsuarioEmpresa'];
?>
<div class="row">
  <div class="col-xs-12">
    <div class="btn-actions">
      <?php
        echo $this->Html->link('Cambiar Correo', '#', array(
          'class' => 'btn btn-primary btn-lg',
          'icon' => 'envelope-alt',
          'data-open-div' => 'new-email-form'
        ));

        echo $this->Html->link('Cambiar Contraseña', '#', array(
          'class' => 'btn btn-primary btn-lg',
          'icon' => 'key',
          'data-open-div' => 'new-pass-form'
        ));
      ?>
    </div>
  </div>
</div>

<div class="row" style="display:none;">
  <div class="col-xs-12">
    <div id="new-pass-form" class="form-hide" style="display:none;">
      <?php
        echo $this->Form->create('UsuarioEmpresa', array(
          'url' => array(
            'controller' => 'mis_cuentas',
            'action' => 'cambiar_contrasena',
            $u['keycode']
          )
        ));
      ?>
        <div class="row">
          <div class="col-xs-6">
            <?php
              echo $this->Form->input('new_password', array(
                'class' => 'form-control input-sm input-block-level',
                'label' => 'Nueva Contraseña',
                'value' => $new_password
              ));
            ?>
          </div>
          <div class="col-xs-6">
            <?php
              echo $this->Form->input('new_password_verify', array(
                'class' => 'form-control input-sm input-block-level',
                'label' => 'Repite la contraseña',
                'value' => $new_password
              ));
            ?>
          </div>
        </div>
        <div class="btn-actions">
            <?php
              echo $this->Form->submit('Aceptar', array(
                'class' => 'btn btn-success',
                'data-submit' => true,
                'div' => false
              ));
            ?>
          </div>
      <?php echo $this->Form->end(); ?>
    </div>
    <div id="new-email-form" class="form-hide" style="display:none;">
      <?php
        echo $this->Form->create('UsuarioEmpresa', array(
          'url' => array(
            'controller' => 'mis_cuentas',
            'action' => 'cambiar_email',
            $u['keycode']
          )
        ));
      ?>
        <div class="well well-small info">
          <p>
            Cambiarás el email del usuario: <strong><?php echo $u['cu_sesion']; ?></strong>. Cambiando el email del usuario
            se actualizará su contraseña. Y un correo de verificación será enviado a la nueva dirección de email.
          </p>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <?php
              echo $this->Form->input('cu_sesion', array(
                'class' => 'form-control input-sm input-block-level',
                'label' => 'Nuevo Correo Electrónico',
              ));
            ?>
          </div>
          <div class="col-xs-6">
            <?php
              echo $this->Form->input('cu_sesion_verify', array(
                'class' => 'form-control input-sm input-block-level',
                'label' => 'Verifica el Correo Electrónico',
              ));
            ?>
          </div>
        </div>
        <div class="btn-actions">
            <?php
              echo $this->Form->submit('Aceptar', array(
                'class' => 'btn btn-success',
                'data-submit' => true,
                'div' => false
              ));
            ?>
          </div>
      <?php echo $this->Form->end(); ?>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    <?php
      echo $this->Form->create('UsuarioEmpresa', array(
        'class' => '',
      ));
    ?>
      <?php echo $this->Session->flash(); ?>
      <fieldset>
        <legend>Datos de la Cuenta</legend>
        <div class="row">
          <div class="col-xs-4">
            <?php
              $perfiles = array();
              /**
               * Sólo el admin puede crear coordinadores.
               */
              if ($this->Acceso->checkRole('admin')) {
                $perfiles['coordinador'] = __('Coordinador');
              }
              $perfiles['reclutador'] = __('Reclutador');

            $select=array(
                  1=> 'coordinador',
                  2=> 'reclutador'
              );

              echo $this->Form->input('UsuarioEmpresa.per_cve', array(
                'class' => 'form-control input-sm input-block-level',
                'value' =>  $select[$this->data['UsuarioEmpresa']['per_cve']] ,
                'label' => 'Tipo de Cuenta',
                'placeholder' => 'Perfil',
                'required' => true,
                'options' => $perfiles
              ));
               echo $this->Form->input('UsuarioEmpresa.per_cve',array(
                'type' => 'hidden',
                'name' => "data[UsuarioEmpresa][per_cveold]"

                ));
            ?>
          </div>
          <div class="col-xs-8">
            <?php
              echo $this->Form->input('UsuarioEmpresa.cu_cvesup', array(
                'class' => 'form-control input-sm input-block-level',
                'label' => 'Asignar a',
                'required' => true,
                'options' => $usuarios
              ));
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
                echo $this->Form->submit('Aceptar', array(
                  'class' => 'btn btn-success',
                  'data-submit' => true,
                  'div' => false
                ));
                echo $this->Html->link('Cancelar', $_referer, array(
                  'class' => 'btn btn-danger',
                  'div' => false
                ));
              ?>
            </div>
          </div>
        </div>
      </fieldset>
    <?php echo $this->Form->end(); ?>
  </div>
</div>

<?php
  echo $this->element('empresas/cuentas/eliminar');

  $this->AssetCompress->addScript(array(
    'app/empresas/cuentas.js'
  ), 'cuentas.js');
?>

<?php
  $e = $empresa['Empresa'];
  $a = $empresa['Admin'];
  $ac = $empresa['AdminContacto'];
  $ej = $empresa['Ejecutivo'];
  $ec = $empresa['EjecutivoContacto'];
  echo $this->element('admin/title');
?>

<div class="row">
  <div class="col-xs-8">
    <h2>
      <?php
        echo $e['cia_nombre'];
      ?>
      <small><?php echo $e['cia_razonsoc']; ?></small>
    </h2>
    <div class="lead">
      <span class="block">
        <?php echo __('<small>%s</small> %s', 'Giro:', $e['giro']); ?>
      </span>
      <span class="block">
        <?php echo __('<small>%s</small> %s', 'Tipo de Servicio:', $empresa['Producto']['membresia_nom'] ?: __('N/D')); ?>
      </span>
      <span class="block">
        <?php echo __('<small>%s</small> %s', 'Socio desde:', $this->Time->d($e['created'])); ?>
      </span>
    </div>
  </div>
  <div class="col-xs-4">
    <div class="clearfix">
      <?php
        echo $this->Html->image($e['logo'], array(
          'alt' => __('Logotipo de %s', $e['cia_nombre']),
          'class' => 'logo img-responsive',
          'id' => 'img-logo-' . $e['cia_cve'],
          'style' => 'float:right; width:220px;'
        ));
      ?>
    </div>
    <div class="text-right">
      <?php
        echo $this->Html->link(__('Cambiar / Subir imagen'), '#subir-logo', array(
          'class' => 'block',
          'data-toggle' => 'modal',
          'id' => 'upload-logo'
        ));
      ?>
    </div>
    <?php
      echo $this->element('empresas/subir_logo', array(
        'empresa' => $e,
        'relatedImg' => 'img-logo-' . $e['cia_cve'],
      ));
    ?>
  </div>
</div>

<?php
  echo $this->element('admin/empresas/editar_ejecutivo', array(
    'empresa' => $empresa
  ));

  echo $this->element('admin/empresas/tipo_compania', array(
    'empresa' => $empresa
  ));
?>

<?php
  echo $this->element('empresas/datos_facturacion', array(
    'empresa' => $e
  ));
?>

<?php
  echo $this->Form->create('Usuario', array(
    'class' => 'form-inline no-bordered',
    'url' => array(
      'admin' => $isAdmin,
      'controller' => 'empresas',
      'action' => 'editar',
      'id' => $e['cia_cve'],
      'slug' => Inflector::slug($e['cia_nombre'], '-')
    )
  ));
?>
  <?php
    echo $this->Form->hidden('Usuario.cu_cve', array(
      'value' => $ac['cu_cve']
    ));
  ?>
  <h5 class="subtitle">
    <?php echo __('Datos de Contacto'); ?>
  </h5>
  <fieldset class="row">
    <div class="col-xs-4">
      <?php
        echo $this->Form->input('Usuario.con_nombre', array(
          'class' => 'form-control input-sm input-block-level',
          'label' => 'Nombre:',
          'placeholder' => '',
          'value' => $ac['con_nombre']
        ));
      ?>
    </div>
    <div class="col-xs-4">
      <?php
        echo $this->Form->input('Usuario.con_paterno', array(
          'class' => 'form-control input-sm input-block-level',
          'label' => 'Apellido Paterno:',
          'placeholder' => '',
          'value' => $ac['con_paterno']
        ));
      ?>
    </div>
    <div class="col-xs-4">
      <?php
        echo $this->Form->input('Usuario.con_materno', array(
          'class' => 'form-control input-sm input-block-level',
          'label' => 'Apellido Materno:',
          'placeholder' => '',
          'value' => $ac['con_materno']
        ));
      ?>
    </div>
  </fieldset>
  <fieldset class="row">
    <div class="col-xs-6">
      <?php
        echo $this->Form->input('Usuario.con_ubicacion', array(
          'class' => 'form-control input-sm input-block-level',
          'label' => 'Ubicación:',
          'placeholder' => '',
          'value' => $ac['con_ubicacion']
        ));
      ?>
    </div>
    <div class="col-xs-4">
      <?php
        echo $this->Form->input('Usuario.con_tel', array(
          'class' => 'form-control input-sm input-block-level numeric',
          'label' => 'Teléfono:',
          'placeholder' => '',
          'value' => $ac['con_tel']
        ));
      ?>
    </div>
    <div class="col-xs-2">
      <?php
        echo $this->Form->input('Usuario.con_ext', array(
          'class' => 'form-control input-sm input-block-level numeric',
          'label' => 'Extensión:',
          'placeholder' => '',
          'type' => 'number',
          'value' => $ac['con_ext']
        ));
      ?>
    </div>
  </fieldset>
  <div class="btn-actions text-right">
    <?php
      echo $this->Html->link(__('Cambiar Correo'), array(
        'admin' => $isAdmin,
        'controller' => 'empresas',
        'action' => 'cambiar_email',
        'id' => $e['cia_cve'],
        'keycode' => $a['keycode']
      ), array(
        'class' => 'btn btn-primary btn-sm',
        'icon' => 'envelope-alt',
        'data-open-div' => 'new-email-form'
      ));

      echo $this->Html->link(__('Cambiar Contraseña'), array(
        'admin' => $isAdmin,
        'controller' => 'empresas',
        'action' => 'cambiar_contrasena',
        'id' => $e['cia_cve'],
        'keycode' => $a['keycode']
      ), array(
        'class' => 'btn btn-primary btn-sm',
        'icon' => 'key',
        'data-open-div' => 'new-pass-form'
      ));

      echo $this->Html->link(__('Aceptar'), '#', array(
        'class' => 'btn btn-success',
        'data-submit' => true
      ));
    ?>
  </div>
<?php echo $this->Form->end(); ?>

<div class="row" style="display:none;">
  <div class="col-xs-12">
    <div id="new-pass-form" class="form-hide" style="display:none;">
      <?php
        echo $this->Form->create('UsuarioEmpresa', array(
          'url' => array(
            'admin' => $isAdmin,
            'controller' => 'empresas',
            'action' => 'cambiar_contrasena',
            'id' => $e['cia_cve'],
            'keycode' => $a['keycode']
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
              echo $this->Html->link(__('Cancelar'), '#', array(
                'class' => 'btn btn-danger btn-sm',
                'data-open-div' => 'new-pass-form'
              ));
              echo $this->Html->link(__('Aceptar'), '#', array(
                'class' => 'btn btn-success btn-sm',
                'data-submit' => true,
              ));
            ?>
          </div>
      <?php echo $this->Form->end(); ?>
    </div>
    <div id="new-email-form" class="form-hide" style="display:none;">
      <?php
        echo $this->Form->create('UsuarioEmpresa', array(
          'url' => array(
            'admin' => $isAdmin,
            'controller' => 'empresas',
            'action' => 'cambiar_email',
            'id' => $e['cia_cve'],
            'keycode' => $a['keycode']
          )
        ));
      ?>
        <div class="well well-small info">
          <p>Cambiarás el email del usuario: <strong><?php echo $a['cu_sesion']; ?></strong>.</p>
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
              echo $this->Html->link(__('Cancelar'), '#', array(
                'class' => 'btn btn-danger btn-sm',
                'data-open-div' => 'new-email-form'
              ));
              echo $this->Html->link(__('Aceptar'), '#', array(
                'class' => 'btn btn-success btn-sm',
                'data-submit' => true,
              ));
            ?>
          </div>
      <?php echo $this->Form->end(); ?>
    </div>
  </div>
</div>

<?php
  $this->AssetCompress->addScript(array(
    'app/empresas/cuentas.js'
  ), 'cuentas.js');
?>
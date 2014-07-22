<?php
  $e = $empresa['Empresa'];
  $ej = $empresa['Ejecutivo'];
  $ec = $empresa['EjecutivoContacto'];

  echo $this->Form->create(false, array(
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
  <h5 class="subtitle">
    <?php echo __('Ejecutivo a cargo'); ?>
  </h5>
  <fieldset class="row">
    <div class="col-xs-12">
      <div class="btn-actions pull-right">
        <?php
          echo $this->Html->link(__('Cambiar Ejecutivo'), '#', array(
            'class' => 'btn btn-primary btn-sm',
            'icon' => 'user',
            'data-open-div' => 'change-super-form'
          ));
        ?>
      </div>
      <ul class="list-unstyled lead">
        <li>
          <?php
            $ejecutivoNombre = implode(' ', array(
              $ec['con_nombre'],
              $ec['con_paterno'],
              $ec['con_materno'],
            ));

            echo __('<small>Nombre:</small> %s', $ejecutivoNombre);
          ?>
        </li>
        <li>
          <?php echo __('<small>Correo:</small> %s', $ej['cu_sesion']); ?>
        </li>
        <li>
          <?php
            $ejecutivoTel = !empty($ec['con_tel']) ? __('%s ext. %s', $ec['con_tel'], $ec['con_ext'] ?: '-') : __('N/D');
            echo __('<small>Tel.:</small> %s', $ejecutivoTel);
          ?>
        </li>
      </ul>
    </div>
  </fieldset>
  <div class="form-hide row" id="change-super-form" style="display:none;">
    <div class="col-xs-12">
      <?php
        echo $this->Form->input('Empresa.ejecutivo_cve', array(
          'class' => 'form-control input-sm input-block-level',
          'label' => __('Seleccione a Ejecutivo:'),
          'required' => true,
          'options' => $usuarios
        ));
      ?>
      <div class="btn-actions">
        <?php
          echo $this->Html->link(__('Cancelar'), '#', array(
            'class' => 'btn btn-danger btn-sm',
            'data-open-div' => 'change-super-form'
          ));
          echo $this->Html->link(__('Aceptar'), '#', array(
            'class' => 'btn btn-success btn-sm',
            'data-submit' => true,
          ));
        ?>
      </div>
    </div>
  </div>
<?php
  echo $this->Form->end();
?>
<?php
  $e = $empresa['Empresa'];
  $ej = $empresa['Ejecutivo'];
  $ec = $empresa['EjecutivoContacto'];

?>
<div>
  <h5 class="subtitle">
    <?php echo __('Tipo de Compania'); ?>
  </h5>
  <div class="row">
    <div class="col-xs-12">
      <div class="btn-actions pull-right">
        <?php if ((int)$e['cia_tipo'] === 1): ?>
          <?php
            echo $this->Html->link(__('Hacer Comercial'), array(
              'admin' => $isAdmin,
              'controller' => 'empresas',
              'action' => 'tipo',
              'id' => $e['cia_cve'],
              'slug' => Inflector::slug($e['cia_nombre'], '-'),
              'comercial'
            ), array(
              'class' => 'btn btn-purple btn-sm',
              'icon' => 'briefcase',
              'data' => array(
                'component' => 'ajaxlink',
                'ajaxlink-confirm-html' => 'alert-tipo-compania'
              )
            ));
          ?>
          <div data-alert-before-send="alert-tipo-compania">
            <div class="alert alert-warning">
              <?php echo __('La empresa <strong>%s</strong> cambiará su tipo a comercial.', $e['cia_nombre']); ?>
            </div>
            <p>
              Esto implica que el convenio se borrará. Esta acción no se puede deshacer.
              <br>
              <strong>¿Estás de acuerdo?</strong>
            </p>
          </div>
        <?php elseif ((int)$e['cia_tipo'] === 0 && empty($empresa['Producto']['membresia_cve'])) : ?>
          <?php
            echo $this->Html->link(__('Hacer Convenio'), array(
              'admin' => $isAdmin,
              'controller' => 'empresas',
              'action' => 'tipo',
              'id' => $e['cia_cve'],
              'slug' => Inflector::slug($e['cia_nombre'], '-'),
              'convenio'
            ), array(
              'class' => 'btn btn-purple btn-sm',
              'icon' => 'briefcase',
              'data' => array(
                'component' => 'ajaxlink',
                'ajaxlink-confirm-html' => 'alert-tipo-compania'
              )
            ));
          ?>
          <div data-alert-before-send="alert-tipo-compania">
            <div class="alert alert-warning">
              <?php echo __('La empresa <strong>%s</strong> cambiará su tipo a convenio.', $e['cia_nombre']); ?>
            </div>
            <p>
              <strong>¿Estás de acuerdo?</strong>
            </p>
          </div>
        <?php else: ?>
          <?php
            $producto = $empresa['Producto']['membresia_clase'] === 'mbs' ?
              __('Membresía %s', $empresa['Producto']['membresia_nom']) :
              $empresa['Producto']['membresia_nom'];

            echo __('Producto Adquirido: <strong>%s</strong>', $producto);
          ?>
        <?php endif; ?>
      </div>
      <span class="lead">
        <small><?php echo __('%s:', 'Tipo') ?></small>
        <?php echo (int)$empresa['Empresa']['cia_tipo'] === 0 ? 'Comercial' : 'Convenio'; ?>
      </span>
    </div>
  </div>
</div>
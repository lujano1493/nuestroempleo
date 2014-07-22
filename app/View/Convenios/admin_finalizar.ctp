<?php
  $e = $empresa['Empresa'];
  $a = $empresa['Admin'];
  $ac = $empresa['AdminContacto'];
  $ej = $empresa['Ejecutivo'];
  $ec = $empresa['EjecutivoContacto'];
  echo $this->element('admin/title');
?>
<div class="alert alert-warning">
  <p>
    <strong>Atención:</strong> Usted está a punto de finalizar un <strong>CONVENIO</strong>, al hacerlo, se perderán todos
    los históricos del sistema.
  </p>
</div>
<div class="row">
  <div class="col-xs-4">
    <h5 class="subtitle">
      <?php echo __('Datos del Convenio'); ?>
    </h5>
    <div class="lead">
      <h3>
        <?php
          echo $e['cia_nombre'];
        ?>
        <small><?php echo $e['cia_razonsoc']; ?></small>
      </h3>
      <div>
        <span class="block">
          <?php echo __('<small>%s</small> %s', 'Giro:', $e['giro']); ?>
        </span>
        <span class="block">
          <?php echo __('<small>%s</small> %s', 'Socio desde:', $this->Time->d($e['created'])); ?>
        </span>
      </div>
    </div>
    <h5 class="subtitle">
      <?php echo __('Condiciones del Convenio'); ?>
    </h5>
    <ul class="list-unstyled">
      <?php
        $selectedIndexMembership = $condiciones['Convenio']['membresia_cve'];
        if (!empty($selectedIndexMembership)) {
          $membresia = $convenios_list['membresias'][$selectedIndexMembership];
          ?>
            <li>
              <h4><?php echo __('Membresía %s', $membresia); ?></h4>
            </li>
          <?php
        }

        foreach ($convenios_list['condiciones'] as $key => $value) {
      ?>
        <li>
          <strong>
            <?php if (!empty($condiciones['Condiciones'][$key])): ?>
                <i class="icon-ok text-success"></i>
            <?php else: ?>
                <i class="icon-remove text-danger"></i>
            <?php endif; ?>
          </strong>
          <span>
            <?php echo $value; ?>
          </span>
        </li>
      <?php
        }
      ?>
    </ul>
  </div>
  <div class="col-xs-8">
    <h5 class="subtitle">
      <?php echo __('Confirmación'); ?>
    </h5>
    <?php
      echo $this->Form->create(false, array(
        'type' => 'delete'
      ));
    ?>
      <div data-alert-before-send>
        <div class="alert alert-danger">
          <strong>¿Estás seguro que deseas finalizar el convenio?</strong>
        </div>
        <p>
          Ten en cuenta que esto borrará absolutamene todo el contenido de la empresa <strong><?php echo $e['cia_nombre']; ?></strong>,
          incluyendo <strong>cuentas de usuario</strong>, <strong>eventos</strong> y <strong>ofertas</strong>.
        </p>
      </div>
      <div>
        <?php
          echo $this->Form->input('Convenio.empresa_id', array(
            'value' => $e['cia_cve'],
            'type' => 'hidden'
          ));

          echo $this->Form->input('Convenio.user_keycode', array(
            'value' => $a['keycode'],
            'type' => 'hidden'
          ));

          echo $this->Form->input('Convenio.cancelacion', array(
            'label' => __('Detalle los motivos para finalizar el Convenio'),
            'class' => 'form-control input-sm',
            'type' => 'textarea'
          ));
        ?>
      </div>
      <div class="btn-actions">
        <?php
          echo $this->Html->link(__('Cancelar'), $_referer, array(
            'class' => 'btn btn-danger'
          ));

          echo $this->Html->link(__('Aceptar'), '#', array(
            'class' => 'btn btn-success',
            'data-submit' => true
          ));
        ?>
      </div>
    <?php echo $this->Form->end(); ?>
  </div>
</div>
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
    <?php
      echo $this->Html->image($e['logo'], array(
        'alt' => __('Logotipo de %s', $e['cia_nombre']),
        'class' => 'logo img-responsive',
        'id' => 'img-logo',
        'style' => 'float:right;width:220px;'
      ));
    ?>
  </div>
</div>
<?php
  echo $this->element('admin/empresas/editar_ejecutivo', array(
    'empresa' => $empresa
  ));
?>
<?php
  echo $this->Form->create('Convenio', array(
    'class' => 'no-lock'
  ));
?>
  <fieldset class="">
    <h5 class="subtitle">
      <?php
        echo __('Membresía');
        $disabled = $condiciones['Convenio']['convenio_status'] >= 2;
      ?>
    </h5>
    <?php if ($disabled): ?>
      <div class="row">
        <div class="col-xs-12">
          <div class="alert alert-info">
            <strong>Este convenio ya ha sido cerrado, no puedes cambiar la membresía.</strong>
          </div>
          <?php
            // echo $this->Form->input('membresia.desc', array(
            //   'placeholder' => __('Agrega una descripción'),
            //   'class' => 'form-control input-sm',
            //   'label' => 'Descripción',
            //   'value' => !empty($membresia['descripcion']) ? $membresia['descripcion'] : ''
            // ));
          ?>
        </div>
      </div>
    <?php endif ?>
    <div class="row">
      <div class="col-xs-4">
        <?php

          echo $this->Form->input('membresia.item', array(
            'before' => '<div class="input radio input-as-btn">',
            'separator' => '</div></div><div class="col-xs-4"><div class="input radio input-as-btn">',
            'after' => '</div>',
            'disabled' => $disabled,
            'options' => $convenios_list['membresias'],
            'hiddenField' => false,
            'div' => false,
            'label' => array(
              'class' => 'orange'
            ),
            'legend' => false,
            'type' => 'radio',
            'value' =>  $condiciones['Convenio']['membresia_cve']
          ));
        ?>
      </div>
    </div>
  </fieldset>
  <fieldset class="row">
    <div class="col-xs-12">
      <h5 class="subtitle">
        <?php echo __('Condiciones'); ?>
      </h5>
      <?php
        $_condiciones = !empty($condiciones['Condiciones']) ? $condiciones['Condiciones'] : array();
        foreach ($convenios_list['condiciones'] as $key => $value):
      ?>
        <?php
          $isSelected = !empty($_condiciones[$key]['condicion']);
        ?>
        <div class="row checkboxinput">
          <div class="col-xs-3">
            <?php
              echo $this->Form->input('Convenio.' . $key . '.item', array(
                'hiddenField' => false,
                'label' => $value,
                'type' => 'checkbox',
                'value' => $key,
                'checked' => $isSelected
              ));
            ?>
          </div>
          <div class="col-xs-9">
            <?php
              echo $this->Form->input('Convenio.' . $key . '.desc', array(
                'placeholder' => __('Agrega una nota'),
                'class' => 'form-control input-sm',
                'label' => false,
                'disabled' => !$isSelected ? 'disabled' : '',
                'value' => $isSelected ? $_condiciones[$key]['descripcion'] : '',
                'required' => true,
              ));
            ?>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </fieldset>
  <div class="btn-actions">
    <?php
      echo $this->Html->link(__('Aceptar'), '#', array(
        'class' => 'btn btn-success',
        'data' => array(
          'submit' => 1
        )
      ));
    ?>
  </div>
<?php echo $this->Form->end(); ?>
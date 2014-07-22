<?php
  echo $this->element('admin/title');
?>
<?php
  echo $this->Form->create('Membresia', array(
    'class' => 'form-inline'
  ));
?>
  <fieldset>
    <?php echo $this->Form->hidden('Membresia.membresia_cve'); ?>
    <div class="row">
      <div class="col-xs-9">
        <?php
          echo $this->Form->input('Membresia.membresia_nom', array(
            'class' => 'form-control input-sm',
            'label' => __('Nombre'),
            'placeholder' => __('Nombre de la membresía')
          ));
        ?>
      </div>
      <div class="col-xs-3">
        <?php
          echo $this->Form->input('Membresia.vigencia', array(
            'class' => 'form-control input-sm',
            'icon' => 'time',
            'options' => $duracion,
            'placeholder' => __('Días'),
          ));
        ?>
      </div>
    </div>
  </fieldset>
  <fieldset>
    <legend>Detalles</legend>
    <div class="row">
      <div class="col-xs-12">
        <?php
          echo $this->Form->input('Membresia.membresia_desc', array(
            'class' => 'form-control input-sm input-block-level',
            'data-component' => 'wysihtml5-editor',
            // 'placeholder' => __('Agregue una descripción de la Membresía.'),
            'style' => 'height: 250px;',
            'type' => 'textarea',
            'label' => false
          ));
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <?php
          echo $this->Form->input('Membresia.detalles', array(
            'class' => 'form-control input-sm',
            'data' => array(
              'source-url' => '/admin/info/servicios.json',
              'display-field' => 'servicio_nom',
              'value-field' => 'servicio_cve'
            ),
            'id' => 'membresiaDetalles',
            'label' => __('Servicios'),
            'placeholder' => __('Ej: Publicaciones Destacadas'),
          ));
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6">
        <?php
          echo $this->Form->input('Membresia.membresia_clase', array(
            'class' => 'form-control input-sm',
            'label' => __('Agrupar en'),
            'options' => $clases
          ));
        ?>
      </div>
      <div class="col-xs-6">
        <?php
          echo $this->Form->input('Membresia.costo', array(
            'class' => 'form-control input-sm',
            'icon' => 'money',
            'placeholder' => __('Costo'),
            'readonly' => true
          ));
        ?>
      </div>
    </div>
  </fieldset>
  <fiedlset>
    <div class="row">
      <div class="col-xs-12">
        <?php
          echo $this->Form->submit(__('Aceptar'), array(
            'class' => 'btn btn-primary btn-lg',
            'div' => false,
            'data' => array(
              'submit' => true,
              'value' => 'membresia'
            )
          ));
        ?>
      </div>
    </div>
  </fiedlset>
<?php
  echo $this->Form->end();
?>
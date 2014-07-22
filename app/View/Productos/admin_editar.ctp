<?php
  echo $this->element('admin/title');
?>

<div class="row">
  <div class="col-xs-12">
    <?php
      echo $this->Form->create('Membresia', array(
        'class' => 'form-inline no-lock'
      ));
    ?>
      <fieldset>
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
                'options' => $catalogos['duracion'],
                'placeholder' => __('Días'),
                'label' => __('Vigencia'),
              ));
            ?>
          </div>
        </div>
      </fieldset>
      <fieldset>
        <legend class="subtitle">
          Detalles
        </legend>
        <div class="row">
          <div class="col-xs-12">
            <?php
              echo $this->Form->input('Membresia.membresia_desc', array(
                'class' => 'form-control input-sm input-block-level',
                'data-component' => 'wysihtml5-editor',
                'placeholder' => __('Agregue una descripción de la Membresía.'),
                'style' => 'height: 150px;',
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
                'required' => true
              ));

              if (!empty($this->request->data['Membresia']['Detalles'])) {
                foreach ($this->request->data['Membresia']['Detalles'] as $key => $value) {
                  $_v = $value['Servicio']['servicio_cve'];
                  echo $this->Form->input('Membresia.Detalles.' . $_v . '.servicio', array(
                    'value' => $value['Detalle']['credito_num'],
                    'type' => 'hidden'
                  ));
                }
              }
            ?>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <?php
              echo $this->Form->input('Membresia.membresia_clase', array(
                'class' => 'form-control input-sm',
                'label' => __('Agrupar en'),
                'options' => $catalogos['clases']
              ));
            ?>
          </div>
          <div class="col-xs-6">
            <?php
              echo $this->Form->input('Membresia.membresia_status', array(
                'class' => 'form-control input-sm',
                'label' => __('Status de la membresía'),
                'options' => array(
                  'Oculta', 'Pública'
                )
              ));
            ?>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-md-offset-6">
            <?php
              echo $this->Form->input('Membresia.costo', array(
                'class' => 'form-control input-sm',
                'label' => 'Costo',
                'min' => 0,
                'required' => true
              ));
            ?>
          </div>
        </div>
      </fieldset>
      <div class="btn-actions">
        <?php
          echo $this->Html->link(__('Aceptar'), '#', array(
            'class' => 'btn btn-success',
            'data' => array(
              'submit' => true,
              'value' => 'membresia'
            ),
          ));
        ?>
      </div>
    <?php
      echo $this->Form->end();
    ?>
  </div>
</div>
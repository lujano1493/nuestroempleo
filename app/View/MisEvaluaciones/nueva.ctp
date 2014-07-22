<?php
  echo $this->element('empresas/title');
?>

<div class="text-left btn-actions">
  <?php
    echo $this->Html->link('Mis Evaluaciones', array(
      'controller' => 'mis_evaluaciones',
      'action' => 'index'
    ), array(
      'class' => 'btn btn-sm btn-blue',
      'icon' => 'pencil'
    ));

    echo $this->Html->link('Asignar Evaluación', array(
      'controller' => 'mis_evaluaciones',
      'action' => 'asignar'
    ), array(
      'class' => 'btn btn-sm btn-success',
      'icon' => 'pencil'
    ));
  ?>
</div>
<?php
  echo $this->Form->create('Evaluacion', array(
    'class' => 'form-inline no-bordered no-q-time no-t-time',
    'data-opts' => '{"ignore":":hidden:not(.validate)"}',
    'id' => 'evaluacion'
  ));
?>
  <fieldsset>
    <legend class="subtitle">
      <i class="icon-time"></i><?php echo __('Tiempo para Responder la Evaluación'); ?>
    </legend>
    <div class="row">
      <div class="col-xs-6 col-md-offset-3 text-center" data-eval-option="time">
        <?php
          echo $this->Form->input('Evaluacion.tipo_tiempo', array(
            'before' => '<div class="input radio input-as-btn">',
            'separator' => '</div><div class="input radio input-as-btn">',
            'after' => '</div>',
            'options' => array(
              'n' => 'No', 'e' => 'Por Examen', 'p' => 'Por Pregunta'
            ),
            'default' => 'n',
            'hiddenField' => false,
            'div' => false,
            'label' => array(
              'class' => 'orange'
            ),
            'legend' => false,
            'type' => 'radio'
          ));
          echo $this->Form->input('Evaluacion.evaluacion_time', array(
            'class' => 'form-control input-sm inline xs',
            'data' => array(
              'rule-required' => true,
              'msg-required' => __('Ingresa el tiempo del examen.'),
            ),
            'div' => 'test-time text-center',
            'label' => __('Tiempo del Examen'),
            'min' => 1,
            'type' => 'number',
            'value' => 1
          ));
        ?>
      </div>
    </div>
  </fieldsset>
  <fieldset>
    <legend class="subtitle">
      <i class="icon-edit-sign"></i><?php echo __('Datos Generales'); ?>
    </legend>
    <div class="row">
      <!-- <div class="col-xs-3" data-eval-option="type" id='evaluacion-tipo'>
        <?php
          echo $this->Form->input('Evaluacion.tipoeva_cve', array(
            'div' => false,
            'legend' => false,
            'before' => '<label>Tipo de Evaluación</label><div class="input radio">',
            'after' => '</div>',
            'separator' => '</div><div class="input radio">',
            'hiddenField' => false,
            'options' => array(
              'd' => 'Desempeño', 'c' => 'Conocimientos'
            ),
            'type' => 'radio',
            'default' => 'd'
          ));
        ?>
      </div> -->
      <div class="col-xs-12">
        <?php
          echo $this->Form->input('Evaluacion.evaluacion_nom', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => __('Nombre del Examen'),
            'data-target-name' => 'evaluacion-title:keyup',
          ));
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <?php
          echo $this->Form->input('Evaluacion.evaluacion_descrip', array(
            'class' => 'form-control input-sm input-block-level',
            'data-target-name' => 'evaluacion-desc:keyup',
            'label' => __('Descripción de la Evaluación'),
            'type' => 'textarea',
            'rows' => 3
          ));
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <?php
          echo $this->Form->input('Evaluacion.evaluacion_indicacion', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => __('Instrucciones Generales'),
            'type' => 'textarea',
            'rows' => 3
          ));
        ?>
      </div>
    </div>
  </fieldsset>
  <fieldset>
    <legend class="subtitle">
      <i class="icon-question"></i><?php echo __('Preguntas y Respuestas'); ?>
    </legend>
    <div class="btn-actions">
      <?php
        echo $this->Html->link(__('Agregar Pregunta'), '#', array(
          'class' => 'btn btn-orange',
          'data-action-role' => 'new-question'
        ));
      ?>
    </div>
    <div class="panel-group" id="evaluacion-preguntas" data-role='questions-section'></div>
  </fieldset>
  <div class="btn-actions">
    <div class="btn-group">
      <?php
        echo $this->Form->submit(__('Guardar Evaluación'), array(
          'class' => 'btn btn-success',
          'data' => array(
            'submit' => true,
            'submit-value' => 'publicada',
          ),
          'div' => false
        ));
      ?>
      <button class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
        <li>
          <?php
            echo $this->Html->link(__('Guardar como Borrador'), '#', array(
              'data' => array(
                'submit' => true,
                'submit-value' => 'borrador',
              ),
              'icon' => 'eraser'
            ));
          ?>
        </li>
      </ul>
    </div>
    <?php
      echo $this->Html->link(__('Vista Previa'), '', array(
        'data' => array(
          'target' => '#evaluacion-preview',
          'toggle' => 'slidemodal',
        ),
        'class' => 'btn btn-aqua'
      ));
      echo $this->Html->link(__('Cancelar'), $_referer, array(
        'class' => 'btn btn-danger'
      ));
    ?>
  </div>
  <?php echo $this->element('empresas/vista_previa/evaluacion'); ?>
<?php echo $this->Form->end(); ?>

<?php
  echo $this->Template->insert(array(
    'pregunta',
    'pregunta-preview',
    'respuesta',
    'respuesta-preview',
  ));

  $this->AssetCompress->script('evaluacion.js', array(
    'inline' => false
  ));
?>
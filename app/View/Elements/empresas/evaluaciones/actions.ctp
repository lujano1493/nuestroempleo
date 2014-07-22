<?php

  /**
   * Para obtener los boton que se van a mostrar.
   * @var [type]
   */
  $__btns = isset($actions) && !isset($actions['exclude']) ? $actions : array_diff(array(
    'submit', 'preview', 'cancel', 'download', 'delete'
  ), isset($actions['exclude']) ? $actions['exclude'] : array());

?>

<div class="btn-actions">
  <?php if (in_array('submit', $__btns)) { ?>
    <div class="btn-group">
      <?php
        echo $this->Form->submit(__('Guardar Evaluación'), array(
          'class' => 'btn btn-sm btn-success',
          'data-submit' => true,
          'data-submit-value' => 'publicada',
          'div' => false
        ));
      ?>
      <button class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
        <li>
          <?php
            echo $this->Html->link(__('Guardar como Borrador'), '#', array(
              'data-submit' => true,
              'data-submit-value' => 'borrador',
              'icon' => 'eraser'
            ));
          ?>
        </li>
      </ul>
    </div>
  <?php } ?>
  <?php
    if (in_array('edit', $__btns)) {
      echo $this->Html->link(__('Editar'), array(
        'controller'=>'mis_evaluaciones',
        'action'=> 'editar',
        'id' => !empty($evaluacion) ? $evaluacion['evaluacion_cve'] : null,
        //'slug' => Inflector::slug($evaluacion['evaluacion_nom'], '-')
      ), array(
        'class' => 'btn btn-orange btn-sm',
        //'disabled' => empty($evaluacion) || $this->params['action'] === 'editar',
        'icon' => 'edit'
      ));
    }

    if (in_array('download', $__btns) && !empty($candidato)) {
      echo $this->Html->link(__('Descargar PDF'), array(
        'controller'=>'mis_evaluaciones',
        'action'=> 'resultados',
        'id' => !empty($evaluacion) ? $evaluacion['evaluacion_cve'] : null,
        'slug' => Inflector::slug($evaluacion['evaluacion_nom'], '-'),
        'itemId' => $candidato['candidato_cve'],
        'itemSlug' => Inflector::slug($candidato['nombre_'] . '-' . $evaluacion['evaluacion_nom'], '-'),
        'ext' => 'pdf'
      ), array(
        'class' => 'btn btn-purple btn-sm',
        //'disabled' => empty($evaluacion) || $this->params['action'] === 'editar',
        'icon' => 'download',
        'target' => '_blank'
      ));
    }

    if (in_array('delete', $__btns)) {
      echo $this->Html->link(__('Eliminar'), '#', array(
        'class' => 'btn btn-danger btn-sm',
        'disabled' => empty($evaluacion),
        'icon' => 'edit'
      ));
    }

    if (isset($backButton)) {
      echo $this->Html->link(__('Regresar'), $backButton, array(
        'data-close' => true,
        'class' => 'btn btn-default btn-sm',
        'icon' => 'arrow-left',
      ));
    }
  ?>
</div>
<?php
  $oferta = empty($this->request->data['Oferta']) ? null : $this->request->data['Oferta'];

  $canEdit = isset($canEdit) ? $canEdit : true;

  /**
   * Para obtener los boton que se van a mostrar.
   * @var [type]
   */
  $__btns = isset($actions) && !isset($actions['exclude']) ? $actions : array_diff(array(
    'submit', 'preview', 'cancel', 'share', 'save', 'delete', 'pause', 'publish'
  ), isset($actions['exclude']) ? $actions['exclude'] : array());

  /**
   * Botones deshabilitados.
   * @var [type]
   */
  $__disabledBtns = isset($actions['disabled']) ? $actions['disabled'] : array();

  /**
   * El tamaño de los botones.
   * @var [type]
   */
  $__btnSize = isset($options['btn-size']) ? 'btn-' . $options['btn-size'] : '';

  $__btnDropup = !empty($options['dropup']) ? 'dropup' : '';

  /**
   * Acciones para guardar.
   * @var array
   */
  $__submitActions = array(
    array(
      //'borrador' => array(
        'text' => __('Guardar Borrador'),
        'icon' => 'draft',
        'submit' => 'borrador'
      //)
    ),
    array(
      //'publicada' => array(
        'text' => __('Publicar'),
        'icon' => 'ok',
        'submit' => 'publicada'
      //)
    ),
    array(
      //'publicada' => array(
        'text' => __('Recomendar'),
        'icon' => 'star',
        'submit' => 'recomendada'
      //)
    ),
    array(
      //'publicada' => array(
        'text' => __('Distinguir'),
        'icon' => 'thumbs-up',
        'submit' => 'distinguida'
      //)
    )
  );
?>

<div class="btn-actions">
  <?php if (in_array('submit', $__btns)) { ?>
    <div class="btn-group <?php echo $__btnDropup; ?>">
      <?php
        /*
          Obtiene el $status de la oferta.
         */
        $status = !empty($status) ? $status : 0;

        /**
         * Se utiliza para reemplazar el texto en caso de que se pueda editar.
         * @var boolean
         */
        $defaultText = false;

        /**
         * Si la oferta no es editable, se establece el status + 1 para establecer como primer botón al
         * botón siguiente a su status actual, debido a que si la oferta no se puede editar sólo puede cambiar su status.
         * En caso contrario, de que la oferta es editable, se sustituye el texto del primer botón.
         */
        if (!$canEdit && $status + 1 < count($__submitActions)) {
          $status += 1;
        } else {
          $defaultText = __('Guardar');
        }

        /**
         * Obtiene las acciones a partir del status actual de la oferta.
         * @var array
         */
        $usedActions = array_slice($__submitActions, $status);

         // Si se puede editar => habilitado
        $disabled = $canEdit ? false
          // Una acción (distinguida) y no editar => habilitado (para distinguir solamente)
          : (count($usedActions) == 1 && $defaultText == false ? false
            // Menos de una acción y no se puede editar => deshabilitado (oferta distinguida y no se puede editar)
            : (count($usedActions) <= 1 && !$canEdit ? true
              // En base a las acciones utilizadas.
              : empty($usedActions)));

        /**
         * Se obtiene como botón principal para guardar al primero de las acciones.
         * @var array
         */
        $firstAction = array_shift($usedActions);

        // echo $this->Form->submit($defaultText ?: $firstAction['text'], array(
        //   'data' => array(
        //     'submit' => true,
        //     'submit-value' => $firstAction['submit']
        //   ),
        //   'disabled' => $disabled,
        //   'class' => 'btn btn-success ' . $__btnSize,
        //   'div' => false,
        //   // 'name' => 'draft-submit'
        // ));

        // echo $this->Form->button('', array(
        //   'class' => 'dropdown-toggle btn btn-success ' . $__btnSize,
        //   'data' => array(
        //     'toggle' => 'dropdown'
        //   ),
        //   'disabled' => empty($usedActions),
        //   'type' => 'caret'
        // ));

        echo $this->Html->link($defaultText ?: $firstAction['text'], '#', array(
          'data' => array(
            'submit' => true,
            'submit-value' => $firstAction['submit']
          ),
          'disabled' => $disabled,
          'class' => 'btn btn-success ' . $__btnSize,
          // 'div' => false,
          // 'name' => 'draft-submit'
        ));

        echo $this->Form->button('', array(
          'class' => 'dropdown-toggle btn btn-success ' . $__btnSize,
          'data' => array(
            'toggle' => 'dropdown'
          ),
          'disabled' => empty($usedActions),
          'type' => 'caret'
        ));
      ?>
        <ul class="dropdown-menu pull-right">
          <?php foreach ($usedActions as $val): ?>
            <li>
              <?php
                echo $this->Html->link($val['text'], '#', array(
                  'data' => array(
                    'submit' => true,
                    'submit-value' => $val['submit']
                  ),
                  'icon' => $val['icon']
                ));
              ?>
            </li>
          <?php endforeach ?>
        </ul>
    </div>
  <?php } ?>
  <?php
    if (in_array('preview', $__btns)) {
      echo $this->Html->link(__('Vista Previa'), '', array(
        'class' => 'btn btn-aqua ' . $__btnSize,
        'data' => array(
          'target' => '#oferta-preview',
          'toggle' => 'slidemodal',
        ),
      ));
    }

    if (in_array('edit', $__btns)) {
      $disabled = in_array('edit', $__disabledBtns);

      echo $this->Html->link('Editar', '#', array(
        'class' => 'btn btn-orange ' . $__btnSize,
        'disabled' => $disabled,
        'icon' => 'edit'
      ));
    }

    if (in_array('publish', $__btns)) {
      $disabled = in_array('publish', $__disabledBtns);
      $url = $disabled ? '#' : array(
        'controller' => 'mis_ofertas',
        'action' => 'duplicar',
        'id' => $oferta['oferta_cve'],
        'slug' => Inflector::slug($oferta['puesto_nom'], '-'),
      );
      // http://nuestroempl.eo/mis_ofertas/Disenador-Web-5054/duplicar
      echo $this->Html->link('Republicar', $url, array(
        'class' => 'btn btn-purple ' . $__btnSize,
        'disabled' => $disabled,
        'icon' => 'copy'
      ));
    }

    if (in_array('share', $__btns)) {
      $disabled = in_array('share', $__disabledBtns);
      $url = $disabled ? '#' : array(
        'controller' => 'mis_ofertas',
        'action' => 'compartir',
        'id' => $oferta['oferta_cve'],
        'slug' => Inflector::slug($oferta['puesto_nom'], '-'),
      );

      // http://nuestroempl.eo/mis_ofertas/Disenador-Web-5054/compartir
      echo $this->Html->link('Compartir', $url, array(
        'data-component' => 'ajaxlink',
        'class' => 'btn btn-aqua ' . $__btnSize,
        'disabled' => $disabled,
        'icon' => 'share-sign'
      ));
    }

    if (in_array('save', $__btns)) { ?>
      <div class="folders-btn inline">
        <?php
          echo $this->Html->link('Guardar en', '#', array(
          'data' => $disabled ? array() : array(
            'component' => 'folderito',
            'source' => '/carpetas/ofertas.json',
            'id' => $oferta['oferta_cve'],
            'controller' => 'mis_ofertas',
          ),
          'class' => 'btn btn-default ' . $__btnSize,
          'disabled' => in_array('save', $__disabledBtns),
          'icon' => 'folder-open'
        ));
        ?>
      </div>
      <?php
    }

    if (in_array('pause', $__btns)) {
      $disabled = in_array('pause', $__disabledBtns);
      $url = $disabled ? '#' : array(
        'controller' => 'mis_ofertas',
        'action' => 'pausar',
        'id' => $oferta['oferta_cve'],
        'slug' => Inflector::slug($oferta['puesto_nom'], '-'),
      );
      // http://nuestroempl.eo/mis_ofertas/Disenador-Web-5054/pausar
      echo $this->Html->link('Pausar', $url, array(
        'data-component' => 'ajaxlink',
        'class' => 'btn btn-default ' . $__btnSize,
        'disabled' => $disabled,
        'icon' => 'pause'
      ));
    }

    if (in_array('delete', $__btns)) {
      $disabled = in_array('delete', $__disabledBtns);
      $url = $disabled ? '#' : array(
        'controller' => 'mis_ofertas',
        'action' => 'eliminar',
        'id' => $oferta['oferta_cve'],
        'slug' => Inflector::slug($oferta['puesto_nom'], '-'),
      );

      // http://nuestroempl.eo/mis_ofertas/Disenador-Web-5054/eliminar
      echo $this->Html->link('Eliminar', $url, array(
        'data-component' => 'ajaxlink',
        'class' => 'btn btn-danger ' . $__btnSize,
        'disabled' => $disabled,
        'icon' => 'trash'
      ));
    }

    if (in_array('cancel', $__btns)) {
      echo $this->Html->link(__('Cancelar'), $_referer, array(
        'class' => 'btn btn-default ' . $__btnSize
      ));
    }
  ?>
</div>

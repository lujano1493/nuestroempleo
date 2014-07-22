<ul id="ntfy-menu" class="nav navbar-nav ntfy-inverted">
  <li class="dropdown" data-ntfy-type="notificacion">
    <?php
      $totalKey = !empty($notificaciones['totales']) ? $notificaciones['totales']['notificacion_total'] : 0;
      $total = !empty($notificaciones['totales']) ? $notificaciones['totales']['notificacion'] : 0;
      echo $this->Html->link('', '#', array(
        'class' => 'link-icon ',
        'icon' => 'bell',
        'data-toggle' => 'dropdown',
        'tags' => array(
          'span', $total, array(
            'class' => 'ntfy-total ' . ($total > 0 ? 'new-ntfys' : '')
          )
        )
      ));
    ?>
    <div class="dropdown-menu arrow">
      <ul class="">
        <?php if ($total > 0): ?>
          <?php foreach ($notificaciones['results'] as $value): ?>
            <li>
              <?php
                // $template = $format[$value['Notificacion']['tipo']]['template'];
                echo $this->element('empresas/notificaciones/notificacion', array(
                  'data' => $value
                ));
              ?>
            </li>
          <?php endforeach ?>
        <?php else: ?>
          <li>
            <?php echo __('No hay nuevas notificaciones.'); ?>
          </li>
        <?php endif ?>
      </ul>
      <div class="btn-actions">
        <?php
          echo $this->Html->link(__('Cargar más', $totalKey), array(
            'controller' => 'notificaciones',
            'action' => 'index'
          ), array(
            'data' => array(
              'ntfy-load' => true,
              'ntfy-offset' => $total <= 10 ? $total : 10,
            ),
            'class' => 'btn btn-xs btn-default'
          ));
          echo $this->Html->link(__('Ver todas (%s)', $totalKey), array(
            'controller' => 'notificaciones',
            'action' => 'index'
          ), array(
            'class' => 'btn btn-xs btn-default'
          ));
        ?>
      </div>
    </div>
  </li>
</ul>

<?php
  // echo $this->Template->insert(array(
  //   'notificacion',
  //   'mensaje',
  //   'evaluacion'
  // ), null, array(
  //   'folder' => 'empresas',
  //   'viewPath' => 'Notificaciones'
  // ));
?>
<?php
  $view_ntfy = array(
    'mensaje' => array(
      'titulo' => 'Mensajes',
      'icono' => 'envelope',
      'element' => array(
        'path' => 'candidatos/notificacion/mensaje'
      )
    ),
    'evento' => array(
      'titulo' => 'Eventos',
      'icono' => 'calendar',
      'element'    => array(
        'path' =>'candidatos/notificacion/evento'
      )
    ),
    'notificacion' => array(
      'titulo' => 'Notificaciones',
      'icono' => 'bell',
      'element'    => array(
        'path' =>'candidatos/notificacion/notificacion'
      )
    )
  );
?>

<div id="ntfy-menu">
  <?php foreach ($view_ntfy as $key => $value): ?>
    <?php if (array_key_exists($key, $notificaciones)): ?>
      <?php
        $titulo = $value['titulo'];
        $icon = $value['icono'];
        $element = $value['element']['path'];
        $totalKey = !empty($notificaciones['totales']) ? $notificaciones['totales'][$key . '_total'] : 0;
        $total = !empty($notificaciones['totales']) ? $notificaciones['totales'][$key] : 0;
      ?>
      <div class="btn-group" data-ntfy-type="<?php echo $key; ?>">
        <button title="<?php echo $titulo; ?>"  data-component="tooltip" data-placement="bottom"  class="btn_color btn-small strong dropdown-toggle" data-toggle="dropdown">
          <i class="icon-<?php echo $icon; ?>"></i>
          <!-- <span class="ntfy-total"><?= $total ?></span> -->
          <?php
            echo $this->Html->tag('span', $total, array(
              'class' => 'ntfy-total ' . ($total > 0 ? 'new-ntfys' : '')
            ));
          ?>
        </button>
        <div class="dropdown-menu arrow">
          <ul class="">
            <?php if ($total > 0): ?>
              <?php foreach ($notificaciones[$key] as $n): ?>
                <li>
                  <?php
                    echo $this->element('candidatos/notificacion/notificacion', array(
                      'data' => $n
                    ));
                  ?>
                </li>
              <?php endforeach ?>
            <?php else: ?>
              <li class="delete ntfy">
                <div class="ntfy-body">
                  <?php echo __('No hay nuevas notificaciones.'); ?>
                </div>
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
                  'ntfy-load' => $key,
                  'ntfy-offset' => $total <= 10 ? $total : 10,
                ),
                'class' => ''
              ));
              echo '&nbsp;&nbsp;&nbsp;&nbsp;';
              echo $this->Html->link(__('Ver todas'), array(
                'controller' => 'notificaciones',
                'action' => 'index',
                "?" =>  "type=$key"
              ), array(
                'class' => ''
              ));
            ?>
          </div>
        </div>
      </div>
    <?php endif ?>
  <?php endforeach ?>
</div>

<?php
  echo $this->Template->insert(array(
    'mensaje',
    'evento',
    'notificacion'
  ), null, array(
    'folder' => 'candidatos',
    'viewPath' => 'Notificaciones'
  ));
?>
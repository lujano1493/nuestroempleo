<?php
  echo $this->element('empresas/title');
?>

<div class="alert alert-info">
  En esta secci&oacute;n podr&aacute; administrar diferentes Eventos como: Ferias de Empleo, Masivos de Reclutamiento,
  Capacitaciones, etc., los cuales, ser&aacute;n visualizados por los Candidatos para lograr mayor afluencia de personas.
</div>

<div class="pull-right btn-actions">
  <?php
    echo $this->Html->link(__('Publicar un Evento'), array(
      'controller' => 'mis_eventos',
      'action' => 'publicar'
    ), array(
      'class' => 'btn btn-lg btn-orange',
      'icon' => 'edit'
    ));

    echo $this->Html->link(__('Todos los Eventos'), array(
      'controller' => 'mis_eventos',
      'action' => 'todos'
    ), array(
      'class' => 'btn btn-lg btn-blue',
      'icon' => 'calendar'
    ));
  ?>
</div>
<p>&nbsp;</p>
<div class="last-events">
  <h5 class="subtitle">
    <i class="icon-tasks"></i><?php echo __('Últimos eventos publicados'); ?>
  </h5>
  <?php
    // Separa los eventos para mostrarlos de 3 en 3.
    $chunks = array_chunk($eventos, 3);
    foreach ($chunks as $k => $chunkEvents):
  ?>
    <div class="row">
      <?php foreach ($chunkEvents as $k => $v): ?>
        <div class="col-xs-4">
          <div class="panel panel-blue">
            <div class="panel-heading">
              <h5>
                <?php echo $v['Evento']['tipo_nombre'] ?>
              </h5>
            </div>
            <div class="panel-body">
              <div>
                <h5>
                  <i class="icon-map-marker icon-2x"></i><?php echo __('Ubicación del Evento'); ?>
                </h5>
                <span>
                  <?php echo $v['Evento']['evento_dir']; ?>
                </span>
              </div>
              <div>
                <h5>
                  <i class="icon-time icon-2x"></i><?php echo __('Duración del Evento'); ?>
                </h5>
                <span class="block"><?php echo __('Inicia: %s', $this->Time->d($v['Evento']['evento_fecini'])); ?></span>
                <span class="block"><?php echo __('Termina: %s', $this->Time->d($v['Evento']['evento_fecfin'])); ?></span>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  <?php
    endforeach;
  ?>
</div>
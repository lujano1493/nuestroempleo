<div class="fast-resume">
  <h5 class="subtitle">
    <i class="icon-tasks"></i>Resumen rápido
  </h5>
  <div class="row">
    <div class="col-xs-4 resume">
      <i class="icon-file-text"></i>
      <?php
        echo $this->Html->link('Mis Ofertas Activas', array(
          'controller' => 'mis_ofertas',
          'action' => 'activas'
        ));
      ?>
      <ul>
        <?php foreach ($stats['ofertas'] as $key => $value): ?>
          <li>
            <span class="stat-label"><?php echo $key; ?></span>
            <span class="cant"><?php echo $value; ?></span>
          </li>
        <?php endforeach ?>
      </ul>
    </div>
    <div class="col-xs-4 resume">
      <i class="icon-ok"></i>
      <?php
        echo $this->Html->link('Mis Ofertas Disponibles', array(
          'controller' => 'mis_ofertas',
          'action' => 'activas'
        ));
      ?>
      <ul>
        <?php
          foreach ($stats['creditos'] as $key => $value):
            $disponibles = (bool)$value['creditos_infinitos'] ? '&infin;' : (int)$value['disponibles']
        ?>
          <li>
            <span class="stat-label"><?php echo $value['nombre']; ?></span>
            <span class="cant"><?php echo $disponibles; ?></span>
          </li>
        <?php endforeach ?>
      </ul>
    </div>
    <div class="col-xs-4">
      <?php echo $this->element('empresas/ofertas/main-tasks'); ?>
    </div>
  </div>
</div>
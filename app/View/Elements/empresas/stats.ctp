<div class="fast-resume">
  <h5 class="subtitle">
    <i class="icon-tasks"></i><?php echo __('Resumen rápido'); ?>
  </h5>
  <div class="row">
    <div class="col-xs-3 resume">
      <i class="icon-file-text"></i>
      <?php echo $this->Html->link(__('Mis Ofertas'), array(
        'controller' => 'mis_ofertas',
        'action' => 'index'
      )); ?>
      <ul>
        <?php foreach ($stats['ofertas'] as $key => $value): ?>
          <li>
            <span class="stat-label"><?php echo $key; ?></span>
            <span class="cant"><?php echo $value; ?></span>
          </li>
        <?php endforeach ?>
      </ul>
    </div>
    <div class="col-xs-3 resume">
      <i class="icon-group"></i>
      <?php echo $this->Html->link(__('Mis Candidatos'), array(
        'controller' => 'mis_candidatos',
        'action' => 'index'
      )); ?>
      <ul>
        <?php foreach ($stats['candidatos'] as $key => $value): ?>
          <li>
            <span class="stat-label"><?php echo $key; ?></span>
            <span class="cant"><?php echo $value; ?></span>
          </li>
        <?php endforeach ?>
      </ul>
    </div>
    <div class="col-xs-3 resume">
      <i class="icon-shopping-cart"></i>
      <?php echo $this->Html->link(__('Mis Productos'), array(
        'controller' => 'mis_productos',
        'action' => 'index'
      )); ?>
      <ul>
        <?php foreach ($stats['productos'] as $key => $value): ?>
          <li>
            <span class="stat-label"><?php echo $key; ?></span>
            <span class="cant"><?php echo $value; ?></span>
          </li>
        <?php endforeach ?>
      </ul>
    </div>
    <div class="col-xs-3">
      <?php echo $this->element('empresas/main-tasks'); ?>
    </div>
  </div>
</div>
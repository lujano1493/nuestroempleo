<?php
  echo $this->element('empresas/title');
?>

<?php //debug($facturas); ?>

<div class="row">
  <h5 class="subtitle">
    <i class="icon-shopping-cart"></i><?php echo __('Mis Productos adquiridos'); ?>
  </h5>
  <div class="row">
    <div class="col-xs-12">
      <div class="items-container">
        <div id="historico-details" class="items sliding" data-navi-class="pagination main-pagination clearfix" data-navi-order="before" data-navi-template="#tmpl-menu-item"></div>
      </div>
    </div>
  </div>
</div>

<?php
  echo $this->Template->insert(array(
    'menu-item',
    'panel-detalles'
  ));
?>
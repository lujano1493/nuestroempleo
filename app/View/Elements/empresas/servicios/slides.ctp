<?php
  echo $this->element('empresas/servicios/botones-index');
?>
<div class="slidemodal" id="nuestros-servicios" data-slides="1" data-slide-from="top" data-slide-to="bottom">
  <div class="slidemodal-dialog">
    <div class="slidemodal-content" style="height:100%;padding-bottom:120px;">
      <div class="slidemodal-header">
        <button type="button" class="close" data-dismiss="modal" data-close="slidemodal" aria-hidden="true">×</button>
        <h4 class="slidemodal-title text-left"><?php echo __('Conoce nuestros Productos.'); ?></h4>
      </div>
      <div class="slidemodal-body no-scroll">
        <div style="height:100%;overflow-y:scroll;">
          <div class="sliding" data-navi-class="#servicios-slides-btns">
            <div class="slide" data-legend="Publicación de Vacantes">
              <?php echo $this->element('empresas/servicios/desc/publicaciones'); ?>
            </div>
            <div class="slide" data-legend="Búsqueda y liberación de CVs">
              <?php echo $this->element('empresas/servicios/desc/liberacion-cvs'); ?>
            </div>
            <div class="slide" data-legend="Membresía Silver">
              <?php echo $this->element('empresas/servicios/desc/silver'); ?>
            </div>
            <div class="slide" data-legend="Membresía Golden">
              <?php echo $this->element('empresas/servicios/desc/golden'); ?>
            </div>
            <div class="slide" data-legend="Membresía Diamond">
              <?php echo $this->element('empresas/servicios/desc/diamond'); ?>
            </div>
            <div class="slide" data-legend="Publicidad">
              <?php echo $this->element('empresas/servicios/desc/publicidad'); ?>
            </div>
          </div>
        </div>
      </div>
      <div class="slidemodal-footer">
        <?php echo $this->element('empresas/servicios/botones-slides'); ?>
        <div class="btn-actions">
          <?php
            echo $this->Html->link(__('Adquiere nuestros Productos'), array(
              'controller' => 'mis_productos',
              'action' => 'catalogo'
            ), array(
              'class' => 'btn btn-lg btn-primary',
              'icon' => 'shopping-cart'
            ));
          ?>
        </div>
        <p class="text-right">
          <small>*Precios más IVA, Moneda Nacional, sujetos a cambios sin previo aviso.</small>
          <?php
            echo $this->Html->link(__('Cerrar'), '#', array(
              'class' => 'btn btn-sm btn-default',
              'data-close' => 'slidemodal',
              // 'icon' => 'remove-circle'
            ));
          ?>
        </p>
      </div>
    </div>
  </div>
</div>
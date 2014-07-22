<?php $id = 'promo-' . time(); ?>
<div id="<?php echo $id; ?>" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4><?php echo __('Tenemos una promoción para ti.'); ?></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-10 col-md-offset-1">
            <div class="lead text-center">
              ¡Adquiere nuestra Membresía Promocional y publica todas tus ofertas hoy mismo!
            </div>
            <div class="block">
              <small>
                Puedes solicitarla en Mis Productos / Tienda en Línea
              </small>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="btn-actions">
          <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
          <?php
            echo $this->Html->link(__('Más información'),array(
              'controller' => 'mis_productos',
              'action' => 'promociones',
            ), array(
              'class' => 'btn btn-primary',
            ));
          ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
  $this->Html->scriptBlock('
    (function($, undefined) {
      $(document).on(\'ready\', function () {
        $(\'#' . $id . '\').modal({
          backdrop: \'static\',
          show : true
        });
      });
    })(jQuery);
  ', array(
    'inline' => false
  ));
?>
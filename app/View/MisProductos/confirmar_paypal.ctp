<?php
  echo $this->element('empresas/title');
  $r = $factura['Factura'];
  $iva = $r['factura_total'] - $r['factura_subtotal'];
?>
<div class="row">
  <div class="col-xs-12">
    <!-- <div class="alert alert-success">
      <?php echo __('Has adquirido los siguientes productos.'); ?>
    </div> -->
    <div class="text-center">
      <h5 class="lead alert alert-success">
        <?php echo __('¡Gracias por tu preferencia!'); ?>
      </h5>
    </div>
    <div class="row">
      <div class="col-xs-9">
        <?php
          echo $this->element('empresas/carrito/confirmar', array(
            'factura' => $factura,
            'items' => $items
          ));
        ?>
      </div>
      <div class="col-xs-3">
        <div class="btn-actions">
          <?php
            echo $this->Html->image('assets/tienda_pagos.jpg', array(
              'class' => 'img-responsive'
            ));

            // echo $this->Html->link(__('Descargar Factura'), array(
            //   'controller' => 'mis_productos',
            //   'action' => 'factura',
            //   'ext' => 'pdf',
            //   $factura['Factura']['factura_folio'],
            // ), array(
            //   'target' => '_blank',
            //   'class' => 'btn btn-primary btn-block'
            // ));


            $link = $this->Html->link(__('Términos y Condiciones'), '#', array(
              'target' => '_blank'
            ));

            echo $this->Form->input('terminos', array(
              'id' => 'activatePaypalBtn',
              'label' => __('Acepto %s', $link),
              'type' => 'checkbox',
              'data' => array(
                'toggle' => 'popover',
                'title' => 'Acepta',
                'content' => '<span class="text-danger">Por favor, antes de pagar lea y acepte los Términos y Condiciones del servicio.</span>',
                'placement' => 'top'
              )
            ));

            $returnUrl = $this->Html->url(array(
              'controller' => 'mis_productos',
              'action' => 'compra_exitosa'
            ), true);

            echo $this->Paypal->button(__('Pagar con Paypal'), array(
              'invoice' => $factura['Factura']['factura_folio'],
              'type' => 'cart',
              'items' => $items,
              'test' => true,
              'tax_cart' => number_format($iva, 2, '.', ''),
              'return' => $returnUrl
              // 'tax_rate' => 0.16,
            ), array(
              'id' => 'paypalBtn',
              'class' => 'btn btn-success btn-block',
              'div' => 'btn-actions'
            ));

            echo $this->Html->link(__('Cancelar Factura'), array(
              'controller' => 'mis_productos',
              'action' => 'factura',
              $factura['Factura']['factura_folio'],
              'cancelar'
            ), array(
              'data' => array(
                'redirect' => true,
                'component' => 'ajaxlink'
              ),
              'class' => 'btn btn-danger btn-block'
            ));
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
  echo $this->Html->scriptBlock(
    '$("#paypalBtn").on("click", function () {
      var $paypalCheckbox = $("#activatePaypalBtn")
        , accepted = $("#activatePaypalBtn").is(":checked");

      if (!accepted) {
        $paypalCheckbox.popover({
          html:true,
          // trigger:"focus"
        }).popover("show");
        return false;
      }
    });',
    array('inline' => false)
  );
?>
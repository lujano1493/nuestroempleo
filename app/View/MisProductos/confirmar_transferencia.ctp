<?php
  echo $this->element('empresas/title');
  $r = $factura['Factura'];
  $iva = $r['factura_total'] - $r['factura_subtotal'];
?>
<div class="row">
  <div class="col-xs-12">
    <!-- <div class="alert alert-success">
      <?php
        echo __('Has adquirido los siguientes productos.');
        $r = $factura['Factura'];
      ?>
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
        <div class="alert alert-success">
          <ul class="list-unstyled">
            <li>
              <?php echo __('%s <strong>%s</strong>', 'BANCO:', 'BBVA BANCOMER'); ?>
            </li>
            <li>
              <?php echo __('%s <strong>%s</strong>', 'CLABE:', '012180001629149055'); ?>
            </li>
            <li>
              <?php echo __('%s <strong>%s</strong>', 'BENEFICIARIO:', 'iGenter México S. de R.L. de C.V.'); ?>
            </li>
            <li>
              <?php echo __('%s <strong>%s</strong>', 'REFERENCIA:', $r['factura_folio']); ?>
            </li>
          </ul>
        </div>
        <div class="alert alert-info">
          <h4><?php echo __('¿Qué sigue?'); ?></h4>
          <p>
            Una vez realizado el pago, envíe su comprobante al correo
            <a class="alert-link" href="mailto:ventas.ne@nuestroempleo.com.mx" target="_blank">ventas.ne@nuestroempleo.com.mx</a>
            o entre en contacto con nosotros.
          </p>
        </div>
      </div>
      <div class="col-xs-3">
        <div class="btn-actions">
          <?php
            echo $this->Html->link(__('Descargar Orden de Compra'), array(
              'controller' => 'mis_productos',
              'action' => 'factura',
              'ext' => 'pdf',
              $factura['Factura']['factura_folio'],
            ), array(
              'target' => '_blank',
              'class' => 'btn btn-primary btn-block'
            ));
            echo $this->Html->link(__('Cancelar'), array(
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

    <?php
      // echo $this->Paypal->button(__('Pagar con Paypal'), array(
      //   'invoice' => $factura['Factura']['factura_folio'],
      //   'type' => 'cart',
      //   'items' => $items,
      //   'test' => true,
      //   'tax_cart' => number_format($iva, 2, '.', ''),
      //   // 'tax_rate' => 0.16,
      // ), array(
      //   'class' => 'btn btn-success btn-lg',
      //   'div' => 'btn-actions'
      // ));
    ?>
  </div>
</div>
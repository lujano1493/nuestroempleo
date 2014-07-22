<?php
  echo $this->element('empresas/title');
?>

<div class="row">
  <div class="col-xs-12">
    <h5 class="subtitle">
      <?php echo __('Instrucciones'); ?>
    </h5>
    <ol>
      <li><?php echo __('Revisa los productos que has elegido y modifica si es necesario.') ?></li>
      <li><?php echo __('Una vez que tengas los productos que deseas, elige un método de pago.') ?></li>
    </ol>
  </div>
</div>

<div class="">
  <?php
    echo $this->Form->create(false, array(
      'id' => 'carritoForm'
    ));
    echo $this->Form->input('Carrito.factura_rfc', array(
      'data-name' => 'rfc',
      'type' => 'hidden'
    ));
  ?>
  <legend class="subtitle">
    Productos seleccionados
  </legend>
  <div class="row">
    <div class="col-xs-12">
      <table class="table table-bordered">
        <thead>
          <tr>
            <td><?php echo __('Paquete'); ?></td>
            <td><?php echo __('Descripción'); ?></td>
            <td><?php echo __('Costo Unitario'); ?></td>
            <td><?php echo __('Cantidad'); ?></td>
            <td><?php echo __('Subtotal'); ?></td>
          </tr>
        </thead>
        <tbody>
          <?php
            $notEmpty = !empty($cart['items']);
            if ($notEmpty) {
              $count = 0;
              foreach ($cart['items'] as $key => $value) {
                $m = $membresias[$key];
                $costo = $value['desc']['costo'];
                $cant = $value['cant'];
          ?>
            <tr>
              <td><?php echo $key; ?></td>
              <td>
                <ul>
                  <li><?php echo __('%s días de Vigencia', $m['vigencia']); ?></li>
                  <?php
                    foreach ($m['Detalles'] as $kd => $vd) {
                      $creditos = $vd['Detalle']['creditos_infinitos'] ? __('Ilimitadas') :  $vd['Detalle']['credito_num'];
                      $servicio = $vd['Servicio']['servicio_nom'];
                      ?>
                        <li><?php echo $creditos . ' '. $servicio; ?></li>
                      <?php
                    }
                  ?>
                </ul>
              </td>
              <td><?php echo $this->Number->currency($costo); ?></td>
              <td>
                <?php
                  echo $this->Form->input("Carrito.Items.$count.id", array(
                  'value' => $key,
                  'type' => 'hidden'
                  ));
                  echo $this->Form->input("Carrito.Items.$count.cant", array(
                    'class' => 'form-control input-sm sm',
                    'data' => array(
                      'cost' => $costo
                    ),
                    'label' => false,
                    'min' => 1,
                    'type' => 'number',
                    'value' => $cant,
                  ));
                ?>
              </td>
              <td>
                <?php
                  echo $this->Form->label(
                    "Carrito.Items.$count.cant",
                    $this->Number->currency($costo * $cant),
                    array(
                      'data-subtotal' => $costo * $cant
                    )
                  );

                  echo $this->Html->link('','', array(
                    'class' => 'text-danger pull-right rm-item',
                    'icon' => 'remove-sign',
                    'data-component'  => 'tooltip',
                    'title' => 'Desactivar item'
                  ));

                  echo $this->Html->link('','', array(
                    'class' => 'text-success pull-right ok-item',
                    'icon' => 'ok',
                    'data-component'  => 'tooltip',
                    'title' => 'Activar item'
                  ));
                ?>
              </td>
            </tr>
          <?php
                $count++;
              }
            } else {
          ?>
            <tr>
              <td colspan="5">
                <?php echo __('No tienes items seleccionados'); ?>
                <?php
                  echo $this->Html->link(__('Ve nuestro Catálogo'), array(
                    'controller' => 'mis_productos',
                    'action' => 'catalogo'
                  ), array(

                  ));
                ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
        <tfooter>
          <tr>
            <td colspan="4" class="text-right">
              <strong><?php echo __('Subtotal'); ?></strong>
            </td>
            <td class="text-center">
              <?php
                echo $this->Html->tag('span', $this->Number->currency($cart['total']), array(
                  'id' => 'carrito-subtotal'
                ));
              ?>
            </td>
          </tr>
          <tr>
            <td colspan="4" class="text-right">
              <strong><?php echo __('IVA (%s %%)', 16); ?></strong>
            </td>
            <td class="text-center">
              <?php
                echo $this->Html->tag('span', $this->Number->currency($cart['total'] * 0.16), array(
                  'id' => 'carrito-iva'
                ));
              ?>
            </td>
          </tr>
          <tr>
            <td colspan="4" class="text-right">
              <strong>Total</strong>
            </td>
            <td class="text-center">
              <?php
                echo $this->Html->tag('span', $this->Number->currency($cart['total'] * 1.16), array(
                  'id' => 'carrito-total'
                ));
              ?>
            </td>
          </tr>
        </tfooter>
      </table>
      <div class="btn-actions text-left">
        <?php
          echo $this->Html->link(__('Seguir Comprando'), array(
            'controller' => 'mis_productos',
            'action' => 'catalogo'
          ), array(
            'class' => 'text-danger'
          ));
        ?>
      </div>
    </div>
  </div>
  <div class="div">
    <h5 class="subtitle">Método de pago</h5>
    <div class="row">
      <?php if ($this->Acceso->isDevCompany()): ?>
        <div class="col-xs-4">
          <?php
            echo $this->Form->input('Carrito.metodo_pago', array(
              'data-open-div' => 'metodo_paypal',
              'hiddenField' => false,
              'options' => array(
                'paypal' => '<img src="/img/assets/logo_paypal.jpg" width="80">'
              ),
              'escape' => false,
              'type' => 'radio'
            ));
          ?>
        </div>
      <?php endif ?>
      <div class="col-xs-4">
        <?php
          echo $this->Form->input('Carrito.metodo_pago', array(
            'data-open-div' => 'metodo_transferencia',
            'hiddenField' => false,
            'options' => array(
              'transferencia' => __('Transferencia Bancaria')
            ),
            'escape' => false,
            'type' => 'radio'
          ));
        ?>
      </div>
      <div class="col-xs-4">
        <?php
          echo $this->Form->input('Carrito.metodo_pago', array(
            'data-open-div' => 'metodo_deposito',
            'hiddenField' => false,
            'options' => array(
              'deposito' => __('Depósito Bancario')
            ),
            'escape' => false,
            'type' => 'radio'
          ));
        ?>
      </div>
    </div>
    <div class="row" style="display:none;">
      <div class="col-xs-12">
        <div id="metodo_paypal" class="form-hide" style="display:none;">
          <?php echo $this->element('empresas/metodos_pago/paypal'); ?>
        </div>
        <div id="metodo_transferencia" class="form-hide" style="display:none;">
          <?php echo $this->element('empresas/metodos_pago/transferencia'); ?>
        </div>
        <div id="metodo_deposito" class="form-hide" style="display:none;">
          <?php echo $this->element('empresas/metodos_pago/deposito'); ?>
        </div>
      </div>
    </div>
  </div>
  <?php
    echo $this->Form->end();
  ?>
  <br><br>
</div>
<div>
  <div class="alert alert-info" style="margin-bottom:0;">
    Una vez elegido el método de pago, revisa los datos de facturación y cámbialos de ser necesario.
    Una vez aceptados, serán definitivos para la expedición de la factura correspondiente.
    Verificado el pago se realizará la activación del servicio.
  </div>
  <?php
    echo $this->element('empresas/datos_facturacion', array(
      'submit' => false
    ));
  ?>
  <?php if ($notEmpty): ?>
    <div style="padding:15px 0;">
      <p class="alert alert-info">
        <strong>¿Tienes alguna duda?</strong> Revisa la selección de dudas o ponte en contacto con nosotros a través de
        <a class="alert-link" href="mailto:contacto.ne@nuestroempleo.com.mx" target="_blank">contacto.ne@nuestroempleo.com.mx</a> o a los teléfonos en el DF y Área
        Metropolitana (0155) 55641071 o (0155) 52642678 y en el interior de la República al 01800 849 24 87.
      </p>
      <div class="btn-actions">
        <?php
          echo $this->Html->link(__('Aceptar'), '#', array(
            'id' => 'submitCarrito',
            'class' => 'btn btn-success'
          ));
        ?>
      </div>
    </div>
  <?php endif ?>
</div>

<?php
  $this->AssetCompress->script('carrito.js', array(
    'inline' => false
  ));
?>
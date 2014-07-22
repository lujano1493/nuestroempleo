<?php
  $r = $factura['Factura'];
  $e = $factura['FacturacionEmpresa'];
  $detalles = $factura['FacturaDetalles'];
  $a = $factura['Administrador'];
  $ac = $factura['AdministradorContacto'];
?>
<div class="well">
  <div>
    <div class="lead text-right">
      <div class="pull-left">
        <?php
          echo $this->Html->image('logo.png', array(
            'width' => 250
          ));
        ?>
      </div>
      <div class="folio">
        <?php echo $r['factura_folio']; ?>
      </div>
      <small class="block">
        Folio del Factura
      </small>
    </div>
  </div>
  <table class="table">
    <thead>
      <tr>
        <th><?php echo __('Cantidad') ?></th>
        <th><?php echo __('Descripción') ?></th>
        <th><?php echo __('Precio Unitario') ?></th>
        <th><?php echo __('Total') ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
        $iva = $r['factura_total'] - $r['factura_subtotal'];
        foreach ($items as $key => $item):
      ?>
        <tr>
          <td>
            <span class="text-center block">
              <?php echo $item['quantity']; ?>
            </span>
          </td>
          <td>
            <span class="text-center block">
              <strong><?php echo __($item['item_name']); ?></strong>
            </span>
          </td>
          <td>
            <span class="text-center block">
              <?php echo $this->Number->currency($item['amount']); ?>
            </span>
          </td>
          <td>
            <span class="pull-right">
              <?php
                $price = (int)$item['quantity'] * (float)$item['amount'];
                echo $this->Number->currency($price);
              ?>
            </span>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
    <tfooter>
      <tr>
        <td colspan="3">
          <span class="text-right block">
            <?php echo __('Subtotal'); ?>
          </span>
        </td>
        <td>
          <span class="pull-right">
            <strong><?php echo $this->Number->currency($r['factura_subtotal']); ?></strong>
          </span>
        </td>
      </tr>
      <tr>
        <td colspan="3">
          <span class="text-right block">
            <?php echo __('IVA') ?>
          </span>
        </td>
        <td>
          <span class="pull-right">
            <strong><?php echo $this->Number->currency($iva); ?></strong>
          </span>
        </td>
      </tr>
      <tr>
        <td colspan="3">
          <span class="text-right block">
            <?php echo __('Total'); ?>
          </span>
        </td>
        <td>
          <span class="pull-right">
            <strong><?php echo $this->Number->currency($r['factura_total']); ?></strong>
          </span>
        </td>
      </tr>
    </tfooter>
  </table>
</div>
<div class="row" style="font-size:1.1em;">
  <div class="col-xs-6">
    <strong><?php echo __('Datos de la Empresa'); ?></strong>
    <br><br>
    <ul class="list-unstyled">
      <li>
        <?php echo __('<strong>%s</strong> %s', 'Empresa:', $e['cia_razonsoc']); ?>
      </li>
      <li>
        <?php echo __('<strong>%s</strong> %s', 'R.F.C.:', $e['cia_rfc']); ?>
      </li>
      <li>
        <?php echo __('<strong>%s</strong> %s', 'Giro:', $e['giro']); ?>
      </li>
    </ul>
  </div>
  <div class="col-xs-6">
    <strong><?php echo __('Datos de Contacto'); ?></strong>
    <br><br>
    <ul class="list-unstyled">
      <li>
        <?php echo __('<strong>%s</strong> %s', 'Nombre:', implode(' ', array(
          $ac['con_nombre'],
          $ac['con_paterno'],
          $ac['con_materno']
        ))); ?>
      </li>
      <li>
        <?php echo __('<strong>%s</strong> %s', 'Perfil:', 'Administrador'); ?>
      </li>
      <li>
        <?php
          $tel = empty($ac['con_tel'])
            ? __('Sin dato')
            : __('%s Ext: %s', $ac['con_tel'], !empty($ac['con_ext']) ? $ac['con_ext'] : '');
          echo __('<strong>%s</strong> %s', 'Teléfono:', htmlentities($tel));
        ?>
      </li>
    </ul>
  </div>
</div>
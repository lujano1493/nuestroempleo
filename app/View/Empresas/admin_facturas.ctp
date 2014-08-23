<?php
  echo $this->element('admin/title');
  $factura = reset($empresa['Facturas']);
  $hasUploadedFiles = !empty($files);
  $isPromo = $factura['is_promo'];
  $facturaStatus = (int)$factura['factura_status'];
?>

<div class="row">
  <div class="col-xs-9">
    <h2>
      <?php
        echo $empresa['Empresa']['cia_nombre'];
        $slug = Inflector::slug($empresa['Empresa']['cia_nombre'] . '-' . $empresa['Empresa']['cia_cve'], '-');
      ?>
      <small>
        <?php echo $empresa['Empresa']['cia_razonsoc']; ?>
      </small>
    </h2>
    <div class="lead">
      <span class="block">
        <?php echo __('Giro: %s', $empresa['Empresa']['giro_nombre']); ?>
      </span>
      <span class="block">
        <?php echo __('Socio desde %s', $this->Time->d($empresa['Empresa']['created'])); ?>
      </span>
    </div>
  </div>
  <div class="col-xs-3">
    <div class="btn-actions">
      <?php
        echo $this->Html->back();
      ?>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-9">
    <?php
      // Factura activada
      if ($facturaStatus >= 2):
    ?>
      <div class="lead text-center alert alert-success">
        <strong><?php echo __('Factura Activada') ?></strong>
      </div>
    <?php endif ?>
    <?php
      /**
       * Si es promocional no se requiren archivos...
       */
      if (!$isPromo) {
        echo $this->element('admin/empresas/archivos', array(
          'factura' => $factura,
          'onlyList' => $facturaStatus >= 2
        ));
      } else { ?>
        <div class="alert alert-info">
          <?php
            echo __('Esta factura activará una membresía <strong>promocional</strong> para la compañia %s',
              $empresa['Empresa']['cia_nombre']);
          ?>
        </div>
      <?php
      }
    ?>
    <h5 class="subtitle">
      <?php echo __('Servicios Contratados'); ?>
    </h5>
    <ul class="list-unstyled lead">
      <li>
        <?php echo __('<small>%s:</small> %s', __('Folio'), $factura['factura_folio']); ?>
      </li>
      <li>
        <?php echo __('<small>%s:</small> %s', __('Razón Social'), $factura['FacturacionEmpresa']['cia_razonsoc']); ?>
      </li>
      <li>
        <?php echo __('<small>%s:</small> %s', __('RFC.'), $factura['FacturacionEmpresa']['cia_rfc']); ?>
      </li>
      <li>
        <?php
          $d = $factura['Direccion'];
          $domicilio = array(
            $d['calle'],
            $d['num_exterior'],
            $d['colonia'],
            $d['ciudad'],
            $d['estado'],
            $d['pais'],
            __('CP. %s', $d['cp'])
          );

          echo __('<small>%s: %s</small>', __('Domicilio'), implode(', ', $domicilio));
        ?>
      </li>
    </ul>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Producto</th>
          <th width="80px">Cantidad</th>
          <th width="150px">Total</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($factura['FacturaDetalles'] as $_k => $_r): ?>
          <tr>
            <td>
              <strong>
                <?php echo $_r['Membresia']['nombre']; ?>
              </strong>
              <p>
                <small style="text-transform:uppercase;color:#a3a3a3;">
                  <?php echo $_r['Membresia']['desc']; ?>
                </small>
              </p>
              <span class="block">
                <?php echo __('Costo: %s', $this->Number->currency($_r['Membresia']['costo'])); ?>
              </span>
            </td>
            <td class="text-center">
              <strong>
                <?php echo $_r['cantidad'] ?>
              </strong>
            </td>
            <td class="text-center">
              <strong>
                <?php echo $this->Number->currency($_r['cantidad'] * $_r['Membresia']['costo']); ?>
              </strong>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
      <tbody>
        <tr>
          <td colspan="2" class="text-right">
            <?php echo __('Subtotal'); ?>
          </td>
          <td class="text-center">
            <?php echo $this->Number->currency($factura['factura_total']); ?>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="text-right">
            <?php echo __('IVA') ?>
          </td>
          <td class="text-center">
            <?php echo $this->Number->currency(0); ?>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="text-right">
            <?php echo __('Total'); ?>
          </td>
          <td class="text-center">
            <strong>
              <?php echo $this->Number->currency($factura['factura_total']); ?>
            </strong>
          </td>
        </tr>
      </tbody>
    </table>
    <br><br>
    <?php if ($isPromo): ?>
      <div class="alert alert-info">
        <?php
          echo __('Esta factura activará una membresía <strong>promocional</strong> para la compañia %s',
            $empresa['Empresa']['cia_nombre']);
        ?>
      </div>
      <div class="alert alert-danger">
        <p>
          <strong>En caso de ser necesario puedes cambiar la membresía que se asignará.</strong>
        </p>
        <div class="row">
          <?php
            echo $this->Form->input('membresia', array(
              'class' => 'selectedMembership',
              'before' => '<div class="col-xs-6"><div class="input radio input-as-btn">',
              'separator' => '</div></div><div class="col-xs-6"><div class="input radio input-as-btn">',
              'after' => '</div></div>',
              'options' => $membresias,
              'default' => $factura['FacturaDetalles'][0]['Membresia']['id'],
              'hiddenField' => false,
              'div' => false,
              'label' => array(
                'class' => 'orange'
              ),
              'legend' => false,
              'type' => 'radio',
              'disabled' => $facturaStatus === 2 ? 'disabled' : false
            ));
          ?>
        </div>
      </div>
      <?php
        echo $this->Form->input('accepted', array(
          'id' => 'accepted',
          'type' => 'hidden',
          'value' => 1
        ));
      ?>
    <?php endif ?>
    <?php
      // Factura activada
      if ($facturaStatus >= 2):
    ?>
      <div class="lead text-center alert alert-success">
        <strong><?php echo __('Factura Activada') ?></strong>
      </div>
    <?php endif ?>
    <div class="btn-actions">
      <?php
        echo $this->Html->back(__('Regresar'), array(
          'class' => 'btn btn-danger',
        ));


        if ($facturaStatus >= 0 && $facturaStatus <= 1) {
          echo $this->Html->link(__('Asignar Créditos'), array(
            'admin' => $isAdmin,
            'controller' => 'empresas',
            'id' => $empresa['Empresa']['cia_cve'],
            'slug' => Inflector::slug($empresa['Empresa']['cia_nombre'], '-'),
            'action' => 'facturas',
            'itemId' => $factura['factura_folio'],
            'subaction' => 'asignar'
          ), array(
            'data' => array(
              'role' => 'assign-credits',
              // 'component' => 'ajaxlink',
              'ajaxlink-confirm-html' => 'alert-assign-credits'
            ),
            'class' => 'btn btn-success',
            // 'disabled' => true
          ));
        } elseif ($facturaStatus >= 2) {
          echo $this->Html->link(__('Créditos Activados'), '#', array(
            'class' => 'btn btn-success disabled',
            'disabled' => true
          ));
        }
      ?>
      <div data-alert-before-send="alert-assign-credits">
        <div class="alert alert-warning">
          <?php echo __('Activarás los créditos de la factura <strong>%s</strong>.', $factura['factura_folio']); ?>
        </div>
        <?php if ((int)$empresa['Empresa']['cia_tipo'] === 1): ?>
          <div class="alert alert-warning">
            <?php echo $empresa['Empresa']['cia_nombre'] ?> actualmente es <strong>CONVENIO</strong>, activando esta
            factura, el convenio se cancelará y <strong><?php echo $empresa['Empresa']['cia_nombre'] ?></strong> pasará
            a ser una compañia <strong>comercial</strong>.
            <br><br>
            Recuerda que esta acción no se puede deshacer.
          </div>
        <?php endif; ?>
        <p>
          <strong>¿Estás de acuerdo?</strong>
        </p>
      </div>
    </div>
  </div>
  <div class="col-xs-3">

  </div>
</div>
<?php
  $this->Html->scriptBlock('
    (function($, undefined) {
      $(\'a[data-role=assign-credits]\')
      .on(\'click\', function (e) {
        e.preventDefault();
        $(this).ajaxlink(\'click\', e, {
          params: {
            membresia: $("input[type=radio].selectedMembership:checked").val()
          }
        });
        return false;
      }).on(\'success.ajaxlink\', function (e) {
        $(this).attr(\'disabled\', true).text(\'Créditos Asignados\');
      });
    })(jQuery);
  ', array(
    'inline' => false
  ));
?>

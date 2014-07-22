<?php
  $r = $factura[0]['Factura'];
  $e = $factura[0]['FacturacionEmpresa'];
  $detalles = $factura[0]['FacturaDetalles'];
  $a = $factura[0]['Administrador'];
  $ac = $factura[0]['AdministradorContacto'];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Factura</title>
    <style>
      body { font-family: sans-serif; font-size: 10pt; }
      h1 { font-size:25px; font-weight: lighter; padding-bottom: 5px; }
      ul.list-unstyled { list-style: none; margin: 0; padding: 0; }
      small { color: #999; font-size: 9pt; }
      table { border-collapse: collapse; border-spacing: 0pt; width: 100%; }
      table td { padding: 5px; }
      table.separate { border-spacing: 8pt; }
      table.bordered { border: 1px solid #000; }
      table.bordered td { border: 1px solid #000; }
      table tr.table-header { background-color: #ccc; }
      .absolute-top-left { position: absolute; top: 0; left: 0; }
      .absolute-top-right { position: absolute; top: 0; right: 0; }
      .border-bottom { border-bottom: #cecece solid 1px; }
      .text-center { text-align: center; }
      .text-right { text-align: right; }
      .datos {
        background-color: #dffdd0;
        border: 1px solid #42b706;
        padding: 10px 15px;
      }
      .info {
        background-color: #ddedfd;
        border: 1px solid #2b92f4;
        padding: 10px 15px;
      }
      .row { margin-top: 15px; margin-bottom: 15px; }
      #footer {
        background-color: #fff;
        border-bottom: 1px solid #f0f0f0;
        bottom: 0px;
        /* height: 30px; */
        left: 0px;
        padding: 10px;
        position: fixed;
        right: 0px;
      }
    </style>
  </head>
  <body>
    <div id="header">
      <p class="absolute-top-left">
        <?php $url_img = WWW_ROOT . 'img/logo.png'; ?>
        <img src="<?= $url_img; ?>" width="150" />
      </p>
      <p class="absolute-top-right">
        <?php echo $this->Time->d($r['created']); ?>
      </p>
      <p>&nbsp;</p>
      <h1 class="text-right">
        <?php echo __('Folio: <strong>%s</strong>', $r['factura_folio']); ?>
      </h1>
      <h2 class="text-center border-bottom">
        <?php echo __('Orden de Compra'); ?>
      </h2>
    </div>
    <div id="body">
      <div class="row">
        <table class="separate">
          <tr>
            <td><strong><?php echo __('Datos de la Empresa'); ?></strong></td>
            <td><strong><?php echo __('Datos de Contacto'); ?></strong></td>
          </tr>
          <tr>
            <td>
              <ul class="list-unstyled">
                <li>Empresa: <?php echo $e['cia_razonsoc']; ?></li>
                <li>R.F.C.: <?php echo $e['cia_rfc']; ?></li>
                <li>Giro: <?php echo htmlentities($e['giro']); ?></li>
              </ul>
            </td>
            <td>
              <ul class="list-unstyled">
                <li>Nombre: <?php echo implode(' ', array(
                    $ac['con_nombre'],
                    $ac['con_paterno'],
                    $ac['con_materno']
                  ));
                  ?>
                </li>
                <li>Perfil: Administrador</li>
                <li>T&eacute;lefono: <?php
                    $tel = empty($ac['con_tel'])
                      ? __('Sin dato')
                      : __('%s Ext: %s', $ac['con_tel'], !empty($ac['con_ext']) ? $ac['con_ext'] : '');

                    echo htmlentities($tel);
                  ?>
                </li>
              </ul>
            </td>
          </tr>
        </table>
      </div>
      <div class="row">
        <table class="bordered">
          <tr class="table-header text-center">
            <td><strong><?php echo __('Cantidad'); ?></strong></td>
            <td><strong><?php echo htmlentities(__('Descripción')); ?></strong></td>
            <td><strong><?php echo __('Precio Unitario'); ?></strong></td>
            <td><strong><?php echo __('Total'); ?></strong></td>
          </tr>
          <?php
            $total = 0;
            foreach ($detalles as $k => $d) {
              $cant = $d['cantidad'];
              $costo = $d['Membresia']['costo'];
              $total += ($cant * $costo);
          ?>
            <tr class="text-center">
              <td><?php echo $cant; ?></td>
              <td>
                <?php echo $d['Membresia']['nombre']; ?>
                <small>
                  <?php echo htmlentities(__('%s días de vigencia', $d['Membresia']['vigencia'])); ?>
                </small>
              </td>
              <td><?php echo $this->Number->currency($costo); ?></td>
              <td><?php echo $this->Number->currency($cant * $costo); ?></td>
            </tr>
          <?php } ?>
          <tr class="text-center">
            <td class="text-right" colspan="3"><?php echo __('Subtotal'); ?></td>
            <td>
              <strong><?php echo $this->Number->currency($r['factura_subtotal']); ?></strong>
            </td>
          </tr>
          <tr class="text-center">
            <td class="text-right" colspan="3"><?php echo __('IVA'); ?></td>
            <td>
              <strong><?php echo $this->Number->currency($r['factura_total'] - $r['factura_subtotal']); ?></strong>
            </td>
          </tr>
          <tr class="text-center">
            <td class="text-right" colspan="3"><?php echo __('Total'); ?></td>
            <td>
              <strong><?php echo $this->Number->currency($r['factura_total']); ?></strong>
            </td>
          </tr>
        </table>
      </div>
      <div class="row">
        <div class="datos">
          <h3><?php echo htmlentities(__('Método de Pago')); ?></h3>
          <?php //$url_img = WWW_ROOT . 'img/assets/logo_bancomer.png'; ?>
          <ul class="list-unstyled">
            <li><?php echo htmlentities(__('Depósito o transferencia')); ?></li>
            <li>
              <?php echo __('%s <strong>%s</strong>', 'BANCO:', 'BBVA Bancomer'); ?>
            </li>
            <li>
              <?php echo __('%s <strong>%s</strong>', 'CUENTA:', '00162914905'); ?>
            </li>
            <li>
              <?php echo __('%s <strong>%s</strong>', 'CLABE:', '012180001629149055'); ?>
            </li>
            <li>
              <?php echo __('%s <strong>%s</strong>', 'BENEFICIARIO:', 'iGenter Mexico S. de R.L. de C.V.'); ?>
            </li>
            <li>
              <?php echo __('%s <strong>%s</strong>', 'REFERENCIA:', $r['factura_folio']); ?>
            </li>
          </ul>
        </div>
      </div>
      <div class="row">
        <div class="info">
          <h3><?php echo htmlentities(__('¿Qué Sigue?')); ?></h3>
          <p>
            <?php
              echo htmlentities(__(
                'Una vez realizado el pago, envíe su comprobante al correo %s o entre en contacto con nosotros.',
                'ventas.ne@nuestroempleo.com.mx'
              ));
            ?>
          </p>
        </div>
      </div>
    </div>
    <div id="footer" class="text-right">
      <?php
        echo htmlentities(__('Este documento se generó el %s.', $this->Time->dt()));
      ?>
    </div>
  </body>
</html>
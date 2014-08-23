<?php
  $f = $factura['Comprobante'];
  $e = $f['cfdi:Emisor'];
  $r = $f['cfdi:Receptor'];
  $cs = $f['cfdi:Conceptos']['cfdi:Concepto'];
  $i = $f['cfdi:Impuestos'];
  $t = $f['cfdi:Complemento']['tfd:TimbreFiscalDigital'];
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
      .small { font-size: 8pt; }
      .tiny { color: #111; font-size: 7pt; }
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
      /*.wrap { white-space: pre-line; word-wrap: break-word; }*/
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
      .row { margin-top: 15px; margin-bottom: 15px; max-width: 100% }
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
      <p class="absolute-top-right text-right">
        <?php echo $this->Time->d($f['@fecha']); ?>
        <br>
        <?php echo htmlentities(__('Lugar de Expedición: %s', 'México, D.F.')); ?>
      </p>
      <p>&nbsp;</p>
      <h1 class="text-right">
        <?php echo __('Folio: <strong>%s</strong>', $f['@folio']); ?>
      </h1>
      <h2 class="text-center border-bottom">
        <?php echo __('Factura'); ?>
      </h2>
    </div>
    <div id="body">
      <div class="row">
        <table class="separate text-center">
          <tr>
            <td>
              <ul class="list-unstyled">
                <?php
                  $z = $e['cfdi:DomicilioFiscal'];
                  $rd = implode(', ', array(
                    $z['@calle'],
                    __('Col. %s', $z['@colonia']),
                    $z['@municipio'],
                    $z['@estado'],
                    $z['@pais'],
                    __('C.P. %s', $z['@codigoPostal']),
                  ));
                ?>
                <li>
                  <strong>
                    <?php echo htmlentities($e['@nombre']); ?>
                  </strong>
                </li>
                <li><small>R.F.C.:</small> <?php echo htmlentities($e['@rfc']); ?></li>
                <li class="tiny"><?php echo htmlentities($rd); ?></li>
              </ul>
            </td>
          </tr>
        </table>
      </div>
      <div class="row">
        <table class="separate">
          <tr>
            <td><strong><?php echo __('Facturado a:'); ?></strong></td>
          </tr>
          <tr>
            <td>
              <ul class="list-unstyled">
                <?php
                  $z = $r['cfdi:Domicilio'];
                  $rd = implode(', ', array(
                    $z['@calle'],
                    __('Col. %s', $z['@colonia']),
                    $z['@municipio'],
                    $z['@estado'],
                    $z['@pais'],
                    __('C.P. %s', $z['@codigoPostal']),
                  ));
                ?>
                <li><small>Empresa:</small> <?php echo htmlentities($r['@nombre']); ?></li>
                <li><small>R.F.C.:</small> <?php echo htmlentities($r['@rfc']); ?></li>
                <li class="tiny"><small>Domicilio:</small> <?php echo htmlentities($rd); ?></li>
              </ul>
            </td>
          </tr>
        </table>
      </div>
      <div class="row">
        <table class="bordered">
          <tr class="table-header text-center">
            <td><strong><?php echo htmlentities(__('Cantidad')); ?></strong></td>
            <td><strong><?php echo htmlentities(__('Descripción')); ?></strong></td>
            <td><strong><?php echo htmlentities(__('Precio Unitario')); ?></strong></td>
            <td><strong><?php echo htmlentities(__('Total')); ?></strong></td>
          </tr>
          <?php
            $subtotal = 0;
            if (empty($cs[0])) {
              $cs = array($cs);
            }

            foreach ($cs as $k => $c) {
              $cant = $c['@cantidad'];
              $costo = $c['@valorUnitario'];
          ?>
            <tr class="text-center">
              <td><?php echo $cant; ?></td>
              <td>
                <?php echo $c['@descripcion']; ?>
                <!-- <small>
                  <?php //echo htmlentities(__('%s días de vigencia', $d['Membresia']['vigencia'])); ?>
                </small> -->
              </td>
              <td><?php echo $this->Number->currency($costo); ?></td>
              <td><?php echo $this->Number->currency($c['@importe']); ?></td>
            </tr>
          <?php } ?>
          <tr class="text-center">
            <td class="text-right" colspan="3"><?php echo __('Subtotal'); ?></td>
            <td>
              <strong><?php echo $this->Number->currency($f['@subTotal']); ?></strong>
            </td>
          </tr>
          <tr class="text-center">
            <td class="text-right" colspan="3"><?php echo __('IVA'); ?></td>
            <td>
              <strong><?php echo $this->Number->currency($i['@totalImpuestosTrasladados']); ?></strong>
            </td>
          </tr>
          <tr class="text-center">
            <td class="text-right" colspan="3"><?php echo __('Total'); ?></td>
            <td>
              <strong><?php echo $this->Number->currency($f['@total']); ?></strong>
            </td>
          </tr>
        </table>
      </div>
      <div class="row">
        <table class="">
          <tr>
            <td></td>
            <td class="text-right">
              <ul class="list-unstyled">
                <li><small><?php echo htmlentities(__('Serie del Certificado del emisor:')); ?></small></li>
                <li><small><?php echo htmlentities(__('No de Serie del Certificado del SAT:')); ?></small></li>
                <li><small><?php echo htmlentities(__('Fecha y hora de certificación:')); ?></small></li>
                <li><small><?php echo htmlentities(__('Folio fiscal:')); ?></small></li>
              </ul>
            </td>
            <td class="text-left">
              <ul class="list-unstyled">
                <li><?php echo $f['@noCertificado']; ?></li>
                <li><?php echo $t['@noCertificadoSAT']; ?></li>
                <li><?php echo $this->Time->dt($t['@FechaTimbrado']); ?></li>
                <li><?php echo strtoupper($t['@UUID']); ?></li>
              </ul>
            </td>
          </tr>
        </table>
      </div>
      <div class="row">
        <table class="bordered">
          <tr class="table-header">
            <td class="text-center">
              <strong><?php echo __('Sello CFDI'); ?></strong>
            </td>
          </tr>
          <tr>
            <td class="wrap">
              <?php
                $split = str_split($t['@selloCFD'], 125);
              ?>
              <small class="tiny"><?php echo implode('<br>', $split); ?></small>
            </td>
          </tr>
        </table>
      </div>
      <div class="row">
        <table class="bordered">
          <tr class="table-header">
            <td class="text-center">
              <strong><?php echo __('Sello del SAT'); ?></strong>
            </td>
          </tr>
          <tr>
            <td class="wrap">
              <?php
                $split = str_split($t['@selloSAT'], 125);
              ?>
              <small class="tiny"><?php echo implode('<br>', $split); ?></small>
            </td>
          </tr>
        </table>
      </div>
      <div class="row">
        <table class="bordered">
          <tr class="table-header">
            <td class="text-center">
              <strong><?php echo htmlentities(__('Cadena original del complemento de certificación digital del SAT')); ?></strong>
            </td>
          </tr>
          <tr>
            <td>
              <?php
                $split = str_split($cadenaOriginal, 125);
              ?>
              <small class="tiny"><?php echo implode('<br>', $split); ?></small>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <div id="footer" class="text-right">
      <?php
        echo htmlentities(__('Este documento se generó el %s.', $this->Time->dt()));
      ?>
    </div>
  </body>
</html>
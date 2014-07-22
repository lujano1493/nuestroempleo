<?php
  $e = $empresa['Empresa'];
  $a = $empresa['Admin'];
  $ac = $empresa['AdminContacto'];
?>
  <!-- <tr>
    <td style="width:50%; text-align:left;">
      <?php
        // echo $this->Html->image('assets/logo.jpg', array(
        //   'fullBase' => true,
        //   'width' => 210,
        //   'height' => 81
        // ));
      ?>
    </td>
    <td style="width:50%;">
      <p style="background-color:#49317b; padding:3px; color:#FFF; font-weight:bold; font-size:16px;">
        Factura Pagado
      </p>
    </td>
  </tr> -->
  <tr>
    <td colspan="2" style="background-color:#49317b; height:3px;"></td>
  </tr>
  <tr>
    <td style="width:50%; vertical-align:top;">
    </td>
    <td style="width:50%; font-weight:bold; font-size:24px; color:#49317b; text-align:center;">
      Se ha recibido un pago mediante Paypal
    </td>
  </tr>
  <tr>
    <td colspan="2" style="background-color:#49317b; height:3px;"></td>
  </tr>
  <tr>
    <td colspan="2">
      <div>
        <p>

        </p>
      </div>
      <div>
        <div class="" style="text-align:center;">
          <h1>
            <small style="color:#999;">FOLIO</small>
            <?php echo $factura; ?>
          </h1>
          <ul style="list-style:none;text-align:left;">
            <li>
              <?php echo __('Empresa: <strong>%s</strong>', $e['cia_nombre']) ?>
            </li>
            <li>
              <?php echo __('RFC: <strong>%s</strong>', $e['cia_rfc']) ?>
            </li>
            <li>
              <?php
                $nombre = array($ac['con_nombre'], $ac['con_paterno']);
                echo __('Admin: <strong>%s</strong>', implode(' ', $nombre));
              ?>
            </li>
            <li>
              <?php echo __('Correo: <strong>%s</strong>', $a['cu_sesion']); ?>
            </li>
          </ul>
          <?php
            echo $this->Html->link(__('Aprobar los créditos'), array(
              'full_base' => true,
              'admin' => true,
              'controller' => 'empresas',
              'action' => 'facturas',
              'id' => $e['cia_cve'],
              'slug' => Inflector::slug($e['cia_nombre'], '-'),
              $factura
            ), array(
              'style' => 'display:inline-block;padding:10px 20px;background-color:#49317b;color:white;'
            ));
          ?>
        </div>
      </div>
    </td>
  </tr>


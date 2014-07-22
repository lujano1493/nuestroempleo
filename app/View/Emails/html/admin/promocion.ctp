<?php
  $e = $empresa['Empresa'];
  $a = $empresa['Admin'];
  $ac = $empresa['AdminContacto'];
?>
  <tr>
    <td colspan="2" style="background-color:#49317b; height:3px;"></td>
  </tr>
  <tr>
    <td style="width:50%; vertical-align:top;">
    </td>
    <td style="width:50%; font-weight:bold; font-size:24px; color:#49317b; text-align:center;">
      Se ha recibido una solicitud de promoción
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
          <?php if ($factura_folio): ?>
            <h1>
              <small style="color:#999;">FOLIO</small>
              <?php echo $factura_folio; ?>
            </h1>
          <?php endif ?>
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
            <li>
              <?php
                $tel = empty($ac['con_tel'])
                  ? __('Sin dato')
                  : __('%s Ext: %s', $ac['con_tel'], !empty($ac['con_ext']) ? $ac['con_ext'] : '');
                echo __('Tel: <strong>%s</strong>', $tel);
              ?>
            </li>
          </ul>
          <?php
            if ($factura_folio) {
              echo $this->Html->link(__('Aprobar los créditos'), array(
                'full_base' => true,
                'admin' => true,
                'controller' => 'empresas',
                'action' => 'facturas',
                'id' => $e['cia_cve'],
                'slug' => Inflector::slug($e['cia_nombre'], '-'),
                $factura_folio
              ), array(
                'style' => 'display:inline-block;padding:10px 20px;background-color:#49317b;color:white;'
              ));
            } else {
              echo $this->Html->link(__('Ver detalles'), array(
                'full_base' => true,
                'admin' => true,
                'controller' => 'convenios',
                'action' => 'condiciones',
                'id' => $e['cia_cve'],
                'slug' => Inflector::slug($e['cia_nombre'], '-')
              ), array(
                'style' => 'display:inline-block;padding:10px 20px;background-color:#49317b;color:white;'
              ));
            }
          ?>
        </div>
      </div>
    </td>
  </tr>


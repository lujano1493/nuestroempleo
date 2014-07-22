<table cellspacing="0" style="width:759px; background-color:#fff;" >
  <tr>
    <td style="width:50%; text-align:left;">
      <?php
        echo $this->Html->image('assets/logo.jpg', array(
          'fullBase' => true,
          'width' => 210,
          'height' => 81
        ));
      ?>
    </td>
    <td style="width:50%;">
      <p style="background-color:#49317b; padding:3px; color:#FFF; font-weight:bold; font-size:16px;">Servicios Activados</p>
    </td>
  </tr>
  <tr>
    <td colspan="2" style=" background-color:#49317b; height:3px;"></td>
  </tr>
  <tr>
    <td style="width:50%; vertical-align:top;">
      <?php
        echo $this->Html->image('assets/confirmacion_cuenta_empresas.jpg', array(
          'fullBase' => true,
          'width' => 381,
          'height' => 190
        ));
      ?>
    </td>
    <td style="width:50%; font-weight:bold; font-size:24px; color:#49317b; text-align:center;">
      <p style="color:#49317b; font-weight:bold; font-size:16px;">Servicios Activados</p>
    </td>
  </tr>
  <tr>
    <td colspan="2" style="background-color:#49317b; height:3px;"></td>
  </tr>
  <tr>
    <td colspan="2" style="text-align:center;">
      <?php if ($folio): ?>
        <p>
          Los servicios del folio <strong><?php echo $folio ?></strong> ya han sido activados.
        </p>
      <?php else: ?>
        <p>
          Los servicios del convenio <strong><?php echo $empresa['Empresa']['cia_nombre']; ?></strong> ya han sido activados.
        </p>
      <?php endif ?>
      <br>
      <p>Agradecemos tu preferencia.</p>
      <br>
      <p>Por favor de clic en el siguiente enlace para iniciar sesión:</p>
      <p>
        <?php
          $url = $this->Html->url(array(
            'admin' => false,
            'controller' => 'empresas',
            'action' => 'index'
          ), true);

          echo $this->Html->link('Nuestro Empleo Empresas', $url, array(
            'style' => 'color:#49317b; font-weight:bold; font-size:16px;'
          ));
        ?>
      </p>
      <br>
    </td>
  </tr>
</table>
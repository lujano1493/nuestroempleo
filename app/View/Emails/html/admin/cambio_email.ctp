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
      <p style="background-color:#49317b; padding:3px; color:#FFF; font-weight:bold; font-size:16px;">
        Cambio de correo electrónico
      </p>
    </td>
  </tr>
  <tr>
    <td colspan="2" style=" background-color:#49317b; height:3px;"></td>
  </tr>
  <tr>
    <td style="width:50%; vertical-align:top;">
      <?php
        echo $this->Html->image('assets/email_foto.jpg', array(
          'fullBase' => true,
          'width' => 383,
          'height' => 191
        ));
      ?>
    </td>
    <td style="width:50%; font-weight:bold; font-size:24px; color:#49317b; text-align:center;">
      Su correo electrónico<br>ha sido modificado
    </td>
  </tr>
  <tr>
    <td colspan="2" style="background-color:#49317b; height:3px;"></td>
  </tr>
  <tr>
    <td colspan="2" style="text-align:center;">
      <p style="font-weight:bold;text-align:right; padding-right:10px;">Enviado: <?php echo $this->Time->dt(); ?></p>
      <p style="font-weight:bold;">Estimado: <?= $nombre; ?></p>
      <p>Su cuenta de inicio de sesión en Nuestro Empleo ha sido cambiada.</p>
      <p><span style="color:#49317b; font-weight:bold; font-size:16px;">Usuario:</span> <?= $email; ?></p>
      <p><span style="color:#49317b; font-weight:bold; font-size:16px;">Contraseña:</span> <?= $password; ?></p>
      <p>Necesita volver a activar su cuenta. Por favor de clic en el siguiente enlace:</p>
      <p>
        <?php
          $url = $this->Html->url(array(
            'admin' => false,
            'controller' => 'cuentas',
            'action' => 'activar',
            $keycode
          ), true);
          echo $this->Html->link($url, $url, array(
            'style' => 'color:#49317b; font-weight:bold; font-size:16px;'
          ));
        ?>
      </p>
    </td>
  </tr>
</table>
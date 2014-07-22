<table cellspacing="0" style="width:759px; background-color:#fff;">
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
        Confirmación de cuenta
      </p>
    </td>
  </tr>
  <tr>
    <td colspan="2" style=" background-color:#49317b; height:3px;"></td>
  </tr>
  <tr>
    <td style="width:50%; vertical-align:top;">
      <?php
        echo $this->Html->image('assets/pw_foto.jpg.jpg', array(
          'fullBase' => true,
          'width' => 381,
          'height' => 190
        ));
      ?>
    </td>
    <td style="width:50%; font-weight:bold; font-size:24px; color:#49317b; text-align:center;">
      La contraseña ha<br>sido cambiada
    </td>
  </tr>
  <tr>
    <td colspan="2" style="background-color:#49317b; height:3px;"></td>
  </tr>
  <tr>
    <td colspan="2" style="text-align:center;">
      <p style="font-weight:bold;text-align:right; padding-right:10px;">Enviado: <?php echo $this->Time->dt(); ?></p>
      <p style="font-weight:bold;">Estimado: <?= $nombre; ?></p>
      <p>Los nuevos datos son:</p>
      <p><span style="color:#49317b; font-weight:bold; font-size:16px;">Usuario:</span> <?= $email; ?></p>
      <p><span style="color:#49317b; font-weight:bold; font-size:16px;">Contraseña:</span> <?= $password; ?></p>
      <p>Por favor de clic en el siguiente enlace para iniciar sesión</p>
      <p>
        <?php
          echo $this->Html->link('Da clic para iniciar sesión.', array(
            'full_base' => true,
            'admin' => true,
            'controller' => 'nuestro_empleo',
            'action' => 'iniciar_sesion',
            'key' => 'ok'
          ), array(
            'style' => 'color:#49317b; font-weight:bold; font-size:16px;'
          ));
        ?>
      </p>
    </td>
  </tr>
</table>
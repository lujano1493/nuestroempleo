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
      <p style="background-color:#49317b; padding:3px; color:#FFF; font-weight:bold; font-size:16px;">Confirmación de cuenta</p>
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
      ¡Gracias por registrarte en
      <br>
      n<span style="color:#4e4f53;">uestro empleo</span>!
      <p style="color:#49317b; font-weight:bold; font-size:16px;">Bienvenido</p>
    </td>
  </tr>
  <tr>
    <td colspan="2" style="background-color:#49317b; height:3px;"></td>
  </tr>
  <tr>
    <td colspan="2" style="text-align:center;">
      <p>Se ha creado con éxito la cuenta de la empresa: <?php echo $cia_nom; ?></p>
      <br>
      <p><span style="color:#49317b; font-weight:bold; font-size:16px;">Usuario:</span> <?php echo $email; ?></p>
      <p><span style="color:#49317b; font-weight:bold; font-size:16px;">Contraseña:</span> <?php echo $password; ?></p>
      <br>
      <br>
      <p>Por favor de clic en el siguiente enlace para activar la cuenta:</p>
      <p>
        <?php
          $url = $this->Html->url(array(
            'admin' => false,
            'controller' => 'empresas',
            'action' => 'activar',
            $keycode
          ), true);

          echo $this->Html->link($url, $url, array(
            'style' => 'color:#49317b; font-weight:bold; font-size:16px;'
          ));
        ?>
      </p>
      <br>
    </td>
  </tr>
</table>
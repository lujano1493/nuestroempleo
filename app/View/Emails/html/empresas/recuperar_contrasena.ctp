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
      <p style="background-color:#49317b; padding:3px; color:#FFF; font-weight:bold; font-size:16px;">Recuperación de contraseña</p>
    </td>
  </tr>
  <tr>
    <td colspan="2" style=" background-color:#49317b; height:3px;"></td>
  </tr>
  <tr>
    <td style="width:50%; vertical-align:top;">
      <?php
        echo $this->Html->image('assets/pw_foto.jpg', array(
          'fullBase' => true,
          'width' => 381,
          'height' => 192
        ));
      ?>
    </td>
    <td style="width:50%; font-weight:bold; font-size:24px; color:#49317b; text-align:center;">
      Solicitud para recuperar
      <br>contraseña
    </td>
  </tr>
  <tr>
    <td colspan="2" style=" background-color:#49317b; height:3px;"></td>
  </tr>
  <tr>
    <td colspan="2" style="text-align:center;">
      <p style="font-weight:bold; text-align:right; padding-right:10px;">
        Enviado: <?php echo $this->Time->dt(); ?>
      </p>
      <p style="font-weight:bold;">Estimado: <?php echo $email; ?></p>
      <p>
        Hemos recibido una solicitud para cambiar su contraseña, de no ser así, por favor ignore este mensaje.
        <br>
        <br>
        Por favor de clic en el siguiente enlace para continuar con el procedimiento:
      </p>
      <p>
        <?php
          $newPasswordLink = $this->Html->url('/tickets/' . $hash, true);
          echo $this->Html->link($newPasswordLink, $newPasswordLink, array(
            'style' => 'color:#49317b; font-weight:bold; font-size:16px;'
          ));
        ?>
      </p>
    </td>
  </tr>
</table>
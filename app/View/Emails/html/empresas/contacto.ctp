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
        Solicitud de contacto
      </p>
    </td>
  </tr>
  <tr>
    <td colspan="2" style="background-color:#49317b; height:3px;"></td>
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
      Has recibido una<br>solicitud de contacto
    </td>
  </tr>
  <tr>
    <td colspan="2" style="background-color:#49317b; height:3px;"></td>
  </tr>
  <tr>
    <td colspan="2">
      <p style="font-weight:bold;text-align:right; padding-right:10px;">Enviado: <?php echo $this->Time->dt(); ?></p>
      <p style="font-weight:bold;padding-left:10px;text-align:left;">Estimado: Nombre</p>
      <p style="text-align:left; padding-left:10px;">
        Has recibido una solicitud de contacto de: <?php echo $empresa['cia_nombre']; ?>
      </p>
      <br>
    </td>
  </tr>
  <tr>
    <td colspan="2" style="background-color:#49317b;padding:10px;color:#FFF;font-weight:bold;text-align:center;">
      Datos del Usuario
    </td>
  </tr>
  <tr style="background-color:#ddd; padding:10px;">
    <td style="padding-left:10px; text-align:left;">
      <p><span style="color:#49317b; font-weight:bold; font-size:16px;">Correo electrónico:</span> <?php echo $user['email']; ?></p>
    </td>
    <td style="padding-left:10px; text-align:left;">
      <p><span style="color:#49317b; font-weight:bold; font-size:16px;">Teléfono:</span> <?php
        echo !empty($user['tel']) ? __('%s ext. %s', $user['tel'], $user['ext'] ?: '-' ) : __('N/D');
      ?></p>
    </td>
  </tr>
  <tr style="background-color:#ddd; padding:10px;">
    <td style="padding-left:10px; text-align:left;">
      <p><span style="color:#49317b; font-weight:bold; font-size:16px;">ID:</span> <?php echo $user['id']; ?></p>
    </td>
    <td style="padding-left:10px; text-align:left;"></td>
  </tr>
   <tr style="background-color:#ddd; padding:10px;">
    <td style="padding-left:10px; text-align:left;">
      <p><span style="color:#49317b; font-weight:bold; font-size:16px;">Nombre:</span> <?php echo $user['nombre']; ?></p>
    </td>
    <td style="padding-left:10px; text-align:left;"></td>
  </tr>
   <tr style="background-color:#ddd; padding:10px;">
    <td style="padding-left:10px; text-align:left;">
      <p><span style="color:#49317b; font-weight:bold; font-size:16px;">Medios de contacto:</span> <?php echo implode(', ', $medio); ?></p>
    </td>
    <td style="padding-left:10px; text-align:left;"></td>
  </tr>
  <tr>
    <td colspan="2" style="background-color:#49317b; padding:10px;color:#FFF; font-weight:bold;text-align:center;">
      Datos de la Empresa
    </td>
  </tr>
  <tr style="background-color:#ddd; padding:10px;">
    <td colspan="2" style="padding-left:10px; text-align:left;">
      <p><span style="color:#49317b; font-weight:bold; font-size:16px;">Nombre:</span> <?php echo $empresa['cia_nombre']; ?></p>
    </td>
  </tr>
  <tr style="background-color:#ddd; padding:10px;">
    <td colspan="2" style="padding-left:10px; text-align:left;">
      <p><span style="color:#49317b; font-weight:bold; font-size:16px;">No. Socio:</span> <?php echo $empresa['cia_cve']; ?></p>
    </td>
  </tr>
  <tr style="background-color:#ddd; padding:10px;">
    <td colspan="2" style="padding-left:10px; text-align:left;">
      <p><span style="color:#49317b; font-weight:bold; font-size:16px;">Teléfono Empresa:</span> <?php
        echo !empty($empresa['tel'])? __('%s', $empresa['tel']) : __('N/D');
      ?></p>
    </td>
  </tr>
  <tr style="background-color:#ddd; padding:10px;">
    <td colspan="2" style="padding-left:10px; text-align:left;">
      <p><span style="color:#49317b; font-weight:bold; font-size:16px;">Razón Social:</span> <?php echo $empresa['cia_razonsoc']; ?></p>
    </td>
  </tr>
  <tr style="background-color:#ddd; padding:10px;">
    <td colspan="2" style="padding-left:10px; text-align:left;">
      <p><span style="color:#49317b; font-weight:bold; font-size:16px;">R.F.C.:</span> <?php echo $empresa['cia_rfc']; ?></p>
    </td>
  </tr>
  <tr style="background-color:#ddd; padding:10px;">
    <td colspan="2" style="padding-left:10px; text-align:left;">
      <p><span style="color:#49317b; font-weight:bold; font-size:16px;">Giro:</span> <?php echo $empresa['giro_nombre']; ?></p>
    </td>
  </tr>
  <tr style="background-color:#ddd; padding:10px;">
    <td colspan="2" style="padding-left:10px; text-align:left;">
      <p><span style="color:#49317b; font-weight:bold; font-size:16px;">Membresía:</span> <?php echo $empresa['membresia']; ?></p>
    </td>
  </tr>
  <tr>
    <td colspan="2" style="background-color:#49317b;padding:10px;color:#FFF;font-weight:bold;text-align:center;">
      <h2 style="text-align:center;"><?php echo $motivo; ?></h2>
      Mensaje
    </td>
  </tr>
  <tr style="background-color:#ddd; padding:10px;">
    <td colspan="2" style="padding-left:10px; text-align:left; height:200px; vertical-align:top;">
      <?php echo $mensaje; ?>
      <br>
    </td>
  </tr>
</table>


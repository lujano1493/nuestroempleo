<?php
  $empresa = $user['Empresa'];
  $preguntas = array(
    'Declara que la Empresa %s está totalmente constituida',
    '%s autoriza recibir una inspección en las instalaciones de su compañía',
    '%s desea que sus publicaciones tengan un sello de Empresa Premium',
  );
?>
<table style="width:759px; background-color:#fff;" cellspacing="0">
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
        Empresa Premium
      </p>
    </td>
  </tr>
  <tr>
    <td colspan="2" style=" background-color:#49317b; height:3px;"></td>
  </tr>
  <tr>
    <td style="width:50%; vertical-align:top;">
      <?php
        echo $this->Html->image('assets/empresas_premium.jpg', array(
          'fullBase' => true,
          'width' => 378,
          'height' => 189
        ));
      ?>
    </td>
    <td style="width:50%; font-weight:bold; font-size:24px; color:#49317b; text-align:center;">
      Has recibido una solicitud
      <br>para empresa premium
    </td>
  </tr>
  <tr>
    <td colspan="2" style="background-color:#49317b; height:3px;"></td>
  </tr>
  <tr>
    <td colspan="2">
      <p class="usuario" style="text-align:right; padding-right:10px;">
        Enviado: <?php echo $this->Time->dt(); ?>
      </p>
      <p style="text-align:left; padding-left:10px;">
        Has recibido una solicitud para Empresa Premium de: <?php echo $empresa['cia_nombre']; ?>
      </p>
      <br>
    </td>
  </tr>
  <tr>
    <td colspan="2" style="background-color:#49317b; padding:10px;color:#FFF; font-weight:bold;">Datos del Usuario</td>
  </tr>
  <tr>
    <td colspan="2" style="text-align:left; padding-top:45px; background-color:#ddd; padding:10px;">
      <div style="text-align:left;">
        <ul style="list-style:none;">
          <li><span style="color:#49317b; font-weight:bold; font-size:16px;">Email:</span><span><?php echo $user['cu_sesion']; ?></span></li>
          <li><span style="color:#49317b; font-weight:bold; font-size:16px;">ID:</span><span><?php echo $user['cu_cve']; ?></span></li>
          <li><span style="color:#49317b; font-weight:bold; font-size:16px;">Nombre:</span><span><?php echo $user['fullName']; ?></span></li>
        </ul>
      </div>
    </td>
  </tr>
  <tr>
    <td colspan="2" style="background-color:#49317b; padding:10px;color:#FFF; font-weight:bold;">
      Datos de la Empresa
    </td>
  </tr>
  <tr>
    <td colspan="2" style="text-align:left; padding-top:45px; background-color:#ddd; padding:10px;">
      <div style="text-align:left;">
        <ul style="list-style:none;">
          <li><span style="color:#49317b; font-weight:bold; font-size:16px;">Nombre:</span><span><?php echo $empresa['cia_nombre']; ?></span></li>
          <li><span style="color:#49317b; font-weight:bold; font-size:16px;">No. de Socio:</span><span><?php echo $empresa['cia_cve']; ?></span></li>
          <li><span style="color:#49317b; font-weight:bold; font-size:16px;">Razón Social:</span><span><?php echo $empresa['cia_razonsoc']; ?></span></li>
          <li><span style="color:#49317b; font-weight:bold; font-size:16px;">RFC:</span><span><?php echo $empresa['cia_rfc']; ?></span></li>
          <li><span style="color:#49317b; font-weight:bold; font-size:16px;">Giro:</span><span><?php echo $empresa['giro_nombre']; ?></span></li>
          <li><span style="color:#49317b; font-weight:bold; font-size:16px;">Membresia:</span><span><?php echo $user['Perfil']['membresia']; ?></span></li>
        </ul>
      </div>
    </td>
  </tr>
  <tr>
    <td colspan="2" style="background-color:#49317b; padding:10px;color:#FFF; font-weight:bold;">
      Información
    </td>
  </tr>
  <tr>
    <td colspan="2" style="text-align:left; padding-top:45px; background-color:#ddd; padding:10px;">
      <div>
        <ul style="list-style:none;">
          <li>
            <span><?php echo __('Tipo de Compañía:') ?></span>
            <strong><?php echo $tipos_compania[$data['tipo_cia']]; ?></strong>
          </li>
          <li>
            <?php
            foreach ($preguntas as $key => $value):
              $response = (!empty($data['pregunta' . ($key + 1)])
                && strtolower($data['pregunta' . ($key + 1)]) === 's')
                ? __('Sí')
                : __('No');
            ?>
              <span style="display:block;">
                <?php echo sprintf($value, '<strong>' . strtoupper($response). '</strong>'); ?>
              </span>
            <?php
            endforeach;
            ?>
          </li>
        </ul>
      </div>
    </td>
  </tr>
  <tr>
    <td colspan="2" style="background-color:#49317b; padding:10px;color:#FFF; font-weight:bold;">
      Comentarios
    </td>
  </tr>
  <tr>
    <td colspan="2" style="text-align:left; padding-top:45px; background-color:#ddd; padding:10px;">
      <p><?php echo $data['comentarios']; ?></p>
    </td>
  </tr>
</table>
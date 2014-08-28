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
      <p style="background-color:#49317b; padding:3px; color:#FFF; font-weight:bold; font-size:16px;">Soporte</p>
    </td>
  </tr>
  <tr>
    <td colspan="2" style=" background-color:#49317b; height:3px;"></td>
  </tr>
  <tr>
    <td colspan="2" style="background-color:#49317b; height:3px;"></td>
  </tr>
  <tr>
    <td colspan="2">
      <div>
        <p>
          Han solicitado soporte.
        </p>
      </div>
      <div style="text-align:center; font-size:1.1em;">
        Asunto: <strong style="font-size:2em;">
          <?php echo $asunto; ?>
        </strong>
      </div>
      <div class="" style="text-align:left;">
        <strong>
          Datos del usuario.
        </strong>
        <ul style="list-style:none;text-align:left;">
          <li>
            <?php echo __('ID: <strong>%s</strong>', $user['cu_cve']); ?>
          </li>
          <li>
            <?php echo __('Perfil: <strong>%s</strong>', $user['per_cve']); ?>
          </li>
          <li>
            <?php echo __('Email: <strong>%s</strong>', $user['fullName']) ?>
          </li>
          <li>
            <?php echo __('Nombre: <strong>%s</strong>', $user['fullName']) ?>
          </li>
        </ul>
      </div>
      <div class="" style="text-align:left;">
        <strong>
          A continuación se muestra la descripción proporcionada.
        </strong>
        <div>
          <?php echo $desc; ?>
        </div>
      </div>
    </td>
  </tr>
</table>

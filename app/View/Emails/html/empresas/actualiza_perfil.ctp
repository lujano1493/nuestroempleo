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
    <td style="width:50%; text-align:right">
      <?php
        echo $this->Html->image($reclutador['Empresa']['logo'], array(
          'fullBase' => true,
          'width' => 183,
          'height' => 82
        ));
      ?>
    </td>
  </tr>
  <tr>
    <td colspan="2" style=" background-color:#2f72cb; height:3px;"></td>
  </tr>
  <tr>
    <td style="width:50%; vertical-align:top;">
      <?php
        echo $this->Html->image('assets/actualiza_CV.jpg', array(
          'fullBase' => true,
          'width' => 380,
          'height' => 192
        ));
      ?>
    </td>
    <td style="width:50%; font-weight:bold; font-size:24px; color:#2f72cb; text-align:center;">
      ¡Las Empresas se han interesado en tu perfil!
    </td>
  </tr>
  <tr>
    <td colspan="2" style="background-color:#2f72cb; height:3px;"></td>
  </tr>
  <tr>
    <td colspan="2">
      <p class="usuario" style="text-align:center;">
        <?php echo __('Estimado: %s (%s)', $candidato['nombre'], $candidato['email']); ?>
      </p>
      <p style="color: #2f72cb;font-weight: bold;font-size: 16px;text-align:center;">
        Actualiza tu información periódicamente para que los reclutadores visualicen tus datos vigentes.
      </p>
      <p style="text-align:center;">
        <?php
          echo $this->Html->image('assets/cvinvitacion.jpg', array(
            'fullBase' => true,
            'width' => 157,
            'height' => 141
          ));
        ?>
      </p>
      <br>
      <p style="text-align:center;">
        <strong>(Información de Atención)</strong><br>
        <span><?php echo $reclutador['fullName'] ?></span><br>
        <span><?php echo $reclutador['cu_sesion'] ?></span><br>
        <?php if ($reclutador['Contacto']['con_tel']): ?>
          <span>
            <?php echo $reclutador['Contacto']['con_tel']; ?>
          </span><br>
        <?php endif ?>
      </p>
      <br>
    </td>
  </tr>
  <tr>
    <td colspan="2" style="background-color:#666; color:#FFF; text-align:center; padding:10px;">
      En cumplimiento a lo establecido por la Ley Federal de Protección de Datos Personales en Posesión de los Particulares, se hace de su conocimiento que se encuentra a su disposición el Aviso de Privacidad relacionado con el tratamiento de los datos personales, en el sitio web: www.hitenlinea.com , a efecto de que pueda ejercer su derecho a la autodeterminación informativa.  Fecha de actualización: 07 Enero 2013
    </td>
  </tr>
</table>
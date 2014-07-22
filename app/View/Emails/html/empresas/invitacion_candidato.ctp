<!-- <table cellspacing="0" style="width:759px; background-color:#fff;" > -->
  <tr>
    <td style="width:50%; text-align:left;">
      <?php
        // echo $this->Html->image('assets/logo.jpg', array(
        //   'fullBase' => true,
        //   'width' => 210,
        //   'height' => 81
        // ));
      ?>
    </td>
    <td style="width:50%; text-align:right">
      <?php
        echo $this->Html->image($reclutador['Empresa']['logo'], array(
          'fullBase' => true,
          'width' => 183,
          'height' => 'auto'
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
        echo $this->Html->image('assets/invitacion.jpg', array(
          'fullBase' => true,
          'width' => 381,
          'height' => 190
        ));
      ?>
    </td>
    <td style="width:50%; font-weight:bold; font-size:24px; color:#2f72cb; text-align:center;">
      Invitación Registro Bolsa de Trabajo<br>Nuestro Empleo
    </td>
  </tr>
  <tr>
    <td colspan="2" style="background-color:#2f72cb; height:3px;"></td>
  </tr>
  <tr>
    <td colspan="2">
      <p class="usuario" style="text-align:left; padding-left:10px;">
        <?php
          $emailLink = $this->Html->link($candidato['email'], 'mailto:' . $candidato['email'], array(
            'style' => 'color:#2f72cb;'
          ));
        ?>
        Estimado: <?php echo $candidato['nombre']; ?> (<?php echo $emailLink; ?>)
      </p>
      <p class="usuario" style="text-align:right; padding-right:10px;">
        <?php echo $this->Time->dt(); ?>
      </p>
      <p style="text-align:justify; padding:10px;">
        Como parte de nuestro proceso de Selección, te invitamos a registrar tu información gratuitamente en  la Bolsa de Trabajo Nuestro Empleo.
        <br><br>Nuestro Empleo es una herramienta nueva y eficaz que nos facilita el proceso de selección al vincular candidatos con empleadores.
        <br><br>Al darte de alta en nuestra Bolsa de Trabajo podremos dar ágil seguimiento a tu proceso, por lo que te solicitamos previo a tu entrevista, confirmes a tu Ejecutivo de Atracción de Talento que el registro ha sido exitoso.
      </p>
      <br>
    </td>
  </tr>
  <tr>
    <td colspan="2" style="background-color:#2f72cb; padding:10px;color:#FFF; font-weight:bold;">Sigue los siguientes pasos:</td>
  </tr>
  <tr class="fondo">
    <td colspan="2" style="text-align:justify; padding:10px; margin-bottom:25px;">
      <?php
        $ref_link = $this->Html->link('www.nuestroempleo.com.mx', array(
          'controller' => 'informacion',
          'action' => 'index',
          '?' => array(
            'ref' => $candidato['ref_code']
          ),
          'full_base' => true
        ), array(
          'style' => 'color:#2f72cb;'
        ));
      ?>
      <p>
        <span class="destacar">1.</span> Ingresa a <?php echo $ref_link; ?> desde cualquier navegador. <br><br>
        <span class="destacar">2.</span> Regístrate en la parte superior derecha "Candidatos". <br><br>
        <span class="destacar">3.</span> Una vez que tengas tu usuario y contraseña, misma que podrás modificar para efectos de confidencialidad, ingresa y regístrate.
          <br><br>La información completa y correcta nos ayudará a conocer más de tu perfil.
          <br><br>Cualquier duda que tengas por favor extérnala a tu Ejecutivo de Atracción de Talento.
          <br><br>
      </p>
      <p style="text-align:center;">
        <strong>(Información de Atención)</strong><br>
        <span><?php echo $reclutador['fullName'] ?></span><br>
        <span>
          <?php
            $emailLink = $this->Html->link($reclutador['cu_sesion'], 'mailto:' . $reclutador['cu_sesion'], array(
              'style' => 'color:#2f72cb;'
            ));
            echo $emailLink;
          ?>
        </span><br>
        <?php if ($reclutador['Contacto']['con_tel']): ?>
          <span>
            <?php echo $reclutador['Contacto']['con_tel']; ?>
          </span><br>
        <?php endif ?>
      </p>
    </td>
  </tr>
<!-- </table> -->
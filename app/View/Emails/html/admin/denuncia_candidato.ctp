 
  <tr>
    <td colspan="2" style="background-color:#343d45; height:3px;"></td>
  </tr>
  <tr>
    <td style="width:50%; vertical-align:top;">

    </td>
    <td style="width:50%; font-weight:bold; font-size:24px; color:#343d45; text-align:center;">
      Has recibido una<br>denuncia de CV.
    </td>
  </tr>
  <tr>
    <td colspan="2" style="background-color:#343d45; height:3px;"></td>
  </tr>
  <tr>
    <td colspan="2">
      <div>
        <p>
          El siguiente currículo ha sido reportado por la empresa <strong><?php echo $reclutador['Empresa']['cia_nombre']; ?></strong>
          debido a <strong><?php echo $data['motivo_texto']; ?></strong>.
        </p>
        <p>
          <?php echo $data['detalles']; ?>
        </p>
      </div>
      <div>
        <h3><?php echo __('Datos del Candidato'); ?></h3>
        <ul>
          <li><?php echo __('Nombre: %s', $candidato['Candidato']['nombre_']); ?></li>
          <li><?php echo __('Email: %s', $candidato['CandidatoUsuario']['cc_email']); ?></li>
          <li><?php echo __('Registro: %s', $this->Time->dt($candidato['CandidatoUsuario']['created'])); ?></li>
        </ul>
        <div class="" style="text-align:center;">
          <?php
          $id=$candidato['Candidato']['candidato_cve'];
          $slug=Inflector::slug($candidato['Candidato']['candidato_perfil'], '-')."-$id";
          $url=Router::fullBaseUrl()."/admin/denuncias/$id/candidato/$slug/";
            echo $this->Html->link(__('Ver Perfil'), $url);
          ?>
        </div>
      </div>
      <div>
        <h3><?php echo __('Datos de la Empresa'); ?></h3>
        <ul>
          <li><?php echo __('Nombre: %s', $reclutador['Empresa']['cia_nombre']); ?></li>
          <li><?php echo __('ID: %s', $reclutador['Empresa']['cia_cve']); ?></li>
          <li><?php echo __('Registro: %s', $this->Time->dt($reclutador['Empresa']['created'])); ?></li>
        </ul>
        <h3><?php echo __('Datos del Usuario de la Empresa'); ?></h3>
        <ul>
          <li><?php echo __('Nombre: %s', $reclutador['fullName']); ?></li>
          <li><?php echo __('ID: %s', $reclutador['cu_cve']); ?></li>
          <li><?php echo __('Email: %s', $reclutador['cu_sesion']); ?></li>
          <?php if (!empty($reclutador['Contacto']['con_tel'])): ?>
            <li><?php echo __('Tel: %s, ext: %s', $reclutador['Contacto']['con_tel'], $reclutador['Contacto']['con_ext'] ?: '-'); ?></li>
          <?php endif ?>
          <li><?php echo __('Registro: %s', $this->Time->dt($reclutador['created'])); ?></li>
        </ul>
      </div>
      <div>
        <p style="font-weight:bold;color:#000;">
          Se solicita la verificación de los datos, en caso de incurrir en la falta indicada, notificar al Candidato
          para la revisión de su perfil, de no cumplirse la actualización del currículum en un plazo de 48 hrs,
          éste será retirado del sistema.
        </p>
      </div>
    </td>
  </tr>

<?php
  $o = $oferta['Oferta'];
  $d = $oferta['Catalogo'];
  $c = $oferta['UsuarioEmpresa'];
?>

  <div class="row">
          <table style="width:100%">
              <tbody>
                <tr>
                  <td style="width:60%">
                                      <h4><?php echo htmlentities($o['puesto_nom']); ?></h4>
                      <h5>
                        <span><?php echo htmlentities($oferta['Direccion']['ciudad']); ?></span>,
                         <span><?php echo htmlentities($oferta['Direccion']['estado']); ?></span>
                      </h5>
                  </td>
                  <td style="width:40%">
                      <?php
                                 $url_img = (file_exists(WWW_ROOT . "documentos/empresas/$o[cia_cve]/logo.jpg")) ?
                                      "documentos/empresas/$o[cia_cve]/logo.jpg" :
                                      "img/no-logo.jpg";

                                  $url_img = (int)$o['oferta_privada'] === 1
                                    ? 'img/assets/img_oferta_priv.jpg'
                                    : $url_img;
                                  
                                  echo "<img   class='logo' style='margin: 10px 10px 0 0'  width='200px' id='img' src='$url_img' >";        
                                ?>
                    
                  </td>                    
                </tr>
              </tbody>
          </table>
      <div class="preview-pane">
        <h5 class="preview-title"><?php echo __('REQUISITOS'); ?></h5>
        <ul class="list-unstyled">
          <li>
            <strong><?php echo __('Experiencia:'); ?></strong>
            <span><?php echo htmlentities($d['experiencia']);  ?></span>
          </li>
          <li>
            <strong><?php echo __('Escolaridad:'); ?></strong>
            <span><?php echo htmlentities($d['escolaridad']); ?></span>
          </li>
          <li>
            <strong><?php echo __('Género:'); ?></strong>
            <span><?php echo htmlentities($d['genero']); ?></span>
          </li>
          <li>
            <strong><?php echo __('Estado Civil:'); ?></strong>
            <span><?php echo htmlentities($d['edocivil']); ?></span>
          </li>
          <li>
            <strong><?php echo __('Edad:'); ?></strong>
            <span><?php echo $o['oferta_edadmin']; ?></span>-<span><?php echo $o['oferta_edadmax']; ?></span>
          </li>
          <li>
            <strong><?php echo __('Disponibilidad:'); ?></strong>
            <span><?php echo $d['disponibilidad']; ?></span>
          </li>
          <?php if ((int)$o['oferta_viajar'] === 1): ?>
            <li>
              <strong>Disponibilidad para Viajar</strong>
            </li>
          <?php endif ?>
          <?php if ((int)$o['oferta_residencia'] === 1): ?>
            <li>
              <strong>Disponibilidad para cambiar de residencia</strong>
            </li>
          <?php endif ?>
        </ul>
      </div>
      <div class="preview-pane">
        <h5 class="preview-title">DESCRIPCI&Oacute;N DE LA OFERTA</h5>
        <div data-name="oferta-desc">
          <?php echo Funciones::parseHtmlFormat($o['oferta_descrip']); ?>
        </div>
      </div>
      <div class="preview-pane">
        <h5 class="preview-title">TIPO DE EMPLEO Y REMUNERACI&Oacute;N</h5>
        <ul class="unstyled">
          <li>
            <span><?php echo htmlentities($d['tipo_empleo']); ?></span>
          </li>
          <li><strong>Sueldo:</strong><span><?php echo $o['sueldo']; ?></span></li>
        </ul>
        <ul class="unstyled" data-name='oferta-prestaciones'>
        </ul>
      </div>
      <?php if((int)$o['oferta_privada'] !== 1) : ?>
        <div class="preview-pane">
          <h5 class="preview-title">DATOS DE CONTACTO</h5>
          <div>
            <p>
              <strong><?php echo __('Nombre:'); ?></strong>
              <span data-value><?php echo htmlentities($c['nombre']); ?></span>
            </p>
            <p>
              <strong><?php echo __('Correo Electrónico:') ?></strong>
              <span data-email><?php echo htmlentities($c['cu_sesion']); ?></span>
            </p>
            <p>
              <strong><?php echo __('Teléfono:') ?></strong>
              <span data-tel><?php echo htmlentities($c['telefono']); ?></span>
            </p>
          </div>
        </div>
      <?php endif; ?>
  
  </div>
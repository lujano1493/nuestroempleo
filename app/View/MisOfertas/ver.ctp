<?php
  $o = $oferta['Oferta'];
  $d = $oferta['Catalogo'];
  $c = $oferta['UsuarioEmpresa'];
?>
<div class="preview" id="oferta-preview">
  <h1 class="title"><?php echo __('Oferta'); ?></h1>
  <?php
    // echo $this->element('empresas/ofertas/actions', array(
    //   'status' => isset($status) ? $status : 0,
    //   'options' => array(
    //     'btn-size' => 'sm'
    //   ),
    //   'actions' => array(
    //     'exclude' => array('preview', 'cancel')
    //   )
    // ));
  ?>
  <div class="row">
    <div class="col-xs-9 preview-content">
      <div class="header clearfix">
        <div class="img-container pull-right" style="position:relative;">
          <?php
            $imgUrl = (int)$o['oferta_privada'] === 1
              ? '/img/oferta/img_oferta_priv.jpg'
              : '/documentos/empresas/' . $o['cia_cve'] . '/logo.jpg';

            echo $this->Html->image($imgUrl, array(
              'alt' => 'Logo Oferta',
              'class' => 'logo',
              'id' => 'img',
              'style' => 'margin: 10px 10px 0 0',
              'width' => 200,
            ));
          ?>
        </div>
        <h5><?php echo $o['puesto_nom']; ?></h5>
        <h6>
          <span><?php echo $oferta['Direccion']['ciudad']; ?></span>, <span><?php echo $oferta['Direccion']['estado']; ?></span>
        </h6>
        <?php
//         sueldo8,001 - ,000 M.N.
// tipoTiempo Completo

        ?>
      </div>
      <div class="preview-pane">
        <h5 class="preview-title"><?php echo __('REQUISITOS'); ?></h5>
        <ul class="list-unstyled">
          <li>
            <strong><?php echo __('Experiencia:'); ?></strong>
            <span><?php echo $d['experiencia']; ?></span>
          </li>
          <li>
            <strong><?php echo __('Escolaridad:'); ?></strong>
            <span><?php echo $d['escolaridad']; ?></span>
          </li>
          <li>
            <strong><?php echo __('Género:'); ?></strong>
            <span><?php echo $d['genero']; ?></span>
          </li>
          <li>
            <strong><?php echo __('Estado Civil:'); ?></strong>
            <span><?php echo $d['edocivil']; ?></span>
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
          <?php echo $o['oferta_descrip']; ?>
        </div>
      </div>
      <div class="preview-pane">
        <h5 class="preview-title">TIPO DE EMPLEO Y REMUNERACI&Oacute;N</h5>
        <ul class="unstyled">
          <li>
            <span><?php echo $d['tipo_empleo']; ?></span>
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
              <span data-value><?php echo $c['nombre']; ?></span>
            </p>
            <p>
              <strong><?php echo __('Correo Electrónico:') ?></strong>
              <span data-email><?php echo $c['cu_sesion']; ?></span>
            </p>
            <p>
              <strong><?php echo __('Teléfono:') ?></strong>
              <span data-tel><?php echo $c['telefono']; ?></span>
            </p>
          </div>
        </div>
      <?php endif; ?>
    </div>
    <div class="col-xs-3">
      <div class="sidebar">
        <p>
          Cuando la vacante se publique, podrás compartirla con el enlace que se generará.
          <?php
            $shortLink = $o['oferta_link'];

            if (empty($shortLink)) {
              $shortLink = 'http://goo.gl/UCVF3L'; // www.nuestroempleo.com.mx
            }

            echo $this->Html->link($shortLink, $shortLink, array(
              'target' => '_blank'
            ));
          ?>
        </p>
        <p class="social">
          <a class="social-icon facebook" href="https://www.facebook.com/NuestroEmpleo" target="_blank" ></a>
          <a class="social-icon linkedin" href="http://mx.linkedin.com/company/nuestro-empleo" target="_blank"></a>
          <a class="social-icon twitter" href="https://twitter.com/NuestroEmpleo" target="_blank"></a>
          <a class="social-icon googleplus" href="https://plus.google.com/111610607829310871158/posts" target="_blank"></a>          
        </p>
      </div>
    </div>
  </div>
  <!-- <p><strong>FECHA DE PUBLICACI&Oacute;N</strong><?php echo date('d/m/Y'); ?></p> -->
</div>
<div class="preview slidemodal" data-slide-from="right" id="oferta-preview">
  <a class="close" href="#" data-close="slidemodal">&times;</a>
  <div class="slidemodal-dialog only-slidemodal-body">
    <div class="slidemodal-body">
      <div class="container">
        <h1 class="title"><?php echo __('Vista Previa'); ?></h1>
        <?php
          echo $this->element('empresas/ofertas/actions', array(
            'status' => isset($status) ? $status : 0,
            'options' => array(
              'btn-size' => 'sm',
            ),
            'actions' => array(
              'disabled' => !empty($isNew) ? array('publish','share','save','pause','delete') : array(),
              'exclude' => array('preview', 'cancel')
            )
          ));
        ?>
        <div class="row">
          <div class="col-xs-7 col-md-offset-1 preview-content">
            <div class="header clearfix">
              <div class="img-container pull-right" style="position:relative;">
                <?php
                  echo $this->Html->image($this->Session->read('Auth.User.Empresa.logo'), array(
                    'alt' => 'Mi logotipo',
                    'class' => 'logo',
                    'id' => 'img',
                    'style' => 'margin: 10px 10px 0 0',
                    'width' => 200,
                  ));

                  echo $this->Html->image('/img/assets/img_oferta_priv.jpg', array(
                    'alt' => 'Oferta Privada',
                    'class' => 'logo',
                    'data-name' => 'oferta-privada',
                    'id' => 'img',
                    'style' => 'margin: 10px 10px 0 0; top: 0; right: 0; position: absolute; height:120px;',
                    'width' => 200,
                  ));
                ?>
              </div>
              <h5 data-name='oferta-title'>El t&iacute;tulo va aqu&iacute;</h5>
              <h6><span data-name='oferta-estado'></span>, <span data-name='oferta-ciudad'></span></h6>
            </div>
            <div class="preview-pane">
              <h5 class="preview-title"><?php echo __('REQUISITOS'); ?></h5>
              <ul class="list-unstyled">
                <li><strong><?php echo __('Experiencia:'); ?></strong><span data-name='oferta-experiencia'></span></li>
                <li><strong><?php echo __('Escolaridad:'); ?></strong><span data-name='oferta-escolaridad'></span></li>
                <li><strong><?php echo __('Género:'); ?></strong><span data-name='oferta-genero'></span></li>
                <li><strong><?php echo __('Estado Civil:'); ?></strong><span data-name='oferta-estado-civil'></span></li>
                <li>
                  <strong><?php echo __('Edad:'); ?></strong>
                  <span data-name='oferta-edadmin'></span>-<span data-name='oferta-edadmax'></span>
                </li>
                <li><strong><?php echo __('Disponibilidad:'); ?></strong><span data-name='oferta-disponibilidad'></span></li>
                <li data-name='oferta-disponibilidad-viajar'>
                  <strong>Disponibilidad para Viajar</strong>
                </li>
                <li data-name='oferta-disponibilidad-residencia'>
                  <strong>Disponibilidad para cambiar de residencia</strong>
                </li>
              </ul>
            </div>
            <div class="preview-pane">
              <h5 class="preview-title">DESCRIPCI&Oacute;N DE LA OFERTA</h5>
              <div data-name="oferta-desc">
                Aquí va la descrición
              </div>
            </div>
            <div class="preview-pane">
              <h5 class="preview-title">TIPO DE EMPLEO Y REMUNERACI&Oacute;N</h5>
              <ul class="unstyled">
                <li><span data-name='oferta-tipo-empleo'></span></li>
                <li><strong>Sueldo:</strong><span data-name='oferta-sueldo'></span></li>
              </ul>
              <ul class="unstyled" data-name='oferta-prestaciones'>
              </ul>
            </div>
            <div class="preview-pane" data-name='oferta-datos-contacto'>
              <h5 class="preview-title">DATOS DE CONTACTO</h5>
              <div data-name="oferta-user-info">
                <p><strong><?php echo __('Nombre:'); ?></strong><span data-value></span></p>
                <p><strong><?php echo __('Correo Electrónico:') ?></strong><span data-email></span></p>
                <p><strong><?php echo __('Teléfono:') ?></strong><span data-tel></span></p>
              </div>
            </div>
          </div>
          <div class="col-xs-3">
            <div class="sidebar">
              <p>
                Cuando la vacante se publique, podrás compartirla con el enlace que se generará.
                <?php
                  if (empty($shortLink)) {
                    $shortLink = 'http://goo.gl/UCVF3L'; // www.nuestroempleo.com.mx
                  }

                  echo $this->Html->link($shortLink, $shortLink, array(
                    'target' => '_blank'
                  ));
                ?>
              </p>
              <p class="social">
                <a class="social-icon facebook" href=""></a>
                <a class="social-icon linkedin" href=""></a>
                <a class="social-icon twitter" href=""></a>
                <a class="social-icon googleplus" href=""></a>
                <a class="social-icon youtube" href=""></a>
              </p>
            </div>
          </div>
        </div>
        <!-- <p><strong>FECHA DE PUBLICACI&Oacute;N</strong><?php echo date('d/m/Y'); ?></p> -->
      </div>
    </div>
  </div>
</div>
<?php
  echo $this->element('admin/title'); 
  $o = $oferta['Oferta'];
  $cat = $oferta['Catalogo'];
  $c = $oferta['UsuarioEmpresa'];
?>

<div class="row">
  <div class="col-xs-9">
    <?php  foreach( $denuncia as $key=> $value ) :
      $d = $value['Reportar'];
    ?>    
  
      <div class="well well-sm">
        <ul class="list-unstyled">
          <li><?php echo __('Fecha de Reporte: <strong>%s</strong>', $this->Time->dt($d['created'])); ?></li>
          <li><?php echo __('Quién Reporta: <strong>%s</strong>', $d['candidato_nombre']); ?></li>
          <li><?php echo __('Datos de Contacto: <strong>%s</strong>, <strong>%s</strong>', $d['candidato_tel'] ? $d['candidato_tel']:'N/D' ,
           $d['candidato_telmovil'] ? $d['candidato_telmovil']:'N/D'); ?>
         </li>
          <li><?php echo __('Email: <strong>%s</strong>', $d['candidato_correo']); ?></li>
          <li><?php echo __('Motivo de Reporte: <strong>%s</strong>', $d['causa']); ?></li>
        </ul>
        <blockquote>
          <?php echo ($d['detalles'] ?: __('Sin detalles')); ?>
        </blockquote>
      </div>

    <?php  endforeach;?>
    <div class="alert alert-info alert-dismissable fade in popup" data-alert="alert">
      A continuación se muestra la oferta Reportada, por favor, analícelo detalladamente.
    </div>
    <h5 class="subtitle">
      <i class="icon-user"></i><?php echo __('Oferta'); ?>
    </h5>
    <div class="row preview">
      <div class="col-xs-12 preview-content">
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
        </div>
        <div class="preview-pane">
          <h5 class="preview-title"><?php echo __('REQUISITOS'); ?></h5>
          <ul class="list-unstyled">
            <li>
              <strong><?php echo __('Experiencia:'); ?></strong>
              <span><?php echo $cat['experiencia']; ?></span>
            </li>
            <li>
              <strong><?php echo __('Escolaridad:'); ?></strong>
              <span><?php echo $cat['escolaridad']; ?></span>
            </li>
            <li>
              <strong><?php echo __('Género:'); ?></strong>
              <span><?php echo $cat['genero']; ?></span>
            </li>
            <li>
              <strong><?php echo __('Estado Civil:'); ?></strong>
              <span><?php echo $cat['edocivil']; ?></span>
            </li>
            <li>
              <strong><?php echo __('Edad:'); ?></strong>
              <span><?php echo $o['oferta_edadmin']; ?></span>-<span><?php echo $o['oferta_edadmax']; ?></span>
            </li>
            <li>
              <strong><?php echo __('Disponibilidad:'); ?></strong>
              <span><?php echo $cat['disponibilidad']; ?></span>
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
              <span><?php echo $cat['tipo_empleo']; ?></span>
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
    </div>
  </div>
  <div class="col-xs-3">
    <div class="btn-actions">
      <?php      
           echo $this->Html->link(__('Imprimir'), array(
              "prefix" =>"admin",
              "controller" => "denuncias",
              "action" => "reporte",
              "id" => $oferta['Oferta']['oferta_cve'],
              "slug" =>"oferta",
              "ext" =>"pdf"
          ), array(
          'class' => 'btn btn-purple btn-block',
          'target' =>"_blank",
          'icon' => 'print'
        ));
        echo $this->element("admin/denuncias/status",array(
              "it" => array( "id" =>  $oferta['Oferta']['oferta_cve'] ,
                             "status" => $denuncia[0]['Reportar']['status'],
                             "slug" =>   Inflector::slug('oferta', '-') . '-' . $oferta['Oferta']['oferta_cve'],
                             "tipo" => "oferta"
                             )
          ));
     
      ?>
    </div>
    <?= $this->Html->back()?>
      <?=$this->element("admin/denuncias/anotacion",array(
          "tipo" =>$tipo,
          "anotacionId" =>  $oferta['Oferta']['oferta_cve']
      ))?>
  
  </div>
</div>
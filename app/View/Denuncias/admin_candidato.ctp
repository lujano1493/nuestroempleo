<?php
  echo $this->element('admin/title');  
 
?>

<div class="row">
  <div class="col-xs-9">

    <?php foreach  ( $denuncia as $key => $value ):  
          $d = $value['Denuncia'];
          $u = $value['UsuarioEmpresa'];
          $uc = $u['Contacto'];
          $usuarioNombre = implode(' ', array(
            $uc['con_nombre'], $uc['con_paterno'], $uc['con_materno']
          ));
          $usuarioTel = __('%s ext: %s', $uc['con_tel'] ? $uc['con_tel']:'N/D', $uc['con_ext'] ?: 'N/D');
    ?>
    <div class="well well-sm">
      <ul class="list-unstyled">
        <li><?php echo __('Fecha de Reporte: <strong>%s</strong>', $this->Time->dt($d['created'])); ?></li>
        <li><?php echo __('Quién Reporta: <strong>%s</strong>', $usuarioNombre); ?></li>
        <li><?php echo __('Datos de Contacto: <strong>%s</strong>', $usuarioTel); ?></li>
        <li><?php echo __('Email: <strong>%s</strong>', $u['cu_sesion']); ?></li>
        <li><?php echo __('Motivo de Reporte: <strong>%s</strong>', $d['motivo_texto']); ?></li>
      </ul>
      <blockquote>
        <?php echo $d['detalles']; ?>
      </blockquote>
    </div>
  <?php  endforeach;?>
     <div class="alert alert-info alert-dismissable fade in popup" data-alert="alert">
       A continuación se muestra el CV Reportado, por favor, analícelo detalladamente.
    </div>
    <h5 class="subtitle">
      <i class="icon-user"></i><?php echo __('Perfil del Candidato'); ?>
    </h5>
    <div id="profile" class="row">
      <div class="col-xs-12 searchable">
          <?php
              echo $this->element('common/candidato_perfil', array(
                'candidato' => $candidato
              ));
            ?>
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
              "id" => $candidato['CandidatoEmpresa']['candidato_cve'],
              "slug" =>"candidato",
              "ext" =>"pdf"
              
          ), array(
          'class' => 'btn btn-purple btn-block',
          'target' =>"_blank",
          'icon' => 'print'
        ));


        echo $this->element("admin/denuncias/status",array(
              "it" => array( "id" =>  $candidato['CandidatoEmpresa']['candidato_cve'] ,
                             "status" => $denuncia[0]['Denuncia']['denuncia_status'],
                             "slug" =>   Inflector::slug('candidato', '-') . '-' . $candidato['CandidatoEmpresa']['candidato_cve'],
                             "tipo" => "cv"
                             )
          ));

       
      ?>
    </div>

    <?= $this->Html->back()?>
     <?=$this->element("admin/denuncias/anotacion",array(
      "tipo" =>$tipo,
      "anotacionId" =>  $candidato['CandidatoEmpresa']['candidato_cve']
      ))?>
  </div>
</div>


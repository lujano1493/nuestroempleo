<html>
  <head>
    <?php
    header('Content-Type: text/html; charset=ISO-8859-1');
    ?>

    <style type="text/css">

    body {
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-size: 14px;
        line-height: 1.428571429;
        color: #333333;
        background-color: #fff;
      }
    .well {
          min-height: 20px;
          padding: 19px;
          margin-bottom: 20px;
          background-color: #f5f5f5;
          border: 1px solid #e3e3e3;
          border-radius: 0;
          -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.05);
          box-shadow: inset 0 1px 1px rgba(0,0,0,0.05);
          }

          .list-unstyled {
            padding-left: 0;
            list-style: none;
            }

            .well blockquote {
              border-color: #ddd;
              border-color: rgba(0,0,0,0.15);
              }
              blockquote {
              padding: 10px 20px;
              margin: 0 0 20px;
              border-left: 5px solid #eeeeee;
              }

              small{
                  font-style: italic;
              }
              .title {
                border-bottom: #ccc solid thin;
                color: #5f81ab;
                font-style: italic;
            /*    font-size: 18px;*/
                line-height: 1;
                text-align: center;
                margin: 10px 0;
                padding: 0px 0 10px;
              }

              .panel-heading {
              color: #333333;
              background-color: #f5f5f5;
              border-color: #ddd;
              }

              .panel {
                position: relative;
                }
                .panel-default {
                border-color: #ddd;
              }

              .nota{
                         background-color: #F0F8FF;
                font-style: normal;
                color: #2f4f4f;
              }
             

    </style>
  </head>

  <body>

        <h1 class="title">
           </i><?php echo __('DENUNCIA DE CANDIDATO'); ?>
         </h1>
      
    <div class="denuncias">
      <?php foreach  ( $denuncia as $key => $value ):  
      $d = $value['Denuncia'];
      $u = $value['UsuarioEmpresa'];
      $uc = $u['Contacto'];
      $usuarioNombre = implode(' ', array(
        htmlentities($uc['con_nombre']), htmlentities($uc['con_paterno']), htmlentities($uc['con_materno'])
        ));
      $usuarioTel = __('%s ext: %s', $uc['con_tel'] ? $uc['con_tel']:'N/D', $uc['con_ext'] ?: 'N/D');
      ?>
      <div class="well well-sm">
        <ul class="list-unstyled">
          <li><?php echo __('Fecha de Reporte: <strong>%s</strong>', $this->Time->dt($d['created'])); ?></li>
          <li><?php echo __('Qui'.htmlentities("é").'n Reporta: <strong>%s</strong>', htmlentities($usuarioNombre)); ?></li>
          <li><?php echo __('Datos de Contacto: <strong>%s</strong>', $usuarioTel); ?></li>
          <li><?php echo __('Email: <strong>%s</strong>', $u['cu_sesion']); ?></li>
          <li><?php echo __('Motivo de Reporte: <strong>%s</strong>', htmlentities($d['motivo_texto'])); ?></li>
        </ul>
        <blockquote>
          <?php echo htmlentities($d['detalles']); ?>
        </blockquote>
      </div>
    <?php  endforeach;?>
   
    
    </div>
    <h3 class="title">
           </i><?php echo __('Anotaciones'); ?>
    </h3>
    <div class="row">  
    <?php
          $tipo=array(1=>"candidato",0=>"oferta");
         if(!empty($anotaciones)) { ?>
        <ul id="lista-anotaciones" class="list-unstyled">
          <?php foreach ($anotaciones as $k => $v) { 
              $v=$v['NotaDenuncia'];
              $s=$tipo[$v['anotacion_tipo']];
            ?>
            <li class="nota well well-sm">            
              <div class="content">
                <?php echo htmlentities($v['anotacion_detalles']);?>
              </div>
              <p class="text-right">
                <small>
                  <?php echo $this->Time->dt($v['created']); ?>
                </small>
              </p>
                <input type="hidden" data-id="<?=$v['anotacion_cve']?>"  data-texto="<?=$v['anotacion_detalles']?>"   class="data"  >    
            </li>
          <?php } ?>
        </ul>
      <?php } else { ?>
        <p class="empty">No hay anotaciones. </p>
      <?php } ?>
  </div>

       <h3 class="title">
           </i><?php echo __('Curriculum'); ?>
    </h3>

      <div class="row">
          
           <?=$this->element("empresas/pdf/curriculum")?>        
      </div>

  

  </body>

</html>
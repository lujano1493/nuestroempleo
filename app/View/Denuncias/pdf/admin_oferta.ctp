<html>
  <head>
    <?php
    header('Content-Type: text/html; charset=ISO-8859-1');
    ?>

    <style type="text/css">

  body {     
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
      font-family: 'Open Sans', Helvetica, Arial, sans-serif;
      font-size: 13px;
      overflow-x: auto;
      overflow-y: scroll;
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
      
      img {
        vertical-align: middle;
        border: 0;
      }
      .pull-right {
        float: right ;
        }


        .preview-pane {
        padding-right: 10px;
        text-align: left;
        }
       .preview-title {
          background-color: #e7e4e4;
          color: #5d5d5d;
          font-size: 13px;
          line-height: 1;
          margin-top: 10px;
          padding: 10px;
          text-transform: uppercase;
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
           </i><?php echo __('DENUNCIA DE OFERTA'); ?>
         </h1>
      
    <div class="denuncias">
			   <?php  foreach( $denuncia as $key=> $value ) :
			      $d = $value['Reportar'];
			    ?>    
			  
			      <div class="well well-sm">
			        <ul class="list-unstyled">
			          <li><?php echo __('Fecha de Reporte: <strong>%s</strong>', $this->Time->dt($d['created'])); ?></li>
			          <li><?php echo __('Qui'.htmlentities('é').'n Reporta: <strong>%s</strong>', htmlentities($d['candidato_nombre'])); ?></li>
			          <li><?php echo __('Datos de Contacto: <strong>%s</strong>, <strong>%s</strong>', $d['candidato_tel'] ? $d['candidato_tel']:'N/D' ,
			           $d['candidato_telmovil'] ? $d['candidato_telmovil']:'N/D'); ?>
			         </li>
			          <li><?php echo __('Email: <strong>%s</strong>', $d['candidato_correo']); ?></li>
			          <li><?php echo __('Motivo de Reporte: <strong>%s</strong>', htmlentities($d['causa'])); ?></li>
			        </ul>
			        <blockquote>
			          <?php echo (htmlentities($d['detalles']) ?: htmlentities(__('Sin detalles'))); ?>
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
           </i><?php echo __('Oferta'); ?>
    </h3>

      <div class="row">
        <?=$this->element("empresas/pdf/oferta")?>
    
      </div>

  

  </body>

</html>
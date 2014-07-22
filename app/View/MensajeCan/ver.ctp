<?php
  $m = $mensaje['Mensaje'];
  $label="";
  if(array_key_exists('Emisor',$mensaje)  ){
     $e =  $mensaje['Emisor'] ;
     $label=$e['nombre'];

  }
  else{

         if(!empty($mensaje['ReceptorEmpresa']) ){

            foreach ($mensaje['ReceptorEmpresa'] as $key => $value) {
                   $label.="<p> ".$value['Cuenta']['nombre'];
            }
         }
         if ( !empty($mensaje['ReceptorCandidato'])  ){
              foreach ($mensaje['ReceptorCandidato'] as $key => $value) {
                     $label.="<p> ".$value['Cuenta']['email'] ." <span class='badge badge-info'> Candidato </span>  </p> ";
              }

         }




  }

?>
<div class="container">
   <div class="forma_genral_tit"><h2>Ver Mensaje</h2></div>

 </div>

<div class="container">
  <div class="alert-container clearfix">
    <div class="alert alert-info fade in popup" data-alert="alert">
      <i class="icon-info-sign icon-3x"></i>
      &nbsp;&nbsp;&nbsp;Revisa periódicamente este módulo, aquí te llegarán las notificaciones de los reclutadores como test, pruebas psicométricas, entrevistas, etc.
    </div>
  </div>
</div>

  <div class="span3 pull-left" style="margin-top:-14px;">
    <?=$this->element("candidatos/mensajes/menu")?>
  </div>
  <div class="span9 pull-left">



    <table class="table table-bordered table-striped table-hover">
      <thead class="table-fondo">
        <tr>
          <th colspan="9">Asunto: <?php echo $m['msj_asunto']; ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="strong">Remitente:</td>
          <td colspan="8"><?php echo $label; ?></td>
        </tr>
        <!--    <tr>
          <td class="strong">Datos adjuntos:</td>
          <td colspan="8"> o <a href="#">link de descarga</a></td>
        </tr> -->
        <tr>
          <td>
            <div class="btn-group">
              <?php
                echo $this->Html->link($tipo =='recibidos'?  'Responder':'Reenviar', array(
                  'controller' => 'MensajeCan',
                  'action' => $tipo == 'recibidos' ? 'responder' : 'reenviar',
                  'id' => $tipo =='recibidos'? $mensaje['MensajeData']['receptormsj_cve'] : $m['msj_cve']
                ), array(
                  'icon' => 'share-alt',
                  'class' => 'btn'
                ));
              ?>
            </div>
          </td>
          <td colspan="8">
            <div class="btn-group">
   <!--              <button title="Reenviar" class="btn btn-small tooltip_bajo"><i class="icon-reply"></i></button>
            <button title="Guardar mensaje" class="btn btn-small tooltip_bajo"><i class="icon-save"></i></button>
              <button title="Borrar mensaje" class="btn btn-small tooltip_bajo"><i class="icon-remove"></i> </button>
              <button title="Archivar mensaje" class="btn btn-small tooltip_bajo"> <i class="icon-folder-open-alt"></i></button>
              <button title="Marcar mensaje" class="btn btn-small tooltip_bajo"> <i class="icon-flag"></i> </button>  -->
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="9" class="center" style="height:200px;">
            <?php echo $m['msj_texto']; ?>
          </td>
        </tr>
      </tbody>
    </table>

  </div>

   <div class="span12">
    <div class="row">
            <div style="margin-top:80px;"><img id="img" src="/img/publicidad/publicidad-horizontal_msj.jpg"  class="img-polaroid"></div>
            <!--<div class="pull-right span4" style="margin-bottom:5px;"><img src="/img/publicidad/publicidad-vertical.jpg" width="167" height="191" class="img-polaroid"></div>
            </div>-->
  </div>

</div>


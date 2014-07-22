<div class="container">
                 <div class="forma_genral_tit"><h2>Mis Mensajes</h2></div>
      
            </div>
            

<div class="container">
      <div class="alert-container clearfix">
    <div class="alert alert-info fade in popup" data-alert="alert">
      <i class="icon-info-sign icon-3x"></i>
      &nbsp;&nbsp;&nbsp;Revisa periódicamente este módulo, aquí te llegarán las notificaciones de los reclutadores como test, pruebas psicométricas, entrevistas, etc.
    </div>
  </div>
   <div class="span3 pull-left" style="margin-top:-14px;">
    <?=$this->element("candidatos/mensajes/menu")?>
  </div>
  <div class="span9 pull-left">


<table id="mensajes-table" class="table table-striped table-bordered" data-component="dynamic-table">
  <thead>
    <tr class="table-fondo" >
      <th colspan="6">
        <div class="pull-left">
          <div class="tabla-link"><h5>Eliminados</h5></div>
        </div>
        <div class="pull-right" id="filters"></div>
      </th>
    </tr>
    <tr style="background-color:#f8f8f8">
      <th data-table-prop="#tmpl-emisor"  >Remitente</th>
      <th data-table-prop="#tmpl-asunto" >Asunto</th>
      <th data-table-prop="#tmpl-fecha" data-order="desc" >Fecha y hora</th>
      <th data-table-prop="#tmpl-eliminados-actions"   >Acciones</th>
    </tr>
  </thead>
  <tbody>
  

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

<?php
  echo( $this->Template->insert(array(
    'fecha',
    'emisor',
    'contenido',
    'responder',
    'asunto',
    'eliminados_actions'
  ),  array("eliminados" => true  )));
?>
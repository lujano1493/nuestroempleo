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
    <tr  >
      <th  class="table-fondo" colspan="6">
        <div class="pull-left">
          <div class="tabla-link"><h5><?=$title_for_layout?></h5></div>
        </div>
        <div class="pull-right" id="filters"></div>
      </th>
    </tr>
    <tr >
     <!--  <th data-table-prop=":input"><input type="checkbox"></th> -->
      <th data-table-prop="#tmpl-emisor">Remitente</th>
      <th data-table-prop="#tmpl-asunto">Asunto</th>
      <th data-table-prop="#tmpl-fecha" data-order="desc">Fecha y hora</th>
      <th data-table-prop="#tmpl-actions">Acciones</th>
    </tr>
  </thead>
  <tbody class="table-body">
   
  </tbody>
</table>
  </div>

  <div class="span12">
    <div class="row">
            <iframe src="/anuncios/banner_mensajes.html" height="100%" width="100%" style="margin-top:50px;" scrolling="no" marginheight="0" marginwidth="0" frameborder="0"></iframe>
  </div>
 
</div>
</div>
<?php
  echo( $this->Template->insert(array(
    'fecha',
    'emisor',
    'contenido',
    'responder',
    'asunto',
    'actions'
  )));
?>
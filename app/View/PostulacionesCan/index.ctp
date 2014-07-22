

<div class="container">
  <div class="forma_genral_tit"><h2>Mis Postulaciones</h2></div>
      
  <div class="alert alert-info fade in popup" data-alert="alert">
    <i class="icon-info-sign icon-3x"></i>&nbsp;&nbsp;&nbsp;
      Aquí están registradas las vacantes a las que te has postulado, accede para ver tu historial y da seguimiento a tu proceso de selección.</div>      


  <div class="row">
    <?= $this->element("candidatos/datos_candidato")?>
      <div class="span9">

<table id="postula-table" class="table table-striped table-bordered" data-component="dynamic-table" width="100%"  data-source-url="<?=
  $this->Html->url(array("controller"=>"postulacionesCan" , "action" =>"postulaciones"))?>"   >
  <thead>
    <tr  id="postula-tr">
      <th class="table-fondo" colspan="6">
        <div class="pull-left">
          <div class="tabla-link"><h5>Postulaciones</h5></div>
        </div>
        <div class="pull-right" id="filters"></div>
      </th>
    </tr>
    <tr style="background-color:#f8f8f8">
      <th data-table-prop="#tmpl-puesto" width="40%">Puesto</th>
      <th data-table-prop="#tmpl-empresa" width="30%">Empresa</th>
      <th data-table-prop="#tmpl-fecha" width="10%">Fecha</th>
      <th data-table-prop="#tmpl-status" width="10%">Status</th>
      <th data-table-prop="#tmpl-action" width="10">Acción</th>
    </tr>
  </thead>
  <tbody id="table-body">
  
  </tbody>
</table>
<div class="articulos_interes">
<div class="span1">&nbsp;</div>
<div class="span1">&nbsp;</div>
<?php  
  $articulos= ClassRegistry::init("WPPost")->articulos_liga(3);
?>              
          <?php
           foreach ($articulos as $key => $articulo):
           ?>

          <?=$this->element("candidatos/articulo",array("value"=>$articulo,"pull" =>"pull-left",  "span" => "span3_2" ) ) ?>
          <?php endforeach;?>
</div>
  </div>


  </div>

<?php
  echo( $this->Template->insert(array(
    'action',
    'fecha',
    'status',
    'empresa',
    'puesto'
  )));
?>



</div>



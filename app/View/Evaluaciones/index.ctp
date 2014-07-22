<div class="container">
                 <div class="forma_genral_tit"><h2>Mis Evaluaciones</h2></div>

<div class="alert alert-info fade in popup" data-alert="alert">
    <i class="icon-info-sign icon-3x"></i>&nbsp;&nbsp;&nbsp;
     En esta sección se encuentran las pruebas de conocimiento y/o psicométricas que haz aplicado o tienes pendientes. Éstas últimas tienen vigencia de 6 meses.</div>      

</div>
            

<!--<div class="container">
  <div class="span12 pull-left left tabular"><a href="#" title="Recuerda que las evaluaciones psicométricas tienen una vigencia de 6 meses." data-component="tooltip" data-placement="bottom"><i class="icon-info-sign icon-3x"></i></a>

  </div>
  <div class="span12 pull-left">-->

  <div class="row">
    <?= $this->element("candidatos/datos_candidato")?>
      <div class="span9">
        <div class="row">
         <table class="table table-striped table-bordered table-hover" width="100%"  
         data-source-url="<?=$this->Html->url(array("controller" =>"Evaluaciones","action"=> "evaluaciones" ))?>" 
         data-component="dynamic-table">
            <thead>
              <tr class="table-fondo">
                <th colspan="6">
                  <div class="pull-left">
                    <div class="tabla-link"><h5>Evaluaciones</h5></div>
                  </div>
                  <div class="pull-right" id="filters"></div>
                </th>
              </tr>
              <tr style="background-color:#f8f8f8">
               <!-- <th data-table-prop=":input"><input type="checkbox"></th>-->
                <th data-table-prop="nombre">Evaluación</th>
                <th data-table-prop="nombre_empresa">Requerida por</th>
                <th data-table-prop="#tmpl-fecha-solicitud" >Solicitado</th>
                <th data-table-prop="#tmpl-fecha-realizado" data-order="desc" >Realizado</th>
                <th data-table-prop="#tmpl-status">Status</th>
                <th data-table-prop="#tmpl-actions">Acciones</th>
              </tr>
            </thead>
            <tbody id="evalua-table">
            </tbody>
          </div>
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
  </div>
<div class="row">

 <?=$this->element("candidatos/eventos")?> 


  </div>


  <?php
  echo( $this->Template->insert(array(
    'actions',
    'status' ,
    'fecha_realizado',
    'fecha_solicitud'
  )));
?>
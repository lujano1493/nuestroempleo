
<?php  
    $data_conditions= array();

    foreach ($param_query as $key => $value) {
        $data_conditions[]=array("name"=>$key,"value" => $value );        
    }

?>
<div class="container">



    <!--criterios de busqueda-->
    <div class="span3">
      <?=$this->element("candidatos/postulacion/filtros",array( 
              "conditions" => $conditions ,
              "tipo_" => "ajax"
        ) ) ?>
      <div>

       <div class="span3">
        <div class="destacadas_candidato-title">
          <h4>Historial de búsqueda
          </h4>
        </div>

        <div class="candidato_historial">
                <?php 
                      $historial_busqueda_oferta=$this->Session->read("historial_busqueda_oferta") ;
                      $historial_busqueda_oferta =  $historial_busqueda_oferta  ? $historial_busqueda_oferta :array("datos"=> array());
                      $historial=$historial_busqueda_oferta['datos'];

                ?>
                <?php foreach($historial as $dato ) :?>
                <p class=" ellipsis" style="width:150px;"> 

                  <?=$this->Html->link($dato, array("controller" => "busquedaOferta" ,
                    "action" =>"index",
                    "?" => "dato=$dato"),array(
                      "data-component" => "tooltip",
                      "data-placement" => "bottom",
                      "title" => $dato
                    ))?>
                </p>

              <?php  endforeach; ?>
        </div>
       </div>

        <!-- eventos -->

        <div class="row">
          <?=$this->element("candidatos/eventos")?>
        </div>

      

        <!--articulos-->
        <div class="articulos_interes container">
          <?

          if($isAuthUser){
       
            $articulos= ClassRegistry::init("WPPost")->articulos_liga(1);

            if(!empty($articulos)){
              echo $this->element("candidatos/articulo",array("value"=>$articulos[0],"pull" =>"pull-left", "span" =>"span3_2" ) );  
            }
            

          }


          ?>

          <div class="left">        
           
         <?=$this->Html->tag("div","",array(
                "class" => "fb-like-box",
                "data-href" => "https://www.facebook.com/NuestroEmpleo",                
                "data-width" =>"250px",
                "data-colorscheme"=>"light",
                "data-show-faces"=>"true",
                "data-header" =>"true",
                "data-stream" =>"true",
                "data-show-border"=>"false"
              ))?>
          </div> 


        </div>
      </div>
    </div>
   
    <!-- ofertas -->
    <div class="span9 oferta_seleccionada" >


      <div id="main-conten-ofertas">


        <div class="row-fluid  short-height">

                  <div class="span12">
                        <div class="filtros-select">
                            
                            <?= $this->element("candidatos/filtro_seleccionado",array(
                                                                                        "data_conditions" =>$data_conditions,
                                                                                        "params_name"=> $params_name,
                                                                                        "is_empty" => empty($datos_agrupados)

                            )) ?>


                          
                        </div>
                  </div>

        </div>
  
                           

        <div class="row-fluid short-height">
           <?=$this->element("inicio/busqueda",array(
                                                    "extra_class" =>"" ,
                                                    "with_title" => false,
                                                    "param" =>$param_query
                                              ))?>        
        </div>

        
        <div id="result-empty-msg"  class="row-fluid  hide" >
            <div class="span12">
              No encontramos resultados en base a tú búsqueda, pero te sugerimos revisar estas ofertas:
            </div>

        </div>

        <div id="desplegables">       
              <div id="ofertas-distinguidas-content" data-component="carrusel" 
              data-type="flexslider" data-isajax="true" data-url="<?=$this->Html->url(array("controller" => "BusquedaOferta","action" => "destacadas") )?>" 
              data-template-id="#tmpl-oferta-distinguida" data-content-type="json" data-direction="vertical" 
              data-num-item-display="2" data-params-ini='<?=json_encode(array($param_query))?>' 
              data-paginate="true" data-limit="200"
              >

               <div class="forma_genral_tit center">
                  <h3>OFERTAS DISTINGUIDAS</h3>
                </div>
                <div id="carrusel-ofertas-distinguidas" class="flexslider">
                  
                       
                </div>
              </div>
              <div id="ofertas-recomendadas-content" data-component="carrusel" 
              data-type="flexslider" data-isajax="true" data-url="<?=$this->Html->url(array("controller" => "BusquedaOferta","action" => "recomendadas") )?>" 
              data-template-id="#tmpl-oferta-recomendada" data-content-type="json" 
              data-num-item-display="2" data-params-ini='<?=json_encode(array($param_query))?>' 
              data-paginate="true" data-limit="200" 
              >
                <div class="forma_genral_tit center">
                  <h3>OFERTAS RECOMENDADAS</h3>
                </div>
                <div id="carrusel-ofertas-recomendadas" class="flexslider">

                  
                       
                </div>
              </div> 




        </div>


      
       <div class="pull-right" style="width:100%">
            <table id="ofertas-table" class="table table-striped table-bordered " data-show-menu-length="[20]"  data-display-length="20"  data-server-side="true" data-table-role="main" 
            data-component="dynamic-table"   data-params-ini='<?=json_encode($data_conditions)?>' 
              data-source-url="<?=$this->Html->url(array("controller" => "BusquedaOferta","action" => "ofertas") )?>">
              <thead>
                <tr class="table-fondo">
                  <th colspan="6">
                    <div class="pull-left">

                    </div>
                    <div class="pull-right" id="filters"></div>
                  </th>
                </tr>
                <tr>
                  <!--  <th data-table-prop=":input"><input type="checkbox"></th> -->
                  <th data-table-prop="#tmpl-oferta"></th>
                </tr>
              </thead>
              <tbody>             
              </tbody>
            </table>

        </div>                                          
       
          
      </div>


    </div>


    <!-- publicidad lateral-->

<?php
  echo $this->Template->insert(array(
    'oferta',
    'filtro_select',
    'oferta_distinguida',
    'oferta_recomendada'
  ));
?>



  
</div>











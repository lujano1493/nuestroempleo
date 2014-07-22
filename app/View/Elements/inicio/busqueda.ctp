<?php 

  $class_form="";
  $class_inpu_search="input-large";
  $salarios=ClassRegistry::init('ExpLabSue')->lista();
  $pais_cve=1;
  $estados=ClassRegistry::init("Estado")->getlistaEstado($pais_cve );

  $model_catalogo=ClassRegistry::init("Catalogo");
  $escolaridad=$model_catalogo->get_list("NIVEL_ESCOLAR",array("Catalogo.opcion_valor >"=> 0 ));
  $dispo_empleo=$model_catalogo->get_list("DISPONIBILIDAD_EMPLEO");

  $categorias=ClassRegistry::init("Categoria")->lista();

  if($this->name =="Candidato"){
    $class_form= "buscador_index_candidatos";
  }

  $dias=$this->Html->create_options_fecha_publicacion();

  $dato= !empty($param) && array_key_exists("dato",$param) ? $param['dato']:"" ;


    $url=$this->name."/".$this->action;


    $arr_url=array(
                        "Candidato/index",
                        "BusquedaOferta/index"

      );


  $input_search_class=  in_array($url,$arr_url)  ? " input-large-candidatos input-large2" :"input-large ";

?>
          <?=$this->Form->create("Busqueda",array(
              'url' => $this->Html->url(
                  array(
                              'controller' => 'BusquedaOferta',
                              'action' => 'index'                                
                              )
                ) ,
              'type' => 'get',
              'class'=> "form-search pull-right $extra_class $class_form",              
              "data-component" => "searchavanced"

          )) ?>
              <fieldset>
                <legend>
              <?php  if ($with_title) :?>
               Encuentra tu Empleo ahora:
               <?php  endif;?>
               </legend>
              <div class="clearfix  panel-search">

                      <?=$this->Form->input("Busqueda.dato",array(

                                                                "class" => "buscador_alto $input_search_class search-query",
                                                                "label" => false,
                                                                "div" => false,
                                                                "data-param-name" => "dato",
                                                                "placeholder" =>"Ingresa tus palabras clave: Empresa, Ciudad, Estado, Sueldo ...",
                                                                "value"=> $dato,
                                                                "type" => "text"
                  )) ?>
                 <?=$this->Form->submit("Buscar",array(
                                                        "class" => "btn_color btn-large search-all",
                                                        "div" => false

              ))?>    
                <p class="help-block strong">
                  <a id="search-avanced-01" href="#" class="btn-slide pull-right search-btn-main">Búsqueda Avanzada
                  </a>
                </p>
              </div>    
              <!-- div despegable -->
              <div id="content" class="panel-advanced" style="display:none">
                <fieldset class="well form-search">

                  <div class="control-group">
                          <p class="help-block pull-left strong">
                            <a href="#"  class="btn-slide active" >
                              <i class="icon-minus-sign"></i>
                              Regresar a Búsqueda Rápida
                            </a>
                            <div class="span12 pull-left"><p class="pull-left">Seleccione uno o varios campos de búsqueda<br/></p></div>
                          </p>
                  </div>

              <div class=" span12">
              <?php 
                  $inputs=array(
                                  array(
                                          "Name" =>"Busqueda.b_nombre_empleo",                                          
                                          "label"=> "Empleo:",
                                          "class" => "param-name btn-small input-medium pull-right",
                                          "data-param-name" => "dato",
                                          "type" => "text"     
                                     ),
                                  array(
                                          "Name" =>"Busqueda.b_sueldo",  
                                          "label"=> "Salario:",
                                          "class" => "param-name btn-small input-medium pull-right",
                                          "data-param-name" => "sueldo",
                                          "empty" => "Seleccione ...",
                                          "options" => $salarios                                            
                                    ),
                                  array(
                                          "Name" =>"Busqueda.b_estado",     
                                          "label"=> "Estado:" ,
                                          "data-component"=> "sourcito",
                                          "data-source-autoload" => "1",
                                          "data-target-name"=>"busqueda-oferta-estado",
                                          "data-source-name" => "ciudades",                                       
                                          "empty" => "Seleccione ...",
                                          "class" => "btn-small input-medium pull-right",
                                          "options" => $estados                                        
                                    ),
                                  array(
                                          "Name" =>"Busqueda.b_ciudad", 
                                          "label"=> "Ciudad:" ,  
                                          "data-param-name" => "ciudad",
                                          "data-json-name" => "ciudades",
                                          "class" => "param-name btn-small input-medium pull-right",
                                          "empty" => "Seleccione ...",
                                          "options" => array(
                                                            )                                                       
                                    ),
                                     array(
                                          "Name" =>"Busqueda.b_tipoEmpleo",  
                                          "label"=> "Tipo:",
                                          "class" => "param-name btn-small input-medium pull-right",
                                          "data-param-name" => "tipo",
                                          "empty" => "Seleccione ...",
                                          "options" => $dispo_empleo                                            
                                    ),
                                    array(
                                          "Name" =>"Busqueda.b_escolaridad",  
                                          "label"=> "Escolaridad:",
                                          "class" => "param-name btn-small input-medium pull-right",
                                          "data-param-name" => "dato",
                                          "empty" => "Seleccione ...",
                                          "options" => $escolaridad                                            
                                    ),

                                    array(
                                          "Name" =>"Busqueda.b_categoria",  
                                          "label"=> "Área:",
                                          "class" => "param-name btn-small input-medium pull-right",
                                          "data-param-name" => "categoria",
                                          "empty" => "Seleccione ...",
                                          "options" => $categorias                                            
                                    ),



                                   array(                                         
                                          "Name" =>"Busqueda.b_fecha_publicacion", 
                                          "class" => "param-name btn-small input-medium pull-right",
                                          "data-param-name" => "publicacion",
                                          "label"=>"Publicación:",
                                          "empty" => "Seleccione ...",
                                          "options" => $dias                          
                                    )


                   );
              ?>

              <?php  foreach($inputs as $input  )  :?>
              <?php 
                $opciones=array(
                                            "div" => array( "class"=>"input control-group span5"),
                                            "label" => array( "class"=>"control-label btn-small pull-left",
                                                              "text" =>$input["label"] 
                                                            )


                                          );

                $array_key=array(
                            "type",
                            "options", 
                            "class",
                            "data-json-name",
                            "data-component",
                            "data-source-autoload",
                            "data-target-name",
                            "data-source-name",
                            "data-param-name",
                            "empty"

                  );

                foreach ($array_key as $key) {

                  if(array_key_exists($key,  $input ) ){                    
                    $opciones[$key]=$input[$key];                        

                  }
                  
                }


          

                ?>
  
                <?=$this->Form->input($input["Name"], $opciones  )?>
              <?php endforeach; ?>                                              
             </div>
             <div class="span12">
              <?=$this->Form->submit("Buscar",array(
                                                        "class" => "row btn search-avanced"
              ))?>

              </div>                
              </fieldset>
        </div>
                     </fieldset>
            <?=$this->Form->end() ?>

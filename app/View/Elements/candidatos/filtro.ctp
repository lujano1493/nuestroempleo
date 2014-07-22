   <?php 

$rs=$datos_agrupados;

$info=array(
   "oferta_sueldo" =>  array( "label"=>  "Sueldos","field_query" => "sueldo" ),

   "localidad" => array("arbol" => true  ,"label"=>  "Ubicación" ,"field_query_root" => "estado" ,"field_query" => "ciudad"  ),
   "categoria" => array("arbol" => true ,"label" => "Categoria", "field_query_root" => "categoria",'field_query' =>'area' ),
   "tipo" =>  array(  "label"=>  "Tipo de Empleo" ),   
   "publicacion" =>array( "label"=>  "Fecha de publicación" ),
   // "genero" => array( "label" => "Género" ),
   // "estado" =>  array(  "label"=>  "Estado" ) ,
   // "categoria_nom" => array("label" =>  "Categoria" ,'field_query' =>'categoria' ),
   //  "area_nom" => array("label" => "Áreas",'field_query' =>'area' ),
              
   // "estado_civil" =>   array( "label"=>  "Estado Civil" )                  
   );

// $llave= array_key_exists($key_,$label ) ?  $label[$key_] : $key_; 

   ?>
   <?php  foreach ($info as  $field=> $array) :?> 
      <?php if (array_key_exists($field,$rs)) :?>
         <div class="filtro-grupo clearfix" data-component="acordeoncito">
            <div class="span3_2 center destacadas_candidato2_2_tit">
               <h5>
                  <?=$array['label']?>
               </h5>
            </div>
            <?php 
            $query_field= ( array_key_exists('field_query',$array ) ) ?   $array['field_query'] :$field;
            $index=0;
            ?>         

            <?php  foreach ( $rs[$field] as  $value => $data )  :?>
            <?php  
            if($index ==0  ){
               echo  "<div  class=\"primeros\" >";
            }
            ?>
            <?php  if (!array_key_exists ("arbol",$array) )  :?>
                <?=$this->element("candidatos/data_filtro",array(
                                                                     "value"=>$value,
                                                                     "data" => $data,
                                                                     "query_field"=>$query_field ,
                                                                     "is_parent" => false
                ))?>
             <?php  else :?>
               <div class="categoria-root">
                    <?=$this->element("candidatos/data_filtro",array(
                                                                     "value"=> str_replace("_",".",$data['name_parent']),
                                                                     "data" =>  $data['count'],
                                                                     "query_field"=>$array['field_query_root'] ,
                                                                     "is_parent" => true
                ))?>

                <?php  
                        $is_hide = array_key_exists($array['field_query'] ,$param_query) ||
                        array_key_exists($array['field_query_root'], $param_query)  ? "" :"hide"  ;
                ?>

                  <div class="sub-categoria <?=$is_hide?>" >
                        <?php foreach ($data['data'] as $name_sub => $count_sub) :?>

                                          <?=$this->element("candidatos/data_filtro",array(
                                                                                          "value"=> str_replace("_",".",$name_sub),
                                                                                          "data" => $count_sub,
                                                                                          "query_field"=>$array['field_query'] ,
                                                                                          "is_parent" => false
                                     ))?>



                        <?php  endforeach;?>
                  </div>
               </div>
            <?php    endif; ?>
        
            <?php  
            if($index == 2  ){
               echo  "</div> <div  class=\"ocultos hide\"  >";
            }

            $index++;
            ?>
         <?php  endforeach; ?>
         <?php
         if($index<2){
            echo "</div>";
         }
         else{
            echo "</div>"; 
         }
         ?>
         <?php if($index > 3):?>

         <div class="control span2_3" >  <a href="#">   <i class="icon-plus"></i>   Mostrar </a> </div> 
      <?php endif;?>
      </div>
   <?php endif; ?>
<?php  endforeach; ?>



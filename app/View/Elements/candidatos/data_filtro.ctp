



<?php  



   // $expresion=!array_key_exists($query_field,$param_query) ;
    $expresion=true;
    $class_base=  !$is_parent      ?   "filtro" :"parent-filtro";

    $icon=  $is_parent ?  "hand-right"     :($expresion ?   "hand-right" : "remove") ;
    $extra_class=  $expresion || $is_parent  ?  ""  :"filtro-select";
    $data_option=  $is_parent ? "" :($expresion ?  "concat":"remove");

    if($query_field=='publicacion' ){
                  $value= $this->Html->formato_fecha_publicacion_code($value);

        }

    $href=  !$expresion  || $is_parent ? "#":$this->Html->url(array("controller" => "busquedaOferta" , "action" => "index" ,"?" => "$query_field=$value"));


?>

<div class="clearfix without-space" style="text-align:left">

  <div class="span2_2 destacadas_candidato2_2"  data-component="tooltip" data-placement="bottom" title="<?=$value?>"  >
    <p  class="ellipsis"   style="width:150px" >
        <i class=" icon-<?=$icon?>">
        </i>    
    


        <a class="filtro <?=$extra_class?>"  data-field-query="<?=$query_field?>"  data-value-query="<?=$value?>"  data-option="<?=$data_option?>" href="<?=$href?>" >
            <?=$value?>
        </a>
   
    </p>
  </div>
  <div class="span1_2 pull-right">
    <span class="badge">
        <?=$data ?> 
    </span>
  </div>
  
</div>    

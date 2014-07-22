 <!-- avisos y publicidad -->
<?php  
  $articulos = array(
      array("src" => "/img/articulos/10.jpg","title" =>"¿Cómo ser un empleado de 10?","descrip" => "Alguna vez te has preguntado ¿Qué nivel de empleado eres? o ¿Qué opinan las personas en tu ..." ,"id" => 1  ),
       array("src" => "/img/articulos/telefono.jpg","title" =>"¿Listo para la entrevista telefónica?","descrip" => "¿Sabías que la entrevista telefónica es un recurso muy utilizado por los reclutadores actualmente? ..." ,"id" => 2 )
    );

?>



            <div class="row">
              <div class="articulos_interes pull-left">
                 <?php foreach ($articulos as $value ) : ?>
                      <?=$this->element("candidatos/articulo",array("value"=>$value,"pull"=>"pull-left","span"=>"span3" ) ) ?>
                  <?php  endforeach;?>
                <div class=" span4">
                  <img src="/img/publicidad/publicidad-horizontal_index.jpg"   class="img-polaroid">
                </div> 
                </div>
             </div>



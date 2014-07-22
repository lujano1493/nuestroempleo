 <!-- articulos de interes-->
  



<?php  
 
  $articulos=ClassRegistry::init("WPPost")->articulos_liga(3);

?>



<div class="<?=$span?>">
  <div class="articulos_interes container">
    <?php foreach ($articulos as $value ) : ?>
        <?=$this->element("candidatos/articulo",array("value"=>$value ,"pull" =>"","span" =>$span ) ) ?>
    <?php  endforeach;?>

  </div>
</div>
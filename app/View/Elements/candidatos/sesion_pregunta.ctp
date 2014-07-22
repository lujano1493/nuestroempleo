<?php 
      
    $class_extra=  $tipo_evaluacion=='P'&&  $index < $numPreg-1 ? "hide" : "";

?>


<div class="row sesion-pregunta  <?=$class_extra?>" style="padding-top:45px;">
  <div class="row left tabular" style="margin-left:45px; margin-right:60px;">
    <div class="span1 examenes">
      <?=$pregunta['pregunta_sec']?>.
    </div>
    <div class="span11">&nbsp;&nbsp;&nbsp;<?=$pregunta['pregunta_nom']?> :
    </div>
  </div>


  <div class="row pregunta  examenes_respuesta ">
    <fieldset>

      <?php foreach ($pregunta['Opciones'] as $index_opcion => $opcion )  :?>            
            <?=$this->element("candidatos/sesion_opciones",compact("index","index_opcion","opcion"))?>    
  
      <?php endforeach;?>
      <?=$this->Form->input("Pregunta.$index.opciones" , array(
        "type" => "hidden",
        "class" => "opciones",
        "value" =>""
        ) )
        ?>

        <?=$this->Form->input("Pregunta.$index.pregunta_cve" , array(
          "type" => "hidden",
          "value" => $pregunta['pregunta_cve']
          ) )
          ?>
    </fieldset>
  </div>



</div>
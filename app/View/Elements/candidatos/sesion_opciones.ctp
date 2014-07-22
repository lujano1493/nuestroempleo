<div class="opciones  left">
  <div class="opcion">   
    <label class="checkbox">

      <?php 
          $checked = false;
          if(isset($opcion['canresp'] ) ){
            $checked= $opcion['canresp'] ? true :false;  
          }
          
      ?>      

      <?=$this->Form->input("Pregunta.$index.Respuesta.$index_opcion.opcpre_opcion",array(
      "type"=> "checkbox",
      "class" => "opcion-input",
      "hiddenField" => false,
      "label" => false,
      "div" => false,
      "checked" => $checked,
      "value" => $opcion['opcpre_cve']
      ))
      ?>                                           
      <?=$opcion['opcpre_nom']?> 
    </label>

  </div>
</div>
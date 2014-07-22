
  <?php 

  $ticket=$param['ticket'];
  $candidato=$param['candidato']['Candidato'];
  $encuesta=$param['encuesta'];
  $refcan=$param['refcan']['RefCan'];

  ?>


  <div class="forma_genral_tit"><h2>Encuesta</h2></div><br>
  <div class="row">
    <?=$this->Form->create('RefCanEnc', array('url'=>  array('controller'=>'EncuestaRef',
      'action' =>"guardar"   ),
    'data-size-preguntas' => count($encuesta),
    'class'=>'form-horizontal well',
    'id'=>'encuesta-ref01'  ) ) ?>  


    <div class="left span12" style="padding:15px;">
      <br></div>
      <br><br>
      <div class="row">

        <div class="span11"> <div class="examenes_encabezado"><i class="icon-info-sign icon-2x"></i><strong>Instrucciones:</strong></div></div>
      </div>
      <div class="row">
        <div class="examenes_instrucciones">Por favor marque la opción que mejor describa al candidato en cuestión:</div>

      </div>
      <?php  $index=0;?>
      <?php foreach ($encuesta as $value )  :?>


      <div class="row sesion-pregunta" style="padding-top:45px;">
        <div class="row left tabular" style="margin-left:45px; margin-right:60px;">
          <div class="span1 examenes">
            <?=$index+1?>.
          </div>
          <div class="span11">&nbsp;&nbsp;&nbsp;<?=$value['EvalPreg']['pregunta_nom']?> :
          </div>
        </div>


        <div class="row  examenes_respuesta">
          <fieldset>

            <?php foreach ($value['OpcPreg'] as $opcion )  :?>

            <?php 

            $checked=  $this->data[$index]['RefCanEnc']['respuesta_cve']   ==  $opcion['opcpre_cve'] ? "checked=\"checked\"":"" ;  
            ?>
            <div class="left">
              <label class="checkbox">
                <input type="radio" name="data[RefCanEnc][<?=$index?>][respuesta_cve]"    value="<?=$opcion['opcpre_cve']?>"  <?=$checked?>   >
                <?=$opcion['opcpre_nom']?> 
              </label>
            </div>

          <?php endforeach;?>

        </fieldset>
      </div>
      <?=$this->form->input($index.".RefCanEnc".".pregunta_cve", 
        array(
          "type" =>"hidden" ,
          "name" =>"data[RefCanEnc][$index][pregunta_cve]"
          )   )?>
      <?=$this->form->input($index.".RefCanEnc".".encuestaref_cve", 
        array(
          "type" =>"hidden",
          "name" =>"data[RefCanEnc][$index][encuestaref_cve]"
          ) )?>

      <?=$this->form->input(null, 
        array(
          "type" =>"hidden",
          "name" =>"data[RefCanEnc][$index][pregunta_tipo]",
          "value" => $value['EvalPreg']['pregunta_tipo']
          ) )?>



        </div>

        <?php  $index++;?>
      <?php endforeach; ?>


      <input id="ticket" name="data[ticket]" value="<?=$ticket?>"  type="hidden" >
      <input id="refcan_cve" name="data[refcan_cve]" value="<?=$refcan['refcan_cve']?>"  type="hidden" >

      <?=$this->Form->submit("Enviar", array ("class"=>'btn_color btn-large',"div"=>array("class"=>'')))  ?>

      <?=$this->Form->end()?>

    </div>

        
<button  style="display:none" id="btn_hide_gracias" data-toggle="modal" href="#msg-gracias-enc01" class="btn" data-backdrop='static' data-keyboard='false'   >  gracias </button>

<div id="msg-gracias-enc01" class="modal hide fade in" style="display: none; ">  
  <div class="modal-header">       
  </div>  
  <div class="modal-body">  
    <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>-->
       <div> <h2>¡Gracias por su colaboración!</h2></div>
       <br>
Encuentre empleo en: <br><br>
    <?=$this->Html->link("www.nuestroempleo.com.mx",array(
                                "controller"=>"Pages",
                                "action" =>"display",
                                'full_base' => true  ) )  ?> 
    <br>
    <br>
    <br>          
  </div>  
  <div class="modal-footer" style="text-align:center" >  

        <?=$this->Html->link("Cerrar",array(
                                "controller"=>"Pages" ,
                                "action" =>"display",
                                'full_base' => true  ) )  ?> 
  </div>  
</div>

<?php      
      $this->Html->script(array("app/candidatos/tool/encuesta_ref"),array ('inline' => false ));


?>






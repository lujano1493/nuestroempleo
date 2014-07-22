
  <?php 


      $ticket="";
      $eva=$evaluacion;

      $preguntas=$eva['Preguntas'];
        $numPreg=count($preguntas);

  ?>

  <div class="forma_genral_tit">
     <h2>Evaluación:  <?=$eva['Evaluacion']['evaluacion_nom']?>   </h2>
  </div>
  <div class="row">
    <?=$this->Form->create('EvaCanRes', array(
      'url'=>       array(  
                            'controller'=>'Evaluaciones',
                            'action' =>"guardar"   
                            ),
    'class'=>'evaluacion form-horizontal well nofication-emit',
    'data-component' => 'evaluacioncan',
    'data-hide-wait-background' => true,
    "data-hide-alert" => true,
    "data-start-test" => $flag_start,
    "data-type-test" => $tipo_evaluacion,
    'data-size-test' => $numPreg,

    'id'=>'evaluacion-01'  ) ) ?>  


    <div class="left span12">    
    </div>

         <div class="row">

        <div class="span11"> 
          <div class="examenes_encabezado">        
            <strong>Descripción
            </strong>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="examen_descripcion">
                <?=$eva['Evaluacion']['evaluacion_descrip']?>
        </div>

      </div>


      <div class="row">

        <div class="span11"> 
          <div class="examenes_encabezado">
            <i class="icon-info-sign icon-2x">
            </i>
            <strong>Instrucciones
            </strong>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="examenes_instrucciones">
                <?=$eva['Evaluacion']['evaluacion_indicacion']?>
        </div>

      </div>



      <?php 
            
          if ($tipo_evaluacion!='N') :?>
          <?php 
               $min=$tiempo['min'];
               $seg=$tiempo['seg'];

               $time_str="$min min. $seg seg.";

               $hide= $flag_start=="true" ? "hide" :"";
          ?>    
        <div class="row">
          <div class="span12">
              <div class="status-time-test">
                <label class='info'> Tiempo 
                </label>  
                <div class='time-test hide' data-time="<?=$tiempo['time']?>"  > 
                  <label> <?=$time_str?>  
                  </label>
                </div>                   
                <button class="btn  btn-start-time  <?=$hide?>" >Comenzar 
                </button>       
              </div>
                    
          </div>      
        </div>
      <?php  endif;  ?>


      <div class="sesion-preguntas">
        <?php  $index=0;             
        ?>
          <?php foreach ($preguntas as $pregunta )  :?>

              <?=$this->element("candidatos/sesion_pregunta",compact("pregunta","index","numPreg"))?>

              <?php  $index++;?>

            <?php endforeach; ?>



      </div>


    
          <?=$this->Form->input("Evaluacion.id" , array(
                                                                        "type" => "hidden",
                                                                        "class" => "idEvaluacion",
                                                                        "value" =>  $eva['Evaluacion']['evaluacion_cve']
            ) )
          ?>

          <?=$this->Form->input("EvaCan.id" , array(
                                                                        "type" => "hidden",                                                                        
                                                                        "value" =>  $id
            ) )
          ?>
          <?=$this->Form->input("Evaluacion.ticket" , array(
                                                                        "type" => "hidden",
                                                                        "value" => ""
            ) )
          ?>

        <?=$this->Form->input("Evaluacion.save" , array(
                                                                        "type" => "hidden",
                                                                        "class" => "save",
                                                                        "value" => "false"
            ) )
          ?>

        <?php
                  $hide_sumb=$tipo_evaluacion !='N' ? 'hide': '';
        ?>


      <?=$this->Form->submit("Enviar", array(
                                                "class"=>"btn_color $hide_sumb btn-large enviar",
                                                "div"=>array("class"=>'row-fluid')
                                          ))  ?>
                                  

      <?=$this->Form->end()?>

    </div>

        
<button   id="btn_hide_gracias" data-toggle="modal" href="#msg-gracias-evaluacion" class="btn hide" data-backdrop='static' data-keyboard='false'   >
  gracias 
</button>





<div id="msg-gracias-evaluacion" class="modal hide fade in" style="display: none; ">  
  <div class="modal-header">       
  </div>  
  <div class="modal-body">  
      <div> 
        <h4> La evaluación ha sido guardada satisfactoriamente   </h4>
      </div>
      <br>
      <br>
      <?=$this->Html->link("Regresar",array(
                                            "controller"=>"Evaluaciones",
                                            "action" =>"index",
                                            'full_base' => true 
                                        ) ,
                                    array(
                                          "class" => "btn btn_color btn-large"
                                      )

                                )  ?> 
    <br>
    <br>
    <br>          
  </div>  
  <div class="modal-footer" style="text-align:center" >  

      
  </div>  
</div>





<?php

        $file_content="";
        $num_docs=0;
       foreach ($documentos as $key => $value) { 
                      if ($value['DocCan']['tipodoc_cve']== $layouts['tipo'] )  {
                        $num_docs++;
                            $file_content.= $this->element("candidatos/portafolio/documento",array("result"  => $value["DocCan"],"hide"=>"" ));
                   }
        }
        $num_max_file=1;
        $disabled= ($num_docs==$num_max_file) ? true : false;        

  

?>


          <?=$this->Form->create("DocCan",array(
              "url"=>  array("controller"=>"Portafolio","action"=>"guardar"   ),              
              "data-hide-alert" => "true",
              "data-max-files" => $num_max_file,
              "data-hide-wait-background" =>"true",
              "class"=> $layouts['tipo'] == 10 ? "guarda_liga" :"" ,
              'data-component' => 'validationform  '    ) ) ?> 
              <div class="row-fluid">
                 <div class="span6">
              <label><?=$layouts['label']?>:</label>
              <?php   $title= !empty($layouts['title']) ? "title=\"".$layouts['title']."\"":"";  ?>
              <?php if ($layouts['tipo'] != 10  )  :?>
       
                <div class="input-append" <?=$title?> data-component="tooltip" data-placement="bottom">
                          <a  class="parent_" >
                    <input type="text" class="input-medium-formulario info" readonly  data-rule-required="true" data-msg-required="Selecciona un archivo"  >
                  </a>  
                  <span class="btn fileinput-button"   >                 
                    <i class="icon-plus icon-white"></i>
                     <span> Examinar </span>              
                    <!-- The file input field used as target for the file upload widget -->
                     <?=$this->Form->input(false,array(

                                      "class" => "fileupload input-controller",
                                      "type" => "file",
                                      "div" => false,
                                      "label" => false,
                                      "name" => "files[]",
                                      "disabled" => $disabled,
                                      "multiple" => ""


                     )); ?> 
                  </span> 

                </div>


             


                 <?=$this->Form->input("format",array(
                    "class" =>"type",
                    "type" => "hidden",
                    "value" => $layouts['format']
                  ))?>
                 <?=$this->Form->input("DocCan.docscan_nom",array(
                    "value" => $layouts['default_nom'],
                    "type" => "hidden"
                  ))?>
                 <?=$this->Form->input("DocCan.tipodoc_cve",array(
                    "class" => "tipo",
                    "value" => $layouts['tipo'],
                    "type" => "hidden"
                  ))?>
                <?php  else : ?>

                    <a  title="Si tu documento pesa más de 2 MB inserta la URL." data-component="tooltip" data-placement="bottom">
                  <?=$this->Form->input("DocCan.docscan_nom",array(
                    "label" => false,
                    "class"=> "input-block-level input-controller",
                    "data-rule-required"=>"true",
                    "disabled" => $disabled,
                    "data-msg-required"=>"Ingresa una URL",
                    "data-rule-myurl"=>"true",
                    "data-msg-myurl"=>"Formato de URL no es correcta"

                    ))?>
                  <?=$this->Form->input("DocCan.tipodoc_cve",array(
                    "class" => "tipo",
                    "value" => $layouts['tipo'],
                    "type" => "hidden"
                  ))?>
                  </a>

                <?php endif; ?>


            </div>
            <div class="span3">
              <label>Nombre alternativo:</label>
              <a  title="Con este nombre el reclutador identificará tu documento." data-component="tooltip" data-placement="bottom">
                   <?=$this->Form->input("DocCan.docscan_descrip",array(
                      "label" => false,
                      "data-rule-required"=>"true",
                      "class" => "input-controller",
                      "disabled" => $disabled,
                      "data-msg-required"=>"Ingresa una descripción"
                    ))?>
              </a>
            </div>
             <div class="span3" style="padding-top:27px;">
                  <?= $this->Form->submit("Guardar", array ("class"=>'btn_color pull-left input-controller save',
                                                            "disabled" => $disabled,
                                                            "div"=>false)) ?>
              </div>
         
 

              </div>

             <div  class='progress-barcito hide' >
                    <div class="progress progress-striped ">
                        <div class="bar" style="width: 0%;"></div>
                    </div>
              </div> 
              
              <div class="row-fluid" >
                <div class="span6">
                   <div class="add-files center">
                  
                    <?=$file_content?>
                  </div>            
                </div>
              </div>
            <?=$this->Form->end()?> 
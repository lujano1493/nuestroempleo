<div class="container">
  <div class="forma_genral_tit"><h2>Actualiza tu Currículum</h2></div>

  <?= $this->element("candidatos/foto_status_cv") ?>
  <!-- formulario-->
  <div class="span11 pull-right">

    <?= $this->element("candidatos/tool/form_candidato_dircandidato",array( "action" => "actualizar") ); ?>
    <!-- forma educacion-->
    <div class="accordion" id="accordion2">
      <div class="accordion-group">
        <div class="accordion-heading">
          <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne"><h5>Educación</h5></a>
        </div>
        <div id="collapseOne" class="accordion-body collapse in">
          <div class="accordion-inner">

            <?=$this->element('Candidatos/tool/work_area',array("action"=>"actualizar",
              "title"=>"Escolar",
              "max_item"=>3,
              "name_model"=>"EscCan",
              "name_template"=>"escolar",
              "ini_add_form"=>0,
              "route_view"=>"Candidatos/tool/form_esccandidato"  ))
              ?>

            </div>
          </div>
        </div>
        <!-- forma expectativas-->
        <div class="accordion-group">
          <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo"><h5>Disponibilidad y expectativas de trabajo</h5></a>
          </div>
          <div id="collapseTwo" class="accordion-body collapse">
            <div class="accordion-inner">
              <?= $this->element('Candidatos/tool/form_expecocan',array("action"=>"actualizar", ))?>


            </div>
          </div>
        </div>
        <!--- trabajo-->
        <div class="accordion-group">
          <div class="accordion-heading">
            <div class="span2"><h5>Experiencia laboral</h5></div>
            <div class="span2 pull-right">
              <button class="btn_color btn-small strong" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">Si</button>
              <button class="btn_color btn-small strong" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree"  >No</button></div>
            </div>
            <div id="collapseThree" class="accordion-body collapse tabular">
              <div class="accordion-inner">

                <?=$this->element('Candidatos/tool/work_area',array("action"=>"actualizar",
                  "title"=>"Laboral",
                  "max_item"=>3,
                  "name_model"=>"ExpLabCan",
                  "name_template"=>"esperiencia_laboral",
                  "ini_add_form"=>0,
                  "route_view"=>"Candidatos/tool/form_explabcan"  ))
                  ?>               


                <?= $this->element("candidatos/tool/form_areaexpcan",array ("action" => "actualizar" )); 
                ?>

                </div>
              </div>
            </div>
            <!-- cursos -->
            <div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour"><h5>Cursos</h5></a>
              </div>
              <div id="collapseFour" class="accordion-body collapse tabular">
                <div class="accordion-inner">
                   <?=$this->element('Candidatos/tool/work_area',array("action"=>"actualizar",
                  "title"=>"Curso",
                  "max_item"=>3,
                  "name_model"=>"CursoCan",
                  "name_template"=>"cursos",
                  "ini_add_form"=>0,
                  "route_view"=>"Candidatos/tool/form_cursoscan"  ))
                  ?>    

                </div>
              </div>
            </div>
            <!-- conocimientos -->
            <div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFive"><h5>Otros conocimientos</h5></a>
              </div>
              <div id="collapseFive" class="accordion-body collapse tabular">
                <div class="accordion-inner">

                     <?=$this->element('Candidatos/tool/work_area',array("action"=>"actualizar",
                          "title"=>"otro conocimiento",
                          "max_item"=>3,
                          "name_model"=>"ConoaCan",
                          "name_template"=>"conocimientoa",
                          "ini_add_form"=>0,
                          "route_view"=>"Candidatos/tool/form_conoacan"  ))
                      ?>    
                
                </div>
              </div>
            </div>   
            <!-- Referencias personales -->
            <div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseSix"><h5>Referencias personales</h5></a>
              </div>
              <div id="collapseSix" class="accordion-body collapse tabular">
                <div class="accordion-inner">
                  Agrega dos referencias laborales recientes y una personal que no sea familiar.
                 
                  <?=$this->element("candidatos/tool/form_refcan"); ?>
                </div>
              </div>
            </div>
            <!--- intereses -->
            <div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseSeven"><h5>Intereses</h5></a>
              </div>
              <div id="collapseSeven" class="accordion-body collapse tabular">
                <div class="accordion-inner">
               
                   <?=$this->element("candidatos/tool/form_interes") ?>
                  </div>
                </div>
              </div>
              <!-- habilidades -->
              <div class="accordion-group">
                <div class="accordion-heading">
                  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseEight"><h5>Habilidades</h5></a>
                </div>
                <div id="collapseEight" class="accordion-body collapse tabular">
                  <div class="accordion-inner">
                    <div class="row-fluid left">
                     <?=$this->element("candidatos/tool/form_habilidades") ?>

                    </div>
                  </div>
                </div>
                <!-- discapacidades -->
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <div class="span5 left"><h5>¿Tienes alguna discapacidad?</h5></div>
                    <div class="span2 pull-right">
                      <button class="btn_color btn-small strong" data-toggle="collapse" data-parent="#accordion2" href="#collapseNine">Si</button>
                      <button class="btn_color btn-small strong">No</button></div>
                    </div>
                    <div id="collapseNine" class="accordion-body collapse tabular">
                      <div class="accordion-inner">
                          <?=$this->element("candidatos/tool/form_incapacidad") ?>
                      </div>
                    </div>
                  </div>
                  <!-- idiomas y otros intereses -->
                 <div class="row-fluid">
                    <div class="span5">
                        <?= $this->element('Candidatos/tool/form_idiomacan',array("action"=>"actualizar"));   ?>

                    </div>
                    <div class="span6">
                      <?= $this->element('Candidatos/tool/form_areaintcan',array("action"=>"actualizar"));  ?>
                      
                    </div>
                </div>

                  <div class="span7">
                    <a href="#" title="Elige el formato en el que deseas visualizar tu Currículum."  data-component="tooltip" data-placement="bottom"><i class="icon-info-sign icon-3x"></i></a>
                    <h5>Previsualizar Currículum en:</h5>
                    <button class="btn_color btn-large strong">Formato B/N</button>
                    <button  class="btn_color btn-large strong">Formato color</button>   						
                  </div>
                </div>

              </div>

              <?=$this->element("candidatos/articulos_destacado");  ?>


            </div>







            <?php 

            /*agregamos eventos*/
            $this->Html->scriptBlock(        
              'toggle_radio(["S","N"],"change",".fecha_final_escolar",".ec_actual ",false);'.
              'toggle_radio(["S","N"],"change",".fecha_final_explab" ,".explab_actual",false);'.
              "toggle_();"
              ,
              array('inline' => false)
              );


            ?>

  <div class="forma_genral_tit"><h2>Actualiza tu Currículum</h2></div>

<div class="alert-container clearfix">
  <div class="alert alert-info fade in popup" data-alert="alert">
    <i class="icon-info-sign icon-3x"></i>&nbsp;&nbsp;&nbsp;
      Actualiza tu información y asegúrate de guardar cada sección, los campos con (*) son obligatorios. 
  </div>
</div>

<div class="row">
  <div class="span3" >
    <?=$this->element("candidatos/foto_status_cv")?>
    <div class="row">
        <?=$this->element("candidatos/articulos_destacado",array("span"=>""))?>
    </div>
    <div class="row">
        <object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="220" height="305">
             <param name="movie" value="/anuncios/sumat_ver.swf?clickTag=http://www.sumat.mx/&clickTarget=_blank">
             <param name="quality" value="high">
             <param name="wmode" value="opaque">
             <param name="swfversion" value="6.0.65.0">
             <!-- Esta etiqueta param indica a los usuarios de Flash Player 6.0 r65 o posterior que descarguen la versión más reciente de Flash Player. Elimínela si no desea que los usuarios vean el mensaje. -->
             <param name="expressinstall" value="Scripts/expressInstall.swf">
             <!-- La siguiente etiqueta object es para navegadores distintos de IE. Ocúltela a IE mediante IECC. -->
             <!--[if !IE]>-->
             <object type="application/x-shockwave-flash" data="/anuncios/sumat_ver.swf?clickTag=http://www.sumat.mx/&clickTarget=_blank" width="220" height="305">
               <!--<![endif]-->
               <param name="quality" value="high">
               <param name="wmode" value="opaque">
               <param name="swfversion" value="6.0.65.0">
               <param name="expressinstall" value="Scripts/expressInstall.swf">
              <embed src="sumat_ver.swf?clickTag=http://www.sumat.mx/&clickTarget=_blank" quality="high" bgcolor="#ffffff" width="220" height="170" name="sumat_ver">
                  
              </embed>
               <!-- El navegador muestra el siguiente contenido alternativo para usuarios con Flash Player 6.0 o versiones anteriores. -->
               <div>
                 <h4>El contenido de esta p&aacute;gina requiere una versi&oacute;n m&aacute;s reciente de Adobe Flash Player.</h4>
                 <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Obtener Adobe Flash Player" width="112" height="33" /></a></p>
               </div>
               <!--[if !IE]>-->
             </object>
             <!--<![endif]-->
           </object>

    </div>
  </div>
  <div class="span9">
      <!-- formulario-->
  <div class="actualizar_cv">

    <?= $this->element("candidatos/tool/form_candidato_dircandidato",array( "action" => "actualizar") ); ?>
    <!-- forma educacion-->
    <div class="accordion" id="accordion2">
      <div class="accordion-group">
        <div class="accordion-heading">
          <a id="edicacion_acor" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
            <h5>Educación <i class="icon-sort-down"></i></h5></a>
        </div>
        <div id="collapseOne" class="accordion-body collapse">
          <div class="accordion-inner">

            <?=$this->element('candidatos/tool/work_area',array("action"=>"actualizar",
              "title"=>"Agregar otra referencia  Escolar",
              "max_item"=>3,
              "name_model"=>"EscCan",
              "name_template"=>"escolar",
              "ini_add_form"=>0,
              "route_view"=>"candidatos/tool/form_esccandidato"  ))
              ?>

            </div>
          </div>
        </div>
        <!-- forma expectativas-->
        <div class="accordion-group">
          <div class="accordion-heading">
            <a id="expectativa_acor" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo"><h5>Expectativas  Económicas y Tipo de Empleo <i class="icon-sort-down"></i></h5></a>
          </div>
          <div id="collapseTwo" class="accordion-body collapse">
            <div class="accordion-inner">
              <?= $this->element('candidatos/tool/form_expecocan',array("action"=>"actualizar", ))?>


            </div>
          </div>
        </div>

        <!--- trabajo-->
        <div class="accordion-group">
          <div class="accordion-heading">
            <a id="experiencia_acor" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree"><h5>Experiencia Laboral <i class="icon-sort-down"></i></h5></a>
            <!--<div class="span2"><h5>Experiencia Laboral<i class="icon-sort-down"></i></h5></div>-->
            <!--<div class="span2 pull-right">
              <button class="btn_color pull-rigth" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree"  >Si</button><!--</div>-->
            </div>
            <div id="collapseThree" class="accordion-body collapse tabular">
              <div class="accordion-inner">
                  
                <div class="alert-container clearfix">
                      <div class="alert alert-info fade in popup" data-alert="alert">
                        <i class=" icon-info-sign icon-2x"></i>              
                      Redacta de forma concisa las funciones y/o actividades realizadas en tu puesto. Ejemplo: Planificación de base de datos,  Realización de reportes de Hacienda y Conciliaciones Bancarias.  </div>
                    </div>



                <?=$this->element('candidatos/tool/work_area',array("action"=>"actualizar",
                  "title"=>"Agregar otra Experiencia Laboral",
                  "max_item"=>3,
                  "name_model"=>"ExpLabCan",
                  "name_template"=>"esperiencia_laboral",
                  "ini_add_form"=>0,
                  "route_view"=>"candidatos/tool/form_explabcan"  ))
                  ?>               


                <?= $this->element("candidatos/tool/form_areaexpcan",array ("action" => "actualizar" )); 
                ?>

                </div>
              </div>
            </div>
            <!-- cursos -->
            <div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour"><h5>Cursos <i class="icon-sort-down"></i> </h5></a>
              </div>
              <div id="collapseFour" class="accordion-body collapse tabular">
                <div class="accordion-inner">

              <div class="alert-container clearfix">
                <div class="alert alert-info fade in popup" data-alert="alert">
                  <i class=" icon-info-sign icon-2x"></i>
                Agrega los últimos cursos que hayas realizado.  </div>
              </div>

                   <?=$this->element('candidatos/tool/work_area',array("action"=>"actualizar",
                  "title"=>"Agregar más Cursos ",
                  "max_item"=>3,
                  "name_model"=>"CursoCan",
                  "name_template"=>"cursos",
                  "ini_add_form"=>0,
                  "route_view"=>"candidatos/tool/form_cursoscan"  ))
                  ?>    

                </div>
              </div>
            </div>
            <!-- conocimientos -->
            <div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFive"><h5>Otros conocimientos <i class="icon-sort-down"></i></h5></a>
              </div>
              <div id="collapseFive" class="accordion-body collapse tabular">
                <div class="accordion-inner">
                     <div class="alert-container clearfix">
                          <div class="alert alert-info fade in popup" data-alert="alert">
                            <i class=" icon-info-sign icon-2x"></i>
                              Registra tus conocimientos extras, recuerda ingresar información de utilidad para el Reclutador.
                              Agrega el conocimiento que corresponda a tu perfil. Se breve y conciso. Ejemplo: 
                              Programación PHP, electricidad, electrónica, etc. Sólo se podra agregar 3 descripciones como máximo.
                          </div>
                     </div>
                   
                        <?=$this->element("candidatos/tool/form_conoacan") ?>

                
                </div>
              </div>
            </div>   
            <!-- Referencias personales -->
            <div class="accordion-group">
              <div class="accordion-heading">
                <a id="referencias_acor" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseSix"><h5>Referencias<i class="icon-sort-down"></i></h5></a>
              </div>
              <div id="collapseSix" class="accordion-body collapse tabular">
                <div class="accordion-inner">
                   <div class="alert-container clearfix">
                          <div class="alert alert-info fade in popup" data-alert="alert">
                            <i class=" icon-info-sign icon-2x"></i>
                         Enviaremos una encuesta acerca de ti a las referencias para evaluarte. Agrega los datos de dos Referencias laborales como mínimo para verificar la relación de trabajo. Si no tienes Experiencia
laboral, agregar referencias personales.</div>
                     </div>
                   <?=$this->element('candidatos/tool/work_area',array("action"=>"actualizar",
                            "title"=>"Agregar más Referencias ",
                            "max_item"=>3,
                            "name_model"=>"RefCan",
                            "name_template"=>"referencias",
                            "ini_add_form"=>0,
                            "route_view"=>"candidatos/tool/form_refcan"  ))
                  ?>    
                </div>
              </div>
            </div>
            <!--- intereses -->
            <div class="accordion-group">
              <div class="accordion-heading">
                <a  id="intereses_acor" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseSeven"><h5>Intereses <i class="icon-sort-down"></i></h5></a>
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
                  <a id="habilidades_acor" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseEight"><h5>Habilidades <i class="icon-sort-down"></i></h5></a>
                </div>
                <div id="collapseEight" class="accordion-body collapse tabular">
                  <div class="accordion-inner">
                  
                    <?=$this->element("candidatos/tool/form_habilidades") ?>

                  </div>
                </div>
                </div>
                <!-- discapacidades -->
             <!--    <div class="accordion-group">

                       <div class="accordion-heading">
                     <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseNine"><h5>Capacidades Diferentes <i class="icon-sort-down"></i></h5></a>
                      </div>
                
                    <div id="collapseNine" class="accordion-body collapse tabular">
                      <div class="accordion-inner">
                          <?=$this->element("candidatos/tool/form_incapacidad") ?>
                      </div>
                    </div>
                  </div> -->
                  <!-- idiomas y otros intereses -->
                 <div class="row-fluid">
                    <div class="span6">
                        <?= $this->element('candidatos/tool/form_idiomacan',array("action"=>"actualizar"));   ?>

                    </div>
                    <div class="span6">
                      <?= $this->element('candidatos/tool/form_areaintcan',array("action"=>"actualizar"));  ?>
                      
                    </div>
                </div>

                  <div class="row-fluid">
                   <!-- <a href="#" title="Elige el formato en el que deseas visualizar tu Currículum." data-component="tooltip" data-placement="bottom">
                      <i class="icon-info-sign icon-3x"></i></a> -->
                    
                    <?=$this->Html->link("Vista Previa",array(
                      "controller"=> "candidato",
                      "action" => "view_pdf",
                      'ext' => 'pdf'
                      ),array(
                        "class" => "btn_color btn-large strong",
                        "target" => "_blank"
                      ))?>
                  
                  </div>
                </div>

              </div>

            </div>

  </div>


              





            <?php 

              $this->Html->script(array("app/candidatos/actualizar","app/candidatos/tool/form_esccandidato"),array("inline"=>false));
             ?>





    <?=$this->element("candidatos/publicidad") ?>










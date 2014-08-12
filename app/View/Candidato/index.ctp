<div class="forma_genral_tit"><h2>Inicio</h2></div>









<?php  if ($show_msg_status_cv) :?>
  <?php  if ($is_nuevo) :?>
    <div id="info-status-candidato01" class="modal hide fade" tabindex="-1" role="dialog" >
       <div class="modal-header">
            <h4 class="modal-title forma_genral_tit">Información de Registro</h4>
        </div>

        <div class="modal-body without-space">
          <div class="alert alert-info fade in popup" data-alert="alert">
            <h5>
              <div class="row-fluid">
                  <div class="span12">
                    <i class="icon-info-sign icon-3x"></i>&nbsp;&nbsp;&nbsp;
               Bienvenido a Nuestro Empleo, ya tenemos tu Perfil General, ahora completa tu Currículum para incrementar tus posibilidades de encontrar empleo 
                  </div>
              </div>
              <div class="row-fluid"> 
                <div class="span6"> 
                  <?=$this->Html->link("Haz clic aquí ",array(
                      "controller" => "candidato" ,
                      "action" => "actualizar"),
                      array(
                      "style" => "width:150px",
                      "class"=> "btn btn-info"
                  ))?>
                     
                </div>
                <div class="span6" >
                       <a  class="btn btn-info" data-dismiss="modal" aria-hidden="true"    style="width:150px" href="" >En otro momento</a> 
                </div>
              </div>
               
             
            </h5> 
          </div>
        </div>

        <div class="modal-footer"></div>
    </div>
    <button  id="btn-status01" class="hide btn" data-toggle="modal" data-target="#info-status-candidato01"  data-keyboard="false" data-backdrop="static" data-show="true" > mostrar</button>
  <?php  else :?>
    <div class="alert alert-info fade in popup" data-alert="alert">
          <div class="row-fluid">
           <div class="span12">
                <i class="icon-info-sign icon-3x"></i>&nbsp;&nbsp;&nbsp;
           Bienvenido a Nuestro Empleo, ya tenemos tu Perfil General, ahora completa tu Currículum para incrementar tus posibilidades de encontrar empleo 
              </div>
          </div>
          <div class="row-fluid"> 
            <div class="span12">
              <?=$this->Html->link("Haz clic aquí ",array(
                      "controller" => "candidato" ,
                      "action" => "actualizar"),
                      array(
                      "style" => "width:150px",
                      "class"=> "btn btn-info btn-small"
                  ))?> 
            </div>
          </div>
    </div>
  <?php endif; ?>
<?php  endif; ?>


  <div class="span3">
  <?=$this->element("candidatos/datos_candidato")?>
  <?=$this->element("candidatos/eventos")?> 
  <p>&nbsp;</p>
  
    <a href="http://www.techo.org/" target="_blank">
      <img src="/img/publicidad/techo_banner_horizontal.jpg" width="210" height="262">
    </a>
  </div>



  <div class="span9 pull-right">

    <?=$this->element("candidatos/inicio/inicio")?>

    <?=$this->element("candidatos/inicio/publicidad")?>

  </div>






 

       

<?php 
      $script='
          $(document).ready(function ($,undefined){
            $("#btn-status01").trigger("click");
          });
      ';



  $this->Html->scriptBlock($script,array("inline" => false));   


?>
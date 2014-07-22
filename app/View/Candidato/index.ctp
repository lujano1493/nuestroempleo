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



<?= $this->element("inicio/busqueda", array("extra_class"=> "buscador_cand","with_title"=>true, "param" =>array() ) )?>


            <table style="width:100%;">
            <tbody>
            
             <tr>
            <td style="width:40%; padding:10px;" valign="top">

              <?php  
            

              ?>
             <?=$this->element("candidatos/ofertas_perfil",array(
                                                                          "ofertas_perfil" =>$ofertas_perfil

             ))?>
            </td>
           
            <td style="width:60%; padding:10px;" valign="top">
<br>
<div class="articulos_interes" >
<?php  
  $art=ClassRegistry::init("WPPost");
  $articulos= $art->articulos_liga(3);
?>


    <div id="semblaza_carru" data-component="carrusel"  
              data-type="flexslider" data-isajax="true" data-url="<?=$this->Html->url(array("controller" => "candidato","action" =>"semblazas") )?>" 
              data-template-id="#tmpl-semblaza" data-content-type="json" data-direction="vertical" 
              data-num-item-display="2" data-paginate="true" data-limit="40"      >

      <div id="semblaza_carrs" class="flexslider">
        
             
      </div>

    <?=$this->Template->insert(array(
        'semblaza',
      ), null, array(
        'viewPath' => 'Candidato'
      ));
       ?>
    </div>




<?php 
                $pos=array(
                          "pull-left",
                          "pull-left",
                          "pull-left");

                $alineacion=array(
                          "align=right",
                          "align=left",
                          "align=right");

                $itera=0;
                $cont=0;
                foreach ($articulos as $value) {
                   echo $this->element("candidatos/articulo_index",array("value"=>$value,"pull" =>$pos[$itera++],  "span" => "span12",  "alineacion" => $alineacion[$cont++]));
                }

          ?>
							
			
              	
                </div>
</td>
            </tr>
            </tbody>
            </table>
            <div class="pull-right span6">
                 
                          <object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="540" height="155">
                      <param name="movie" value="/anuncios/sumat.swf?clickTag=http://www.sumat.mx/&clickTarget=_blank">
                      <param name="quality" value="high">
                      <param name="wmode" value="opaque">
                      <param name="swfversion" value="6.0.65.0">
                      <!-- Esta etiqueta param indica a los usuarios de Flash Player 6.0 r65 o posterior que descarguen la versión más reciente de Flash Player. Elimínela si no desea que los usuarios vean el mensaje. -->
                      <param name="expressinstall" value="Scripts/expressInstall.swf">
                      <!-- La siguiente etiqueta object es para navegadores distintos de IE. Ocúltela a IE mediante IECC. -->
                      <!--[if !IE]>-->
                      <object type="application/x-shockwave-flash" data="/anuncios/sumat.swf?clickTag=http://www.sumat.mx/&clickTarget=_blank" width="540" height="155">
                        <!--<![endif]-->
                        <param name="quality" value="high">
                        <param name="wmode" value="opaque">
                        <param name="swfversion" value="6.0.65.0">
                        <param name="expressinstall" value="Scripts/expressInstall.swf">
                         <embed src="sumat.swf?clickTag=http://www.sumat.mx/&clickTarget=_blank" quality="high"
                  bgcolor="#ffffff" width="220" height="170" name="sumat"></embed>
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
       

<?php 
      $script='
          $(document).ready(function ($,undefined){
            $("#btn-status01").trigger("click");
          });
      ';



  $this->Html->scriptBlock($script,array("inline" => false));   


?>
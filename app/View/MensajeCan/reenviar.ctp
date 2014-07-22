<?php
  $m = $mensaje['Mensaje'];
  $correo="";

  if(isset($mensaje['Emisor'])){
      $e = $mensaje['Emisor'];
      $id= $m['emisor_cve'];
      $tipo=$m['emisor_tipo'];
      $nombre=$e['nombre'];
      $correo=$e['email'];

  }
  else{

    $arr=  array("ReceptorEmpresa","ReceptorCandidato");
    foreach ($arr as $receptor) {
      if(isset($mensaje[$receptor]) && !empty( $mensaje[$receptor])){
        $e = $mensaje[$receptor][0];
        $id= $e['receptor_cve'];
        $tipo=$e['receptor_tipo'];
        $nombre=$e['Cuenta']['nombre'];
        $correo=$e['Cuenta']['email'];
      }
    }
  }



?>

<div class="container">
   <div class="forma_genral_tit"><h2><?=$title_for_layout?></h2></div>

 </div>

<div class="container">
    <div class="alert-container clearfix">
    <div class="alert alert-info fade in popup" data-alert="alert">
      <i class="icon-info-sign icon-3x"></i>
      &nbsp;&nbsp;&nbsp;Revisa periódicamente este módulo, aquí te llegarán las notificaciones de los reclutadores como test, pruebas psicométricas, entrevistas, etc.
    </div>
  </div>

  <div class="span3 pull-left" style="margin-top:-14px;">
    <?=$this->element("candidatos/mensajes/menu")?>
  </div>
  <div class="span9 pull-left">
    <?php

        $to= compact("id","tipo","nombre");
        $asunto= 'Re: ' . $m['msj_asunto'];
         $superior=$m['msj_cve'];
        $tipo=$m['tipomsj_cve'];
       $msg=($this->action=='responder' )?' <br /><br /><br />------ Mensaje: <b>' . $correo .'</b>, ' . $m['created'] . ' ------<br />' .$m['msj_texto']:$m['msj_texto'];
       $msg=$tipo !=1  ? $msg: "";
        $new=false;
        $parametros=compact("tipo","superior");
       
    ?>
    <?=$this->element("editor_msg",compact("new","to","asunto","msg","parametros"))?>



  </div>

    <div class="span12">
      <div class="row">
              <div style="margin-top:80px;"><img id="img" src="/img/publicidad/publicidad-horizontal_msj.jpg"  class="img-polaroid"></div>
              <!--<div class="pull-right span4" style="margin-bottom:5px;"><img src="/img/publicidad/publicidad-vertical.jpg" width="167" height="191" class="img-polaroid"></div>
              </div>-->
    </div>
</div>
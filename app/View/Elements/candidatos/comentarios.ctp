 <div  data-component='comentcan'>


  <i class="icon-comments icon-2x">        
  </i>&nbsp;
  <span>
    <!--<a href="#" class="no_link" data-component='tooltip' data-placement='bottom' title="Tu pregunta será publicada una vez que el reclutador la haya autorizado.">-->
      Si tienes dudas sobre la vacante, escribe una pregunta al reclutador:
    <!--</a>-->
  </span>


  <?php 
    $foto = "/img/candidatos/default.jpg";
    $idUser=$authUser['candidato_cve'];
    $path_full="documentos/candidatos/$idUser/foto.jpg";
    if (file_exists(WWW_ROOT . $path_full)) {
      $foto = "/$path_full";
    }

  ?>

  <div class="dudas_pregunta left">
      <img id="img" src="<?=$foto?>" width="62px" height="74px"> 
       <input type="text" class="span10  mensaje-candidato">
  </div>

  <div class="left" style="padding-top:15px;">
    <button class="btn_color enviar-comentario-candidato">Enviar</button>
  </div>
  <div class="row-fluid">
    <i class="icon-question-sign icon-2x"></i>
    <span>Preguntas anteriores realizadas al reclutador:</span>  
  </div>        
  
  <div class='area-comentarios'>
    
  </div>



</div>



<?=$this->Template->insert(array(
        'comentarios',
      ), null, array(
        'viewPath' => 'PostulacionesCan'
      ));
?>

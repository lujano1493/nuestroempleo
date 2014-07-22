<?php
  echo $this->element('empresas/title');
?>

<div class="row">
  <div class="col-xs-12">
    <?php
      $asunto = $msg = "";
      $scriptsLoaded = $new = true;
      $tipo=0;
      $superior=null;
      $parametros=array();

      if($this->action==='reenviar'){
        if( !empty($mensaje)){
          $parametros['comentario']=$mensaje['MensajeOferta'];
          $parametros['tipo']=$mensaje['Mensaje']['tipomsj_cve'];
          $parametros['superior']=$mensaje['Mensaje']['msj_cve'];
        }      
      }
      echo $this->element('editor_msg', compact('new', 'asunto', 'msg','parametros'));
    ?>
  </div>
</div>

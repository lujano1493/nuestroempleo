<?php
  echo $this->element('empresas/title');

  $m = $mensaje['Mensaje'];
  $mxo=$mensaje['MensajeOferta'];
  if (isset($mensaje['Emisor'])) {
    $e = $mensaje['Emisor'];
    $id = $m['emisor_cve'];
    $tipo = $m['emisor_tipo'];
    $nombre = $e['nombre'];
    $correo = $e['email'];
  } else {
    $arr = array('ReceptorEmpresa', 'ReceptorCandidato');
    foreach ($arr as $receptor) {
      if(isset($mensaje[$receptor]) && !empty( $mensaje[$receptor])) {
        $e = $mensaje[$receptor][0];
        $id = $e['receptor_cve'];
        $tipo = $e['receptor_tipo'];
        $nombre = $e['Cuenta']['nombre'];
        $correo = $e['Cuenta']['email'];
      }
    }
  }

  $to = array(
    'id' => $id,
    'tipo' => $tipo,
    'nombre' => $nombre
  );

  $asunto= 'Re: ' . $m['msj_asunto'];
  $superior=$m['msj_cve'];
  $tipo=$m['tipomsj_cve'];
  $msg = $tipo!= 1 ? '<br /><br /><br />------ Mensaje: <b>' . $correo .'</b>, ' . $m['created'] . ' ------<br />' . $m['msj_texto']: "";
  $new = false;
  $comentario= $mxo;
  $parametros=compact('superior','tipo','comentario');    
  echo $this->element('editor_msg', compact('new', 'to', 'asunto', 'msg' ,'parametros'));
?>


<?php
  $user = $this->Session->read('Auth.User');

  $this->_results = array(
    'id' => (int)$insertedID,
    'tipo' => $anotacion['anotacion_tipo'],
    'texto' => $anotacion['anotacion_detalles'],
    'candidato' => $anotacion['candidato_cve'],
    'created' => $this->Time->dt($anotacion['created']),
    'usuario' => array(
      'id' => (int)$user['cu_cve'],
      'email' => $user['cu_sesion'],
      'nombre' => $user['fullName'],
    )
  );
?>
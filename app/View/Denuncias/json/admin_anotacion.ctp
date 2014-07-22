<?php
  $user = $this->Session->read('Auth.User');
  $tipo=array(1=>"candidato",0=>"oferta");

  $this->_results = array(
    'id' => (int)$insertedID,
    'is_created' => $is_created,    
    'tipo' => $tipo[ $anotacion['anotacion_tipo'] ],  
    'denunciaId' => (int) $anotacion['anotacion_id'],
    'texto' => $anotacion['anotacion_detalles'],
    'created' => $this->Time->dt($anotacion['created'])
  );
?>
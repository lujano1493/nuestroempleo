<?php

App::uses('AppHelper', 'View/Helper');
App::uses('Notificaciones','Utility');
/**
  * Helper personalizado para los inputs de nuestro empleo.
  */
class NotificacionHelper extends AppHelper {
  public $helpers = array(
    'Time' => array('className' => 'Tiempito', 'engine' => 'Tiempito'),
  );
  public function formatToJson($data, $options = array()) {
    if(!$data){
      return false;
    }
    $role=$this->_View->viewVars['role'];
    $user=$this->_View->viewVars['authUser'];
    return Notificaciones::notificacion_formato($data,$options,$role,$user);
  }

}


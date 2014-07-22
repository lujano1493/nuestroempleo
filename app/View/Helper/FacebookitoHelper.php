<?php

App::uses('AppHelper', 'View/Helper');
App::uses('Notificaciones','Utility');
App::uses('FacebookHelper','Facebook.View/Helper');
/**
  * Helper personalizado para los inputs de nuestro empleo.
  */
class FacebookitoHelper extends FacebookHelper {
 

 public function login($options = array(),$label=''){
    $options = array_merge(
      array(
        'data-redirect' => false,
        'class' => "fb-login-button",
        'data-max-row'=>200,
        "style"=>"border:0px",
        'escape' =>false
      ),
      $options
    );
 	

 	return $this->Html->tag("div",$label,$options );



   
  }
 
 
}


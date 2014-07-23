<?php
App::uses('FB', 'Facebook.Lib');

use Facebook\GraphSessionInfo;
use Facebook\FacebookRequest;
use Facebook\FacebookSession;
/**
 * Componente para verificar los permisos, accesos y créditos del Usuario.
 */
class FacebookComponent extends Component {

  /**
   * [$components description]
   * @var array
   */
  public $components = array('Auth', 'Session');

  /**
   * Inicialización del componente.
   * @param  Controller $controller [description]
   * @return [type]                 [description]
   */
  private $facebook=null;
  public function initialize(Controller $controller) {
    $this->controller = $controller;
    $this->params = $this->controller->request->params;

    $this->facebook=new FB();
  }

  public function startup(Controller $controller) {
    
  }


  public  function login($options=array()){
      $options_=array(
        'scope' => 'email,user_likes,publish_actions',
        'redirect_uri' => '/',
        'display'=> 'page'
      );  
      $options=array_merge($options_,$options);
     return $this->facebook->getLoginUrl($options);

  }

  public  function logout($options=array()){
    $options_=array(
      'next'=>'/'
      );
    $options=array_merge($options_,$options);
    return $this->facebook->getLogoutUrl($options);

  }

  public  function getUserId(){  
      return $this->facebook->getUser();
  }

  /**
   * funcion post: utilizada para publicar o compartir un objeto de nuestroempleo
   * @param  array  $options contiene las opciones 
   * @return int          si es null es una excepcion , si es -1 es por que aun no esta logeado
   */
  public  function post($options=array() ){
    if($this->getUserId()){
      $token=$this->facebook->getAccessToken();
      $options_=array(
        'name' => "Nuestro Empleo Desarrollo",
        'description' => 'desarrollo de en nuestro empleo para redes sociales',
        'picture' => 'https://www.nuestroempleo.com.mx/img/logo.png',
        'message' => 'mensaje generico',
        'link' => 'http://www.nuestroempleo.com'
        );
      $options=array_merge($options_,$options);
      $options['access_token']=$token;
      $res=null;
      try{
        $res = $this->facebook->api('/me/feed', 'POST', $options);  
      }catch (Exception $e){
        $res=null;
      }  

    }

    else{
      $res=-1;
    }
    return $res;
  }


  public function perfil($perfil='me'){
    return $this->facebook->api("/$perfil",'GET');
  }
 
}
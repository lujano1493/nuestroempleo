<?php

App::uses('AppController', 'Controller');
App::uses('Funciones','vendor');
App::uses('Facebook','Utility');
App::uses('Twitter','Utility');
/**
 * Controlador general de la aplicación.
 */
class SocialesController extends AppController {

  /**
    * Nombre del controlador.
    */
  public $name = 'Sociales';

 


  /**
    * Indica qué modelos se usarán. Un array vacío, indica que no usará algún modelo.
    */
  public $uses = array();


  public function admin_logout_network(){
    $this->Session->delete('fb_token');
    $this->Session->delete('tw_token');
    $url=$this->Session->read("redirect_network_logout");
    $this->Session->delete("redirect_network_logout");
    $this->redirect($url);
  }


  public function admin_ofertas(){
    $this->loadModel("Oferta");
    if($this->isAjax){
      $compartirse=$this->Oferta->find("sociales",array(
          "idUser" =>$this->Auth->user('cu_cve')
        )
      );
      $this->set(compact("compartirse"));
    }else{
      $url_redirect=Router::fullBaseUrl()."/admin/sociales/ofertas";
      $this->facebook_();
      $this->twitter_();
    }
  }
    public function admin_eventos(){
      $this->loadModel("Evento");
      if($this->isAjax){
      $compartirse=$this->Evento->find("sociales",array(
          "idUser" =>$this->Auth->user('cu_cve')
        )
      );
      $this->set(compact("compartirse"));
      }else{
          $url_redirect=Router::fullBaseUrl()."/admin/sociales/eventos";
          $this->facebook_($url_redirect);
          $this->twitter_($url_redirect);
    }
  }
  private function  twitter_($url_redirect=null){
    $twitter= new Twitter($url_redirect);
    $status_tw=$twitter->getStatus();
    $login_tw=$twitter->login();
    $logout_tw="/admin/sociales/logout_network";
    $this->Session->write("redirect_network_logout",$url_redirect);
    $this->set(compact("status_tw","login_tw","logout_tw"));

  }
  private function facebook_($url_redirect=null){
      $facebook= new Facebook( $url_redirect );
      $login_fc= $facebook->login();
      $logout_fc=$facebook->logout(Router::fullBaseUrl()."/admin/sociales/logout_network");
      $userFacebok = $facebook->getIdUser();
      $pefilFacebook=$facebook->getPerfil();             
      $this->Session->write("redirect_network_logout",$url_redirect);
      $this->set(compact("userFacebok","pefilFacebook","login_fc","logout_fc"));
  }
  public function admin_compartir($red=null,$tipo=null,$id=null){
    if( $red==null || $tipo==null || $tipo ==null ){
      $this->error(__("Error no se ha enviado ningun parametro."));
      return ;
    }
    $model=ClassRegistry::init($tipo == 'oferta' ? 'Oferta': 'Evento');  
    $_label= $tipo==='oferta' ? __(" la oferta ") : __(" el evento ") ;
    $this->loadModel("Compartir");
    $this->Compartir->begin(); 
    if( !$this->Compartir->compartir($id,$tipo,$red) ){
      $this->error(  __("No fue posible guardar $_label.") );
      $this->Compartir->rollback();
      return;
    } 
    $compartir=$model->find("sociales",array(
        "id" =>$id,
        "idUser" => $this->user['cu_cve']
        )
      );      
      $params=$model->format_to_share($red,$compartir[0]);
      $sts_rs=$this->compartir_red_social($red, $params);
      if( $sts_rs===false || $sts_rs===null || $sts_rs===-1 ){
        $label_error= $sts_rs===false ?  __("No fue posible compartir en  $red   $_label") :
          ( $sts_rs===null ? __("Ocurrio un error al tratar de compartir $_label, intentalo más tarde"):
          __("Debes iniciar sessión en $red.")    )  ;
        $this->error( $label_error );
        $this->Compartir->rollback();
        return;
      } 
    $this->set(compact("compartir","tipo"));
    $this->callback($this->request->data['after']);
    $this->Compartir->commit();
    $this->success(__("$_label fue compartida en $red") );
  }


  private function compartir_red_social($red='facebook',$params=array()){
      if($red==='facebook'){
        //Router::fullBaseUrl()."/admin/sociales/ofertas"
        $f=new Facebook();
        $sts=$f->postLink($params);       
        return $sts;
      }
      else if ($red==='twitter'){
        $tw= new Twitter();
        $sts= $tw->tweet($params);
        return  $sts;
      }

      return false;

  }


  /**
    * Método que se ejecuta antes de cualquier acción.
    */
  public function beforeFilter() {
    parent::beforeFilter();
    /**
      * Acciones que no necesitan autenticación.
      */
    $allowActions = array();

    $this->Auth->allow($allowActions);


    /**
     * verificamos que este loggeado en facebook para compartir 
     * @var [type]
     */    
  }

 
}
<?php

App::uses('BaseEmpresasController', 'Controller');
App::uses('Funciones','vendor');
/**
 * Controlador general de la aplicación.
 */
class SocialesController extends BaseEmpresasController {

  /**
    * Nombre del controlador.
    */
  public $name = 'Sociales';

  public $components=array(
    'Facebook'
  );


  /**
    * Indica qué modelos se usarán. Un array vacío, indica que no usará algún modelo.
    */
  public $uses = array();


  public function admin_logout_network(){
    $this->Facebook->delete();
    $this->redirect('/admin/sociales/ofertas');
  }


  public function admin_ofertas(){

    $this->loadModel("Oferta");

    if($this->isAjax){
      $ofertas=$this->Oferta->find("sociales",array(
          "idUser" =>$this->Auth->user('cu_cve')
        )
      );
      $this->set(compact("ofertas"));
    }else{

          $login_fc= $this->Facebook->login(array(
              'redirect_uri' =>Router::fullBaseUrl()."/admin/sociales/ofertas"
            ));
          $logout_fc=$this->Facebook->logout(array(
              'next' => Router::fullBaseUrl()."/admin/sociales/logout_network"
              )
            );

          $userFacebok = $this->Facebook->getUserId();
          $pefilFacebook=$this->Facebook->perfil();             
          $this->set(compact("userFacebok","pefilFacebook","login_fc","logout_fc"));

    }


  }

  public function admin_compartir($red=null,$tipo=null,$id=null){
    if( $red==null || $tipo==null || $tipo ==null ){
      $this->error(__("Error no se ha enviado ningun parametro."));
      return ;
    }
    $model=ClassRegistry::init($tipo == 'oferta' ? 'Oferta': 'Evento');  
    $this->loadModel("Compartir");
    $this->Compartir->begin(); 
    if(! $this->Compartir->compartir($id,$tipo,$red) ){
      $this->error(__("No fue posible guardar la/el $tipo."));
      $this->Compartir->rollback();
      return;
    }    
      $compartir=$model->find("sociales",array(
        "id" =>$id,
        "idUser" => $this->user['cu_cve']
        )
      );      
      $params=$model->format_to_share($red,$compartir[0]);
 
      if(!$this->compartir_red_social($red, $params) ){
        $this->error(__("No fue posible compartir en  $red  la/el $evento"));
        $this->Compartir->rollback();
        return;
      }

      $this->set(compact("compartir","tipo"));
     $this->callback($this->request->data['after']);
     $this->Compartir->commit();



  }


  private function compartir_red_social($red='facebook',$params=array()){
      if($red==='facebook'){      
         return $this->Facebook->post($params);
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
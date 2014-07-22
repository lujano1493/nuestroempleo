<?php

App::import('Utility','Security');

App::import('Controller', 'MisMensajes');
App::import('Vendor',array('funciones'));

App::import('Controller', 'BaseCandidato');

class MensajeCanController extends BaseCandidatoController {
    public $name = 'MensajeCan';
    public $uses=array("Mensaje");
    public $components=array('Notificaciones');
    public function index(){
      $title_for_layout = 'Bandeja de Entrada';


   	  $mensajes = array();

     if($this->isAjax){
        $mensajes=$this->Mensaje->find('recibidos', array(
          'toUser' => $this->Auth->user('candidato_cve') ,
          'userType' =>  $this->Acceso->is(),
        ));


     }


    $this->set('mensajes',$mensajes);
    $this->set('title_for_layout',$title_for_layout);

    }


    public function eliminados(){

    $mensajes = array();

     if($this->isAjax){

        $mensajes = $this->Mensaje->find('recibidos', array(
        'toUser' => $this->Auth->user('candidato_cve') ,
        'userType' =>  $this->Acceso->is(),
        'status' => -1
        ));
      }

    $this->set(compact('mensajes'));


    }



    public function importates(){
        $title_for_layout = 'Importantes';

        $mensajes = array();


     if($this->isAjax){

      $mensajes=$this->Mensaje->find('recibidos', array(
        'toUser' => $this->Auth->user('candidato_cve') ,
        'userType' =>  $this->Acceso->is(),
        'is_importante' => true
      ));

     }
    $this->set('mensajes',$mensajes);
    $this->set('title_for_layout',$title_for_layout);

    $this->render("index");

    }



  public function enviados() {
    $mensajes = array();

    if($this->isAjax){
      $mensajes= $this->Mensaje->find('enviados', array(
      'fromUser' => $this->Auth->user('candidato_cve'),
      'userType' => $this->Acceso->is()
        ));
    }
    $this->set(compact('mensajes'));
  }


  //  public function nuevo() {
  //   if ($this->request->is('post')) {
  //     $data = $this->request->data;
  //     $data['Mensaje']['emisor_tipo'] = (int)$this->Acceso->is('candidato');
  //     $data['Mensaje']['emisor_cve'] = $this->Auth->user('candidato_cve');
  //     $data['Mensaje']['msj_status'] = 1; // Indica que es nuevo.
  //     //debug($data);die;
  //     if ($this->Mensaje->saveMensaje($data)) {
  //       $this->success('Se ha enviado el mensaje a tus destinatarios');
  //       $this->redirect("/MensajeCan");
  //     } else {
  //       $this->error('Ha ocurrido un error al guardar tu mensaje');
  //     }

  //     $this->set("tipo","nuevo");
  //   }

  // }

    public function reenviar($id) {
    $title_for_layout = 'Reenviar Mensaje';

    if (!$this->Mensaje->exists($id)) {
      throw new NotFoundException('El mensaje que buscas no existe.');
    }

    if ($this->request->is("get") ) {

      $mensaje = $this->Mensaje->find('enviados', array(
        'fromUser' => $this->Auth->user('candidato_cve'),
        'userType' => $this->Acceso->is(),
        'conditions' => array(
          'Mensaje.msj_cve' => $id
        )
      ))[0];

      $mensaje['Mensaje']['receptores'] = Utils::toJSONIntArray($mensaje, 'ReceptorEmpresa.{n}.receptor_cve');
      $mensaje['Mensaje']['c_receptores'] = Utils::toJSONIntArray($mensaje, 'ReceptorCandidato.{n}.receptor_cve');

      $this->set(compact('mensaje', 'title_for_layout'));
      $this->set("title_module","");
      $this->render("responder");
    } else  {

          $this->saveMensaje();
    }

  }

    private function saveMensaje(){
      $data = $this->request->data;
      $data['Mensaje']['emisor_tipo'] = (int)$this->Acceso->is('candidato');
      $data['Mensaje']['emisor_cve'] = $this->Auth->user('candidato_cve');
      if ($data['Mensaje']['user_type'] == 0) {
        $data['Mensaje']['receptores'] = "[" . $data['Mensaje']['to_user'] . "]";
      } else {
        $data['Mensaje']['c_receptores'] = "[" . $data['Mensaje']['to_user'] . "]";
      }
      $data = $this->Mensaje->saveMensaje($data);
      if ($data) {
        //$results =$this->Notificaciones->formato_notificacion($data,array('tipo'=>'mensaje'));
        // $this->Notificaciones->enviar("send-ntfy", $results );
        $this->redirect("enviados");
        $this->success(__('Se ha enviado el mensaje a tus destinatarios'));
      } else {
        $this->response->statusCode(300);
        $this->error(__('Ha ocurrido un error al guardar tu mensaje'));
      }

  }



  public function ver($id, $tipo = 'recibidos') {
    if ($tipo === 'recibidos') {
      $exists = $this->Mensaje->MensajeData->exists($id);
      $typeUs = 'toUser';
      $options = array(
        'mensaje' => $id
      );
    } else {
      $exists = $this->Mensaje->exists($id);
      $typeUs = 'fromUser';
      $options = array(
        'conditions' => array(
          'Mensaje.msj_cve' => $id
        )
      );
    }

    if (!$exists) {
      throw new NotFoundException('El mensaje que buscas no existe.');
    }

    $options[$typeUs] = $this->Auth->user('candidato_cve');
    $options['userType'] = $this->Acceso->is();

    $mensaje = $this->Mensaje->find($tipo, $options)[0];

    //verificamos que el mensaje no habia sido leido antes
    if($tipo == 'recibidos' && !empty($mensaje) && $mensaje['MensajeData']['msj_leido'] == 0  ){
       if($this->Mensaje->cambiaStatus($mensaje['MensajeData']['receptormsj_cve'],'leido',1)){
          $mensaje['MensajeData']['msj_leido']=1;
       }
    }

    $this->set(compact('mensaje','tipo'));
  }

  public function responder($id) {
     $title_for_layout = 'Responder Mensaje';
    if (!$this->Mensaje->MensajeData->exists($id)) {
      throw new NotFoundException('El mensaje que buscas no existe.');
    }
    if ($this->request->is('post') && $this->isAjax) {
      $this->saveMensaje();
      return ;
    }

    if ($this->request->is('get')) {
      $mensaje = $this->Mensaje->find('recibidos', array(
        'toUser' => $this->Auth->user('candidato_cve'),
        'userType' => $this->Acceso->is(),
        'mensaje' => $id
        // 'conditions' => array(
        //   'Mensaje.msj_cve' => $id
        // )
      ))[0];

      $this->leido($mensaje['MensajeData']['receptormsj_cve']);
    }

    $this->set(compact('mensaje','title_for_layout'));
  }

  public function leido($mensajeId) {
    $userId = $this->Auth->user('candidato_cve');

    if (!$this->Mensaje->MensajeData->isOwnedBy($userId, $mensajeId, $this->Acceso->is())) {
      $this->error('Este mensaje no existe.');
      return;
    }

    if ($this->Mensaje->MensajeData->leido($mensajeId)) {

     // $this->success('Este mensaje se ha marcado como leído.');
    } else {
      $this->error('Ha ocurrido un error al procesar tu solicitud.');
    }

  }


  public function eliminar($id=null){
      $this->cambia($id,"eliminado");
  }

public function restaurar($id=null){
      $this->cambia($id,"normal");
  }

public function eliminar_completamente($id=null){
      $this->cambia($id,"eliminado_permanente");
  }

  private function cambia($id= null,$status_name=null){

        if($id== null || $status_name==null){
          $this->error("Error el id es nulo.");
          $this->response->statusCode(300);
          return false;

        }
        $results=array(); $stat=array();
        $recibido=$this->Mensaje->MensajeData;
        $status=$recibido->status[$status_name];
        if($results=$recibido->cambia_status($id,$status)){
            $stat= $this->Mensaje->getStats($this->user['candidato_cve'],'candidato');
            $this->callback('deleteRow',array((array)$id ,$stat));
        } 
        else{
              $this->error("Error al tratar de $accion mensaje.");
              $this->response->statusCode(300);
        }
        $this->set(compact("stat"));
  }



  public function beforeFilter(){
    parent::beforeFilter();
    	//$this->Auth->allow();

  }

}
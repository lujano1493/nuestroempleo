<?php

App::uses('BaseEmpresasController', 'Controller');
App::uses('MensajeListener', 'Event');
App::uses('Utils', 'Utility');

class MisMensajesController extends BaseEmpresasController {
  public $name = 'MisMensajes';

  public $uses = array('Mensaje');
  // public $components = array('Notificaciones');
  /**
    * Método que se ejecuta antes de cualquier acción.
    */
  public function beforeFilter() {
    parent::beforeFilter();

    if (!empty($this->params['prefix']) && ($this->params['prefix'] == 'admin')) {
      $this->layout = 'admin/home';
    }
    /**
      * Acciones que no necesitan autenticación.
      */
    $allowActions = array();

    $this->Auth->allow($allowActions);
  }

  protected function updateSession() {
    $userId = $this->Auth->user('cu_cve');
    $ciaId = $this->Auth->user('Empresa.cia_cve');

    $stats = ClassRegistry::init('UsuarioEmpresa')->getStats($userId, $ciaId, 'mensajes');
    $this->Session->write('Auth.User.Stats.mensajes', $stats);
  }

  public function enviados() {
    $title_for_layout = __('Mensajes Enviados');

    $mensajes = $this->Mensaje->find('enviados', array(
      'fromUser' => $this->Auth->user('cu_cve'),
      'userType' => $this->Acceso->is()
    ));

    $this->set(compact('mensajes', 'title_for_layout'));
  }

  public function index() {
    $title_for_layout = __('Bandeja de Entrada');
    $this->updateSession();
    $mensajes = $this->Mensaje->find('recibidos', array(
      'toUser' => $this->Auth->user('cu_cve'),
      'userType' => $this->Acceso->is()
    ));

    $this->set(compact('mensajes', 'title_for_layout'));
  }

  public function importantes() {
    $title_for_layout = __('Mensajes Importantes');

    $mensajes = $this->Mensaje->MensajeData->find('recibidos', array(
      'toUser' => $this->Auth->user('cu_cve'),
      'userType' => $this->Acceso->is(),
      'conditions' => array(
        'Mensaje.msj_importante' => 1
      )
    ));

    $this->set(compact('mensajes', 'title_for_layout'));
    $this->render('index');
  }

  public function carpeta($folderId, $folderName = null) {
    $this->loadModel('Carpeta');

    $carpeta = $this->Carpeta->get($folderId, array(
      'recursive' => -1
    ));

    $title_for_layout = __('Mis Mensajes en %s', $carpeta['carpeta_nombre']);

    $mensajes = $this->Mensaje->MensajeData->find('recibidos', array(
      'toUser' => $this->Auth->user('cu_cve'),
      'userType' => $this->Acceso->is(),
      'conditions' => array(
        'MensajeData.carpeta_cve' => $folderId
      )
    ));

    $this->set(compact('mensajes', 'title_for_layout'));
    $this->render('index');
  }

  /**
   * Nuevo Mensaje.
   * @return [type] [description]
   */
  public function nuevo() {
    $title_for_layout = __('Nuevo Mensaje');

    if ($this->request->is('post')) {
      $data = $this->request->data;
      $data['Mensaje']['emisor_tipo'] = (int)$this->Acceso->is('candidato'); // 0 Reclutador, 1 Candidato
      $data['Mensaje']['emisor_cve'] = $this->Auth->user('cu_cve');
      $data['Mensaje']['msj_status'] = 1; // Indica que es nuevo.

      // La primera condición verifica los receptores. Ya no es necesaria.
      if (/*/(empty($data['Mensaje']['receptores']) || $data['Mensaje']['receptores'] == '[]') && /**/
        (empty($data['Mensaje']['c_receptores']) || $data['Mensaje']['c_receptores'] == '[]')) {
        $this->error(__('Debes agregar al menos un destinatario.'));

        $this->response->statusCode(400);
        return;
      }

      if ($this->Mensaje->saveMensaje($data)) {
        $this->updateSession();
        $this
          ->success(__('Se ha enviado el mensaje a tus destinatarios.'))
          ->redirect(array(
            'controller' => 'mis_mensajes',
            'action' => 'enviados'
          ));
      } else {
        $this->error(__('Ha ocurrido un error al intentar guardar tu mensaje.'));
        $this->response->statusCode(400);
      }
    }

    if (isset($this->request->query['id']) && ($id = $this->request->query['id'])) {
     $this->request->data['Mensaje']['c_receptores'] = "[$id]";
    }

    $this->set(compact('title_for_layout'));
  }

  public function reenviar($id) {
    $title_for_layout = __('Reenviar Mensaje');

    if (!$this->Mensaje->exists($id)) {
      throw new NotFoundException(__('El mensaje que buscas no existe.'));
    }

    if ($this->request->is('get')) {
      $mensaje = $this->Mensaje->find('enviados', array(
        'fromUser' => $this->Auth->user('cu_cve'),
        'userType' => $this->Acceso->is(),
        'conditions' => array(
          'Mensaje.msj_cve' => $id
        )
      ))[0];

      // De igual manera. Esto ya no es necesario ya que ya no puede reenviar a reclutadores.
      //$mensaje['Mensaje']['receptores'] = Utils::toJSONIntArray($mensaje, 'ReceptorEmpresa.{n}.receptor_cve');
      $mensaje['Mensaje']['c_receptores'] = Utils::toJSONIntArray($mensaje, 'ReceptorCandidato.{n}.receptor_cve');

      $this->set(compact('mensaje', 'title_for_layout'));

      $this->request->data = $mensaje;
    } else {
      $data = $this->request->data;
      $data['Mensaje']['emisor_tipo'] = (int)$this->Acceso->is('candidato');
      $data['Mensaje']['emisor_cve'] = $this->Auth->user('cu_cve');
      $data['Mensaje']['msj_status'] = 1; // Indica que es nuevo.
      if ($this->Mensaje->saveMensaje($data)) {
        // $results = $this->Notificaciones->formato_notificacion($data, array('tipo'=>'mensaje'));
        // $this->Notificaciones->enviar('send-ntfy', $results );
        $this->updateSession();
        $this
          ->success(__('Se ha enviado el mensaje a tus destinatarios.'))
          ->redirect(array(
            'controller' => 'mis_mensajes',
            'action' => 'enviados'
          ));
      } else {
        $this->error(__('Ha ocurrido un error al intentar guardar tu mensaje.'));
        $this->response->statusCode(400);
      }
    }

    $this->render('nuevo');
  }

  public function ver($id, $typeMsg = "recibidos") {
    $title_for_layout = __('Ver Mensaje');

    if ($typeMsg === 'recibidos') {
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

    $options[$typeUs] = $this->Auth->user('cu_cve');
    $options['userType'] = $this->Acceso->is();
    $options['first'] = true;

    $mensaje = $this->Mensaje->get($typeMsg, $options);

    //verificamos que el mensaje no habia sido leido antes
    if($typeMsg == 'recibidos' && !empty($mensaje) && $mensaje['MensajeData']['msj_leido'] == 0  ){
       if($this->Mensaje->cambiaStatus($mensaje['MensajeData']['receptormsj_cve'],'leido',1)){
          $mensaje['MensajeData']['msj_leido']=1;
       }
    }

    $this->set(compact('title_for_layout', 'mensaje', 'typeMsg'));
  }

  /**
   * Guarda a algún mensaje en las carpetas del usuario.
   * @param  int    $candidatoId [description]
   * @return [type]              [description]
   */
  public function guardar_en($mensajeId, $folderId, $folderSlug) {
    $userId = $this->Auth->user('cu_cve');

    if ($mensajeId) {
      $isOwnedBy = $this->Mensaje->MensajeData->isOwnedBy($userId, $mensajeId, $this->Acceso->is());
      if (!$isOwnedBy) {
        $this->error(__('El mensaje que intentas guardar no existe.'));
        return;
      }
      $successMsg = __('Se ha guardado el mensaje satisfactoriamente.');
    } else {
      $mensajeId = $this->request->data('ids');
      $successMsg = __('Se han guardado los mensajes en la carpeta satisfactoriamente.');
    }

    if ($this->Mensaje->MensajeData->guardarEnCarpeta($mensajeId, $userId, $folderId)) {
      $this->updateSession();
      $this->success($successMsg);
      $this->set(compact('folderId', 'mensajeId'));
    } else {
      $this->error(__('Ha ocurrido un error al procesar tu solicitud.'));
    }
  }

  public function leido($mensajeId) {
    $userId = $this->Auth->user('cu_cve');

    if ($mensajeId) {
      $isOwnedBy = $this->Mensaje->MensajeData->isOwnedBy($userId, $mensajeId, $this->Acceso->is());
      if (!$isOwnedBy) {
        $this->error(__('El mensaje que intentas guardar no existe.'));
        return;
      }
      $successMsg = __('El mensaje se ha marcado como leído.');
    } else {
      $mensajeId = $this->request->data('ids');
      $successMsg = __('Se han marcado los mensajes como leídos.');
    }

    if ($this->Mensaje->MensajeData->leido($mensajeId)) {
      $this->updateSession();
      $this->success($successMsg);
    } else {
      $this->error(__('Ha ocurrido un error al procesar tu solicitud.'));
    }
  }

  // public function archivar($mensajeId) {
  //   $userId = $this->Auth->user('cu_cve');

  //   if (!$this->Mensaje->isOwnedBy($userId, $mensajeId, $this->Acceso->is())) {
  //     $this->error('El mensaje que intentas archivar no existe.');
  //     return;
  //   }

  //   if ($this->Mensaje->archivar($mensajeId)) {
  //     $this->success('Se ha archivado el mensaje satisfactoriamente.');
  //   } else {
  //     $this->error('Ha ocurrido un error al procesar tu solicitud.');
  //   }
  // }

  public function borrar($mensajeId = null, $keycode = null) {
    $userId = $this->Auth->user('cu_cve');

    if ($mensajeId) {
      $isOwnedBy = $this->Mensaje->MensajeData->isOwnedBy($userId, $mensajeId, $this->Acceso->is());
      if (!$isOwnedBy) {
        $this->error(__('El mensaje que intentas borrar no existe.'));
        return;
      }

      $successMsg = __('Se ha borrado el mensaje satisfactoriamente.');
    } else {
      $mensajeId = $this->request->data('ids');
      $successMsg = __('Se han borrado los mensajes satisfactoriamente.');
    }

    if ($this->Mensaje->MensajeData->cambiaStatus($mensajeId)) {
      $this->Session->write('Auth.User.Folders.mensajes', ClassRegistry::init('Carpeta')->getFolders(
        $this->Auth->user('cu_cve'), 'mensajes'
      ));

      $this->updateSession();
      $this
        ->success($successMsg)
        ->callback('deleteRow', array(
          (array)$mensajeId
        ))
        ->html('element', 'empresas/submenus/mensajes');
    } else {
      $this->error(__('Ha ocurrido un error al procesar tu solicitud.'));
    }
  }

  public function responder($id) {
    $title_for_layout = 'Responder Mensaje';

    if (!$this->Mensaje->MensajeData->exists($id)) {
      throw new NotFoundException(__('El mensaje que buscas no existe.'));
    }

    if ($this->request->is('post') && $this->isAjax) {
      $data = $this->request->data;
      $data['Mensaje']['emisor_tipo'] = (int)$this->Acceso->is('candidato');
      $data['Mensaje']['emisor_cve'] = $this->Auth->user('cu_cve');

      if ($data['Mensaje']['user_type'] == 0) {
        $data['Mensaje']['receptores'] = "[" . $data['Mensaje']['to_user'] . "]";
      } else {
        $data['Mensaje']['c_receptores'] = "[" . $data['Mensaje']['to_user'] . "]";
      }

      if ($this->Mensaje->saveMensaje($data)) {
        // $results =$this->Notificaciones->formato_notificacion($data, array('tipo'=>'mensaje'));
        // $this->Notificaciones->enviar('send-ntfy', $results );
        $this->updateSession();
        $this
          ->success(__('Se ha enviado el mensaje a tus destinatarios'))
          ->redirect(array(
            'controller' => 'mis_mensajes',
            'action' => 'enviados'
          ));
      } else {
        $this->error(__('Ha ocurrido un error al guardar tu mensaje'));
        $this->response->statusCode(400);
      }
    } else {
      $mensaje = $this->Mensaje->find('recibidos', array(
        'toUser' => $this->Auth->user('cu_cve'),
        'userType' => $this->Acceso->is(),
        'mensaje' => $id
      ))[0];

      $this->set(compact('title_for_layout','mensaje'));
    }

  }

  public function eliminados() {
    $title_for_layout = __('Mensajes Eliminados');

    $mensajes = $this->Mensaje->find('recibidos', array(
      'toUser' => $this->Auth->user('cu_cve'),
      'userType' => $this->Acceso->is(),
      'status' => -1
    ));

    $this->set(compact('title_for_layout', 'mensajes'));
  }
}
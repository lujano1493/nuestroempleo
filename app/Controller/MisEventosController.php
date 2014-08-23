<?php

App::uses('BaseEmpresasController', 'Controller');

/**
 * Controlador de Eventos.
 */
class MisEventosController extends BaseEmpresasController {

  /**
    * Nombre del controlador.
    */
  public $name = 'MisEventos';

  public $components=array(
       'Shortener' => array(
          'base' => 'http://www.nuestroempleo.com.mx'
        )
    );

  /**
    * Indica qué modelos se usarán. Un array vacío, indica que no usará algún modelo.
    */
  public $uses = array('Evento');
  //public $components= array('Notificaciones');

  public function index() {
    $title_for_layout = __('Mis Eventos');

    $eventos = $this->Evento->get('all_info', array(
      'conditions' => array(
        'Evento.cia_cve' => $this->Auth->user('Empresa.cia_cve')
      ),
      'limit' => 6,
      'order' => array(
        'Evento.created' => 'DESC'
      )
    ));

    $this->set(compact('title_for_layout', 'eventos'));
  }

  public function publicar() {
    $title_for_layout = __('Publicar Evento');

    $this->set(compact('title_for_layout'));
  }

  public function todos() {
    $title_for_layout = __('Todos los Eventos');

    $conditions = array(
      'Evento.cia_cve' => $this->Auth->user('Empresa.cia_cve'),
    );
    $tsStart = $this->request->query('start');
    $tsEnd = $this->request->query('end');

    if ($tsStart && $tsEnd) {
      $conditions['AND'] = array(
          'evento_fecini >=' => date('Y-m-d H:i:s', $tsStart),
          'evento_fecfin <=' => date('Y-m-d H:i:s', $tsEnd),
      );
    }

    $eventos = $this->Evento->find('all_info', array(
      'conditions' => $conditions
    ));

    $this->set(compact('title_for_layout', 'eventos'));
  }

  public function registrar() {
    if (!$this->request->is('post')) {
      throw new MethodNotAllowedException();
    }
      /**
     * Se detecta si hay alguna referencia hacia algun correo electronico o telefono en la descripción
     */
    if(preg_match('/([a-zA-Z0-9_.+-]+)@([a-zA-Z_-]+).([a-zA-Z]{2,4})(.[a-zA-Z]{2,3})?/i', $this->request->data['desc']) ||
      preg_match("/0{0,2}([\+]?[\d]{1,3} ?)?([\(]([\d]{2,3})[)] ?)?[0-9][0-9 \-]{6,}( ?([xX]|([eE]xt[\.]?)) ?([\d]{2,5}))?/i",
       $this->request->data['desc'] ) ){
      $this->error("Hemos detectado una dirección de correo electrónico o teléfono en la Descripción del evento.");
      $this->set('message_time', 10000);
      $this->set('lastId',null);
      return;
    }


    $evento = $this->Evento->normalizar($this->request->data);
    $evento['cu_cve'] = $this->Auth->user('cu_cve');
    $evento['cia_cve'] = $this->Auth->user('Empresa.cia_cve');
    $evento['ciudad_cve'] = ClassRegistry::init('CodigoPostal')->field('ciudad_cve', array(
      'cp_cp' => $this->request->data['cp']
    ));
    $this->Evento->begin();
    $this->Evento->create();
    if ($this->Evento->save($evento) ) {
      // if(($data = $this->Evento->candidatos_cercas($this->Evento->id)) !== false) {
      //   $results = $this->Notificaciones->formato_notificacion($data, array(
      //     'tipo'=>'evento'
      //   ));

      //   $this->Notificaciones->enviar("send-ntfy", $results );
      // }

      $lastId = $this->Evento->getLastInsertID();
      if( $this->generateShortenURL($lastId) ===false){
        $this->Evento->rollback();
        $this->error("No fue posible generar url para evento.");
        $this->set("lastId",null);
        return;
      }
      $this->Evento->commit();
      $this->set(compact('lastId'));
      $this->success(__('Se ha guardado el evento satisfactoriamente.'));
    } else {
      $this->response->statusCode(301);
      $this->error(__('Ha ocurrido un error al intentar guardar el evento.'));
    }
  }

  public function actualizar($id) {
    if ($this->request->is('put')) {
           /**
       * Se detecta si hay alguna referencia hacia algun correo electronico o telefono en la descripción
       */
      if(preg_match('/([a-zA-Z0-9_.+-]+)@([a-zA-Z_-]+).([a-zA-Z]{2,4})(.[a-zA-Z]{2,3})?/i', $this->request->data['Evento']['desc']) ||
        preg_match("/0{0,2}([\+]?[\d]{1,3} ?)?([\(]([\d]{2,3})[)] ?)?[0-9][0-9 \-]{6,}( ?([xX]|([eE]xt[\.]?)) ?([\d]{2,5}))?/i",
         $this->request->data['Evento']['desc'] ) ){
        $this->error("Hemos detectado una dirección de correo electrónico o teléfono en la Descripción del evento.");
        $this->set('message_time', 10000);
        $this->set("id" ,null);
        return;
      }

      if ($this->Evento->actualizar($id, $this->request->data)) {
        $evento = $this->request->data;
        $this->success(__('Se ha modificado el evento satisfactoriamente.'));
        $this->set(compact('id', 'evento'));
      } else {
        $this->response->statusCode(301);
        $this->error(__('No se ha podido actualizar el evento.'));
      }
    }
  }

  public function cancelar($id) {
    if (!$this->request->is('post')) {
      throw new MethodNotAllowedException(__('Método no permitido.'), 1);
    }

    $isOwnedBy = $this->Evento->isOwnedBy($this->Auth->user('cu_cve'), $id);

    if ($isOwnedBy) {
      if ($this->Evento->cancelar($id)) {
        $this->success(__('El evento se canceló satisfactoriamente.'));
      } else {
        $this->error(__('Ha ocurrido un un error al intentar cancelar el evento.'));
      }
    } else {
      $this->error(__('No puedes cancelar un evento que no creaste.'));
    }
  }


  public function eliminar($eventoId = null, $keycode = null) {
    $userId = $this->Auth->user('cu_cve');
    $isKey = $keycode === $this->Auth->user('keycode');

    if ($eventoId) {
      $isOwnedBy = $this->Evento->isOwnedBy($this->Auth->user('cu_cve'), $eventoId);
      if (!$isOwnedBy) {
        $this->error(__('No tienes los permisos para esta acción.'));
        return;
      }
      $successMsg = __('Se ha borrado el evento de forma permanente.');
    } else {
      $eventoId = $this->request->data('ids');
      $successMsg = __('Se han borrado los eventos de forma permanente.');
    }

    if ($this->Evento->deleteAll(array(
      $this->Evento->primaryKey => $eventoId
    ))) {
      $this->success($successMsg);
      $this->callback('deleteRow', array(
        (array)$eventoId
      ));
    } else {
      $this->error(__('No se han podido eliminar los eventos que seleccionaste.'));
    }

    $this->redirect('referer');
  }
  public function mantenimiento_link($id=null){
    $this->autoRender=false;
    $sucess=$this->generateShortenURL($id);
    echo $sucess===false ? 'fallo' : $sucess;
  }

  protected function generateShortenURL($id) {
    $success = false;
    $evento = $this->Evento->get($id, array('fields' => array(
      'evento_cve', 'evento_nombre', 'evento_link'
    )));
    if(empty($evento)){
      return false;
    }
    $shortenUrl = $evento['evento_link'];
    if (empty($shortenUrl)) {
      $shortenUrl = $this->Shortener->shorten(array(
        'controller' => 'eventosCan',
        'id' => $id,
        'slug' => Inflector::slug($evento['evento_nombre'], '-'),
        'action' => 'ver'
      ));
      if( isset($shortenUrl['error']) ){
        return $shortenUrl;
      }
      $this->Evento->id = $id;
      $success = $this->Evento->saveField('evento_link', $shortenUrl);
    } else {
      $success = true;
    }

    return $success ? $shortenUrl : false;
  }
}
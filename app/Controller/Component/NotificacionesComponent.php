<?php

/**
 * Componente para envio de notificaciones utiliza elephantIO cliente de socket.io para php
 */
App::uses('Component', 'Controller');
App::uses('NtfyListener', 'Event');
App::uses('Acceso', 'Utility');
App::uses('Notificaciones', 'Utility');

class NotificacionesComponent extends Component {

  public function initialize(Controller $controller) {
    $this->controller = $controller;
    $this->params = $this->controller->request->params;

    // Agrega NtfyListener al manejador de eventos.
    $listener = new NtfyListener();
    $this->controller->getEventManager()->attach($listener);
  }

/**
 * metodo para enviar informacion al servidor de notificaciones
 * @param  string $evento tipo de evento a emitir
 * @param  array  $data   informacion que va ser enviado
 * @return null
 */

  public function formato_notificacion ($data=array(),$options=array()){
      if(!$data){
          return false;
      }
    $role=Acceso::is();
    $user=$this->controller->user;
    return Notificaciones::notificacion_formato($data,$options,$role,$user);
  }

  public function simple_format($data=array()){
      $role=Acceso::is();
      $user=$this->controller->user;
      return Notificaciones::simple_format($data,$role,$user);
  }

  public function enviar($event = 'default', $data = array(), $namespace = null) {

    $event = new CakeEvent('Component.Ntfy.send', $this, compact('event', 'data', 'namespace'));
    $this->controller->getEventManager()->dispatch($event);
  }

}
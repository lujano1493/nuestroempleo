<?php

App::uses('Router', 'Routing');
App::uses('BaseEventListener', 'Event');

class EventoListener extends BaseEventListener {

  public function implementedEvents() {
    return array(
      'Model.Evento.created' => 'sendNtfy'
    );
  }

  public function sendNtfy(CakeEvent $event) {
    $savedData = $event->data['data'];

    if ($this->save($savedData['Evento'], $savedData['Receptores'])) {
      $this->send('send-ntfy', $this->format($savedData),
        'candidatos'
      );
    }
  }

  public function format($data = array()) {
    $e = $data['Evento'];
    $eId = (int)$e['evento_cve'];
    $ids = Hash::extract($data['Receptores'], '{n}.id');
    // $emails = ClassRegistry::init('CandidatoUsuario')->getEmails($ids, true);
    $customData = $this->getEmailsAndNtfyID($ids);

    return array(
      'data' => array(
        // 'id' => $eId,
        'title' => $e['evento_nombre'],
        'body' => $e['evento_resena'],
      ),
      'meta' => array(
        'type' => 'evento',
        'route' => $this->route($eId),
        'created' => $this->date(),
        'isNew' => true
      ),
      'from' => array(
        'email' => $this->user('cu_sesion'),
        'name' => $this->user('fullName'),
        'logo' => $this->user('Empresa.logo')
      ),
      'to' => $customData,
    );
  }

  public function route($id) {
    return Router::url(array(
      'controller' => 'eventos_can',
      'action' => 'index',
         "?"=> "idEvento=$id"
    ));
  }

  public function save($evento, $receptores = array()) {
    $nData = array();           // Notificaciones
    $eData = array(             // Datos desde el evento
      'emisor_tipo' => 0,
      'emisor_cve' => $evento['cu_cve'],
      'notificacion_tipo' => 2,
      'notificacion_controlador' => $this->route($evento['evento_cve']),
      'notificacion_id' => $evento['evento_cve'],
      'notificacion_titulo' => $evento['evento_nombre'],
      'notificacion_texto' => $evento['evento_resena'],
      'notificacion_status' => 0,
      'notificacion_leido' => 0,
    );

    foreach ($receptores as $key => $value) {
      $nData[] = $eData + array(
        'receptor_tipo' => 1,
        'receptor_cve' => $value['id'],
      );
    }

    return $this->Notificacion->saveMany($nData);
  }
}
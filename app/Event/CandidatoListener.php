<?php

App::uses('BaseEventListener', 'Event');

class CandidatoListener extends BaseEventListener {

  public function implementedEvents() {
    return array(
      'Model.Candidato.viewCV' => 'ntfyAsignaciones'
    );
  }

  public function ntfyAsignaciones(CakeEvent $event) {
    $savedData = $event->data['data'];

    if ($this->save($savedData['VisitaCV'])) {
      $this->send('send-ntfy', $this->format($savedData), 'candidatos');
    }
  }

  public function format($data = array()) {
    $v = $data['VisitaCV'];
    $vId = (int)$v['visitacv_cve'];
    //$emails = ClassRegistry::init('CandidatoUsuario')->getEmails($v['candidato_cve'], true);
    $customData = $this->getEmailsAndNtfyID($v['candidato_cve']);

    return array(
      'data' => array(
        'id' => $vId,
        'title' => 'Han Visto tu Perfil',
        'body' => __('%s ha visitado tu perfil.', $this->user('fullName'))
      ),
      'meta' => array(
        'type' => 'notificacion',
        'route' => $this->route(),
        'created' => $this->date(),
        'isNew' => true
      ),
      'from' => array(
        'name' => $this->user('Empresa.cia_nombre'),
        'logo' => $this->user('Empresa.logo')
      ),
      'to' => $customData,
    );
  }

  public function route() {
    return Router::url(array(
      'controller' => 'busqueda_oferta',
      'action' => 'index',
      '?' => array(
        'dato' => $this->user('Empresa.cia_nombre')
      )
    ));
  }

  public function save($cv) {
    $data = array(             // Datos desde el evento
      'emisor_cve' => $cv['cu_cve'],
      'emisor_tipo' => 0,
      'notificacion_tipo' => 4,
      'notificacion_controlador' => $this->route(),
      'notificacion_titulo' => 'Han Visto tu Perfil',
      'notificacion_texto' => __('%s ha visitado tu perfil.', $this->user('fullName')),
      'notificacion_status' => 0,
      'notificacion_leido' => 0,
      'notificacion_id' => $cv['visitacv_cve'],
      'receptor_tipo' => 1,
      'receptor_cve' => $cv['candidato_cve'],
    );

    return $this->Notificacion->save($data);
  }
}
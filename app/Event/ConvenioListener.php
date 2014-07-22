<?php

App::uses('BaseEventListener', 'Event');

class ConvenioListener extends BaseEventListener {

  public function implementedEvents() {
    return array(
      'Model.Convenio.revision' => 'ntfyConvenio'
    );
  }

  public function ntfyConvenio(CakeEvent $event) {
    $savedData = $event->data['data'];

    if ($this->save($savedData)) {
      // $this->send('send-ntfy', $this->format($savedData), 'admin');
    }
  }

  public function route($empresa) {
    return Router::url(array(
      'admin' => true,
      'controller' => 'convenios',
      'action' => 'condiciones',
      'id' => $empresa['cia_cve'],
      'slug' => Inflector::slug($empresa['cia_nombre'], '-')
    ));
  }

  public function save($empresa) {
    $date = date('Y-m-d H:i:s', strtotime('+5 days'));

    $data = array(  // Datos desde el evento
      'emisor_cve' => $this->user('cu_cve'),
      'emisor_tipo' => -1,
      'notificacion_tipo' => 5,
      'notificacion_controlador' => $this->route($empresa),
      'notificacion_titulo' => 'Un Convenio está en revisión',
      'notificacion_texto' => __('El convenio de %s debe ser revisado.', $empresa['cia_nombre']),
      'notificacion_status' => 0,
      'notificacion_leido' => 0,
      'notificacion_id' => $empresa['cia_cve'],
      'receptor_tipo' => -1,
      'receptor_cve' => $this->user('cu_cve'),
      'created' => $date,
      'modified' => $date
    );

    return $this->Notificacion->save($data);
  }
}
<?php

App::uses('AppModel', 'Model');
App::uses('Security', 'Utility');
App::uses('CakeEvent', 'Event');
App::uses('InvitacionListener', 'Event');

class Invitacion extends AppModel {

    // Nombre del Modelo
  public $name = 'Invitacion';

  public $primaryKey = 'invitacion_cve';

  // Tabla.
  public $useTable = 'tinvitacion';

  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);

    // Agrega InvitacionListener al manejador de eventos.
    $listener = new InvitacionListener();
    $this->getEventManager()->attach($listener);
  }

  /**
   * Después de guardar cada invitación dispara el evento.
   * @param  [type] $created [description]
   * @param  array  $options [description]
   * @return [type]          [description]
   */
  public function afterSave($created, $options = array()) {
    if ($created) {
      $event = new CakeEvent('Model.Invitacion.created', $this, array(
        'id' => $this->id,
        'data' => $this->data[$this->alias]
      ));

      $this->getEventManager()->dispatch($event);
    }
  }

  public function saveAndSend($candidatos, $user = array()) {
    $data = array();

    $userId = $user['cu_cve'];
    $ciaId = $user['Empresa']['cia_cve'];
    foreach ($candidatos as $key => $value) {
      $c = array(
        'candidato_nom' => trim($value['nombre']),
        'candidato_mail' => trim($value['email']),
        'cu_cve' => $userId,
        'cia_cve' => $ciaId,
        'invitacion_status' => 0,
        'invitacion_ref' => $this->generateHash($value['email'] . $user['cu_sesion']),
      );

      $data[] = $c;
    }
    return $this->saveAll($data);
  }

  public function generateHash ($text = false) {
    if (!$text) {
      $text = 'A';
    }

    return Security::hash($text, 'md5', true);
  }
}

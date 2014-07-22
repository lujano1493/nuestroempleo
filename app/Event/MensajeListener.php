<?php

App::uses('Router', 'Routing');
App::uses('BaseEventListener', 'Event');

class MensajeListener extends BaseEventListener {

  public function implementedEvents() {
    return array(
      'Model.Mensaje.created' => 'sendNtfy'
    );
  }

  public function sendNtfy(CakeEvent $event) {
    $savedData = $event->data['data'];
    $emisor = (int)$savedData['Mensaje']['emisor_tipo'];

    if ($this->save($savedData['Mensaje'], $savedData['Receptores'])) {
      $this->send('send-ntfy', $this->format($savedData),
        $emisor === 0 ? 'candidatos' : 'empresas'
      );
    }
  }

  public function format($data = array()) {
    $m = $data['Mensaje'];
    $mId = (int)$m['msj_cve'];
    $emisor = (int)$m['emisor_tipo'];

    $ids = Hash::extract($data['Receptores'], '{n}.receptor_cve');
    $customData = $this->getEmailsAndNtfyID($ids, $emisor === 0 ? 'CandidatoUsuario' : 'UsuarioEmpresa', array(
      'meta.route' => 'notificacion_controlador'
    ));

    return array(
      'data' => array(
        // 'id' => $mId,
        'title' => $m['msj_asunto'],
        'body' => $m['msj_texto'],
      ),
      'meta' => array(
        'type' => 'mensaje',
        // 'route' => $this->route($mId, $emisor),
        'tmpl' => 'mensaje',
        'created' => $this->date(),
        'isNew' => true
      ),
      'from' => array(
        'email' => $this->user('cu_sesion') . $this->user('cc_email'),
        'name' => $this->user('fullName') . $this->user('Candidato.nombre_'),
        'logo' => $this->user('Empresa.logo') . $this->user('Candidato.logo')
      ),
      'to' => $customData,
    );
  }

  public function route($id, $type = 0) {
    return Router::url(array(
      'controller' => $type === 1 ? 'mensaje_can' : 'mis_mensajes',
      'action' => 'ver',
      'id' => $id
    ));
  }

  public function save($mensaje, $receptores = array()) {
    $nData = array();           // Notificaciones
    $mData = array(             // Datos desde el mensaje
      'emisor_tipo' => $mensaje['emisor_tipo'],
      'emisor_cve' => $mensaje['emisor_cve'],
      'notificacion_tipo' => 1,
      //'notificacion_controlador' => $this->route($mensaje['msj_cve'], $mensaje['emisor_tipo']),
      //'notificacion_id' => $mensaje['msj_cve'],
      'notificacion_titulo' => $mensaje['msj_asunto'],
      'notificacion_texto' => $mensaje['msj_texto'],
      'notificacion_status' => 0,
      'notificacion_leido' => 0,
    );

    foreach ($receptores as $key => $value) {
      $id = $value['receptormsj_cve'];
      $nData[] = $mData + array(
        'receptor_tipo' => $value['receptor_tipo'],
        'receptor_cve' => $value['receptor_cve'],
        'notificacion_controlador' => $this->route($id, (int)$value['receptor_tipo']),
        'notificacion_id' => $id,
      );
    }

    return $this->Notificacion->saveMany($nData);
  }
}
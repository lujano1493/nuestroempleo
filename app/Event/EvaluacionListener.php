<?php

App::uses('BaseEventListener', 'Event');

class EvaluacionListener extends BaseEventListener {

  public function implementedEvents() {
    return array(
      'Model.Asignacion.created' => 'ntfyAssignment',
      'Model.Evaluacion.completed' => 'ntfyTestCompleted'
    );
  }

  public function ntfyTestCompleted(CakeEvent $event) {
    $savedData = $event->data['data'];

    //debug($savedData);die;
    if ($this->saveTestCompleted($savedData['Evaluacion'], $savedData['EvaCan'])) {
      $this->send('send-ntfy', $this->formatTestCompleted($savedData), 'empresas');
    }
  }

  public function formatTestCompleted($data = array()) {
    $e = $data['Evaluacion'];
    $eId = (int)$e['evaluacion_cve'];

    $ids = Hash::extract($data['EvaCan'], 'cu_cve');
    //$emails = ClassRegistry::init('UsuarioEmpresa')->getEmails($ids, true);
    $customData = $this->getEmailsAndNtfyID($ids, 'UsuarioEmpresa');

    return array(
      'data' => array(
        //'id' => $eId,
        'title' => __('Se finalizó una evaluación.'),
        'body' => __('%s ha finalizado la evaluación %s', $this->user('Candidato.nombre_'), $e['evaluacion_nom']),
      ),
      'meta' => array(
        'type' => 'notificacion',
        'route' => '',
        'created' => $this->date(),
        'tmpl' => 'evaluacion',
        'isNew' => true
      ),
      'from' => array(
        'email' => $this->user('cc_email'),
        'name' => $this->user('Candidato.nombre_'),
        'logo' => $this->user('Candidato.logo')
      ),
      'to' => $customData,
    );
  }

  public function saveTestCompleted($e, $receptores = array()) {
    $eData = array(             // Datos desde el evento
      'notificacion_tipo' => 3,
      'notificacion_titulo' => __('Se finalizó una evaluación.'),
      'notificacion_texto' => __('%s ha finalizado la evaluación %s', $this->user('Candidato.nombre_'), $e['evaluacion_nom']),
      'notificacion_status' => 0,
      'notificacion_leido' => 0,
      'emisor_tipo' => 1,
      'emisor_cve' => $receptores['candidato_cve'],
      'notificacion_id' => $receptores['evaxcan_cve'],
      'notificacion_controlador' => '/mis_evaluaciones/'
        . Inflector::slug($e['evaluacion_nom'],'-') . '-' . $e['evaluacion_cve']
        . '/resultados/'
        . $receptores['candidato_cve']
      ,
      'receptor_tipo' => 0,
      'receptor_cve' => $receptores['cu_cve'],
    );

    return $this->Notificacion->save($eData);
  }

  public function ntfyAssignment(CakeEvent $event) {
    $savedData = $event->data['data'];

    if ($this->saveAssignment($savedData['Evaluacion'], $savedData['Asignaciones'])) {
      // $this->send('mensaje.created', $event->data);
      $this->send('send-ntfy', $this->formatAssignment($savedData), 'candidatos');
    }
  }

  public function formatAssignment($data = array()) {
    $e = $data['Evaluacion'];
    $eId = (int)$e['evaluacion_cve'];

    $ids = Hash::extract($data['Asignaciones'], '{n}.Candidato.id');
    //$emails = ClassRegistry::init('CandidatoUsuario')->getEmails($ids, true);
    $customData = $this->getEmailsAndNtfyID($ids);

    return array(
      'data' => array(
        //'id' => $eId,
        'title' => __('Se te ha asignado una nueva evaluación'),
        'body' => $e['evaluacion_nom'],
      ),
      'meta' => array(
        'type' => 'notificacion',
        'route' => $this->route($eId),
        'created' => $this->date(),
        'tmpl' => 'notificacion',
        'isNew' => true
      ),
      'from' => array(
        'name' => $this->user('fullName'),
        'logo' => $this->user('Empresa.logo')
      ),
      'to' => $customData,
    );
  }

  public function route($id) {
    return Router::url(array(
      'controller' => 'evaluaciones',
      'action' => 'aplicar',
      'id' => $id
    ));
  }

  public function saveAssignment($evaluacion, $receptores = array()) {
    $nData = array();           // Notificaciones
    $eData = array(             // Datos desde el evento
      'emisor_tipo' => 0,
      'notificacion_tipo' => 3,
      'notificacion_titulo' => __('Se te ha asignado una nueva evaluación'),
      'notificacion_texto' => $evaluacion['evaluacion_nom'],
      'notificacion_status' => 0,
      'notificacion_leido' => 0,
    );

    foreach ($receptores as $key => $value) {
      $nData[] = $eData + array(
        'emisor_cve' => $value['cu_cve'],
        'notificacion_id' => $value['evaxcan_cve'],
        'notificacion_controlador' => $this->route($value['evaxcan_cve']),
        'receptor_tipo' => 1,
        'receptor_cve' => $value['Candidato']['id'],
      );
    }

    return $this->Notificacion->saveMany($nData);
  }
}
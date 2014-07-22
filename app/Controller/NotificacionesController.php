<?php

class NotificacionesController extends AppController {
  public $name = 'Notificaciones';

  public $uses = array('Notificacion');

  public $components = array('Acceso');

  public function beforeFilter() {
    parent::beforeFilter();
  }

  public function admin_index() {

  }

  public function index() {
    $role = $this->Acceso->is();
    $data = array_merge(array(
      'type' => 'mensaje',
      'limit' => 10,
      'offset' => 0,
      'all' => 0,
    ), $this->request->query);

    $tipo = $data['type'];
    if ($this->isAjax) {
      $conditions = (int)$data['all'] === 0 ? array(
        'Notificacion.notificacion_leido' => 0
      ) : array();

      !empty($data['timestamp']) && $conditions['Notificacion.created <='] = date('Y-m-d H:i:s', $data['timestamp']);

      $notificaciones = $this->Notificacion->find('all_info', array(
        'idUser' => $this->user[$role === 'candidato' ? 'candidato_cve' : 'cu_cve'],
        'typeUser' => $role,
        'type' => $tipo,
        'limit' => $data['limit'],
        'offset' => $data['offset'],
        'conditions' => $conditions
      ));

      $this->set(compact('notificaciones'));
    }

    $this->set(compact('tipo'));
    $this->render($role);
  }

  public function leido($id = null) {
    $role = $this->Acceso->is();
    $idUser = $this->user[$role === 'candidato' ? 'candidato_cve' : 'cu_cve'];
    $totales = null;

    if ($this->Notificacion->isOwner($id, $idUser, $role) === false) {
      $this->error('Esta no es tu notificación');
    } elseif ($data = $this->Notificacion->leido($id)) {
      $typeUser = $role;
      $idUser = $this->user[$role === 'candidato' ? 'candidato_cve' : 'cu_cve'];
      $totales = $this->Notificacion->totales($typeUser, $idUser);
    }

    $this->set(compact('data', 'totales'));
  }
}


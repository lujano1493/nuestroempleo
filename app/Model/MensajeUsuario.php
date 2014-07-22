<?php

App::uses('AppModel', 'Model');

class MensajeUsuario extends AppModel {
  public $actsAs = array('Containable');

  public $primaryKey = 'receptormsj_cve';

  public $useTable = 'treceptormsj';

  public $belongsTo = array(
    'Mensaje' => array(
      'className' => 'Mensaje',
      'foreignKey' => 'msj_cve'
    ),
    'Carpeta' => array(
      'className' => 'Carpeta',
      'foreignKey' => 'carpeta_cve'
    )
  );

  public $findMethods = array('all_data' => true, 'recibidos' => true, 'enviados' => true);

  private $userType = array(
    'empresa' => 0,
    'candidato' => 1,
    'admin' => 100
  );

  public $status= array(
    'normal' => 0,
    'eliminado' => -1,
    'eliminado_permanente' => -2
  );

  protected function _findRecibidos($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['contain'] = array(
        'Carpeta',
        'Mensaje'
      );

      if (!isset($query['conditions'])) {
        $query['conditions'] = array();
      }

      $query['conditions'] = array_merge($query['conditions'], array(
        $this->alias . '.receptor_cve' => $query['toUser'],
        $this->alias . '.receptor_tipo' => $this->userType[$query['userType']],
        $this->alias . '.msj_status' => empty($query['status']) ? 0 : $query['status']
      ));

      $query['order'] = array(
        $this->alias . '.created' => 'DESC'
      );

      $query['recursive'] = -1;
      return $query;
    }

    $users = array(
      'empresas' => array(),
      'candidatos' => array(),
    );

    foreach ($results as $key => $value) {
      $userType = $value['Mensaje']['emisor_tipo'];
      $userId = $value['Mensaje']['emisor_cve'];

      if ((int)$userType === 0) { // Es empresa
        $users['empresas'][$userId] = true;
      } else {                    // Es candidato
        $users['candidatos'][$userId] = true;
      }
    }

    $usuariosEmpresa = !empty($users['empresas']) ? ClassRegistry::init('UsuarioEmpresa')->find('data', array(
      'fields' => array(
        'UsuarioEmpresa.cu_sesion Contacto__email'
      ),
      'conditions' => array(
        'UsuarioEmpresa.cu_cve' => array_keys($users['empresas'])
      ),
      'recursive' => -1
    )) : array();

    $usuariosCandidato = !empty($users['candidatos']) ? ClassRegistry::init('CandidatoEmpresa')->find('basic_info', array(
      'fields' => array(
        '(CandidatoEmpresa.candidato_nom || \' \' || CandidatoEmpresa.candidato_pat || \' \' || CandidatoEmpresa.candidato_mat) Cuenta__nombre',
      ),
      'conditions' => array(
        'CandidatoEmpresa.candidato_cve' => array_keys($users['candidatos'])
      ),
      'recursive' => -1
    )) : array();

    foreach ($results as $key => $value) {
      $userType = $value['Mensaje']['emisor_tipo'];
      $userId = $value['Mensaje']['emisor_cve'];

      if ((int)$userType === 0) { // Es empresa
        $user = current(Hash::extract($usuariosEmpresa, "{n}.Contacto[cu_cve=$userId]"));
      } else {                    // Es candidato
        $user = current(Hash::extract($usuariosCandidato, "{n}.Cuenta[candidato_cve=$userId]"));
      }

      if (!empty($user)) {
        $results[$key]['Emisor'] = $user;
      } else {
        unset($results[$key]);
      }
    }

    return $results;
  }

  /**
   * Marca como leídos, los mensajes especificados por $id
   * @param  mixed  $id     id (int) o ids (array) de los mensajes.
   * @param  boolean $leido [description]
   * @return [type]         [description]
   */
  public function leido($id, $leido = true) {
    $result= $this->updateAll(array(
      'msj_leido' => (int)$leido
    ), array(
      $this->alias . '.' . $this->primaryKey => $id
    ));

    $this->recursive = -1;
    $this->read(null, $id);
    $info = $this->data[$this->alias];

    $ntfy = ClassRegistry::init('Notificacion');
    $rs = $ntfy->find('first',array(
      'recursive' => -1,
      'conditions' => array(
        'receptor_tipo' => $info['receptor_tipo'],
        'receptor_cve' =>  $info['receptor_cve'],
        'notificacion_tipo' => 1,
        'notificacion_id' => $info['msj_cve']
      )
    ));

    if (!empty($rs)) {
      $rs = $rs['Notificacion'];
      $ntfy->id = $rs['notificacion_cve'];
      $ntfy->saveField('notificacion_leido', (int)$leido);
    }

    return $result;
  }

  /**
   * Cambia el status de los mensajes.
   * @param  mixed    $id     id (int) o ids (array) de los mensajes.
   * @param  string   $field  el campo. default msj_status
   * @param  integer  $status 0 = normal, -1 = papelera, -2 = eliminado (inaccesible).
   * @return [type]          [description]
   */
  public function cambiaStatus($id = null, $field = 'msj_status', $status = -1) {
    if ($field == 'msj_status' && is_string($status)) {
      $status = (int)$this->$status[$status];
    }

    return $this->updateAll(array(
      $field => $status
    ), array(
      $this->alias . '.' . $this->primaryKey => $id
    ));
  }

  public function cambia_status($id = null, $status=0 ) {
    $this->id=$id;
    return $this->saveField("msj_status",$status);

  }

  public function checaStatus($id = null, $field = "msj_status", $status = 1) {
    $result = $this->read($field, $id);
  	return $result[$this->alias]["msj_status"] == $status ;
  }

  // public function guardarEnCarpeta($mensajeId, $userId, $folderId, $userType = 0) {
  //   $mensajeId = $mensajeId ?: $this->id;
  //   if (!isset($mensajeId)) {
  //     throw new Exception("Error al cambiar datos del mensaje, id no especificado.");
  //   }

  //   return $this->updateAll(array(
  //     'carpeta_cve' => $folderId
  //   ), array(
  //     $this->primaryKey => $mensajeId
  //   ));
  // }

  /**
   * Verifica si el mensaje es propiedad del usuario.
   * @param  [type]  $userId   [description]
   * @param  [type]  $modelId  [description]
   * @param  [type]  $userType [description]
   * @return boolean           [description]
   */
  public function isOwnedBy($userId, $modelId = null, $userType = null) {
    return parent::isOwnedBy($userId, $modelId, array(
      'userKey' => 'receptor_cve',
      'conditions' => array(
        $this->alias . '.receptor_tipo' => $this->userType[$userType]
      )
    ));
  }

}
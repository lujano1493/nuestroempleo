<?php

App::uses('UsuarioAdminEmpresa', 'Model');

class UsuarioAdmin extends UsuarioAdminEmpresa {


  public $findMethods = array(
    'dependents' => true,
    'data' => true
  );

  public $validate = array(
    'cu_sesion' => array(
      'email' => array(
        'rule' => 'email',
        'allowEmpty' => false,
        'required' => true,
        'message' => 'Por favor, ingresa un email válido.'
      ),
      'unique' => array(
        'rule' => 'isUnique',
        'message' => 'Ya existe un usuario registrado con este email.'
      )
    ),
    'cu_sesion_confirm' => array(
      'required'=> array(
        'rule' => 'notEmpty',
        'required' => true,
        'message'    => 'Debes confirmar tu correo electrónico.'
      ),
      'equalto'=> array(
        'rule' => array('equalTo', 'cu_sesion'),
        'message' => 'Parece que no coinciden ambos correos electrónicos.'
      )
    ),
  );

  public function getLast($limit = 5) {
    return $this->find('all', array(
      'limit' => $limit,
      'order' => array(
        'UsuarioAdmin.created' => 'DESC'
      )
    ));
  }

  public function getAdmins($userId) {
    return $this->find('dependents', array(
      'conditions' => array(
        'UsuarioAdmin.per_cve <=' => 3,
        'UsuarioAdmin.cu_status' => 1
      ),
      'fields' => array('cu_cve', 'cu_sesion', 'per_cve'),
      'recursive' => -1,
      'parent' => $userId,
      'format' => 'cuenta'
    ));
  }


  public function editar($data, $userId = null) {
    $success = false;

    if ($userId) {
      $this->id = $userId;
    }

    $userData = array(
      'per_cve' => $data[$this->alias]['per_cve'],
      'cu_cvesup' => $data[$this->alias]['cu_cvesup']
    );

    $this->begin();

    $updateSubs = true;
    // Si el perfil nuevo va a ser ventas, sus subordinados
    // cambian al superior de éste.
    if ($data[$this->alias]['per_cve'] === 2) {
      $updateSubs = $this->updateSubsToSuper($this->id);
    }

    if ($updateSubs && $this->save($userData, false, array('per_cve', 'cu_cvesup'))) {
      $this->Contacto->id = $this->id;
      $contactoData = $data['Contacto'];
      if ($this->Contacto->save($contactoData)) {
        $this->commit();
        $success = true;
      }
    }
    !$success && $this->rollback();

    return $success;
  }

  public function eliminar($userId, $reassigments = array()) {

    $this->begin();
    $success = $this->cambiar_status($userId, -2);
    if ($success) {
      /**
       * Cuando haya nada que actualizar o no se tenga el id a reasignar establecerá las variables
       * $update...ToSuper a true para realizar el commit.
       * @var [type]
       */
      $updateCuentasToSuper = empty($reassigments['clientes']) || $this->updateSubsToSuper($userId, $reassigments['clientes']);

      if ($updateCuentasToSuper) {
        $this->commit();
        $success = true;
      } else {
        $this->rollback();
        $success = false;
      }
    }

    return $success;
  }

  public function beforeFind($queryData = array()) {
    if (empty($queryData['nextId'])) {
      $queryData['conditions']['UsuarioAdmin.per_cve <='] = 99;
    }

    return parent::beforeFind($queryData);
  }

}
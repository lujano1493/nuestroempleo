<?php

App::uses('AppModel', 'Model');
App::import('Vendor','funciones');

/**
 *
 */
class UsuarioBase extends AppModel {

  public $useTable = 'tcuentausuario';

  public $primaryKey = 'cu_cve';

  public $actsAs = array('Containable');

  /**
   * Nombre del campo del sesión del usuario.
   * @var string
   */
  public $sessionKey = 'cu_sesion';

  /**
   * Nombre del campo del status del usuario.
   * @var string
   */
  public $statusKey = 'cu_status';

  /**
   * Nombre del campo del password del usuario.
   * @var string
   */
  public $passwordKey = 'cu_password';

  /**
   * Genera un codigo de usuario basado en MD5
   * @param  boolean $unique Si es verdadero, buscará en la bd para evitar colisiones.
   * @return [type]          [description]
   */
  protected function generateKeycode($unique = false) {
    $keycode = Security::generateAuthKey();

    if ($unique && $this->hasAny(array($this->alias . '.keycode' => $keycode))) {
      $keycode = $this->generateKeycode(true);
    }

    return $keycode;
  }

  public function activar($id) {
    return $this->cambiar_status($id, 1);
  }

  public function inactivar($id) {
    return $this->cambiar_status($id, 0);
  }

  public function cambiar_status($id, $status = 0) {
    $usuario = array(
      $this->primaryKey => $id,
      $this->statusKey => $status
    );

    return $this->save($usuario, true, array($this->statusKey, 'keycode'));
  }

  public function changePassword($password = null, $id = null) {
    if (isset($id)) {
      $this->id = $id;
    } else if ($this->issetId()) {
      $this->id = $this->id ?: $this->data[$this->alias][$this->primaryKey];
    } else {
      throw new Exception("Error al cambiar datos del usuario, id no especificado.");
    }

    $this->password = $password ?: $this->newPassword();

    $data[$this->alias][$this->passwordKey] = $this->password;

    if ($this->save($data, false, array($this->passwordKey, 'keycode'))) {
      return array(
        'id' => $this->id,
        'password' => $this->password,
        'keycode' => $this->keycode
      );
    }

    return false;
  }

  public function updateEmail($email, $userId = null, $password = null) {
    if (isset($userId)) {
      $this->id = $userId;
    } else if ($this->issetId()) {
      $this->id = $this->id ?: $this->data[$this->alias][$this->primaryKey];
    } else {
      throw new Exception("Error al cambiar datos del usuario, id no especificado.");
    }

    $this->email = $email;
    $this->password = $password ?: $this->newPassword();

    $data[$this->alias][$this->sessionKey] = $this->email;
    $data[$this->alias][$this->passwordKey] = $this->password;
    $data[$this->alias][$this->statusKey] = -1;

    if ($this->save($data, true, array($this->statusKey, $this->sessionKey, $this->passwordKey, 'keycode'))) {
      return array(
        'id' => $this->id,
        'email' => $email,
        'password' => $this->password,
        'keycode' => $this->keycode
      );
    }

    return false;
  }

  public function beforeFind($queryData = array()) {
    if (empty($queryData['order'][0])) {
      $queryData['order'] = array(
        $this->alias . '.' . $this->primaryKey => 'ASC'
      );
    }

    return parent::beforeFind($queryData);
  }

  public function beforeSave($options = array()) {
    $this->data[$this->alias]['keycode'] = $this->generateKeycode();

    // Usamos bcrypt
    if (isset($this->data[$this->alias][$this->passwordKey])) {
      $hash = Security::hash($this->data[$this->alias][$this->passwordKey], 'blowfish');
      $this->data[$this->alias][$this->passwordKey] = $hash;
    }

    if (isset($this->data[$this->alias][$this->sessionKey])) {
      $this->data[$this->alias][$this->sessionKey] = trim($this->data[$this->alias][$this->sessionKey]);
    }

    return parent::beforeSave($options);
  }

  public function afterSave($created, $options = array()) {
    if (isset($this->data[$this->alias]['keycode'])) {
      $this->keycode = $this->data[$this->alias]['keycode'];
    }

    parent::afterSave($created, $options);
  }

  public function newPassword() {
    return Funciones::generar_clave(8);
  }

  public function verifyPassword($oldPassword, $userId = null) {
    if (isset($userId)) {
      $this->id = $userId;
    } else if ($this->issetId()) {
      $this->id = $this->id ?: $this->data[$this->alias][$this->primaryKey];
    } else {
      throw new Exception("Error al cambiar datos del usuario, id no especificado.");
    }

    $password = $this->field($this->passwordKey);

    return Security::hash($oldPassword, 'blowfish', $password) === $password;
  }

  public function getEmails($id, $job = false) {
    $emails = $this->find('all', array(
      'fields' => array(
        $this->alias . '.' . $this->primaryKey,
        $this->alias . '.' . $this->sessionKey,
      ),
      'conditions'  => array(
        $this->alias . '.' . $this->primaryKey => $id
      ),
      'recursive' => -1
    ));

    if ($job === 'group') {
      $emails = Hash::combine($emails,
        '{n}.' . $this->alias . '.' . $this->sessionKey, //key
        '{n}.' . $this->alias . '.' . $this->primaryKey  //value
      );

    } elseif ((bool)$job) {
      $emails = Hash::extract($emails, '{n}.' . $this->alias . '.' . $this->sessionKey);
      $emails = array_unique($emails);
    }

    return $emails;
  }
}
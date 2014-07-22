<?php
/**
  *
  */
App::uses('AppHelper', 'View/Helper');
App::uses('Acceso', 'Utility');

/**
 *
 */
class AccesoHelper extends AppHelper {

  public $helpers = array('Html', 'Session');

  /**
   * Obtiene el perfil del usuario logueado.
   * @param  [type] $profile [description]
   * @return [type]          [description]
   */
  public function profile($profile = null) {
    return Acceso::profile($profile);
  }

  /**
    * Verifica si el Usuario es administrador.
    * Si su número de perfil está entre 1 y 100, entonces el usuario es administrador.
    * @param User $user
    * @return boolean
    */
  public function isAdmin($user = null) {
    return Acceso::isAdmin($user);
  }

  /**
   * Verifica el perfil del usuario en base a los índices.
   * @param  integer $profile     [description]
   * @param  [type]  $profileName [description]
   * @return [type]               [description]
   */
  public function checkProfile($profile = null, $profileName = null) {
    return Acceso::checkProfile($profile, $profileName);
  }

  /**
   * Verifica el rol del usuario (admin = 0, coordinador = 1, reclutador = 2)
   * @param  [type] $profile [description]
   * @return [type]          [description]
   */
  public function checkRole($profile = null) {
    return Acceso::checkRole($profile);
  }

  /**
   * Verifica si el usuario 'guest', 'candidato', 'empresa', o 'admin'.
   * @param  [type]  $type [description]
   * @param  [type]  $user [description]
   * @return boolean       [description]
   */
  public function is($type = null, $user = null) {
    return Acceso::is($type, $user);
  }

  public function has($url = array()) {
    return Acceso::has($url);
  }

  public function isDevCompany() {
    $ciaId = $this->Session->read('Auth.User.Empresa.cia_cve');
    $cias = Configure::read('dev_companies');

    return !empty($cias) && in_array($ciaId, $cias);
  }
}

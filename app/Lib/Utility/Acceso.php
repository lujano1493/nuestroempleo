<?php

require_once(APP . 'Config' . DS . 'accesos.php');

App::uses('Router', 'Routing');

/**
 * Componente para verificar los permisos, accesos y créditos del Usuario.
 */
class Acceso {

  public static function rules($key = null) {
    $_rules = AccesoConfig::$rules;

    return $key === null ? $_rules : (
      !empty($_rules[$key]) ? $_rules[$key] : array()
    );
  }

  /**
   * Obtiene la definición de los perfiles.
   * @param  [type] $type     [description]
   * @param  [type] $maxOrMin [description]
   * @return [type]           [description]
   */
  public static function profiles($type = null, $maxOrMin = null) {
    $_profiles = AccesoConfig::$profiles;

    if (!is_null($type)) {
      if ($maxOrMin === 'min' || $maxOrMin === 'max') {
        return $_profiles[$type][$maxOrMin];
      }
      return $_profiles[$type];
    }

    return $_profiles;
  }

  /**
   * Obtiene el perfil del usuario logueado.
   * @param  [type] $profile [description]
   * @return [type]          [description]
   */
  public static function profile($profile = null) {
    return self::checkProfile(null, $profile);
  }

  /**
    * Verifica si el Usuario es administrador.
    * Si su número de perfil está entre 1 y 100, entonces el usuario es administrador.
    * @param User $user
    * @return boolean
    */
  public static function isAdmin($user = null) {
    if ($user === null) {
      $user = AuthComponent::user();
    }

    return self::checkProfile((int)$user['per_cve'], 'admin');
  }

  /**
   * Verifica el perfil del usuario en base a los índices.
   * @param  integer $profile     [description]
   * @param  [type]  $profileName [description]
   * @return [type]               [description]
   */
  public static function checkProfile($profile = null, $profileName = null) {
    $_profiles = AccesoConfig::$profiles;

    $return = 'guest';

    /**
     * Cuando $profile es null, se obtendra el perfil del usuario actual.
     *
     * Es preferible verificar que $user sea empresa o admin (ya que en estos si existe la clave 'per_cve'),
     * debido a que al hacer el cast a int, si es null convertiría a 0 haciendo administrador
     * a un usuario que no ha iniciado sesión o es candidato, caso que no queremos que suceda.
     * @var [type]
     */
    if ($profile === null && in_array(self::is(), array('admin', 'empresa'))) {
      $profile = (int)AuthComponent::user('per_cve');
    }

    if ($profile) {
      // Si especificamos $profileName, entonces queremos saber si $profile coincide con el tipo
      // retornando un booleano.
      if ($profileName) {
        $return = $profile >= $_profiles[$profileName]['min'] && $profile <= $_profiles[$profileName]['max'];
      } else {
        // En caso contrario, queremos saber el tipo de $perfil
        // retornando un string (tipo de perfil).
        foreach($_profiles as $p => $v){
          if ($profile >= $v['min'] && $profile <= $v['max']) {
            $return = $p;
            break;
          }
        }
      }
    }

    return $return;
  }

  /**
   * Verifica el rol del usuario (admin = 0, coordinador = 1, reclutador = 2)
   * @param  [type] $profile [description]
   * @return [type]          [description]
   */
  public static function checkRole($role = null, $userPerfil = null) {
    $_maxAdminProfile = AccesoConfig::$profiles['admin']['max'];
    $_roles = AccesoConfig::$roles;

    $_role = 'guest';

    /**
     * Cuando $profile es null, se obtendra el rol del usuario actual.
     * @var [type]
     */
    if ($userPerfil === null) {
      $userPerfil = (int)AuthComponent::user('per_cve');
    }

    if ($userPerfil > $_maxAdminProfile) {
      $_role = $_roles[$userPerfil % 100];
    }

    return ($role === null) ? $_role : $role === $_role;
  }

  /**
   * Verifica si el usuario 'guest', 'candidato', 'empresa', o 'admin'.
   * @param  [type]  $type [description]
   * @param  [type]  $user [description]
   * @return boolean       [description]
   */
  public static function is($type = null, $user = null) {
    $is = 'guest';

    if (is_null($user)) {
      $user = AuthComponent::user();
    }

    if (!empty($user)) {
      if (array_key_exists('candidato_cve', $user)) {
        $is = 'candidato';
      } elseif (array_key_exists('cu_cve', $user)) {
        $is = 'empresa';
        if (self::isAdmin($user)) {
          $is = 'admin';
        }
      }
    }

    return ($type === null) ? $is : $is === $type;
  }

  /**
   * [has description]
   * @return boolean [description]
   */
  public static function has($url = array()) {
    $url = empty($url) ? Router::url(null, true) : $url;

    if (is_string($url) && !($url = Router::parse($url))) {
      return false;
    }

    return !empty($url['controller']) ? self::verifyAccess($url['controller']) : false;
  }

  public static function verifyAccess($controller, $options = array()) {
    $hasAccess = false;
    $rules = self::rules($controller);

    if (empty($rules)) {
      return !$hasAccess; // Si no existe la regla, da acceso.
    }

    $profile = self::profile(); //Obtiene el perfil del usuario.

    if (array_key_exists($profile, $rules) || array_key_exists('*', $rules)) {
      $roles = isset($rules['*']) ? (array)$rules['*'] : (array)$rules[$profile];
      $hasAccess = (in_array('*', $roles) || in_array(self::checkRole(), $roles));
    }

    return $hasAccess;
  }
}
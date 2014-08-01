<?php

App::uses('Acceso', 'Utility');

/**
 * Componente para verificar los permisos, accesos y créditos del Usuario.
 */
class AccesoComponent extends Component {

  /**
   * [$components description]
   * @var array
   */
  public $components = array('Auth', 'Session', 'Creditos');

  /**
   * Inicialización del componente.
   * @param  Controller $controller [description]
   * @return [type]                 [description]
   */
  public function initialize(Controller $controller) {
    $this->controller = $controller;
    $this->params = $this->controller->request->params;

    $this->rules = Acceso::rules();
  }

  public function startup(Controller $controller) {
    $only = true;

    if (!in_array('Acceso', $this->controller->helpers) && !array_key_exists('Acceso', $this->controller->helpers)) {
      $this->controller->helpers[] = 'Acceso';
    }

    if ($only && !preg_match("/.*\.js$|.*\.css$/i", $this->controller->request->url)) {
      $this->only($this->params);
    }
  }

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

  public function isPrimera($role = 'candidato', $action = 'primera', $user = null) {
    /* verificamos que haya ingresado por primera vez */
    /* acciones que solo podran hacer la primera vez que ingresen */
    if (is_null($user)) {
      $user = $this->Auth->user();
    }

    if ($role === 'candidato') {
      $actions_ = array(
        'guardar',
        'primera',
        'loadFoto',
        'guardar_primera',
        'logout',
        'areas_generales',
        'carreras_genericas',
        'carreras_especificas',
        'agregarPsw'
      );

      if ('N' == $user['cc_completo'] && !in_array($action,$actions_)) {
        return false;
      }
    }
    return true;
  }

  public function defineStyle () {
    $styleApp = $this->Session->read('style');
    if (!$styleApp) {
      $styleApp = array(
        'css' => rand(1, 4),
        'img' => rand(0,4)
      );

      $this->Session->write('style', $styleApp);
    }

    $this->controller->set(compact('styleApp'));
  }

  /**
   * Verifica y da acceso con las opciones especificadas.
   * @param  [type] $options [description]
   * @return [type]          [description]
   */
  public function only($url) {
    if ($this->isAdmin()) {
      // Verifica si tiene acceso,
      $redirect = !Acceso::verifyAdminAccess($url);
      $redirect
        && $this->controller->info(__('No tienes acceso a esta área administrativa.'))
        && $this->controller->redirect('/admin/mi_espacio');
    } else {
      // Verifica si tiene acceso,
      $redirect = !Acceso::verifyAccess($url['controller']);

      $redirect && $this->Auth->user() && $this->redirect();
    }

  }

  /**
   * [redirect description]
   * @return [type] [description]
   */
  public function redirect() {
    $this->controller->info(__('No tienes acceso a esta área'));
    $this->controller->redirect('/planes');
  }

  public function isDevCompany($cia = null) {
    $ciaId = $this->Session->read('Auth.User.Empresa.cia_cve');
    $companias = Configure::read('dev_companies');

    if ($cia) {
      $cias = !empty($companias[$cia]) ? (array)$companias[$cia] : array();
    } else {
      $cias = array_values($companias);
    }

    return !empty($cias) && in_array($ciaId, $cias);
  }
}
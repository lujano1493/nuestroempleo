<?php
App::uses('CakeEventListener', 'Event');
App::uses('Email', 'Utility');
App::uses('Acceso', 'Utility');
App::uses('AuthComponent', 'Controller/Component');
App::uses('Usuario', 'Utility');
App::uses('Tiempito', 'Utility');
App::uses('Notificacion', 'Model');

abstract class BaseEventListener implements CakeEventListener {

  /**
   * Usuario logueado.
   * @var [type]
   */
  public $user = null;

  public $Notificacion = null;

  /**
   * Habilita los notificadores.
   * @var array
   */
  public $settings = array(
    'notifiers' => array(
      'Empresas', 'Candidatos'
    )
  );

  protected $_notifierObjects = array();

  public function __construct() {
    $this->user = $this->user();
    $this->Notificacion = new Notificacion();
  }

  public function user($key = null) {
    if ($key === 'Candidato.logo') {
      $id = AuthComponent::user('candidato_cve');
      return $id ? Usuario::getPhotoPath($id) : null;
    }

    return AuthComponent::user($key);
  }

  public function sendEmail($mailTo = null, $subject = null, $template = null, $vars = array(), $from = 'default') {
    Email::sendEmail($mailTo, $subject, $template, $vars, $from);
  }

  public function date($date = null) {
    return Tiempito::dt($date);
  }

  /**
   * Obtiene un notificador.
   * @param  [type] $notifier [description]
   * @return [type]           [description]
   */
  public function get($notifier) {
    $notifier = ucfirst($notifier);
    if (!$this->_isset($notifier)) {
      $this->constructNotifiers();
    }

    return $this->_notifierObjects[$notifier];
  }

  /**
   * Envia.
   * @param  [type] $event    [description]
   * @param  array  $data     [description]
   * @param  [type] $notifier [description]
   * @return [type]           [description]
   */
  public function send($event, $data = array(), $notifier = null) {
    if (!$notifier) {
      $notifier = Inflector::pluralize(Acceso::is());
    }

    return $this->get($notifier)->send($event, $data);
  }

  /**
   * Genera los notificadores.
   * @return [type] [description]
   */
  protected function constructNotifiers() {
    $config = Hash::normalize($this->settings['notifiers']);
    $global = array();

    foreach ($config as $class => $settings) {
      list($plugin, $class) = pluginSplit($class, true);
      $className = $class . 'Ntfy';

      if (!$this->_isset($class)) {
        App::uses($className, $plugin . 'Lib/Ntfy');
        if (!class_exists($className)) {
          throw new CakeException(__d('cake_dev', 'Notifier adapter "%s" was not found.', $class));
        }

        $settings = array_merge($global, (array)$settings, array(
          'namespace' => strtolower($class)
        ));

        $this->_notifierObjects[$class] = new $className($settings);
      }
    }

    return $this->_notifierObjects;
  }

  /**
   * Verifica que exista el notificador.
   * @param  [type] $notifier [description]
   * @return [type]           [description]
   */
  protected function _isset($notifier) {
    return !empty($this->_notifierObjects[$notifier]);
  }

  public function getEmailsAndNtfyID($ids, $modelName = 'CandidatoUsuario', $extraData = array()) {
    $emails = ClassRegistry::init($modelName)->getEmails($ids, 'group');
    $customData = array();

    foreach ($emails as $email => $id) {
      $notificacion = current(Hash::extract($this->Notificacion->allSavedData, "{n}.data.Notificacion[receptor_cve=$id]"));
      if ($notificacion && isset($notificacion['notificacion_cve'])) {
        $data = Hash::insert(array(), 'data.id', (int)$notificacion['notificacion_cve']);
        foreach ($extraData as $key => $value) {
          $data = Hash::insert($data, $key, $notificacion[$value]);
        }

        $customData[$email] = $data;
      }
    }

    return $customData;
  }
}
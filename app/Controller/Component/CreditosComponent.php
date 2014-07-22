<?php

App::uses('Component', 'Controller');
App::uses('CreditosListener', 'Event');

/**
 * Componente para verificar los créditos del Usuario.
 */
class CreditosComponent extends Component {

  private $availableKey = 'disponibles';
  private $usedKey = 'ocupados';
  private $serviceKey = 'servicio_cve';

  /**
   * [$components description]
   * @var array
   */
  public $components = array(
    'Auth',
    'Session',
    'Ntfy' => array(
      'notifiers' => array(
        'Empresas', 'Candidatos'
      )
    )
  );

  /**
   * Constructor del Componente, inicializa el modelo Crédito.
   * @param ComponentCollection $collection [description]
   * @param array               $settings   [description]
   */
  public function __construct(ComponentCollection $collection, $settings = array()) {
    $this->Credito = ClassRegistry::init('Credito');
    parent::__construct($collection, $settings);

  }

  /**
   * Inicialización del componente.
   * @param  Controller $controller [description]
   * @return [type]                 [description]
   */
  public function initialize(Controller $controller) {
    $this->controller = $controller;
    $this->params = $this->controller->params;

    // Agrega CreditosListener al manejador de eventos.
    $listener = new CreditosListener();
    $this->controller->getEventManager()->attach($listener);
  }

  /**
   * Rdirecciona a planes.
   * @param  [type] $message [description]
   * @return [type]          [description]
   */
  public function redirect($message = null) {
    $message = $message ?: 'No tienes los créditos suficientes.';

    $this->controller->warning($message);
    $this->controller->redirect('/planes');
  }

  /**
   * Verifica si tiene créditos de algún tipo.
   * @return boolean [description]
   */
  public function has($type) {
    if (is_bool($type)) {
      return $type;
    }

    $creditos = $this->Auth->user('Creditos');
    return isset($creditos[$type][$this->availableKey]) && (
      (int)$creditos[$type][$this->availableKey] >= 1 || (int)$creditos[$type]['creditos_infinitos'] === 1
    );
  }

  /**
   * Gasta creditos, actualizando la sesión y la BD.
   * @param  [type]  $type       [description]
   * @param  integer $numCredits [description]
   * @return [type]              [description]
   */
  public function spend($type, $productId = null, $numCredits = 1) {
    if ($type === true) {
      return true;
    }

    // El nombre de la variable a verificar en la sesión.
    $creditKey = implode('.', array('Auth.User', 'Creditos', $type));
    $credits = $this->Session->read($creditKey);
    if ((int)$credits[$this->availableKey] > 0) {
      //El tipo de servicio ahora es su clave.
      $type = $credits[$this->serviceKey];
      $available = (int)$credits[$this->availableKey];
      $used = (int)$credits[$this->usedKey];

      $user = $this->Auth->user();
      if ($this->Credito->spend($user, $type, $productId, $numCredits)) {
        $this->Session->write($creditKey . '.' . $this->availableKey, $available - $numCredits);
        $this->Session->write($creditKey . '.' . $this->usedKey, $used + $numCredits);
      }

      return (int)$this->Session->read($creditKey . '.' . $this->availableKey) == $available - $numCredits;
    } elseif ((int)$credits['creditos_infinitos'] === 1) {
      $type = $credits[$this->serviceKey];
      $user = $this->Auth->user();
      $used = (int)$credits[$this->usedKey];
      if (($success = $this->Credito->spend($user, $type, $productId, 'infinity'))) {
        $this->Session->write($creditKey . '.' . $this->usedKey, $used + $numCredits);
      }
      return $success;
    }
    return false;
  }

  /**
   * Actualiza los créditos del usuario desde la BD.
   * @return [type] [description]
   */
  public function update($users = array()) {
    if (!empty($users)) {
      array_push($users, $this->Auth->user('cu_cve'));
    }

    $creditsByEmpresa = $this->Credito->getByEmpresa(
      $this->Auth->user('Empresa.cia_cve'),
      array(
        'userId' => $this->Auth->user('cu_cve'),
        'users' => $users
      )
    );

    $event = new CakeEvent('Component.Creditos.updated', $this, array(
      'credits' => $creditsByEmpresa
    ));

    $this->controller->getEventManager()->dispatch($event);

    $userEmail = $this->Auth->user('cu_sesion');
    if (!empty($creditsByEmpresa[$userEmail]) && ($userCredits = $creditsByEmpresa[$userEmail])) {
      $this->Session->write('Auth.User.Creditos', $userCredits);
    }
  }

  /**
   * Compara que la asignación y recuperación de los créditos coincida.
   * Hace la suma de los $creditos disponibles + los recuperados y los compara con los créditos asignados.
   * Si los créditos asignados son mayor que los disponibles no continua.
   * @param  array  $data [description]
   * @return [type]       [description]
   */
  public function compare($data = array()) {
    $canAssign = true;
    $credits = $this->get();

    foreach ($credits as $key => $value) {
      // Checa si los créditos son infinitos.
      $infiniteCredits = (bool)$value['creditos_infinitos'];
      $availableCredits = $value['disponibles'];
      $assigned = Hash::extract($data, '{n}.Creditos.asignados.' . $key);
      $recovered = Hash::extract($data, '{n}.Creditos.recuperados.' . $key);

      if (!$infiniteCredits && $availableCredits + array_sum($recovered) < array_sum($assigned)) {
        $canAssign = false;
        break;
      }
    }

    return $canAssign;
  }

  public function get($type = array()) {
    $creditos = $this->Auth->user('Creditos');
    $to_get = array();

    if (empty($type)) {
      return $creditos;
    }

    foreach ((array)$type as $value) {
      $to_get[$value] = $creditos[$value];
    }

    return $to_get;
  }
}
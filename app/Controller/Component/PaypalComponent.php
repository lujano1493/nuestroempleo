<?php

App::uses('Component', 'Controller');
App::uses('Router', 'Routing');
App::uses('HttpSocket','Network/Http');

class PaypalComponent extends Component {
  public $Http = null;

  /**
   * Constructor del Componente.
   * @param ComponentCollection $collection [description]
   * @param array               $settings   [description]
   */
  public function __construct(ComponentCollection $collection, $settings = array()) {
    $this->Http = new HttpSocket();

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
  }

  public function isValid($data){
    $data['cmd'] = '_notify-validate';
    $data = array_map(array('PaypalComponent', 'clearSlash'), $data);

    if (isset($data['test_ipn'])) {
      $server = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    } else {
      $server = 'https://www.paypal.com/cgi-bin/webscr';
    }

    $response = $this->Http->post($server, $data);
    if ($response->body === 'VERIFIED') {
      return true;
    }

    if (!$response) {
      $this->log('HTTP Error in PaypalComponent::isValid while posting back to PayPal', 'paypal');
    }

    return false;
  }

  public static function clearSlash($value){
    return get_magic_quotes_runtime() ? stripslashes($value) : $value;
  }

}
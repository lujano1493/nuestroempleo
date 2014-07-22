<?php

App::uses('Component', 'Controller');
App::uses('HttpSocket', 'Network/Http');

/**
 * Component para hacer peticiones a otros dominios.
 */
class RequesterComponent extends Component {

  public $HttpSocket = null;

  public function __construct(ComponentCollection $collection, $settings = array()) {
    parent::__construct($collection, $settings);

    $this->HttpSocket = new HttpSocket();
  }

  public function initialize(Controller $controller) {
    $this->controller = $controller;
  }

  public function getFile($url, $query) {
    $file = $this->HttpSocket->get($url, $query);

    $this->controller->response->body($file->body());

    return $this->controller->response;
  }
}
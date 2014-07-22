<?php
/**
  *
  */
App::uses('AppController', 'Controller');

class BusquedaController extends AppController {

  /**
    * Nombre del controlador.
    *
    * @var string
    */
  public $name = 'Busqueda';

  public $uses = array();

  public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow();
  }

  /**
    *
    */
  public function index() {
    
  }

  /**
    *
    */
  public function admin_index() {
    
  }

  public function auto() {
  }

}

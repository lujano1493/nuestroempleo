<?php

App::uses('BaseEmpresasController', 'Controller');
/**
 * Controlador general de la aplicación.
 */
class ConfigController extends BaseEmpresasController {

  /**
    * Indica qué modelos se usarán. Un array vacío, indica que no usará algún modelo.
    */
  public $uses = array();

	/**
    * Componentes necesarios que utiliza el Controlador.
    * @var Array
  	*/
  public $components = array('Session');

  /**
    * Método que se ejecuta antes de cualquier acción.
    */
  public function beforeFilter() {
    parent::beforeFilter();
    /**
    	* Acciones que no necesitan autenticación.
    	*/
    $allowActions = array();

    $this->Auth->allow($allowActions);
  }

  public function index() {

  }

  public function admin_index() {
    $this->set('title_for_layout', 'Configuración');
  }

  public function admin_catalogos($type = null) {
    $this->loadModel('Catalogo');

    $gpos = $this->Catalogo->getGroups();

    $this->set(compact('gpos'));
  }

  public function admin_perfiles($type = null) {
    $this->loadModel('Catalogo');

    $gpos = $this->Catalogo->getGroups();

    $this->set(compact('gpos'));
  }
}
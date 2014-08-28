<?php

require_once(APP . 'Config' . DS . 'timbrado.php');

App::uses('Timbrado', 'Lib/CFDI');

class TimbradoComponent extends Component {

  protected $_timbrado = null;

  /**
   * Constructor del Componente.
   * @param ComponentCollection $collection [description]
   * @param array               $settings   [description]
   */
  public function __construct(ComponentCollection $collection, $settings = array()) {
    parent::__construct($collection, $settings);

    $this->_timbrado = Timbrado::init();
  }

  /**
   * Inicializacion del componente.
   * @param  Controller $controller [description]
   * @return [type]                 [description]
   */
  public function initialize(Controller $controller) {
    $this->controller = $controller;
    $this->params = $this->controller->params;
  }

  public function timbrar($folio, $config = 'default') {
    return $this->_timbrado->timbrar($folio, $config);
  }

  public function cancelar($folio, $config = 'defualt') {
    return $this->_timbrado->cancelar($folio, $config);
  }

  public function errors() {
    return $this->_timbrado->errors();
  }
}

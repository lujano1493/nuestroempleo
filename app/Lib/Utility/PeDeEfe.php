<?php
require_once(APP . 'Config' . DS . 'dompdf.inc.php');
spl_autoload_register('DOMPDF_autoload');

App::uses('File', 'Utility');
App::uses('View', 'View');

class PeDeEfe {
  public $fileName = null;

  protected $_dompdf = null;


  /**
   * Constructor del Componente.
   * @param ComponentCollection $collection [description]
   * @param array               $settings   [description]
   */
  public function __construct($fileName) {
    $this->fileName = substr(strtolower($fileName), -strlen('.pdf')) === '.pdf'
      ? $fileName
      : $fileName . '.pdf';

    $this->_View = new View();

    $this->_View->loadHelper('Time', array(
      'className' => 'Tiempito',
      'engine' => 'Tiempito'
    ));

    $this->_dompdf = new DOMPDF();
    $this->_dompdf->set_paper = 'A4';
  }

  // public function fromView($view, $data = array()) {
  //   $this->_View->set($data);

  //   $html = $this->_View->render($view, false);

  //   $this->_dompdf
  //     ->load_html(utf8_decode($html), Configure::read('App.encoding'));

  //   return $this;
  // }

  public function render($view, $vars = array()) {
    $this->_View->set($vars);
    $html = $this->_View->render($view, false);

    $this->_dompdf
      ->load_html(utf8_decode($html), Configure::read('App.encoding'));

    $this->_dompdf->render();

    return $this;
  }

  public function output() {
    return $this->_dompdf->output();
  }

  public function save() {
    $this->_file = new File($this->fileName, true);

    if ($this->_file->write($this->output())) {
      return $this->_file->path;
    }

    return false;
  }

  public static function fromView($fileName, $view, $data = array()) {
    return (new PeDeEfe($fileName))->render($view, $data);
  }
}
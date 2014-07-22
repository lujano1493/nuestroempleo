<?php
/**
  *
  */
App::uses('AppHelper', 'View/Helper');

/**
 *
 */
class TemplateHelper extends AppHelper {

  public $helpers = array('Html', 'Session', 'Form');

  public function __construct(View $View, $settings = array()) {
    parent::__construct($View, $settings);
  }

  public function insert($name, $data = array(), $options = array()) {
    $templates = array();
    if (!is_array($name)) {
      $name = (array)$name;
    }

    foreach ($name as $k => $n) {
      $tmplName = $n;

      if (is_string($k)) {
        $tmplName = array(
          'name' => $k,
          'id' => $n
        );
      }

      $templates[] = $this->get($tmplName, $data, $options);
    }

    return implode(PHP_EOL, $templates);
  }

  public function get($name, $data = array(), $options = array()) {
    $id = isset($name['id']) ? $name['id'] : false;
    $name = is_string($name) ? $name : $name['name'];

    $file = $this->_getTemplateFileName($name, $options);
    if ($file) {
      $id = $this->generateId($id ?: $name);
      return
         '<script id="'. $id . '" type="text/x-dot-template">' . PHP_EOL
        . $this->_renderTemplate($file, $data, $options) // . PHP_EOL
        . '</script>';
    }

    return false;
  }

  public function generateId($name) {
    $pieces = explode('__', $name);
    $name = $pieces[0];

    return 'tmpl-'. Inflector::slug($name, '-');
  }

  protected function _renderTemplate($file, $data = array(), $options = array()) {
    $data = $data ?: array();
    $template = $this->_evaluate($file, array_merge($this->_View->viewVars, $data));
    return $template;
  }

  protected function _evaluate($viewFile, $dataForView = array()) {
    extract($dataForView);
    ob_start();

    include $viewFile;

    unset($viewFile);
    return ob_get_clean();
  }

  protected function _getTemplateFileName($name, $options) {
    $viewPath = !empty($options['viewPath']) ? $options['viewPath'] : null;
    $folder = !empty($options['folder']) ? $options['folder'] : null;

    $path = $this->_generatePath($name, $viewPath, $folder);
    return file_exists($path) ? $path : false;
  }

  protected function _generatePath($name, $viewPath = null, $folder = null) {
    $appViewPaths = App::path('View');
    if (empty($viewPath)) {
      $viewPath = $this->_View->viewPath;
    }
    $path = $appViewPaths[0] . $viewPath . DS . 'templates' .
      ($folder ? DS . $folder : '') .
      DS . $name . '.ctp';

    return $path;
  }
}

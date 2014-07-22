<?php

App::uses('Component', 'Controller');
App::uses('Router', 'Routing');

class ShortenerComponent extends Component {
  
  private $path = null;

  /**
   * Constructor del Componente.
   * @param ComponentCollection $collection [description]
   * @param array               $settings   [description]
   */
  public function __construct(ComponentCollection $collection, $settings = array()) {
    $this->path = "https://www.googleapis.com/urlshortener/v1";
    
    if (empty($settings['api_key'])) {
      $settings['api_key'] = Configure::read('google_api_key');
    }

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

  /**
   * Corta la url.
   * @param  string|array   $url [description]
   * @return [type]      [description]
   */
  public function shorten($url) {
    if (is_array($url)) {
      /**
       * Si en las opciones, a llamar al componente, existe la clave 'base', su valor será
       * la base para generar los links. En caso contrario, la base será la definida en la variable
       * 'FULL_BASE_URL' que genera CakePHP.
       * @var string
       */
      $base = empty($this->settings['base']) ? null : $this->settings['base'];

      $url = $base . h(Router::url($url, empty($base)));
    }

    $data = $this->_shorten($url);

    return $data["id"];
  }

  /**
   * Encuetra la url original.
   * @param  [type] $url [description]
   * @return [type]      [description]
   */
  public function expand($url) {
    $data = $this->_expand($url);

    return $data["longUrl"];
  }

  protected function _expand($url) {
    $ch = curl_init($this->path . "/url?shortUrl=" . $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $rpta = curl_exec($ch);
    $data = json_decode($rpta, true);
    curl_close($ch);
    return $data;
  }

  protected function _shorten($url) {
    $key = $this->settings['api_key'];

    $ch = curl_init($this->path . "/url?key=" . $key);
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array('longUrl' => $url)));

    $rpta = curl_exec($ch);
    $data = json_decode($rpta, true);
    curl_close($ch);

    return $data;
  }
}
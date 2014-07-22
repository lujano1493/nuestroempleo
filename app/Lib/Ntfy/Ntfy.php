<?php

/**
 * Notificaciones.
 */
require_once(ROOT . DS . 'vendor' . DS . 'wisembly' . DS . 'elephant.io'. DS . 'lib' . DS . 'ElephantIO' . DS . 'Client.php');
use ElephantIO\Client as ElephantIOClient;

class Ntfy {

  public $socket = null;

  /**
   * Namespace para socket.io
   * https://github.com/LearnBoost/socket.io/wiki/Authorizing#wiki-namespace-authorization
   * @var string
   */
  public $namespace = '/';

  /**
   * Constructor.
   * @param array $settings [description]
   */
  public function __construct($settings = array()) {
    /**
     * Establece el namepace.
     * @var string
     */
    $this->namespace = '/' . (!empty($settings['namespace']) ? $settings['namespace'] : '');

    $this->socket = new ElephantIOClient($this->getURL($settings), 'socket.io', 1, false, true);
  }

  /**
   * Obtiene la URL de socket.io en base a la configuración.
   * @param  array  $settings [description]
   * @return [type]           [description]
   */
  protected function getURL($settings = array()) {
    $url = Configure::read('socket_io.url');
    $baseUrl = $url['host'] . (isset($url['port']) && is_numeric($url['port']) ? ':' . $url['port'] : '');

    return $baseUrl;
  }

  /**
   * Emite los eventos.
   * @param  [type] $event [description]
   * @param  array  $data  [description]
   * @return [type]        [description]
   */
  public function send($event, $data = array()) {
    try {
      /**
       * Inicia la conexión del socket.
       */
      $this->socket->init();

      /**
       * Estás línes son importantes, ya que es aquí dónde se establece el namespace.
       */
      $this->socket->send(1, '', $this->namespace);
      $this->socket->emit($event, $data, $this->namespace);

      /**
       * Cierra la conexión socket.
       */
      $this->socket->close();
    } catch (Exception $e) {

    }
  }
}
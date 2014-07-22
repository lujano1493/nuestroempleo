<?php

  /**
   * Por default esto contendrá la respuesta.
   * @var array
   */
  $response = array(
    'statusCode' => $this->response->statusCode(),
    'message' => !empty($errorMessage) ? $errorMessage : $this->Session->flash(),
  );

  if (!empty($message_time)) {
    $response['message_time'] = $message_time;
  }


  $response['results'] = array();
  /**
   * Si existe la variable $_results, asignará a la respuesta.
   */
  if (!empty($_results)) {
    $this->_results = $_results;
  }

  if (!empty($this->_results) || !empty($emptyResults)) {
    if (array_key_exists('paginate', $this->_results)) {
      $response = array_merge($response, $this->_results['paginate']);
      $this->_results = $this->_results['data'];
    }

    $response['results'] = $this->_results;
  }

  /**
   * Si existe la variable $redirectUrl, se mandará en el json como redirect.
   */
  if (!empty($redirectUrl)) {
    $response['redirect'] = $redirectUrl;
  }

  /**
   * Si existe la variable $callback, la agregará al json.
   */
  if (!empty($callback)) {
    $response['callback'] = $callback;
  }

    /**
   * Si existe la variable $html, la agregará al json.
   */
  if (!empty($html)) {
    if (!empty($_modal)) {
      $response['modal'] = $html;
    } else {
      $response['html'] = $html;
    }
  }

  if($content = $this->fetch('content')){
    $response['content'] = $content;
  }

  /**
   * Si hay validaciones, también las agregará a la respuesta.
   */
  if (!empty($noValidationErrors) === false && !empty($this->validationErrors)) {
    /**
     * Limpia los errores de validación para que se envíen sólo los de los modelos que generaron error.
     */
    $filterEmptys = function($item) use (&$filterEmptys) {
      if (is_array($item)) {
        return array_filter($item, $filterEmptys);
      }
      if (!empty($item)) {
        return true;
      }
    };

    $response['validationErrors'] = array_filter($this->validationErrors, $filterEmptys);
  }

  $debug = Configure::read('debug');

  /**
   * Si existe un error lo agregará a la respuesta.
   */
  if ($response['statusCode'] >= 300 && !empty($error) && $debug > 0) {
    $response['error'] = array(
      /*'attributes' => $error->getAttributes(),*/
      'message' => $error->getMessage(),
      'file' => $error->getFile(),
      'line' => $error->getLine(),
      'code' => $error->getCode()
    );
  }

  /**
   * Muestra el log si está disponible el debug.
   */
  if ($debug > 0) {
    $db = ConnectionManager::getDataSource('default');
    $response['logSql'] = $db->getLog(false, false);
    $response['debug'] = $debug;
  }

  /**
   * Envía la respuesta.
   */
  echo json_encode($response);
?>
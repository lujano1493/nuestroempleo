<?php


App::uses('ExceptionRenderer', 'Error');

/**
 * Clase que renderiza los errores.
 */
class AppExceptionRenderer extends ExceptionRenderer {

  /**
   * Maneja los errores 400. 
   * @param  Error $error
   * @return [type]        [description]
   */
  public function error400($error) {
    $codeError = $error->getCode() ?: 400; // Por default, es el error 400.
    $this->_prepareView($error, 'Not Found');
    $this->controller->response->statusCode($codeError);
    $this->_outputMessage('error' . $codeError);
  }

  // override
  public function error500($error) {
    $this->_prepareView($error, 'An Internal Error Has Ocurred.');
    $code = ($error->getCode() > 500 && $error->getCode() < 506) ? $error->getCode() : 500;
    $this->controller->response->statusCode($code);

    $this->_outputMessage('error500');
  }

  private function _prepareView($error, $genericMessage) {
    $message = $error->getMessage();
    /*if(!Configure::read('debug') && !Configure::read('detailed_exceptions')) {
      $message = __d('cake', $genericMessage);
    }*/
    $url = $this->controller->request->here();
    $renderVars = array(
      'name' => $message,
      'errorMessage' => $message,
      'url' => h($url),
      'code' => $error->getCode()
    );
    
    if(isset($this->controller->viewVars['csrf_token'])) {
      $renderVars['csrf_token'] = $this->controller->viewVars['csrf_token'];
    }
    $renderVars['_serialize'] = array_keys($renderVars);
    $this->controller->set('error', $error);
    $this->controller->set($renderVars);
  }
}
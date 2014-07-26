<?php

App::uses('Controller', 'Controller');
App::uses('ConnectionManager', 'Model');

class AppController extends Controller {

  /**
   * Helpers para las vistas.
   * @var array
   */
  public $helpers = array(
    'AssetCompress.AssetCompress',
    'Form' => array('className' => 'Formito'),
    'Html' => array('className' => 'Htmlito'),
    'Time' => array(
      'className' => 'Tiempito',
      'engine' => 'Tiempito'
    ),
    'Menu',
    'Template',
    'Facebook'=> array('className' => 'Facebookito' )
  );

  /**
   * Componentes para los controladores.
   * @var array
   */
  public $components = array(
    'Acceso',
    'Auth' => array(
      'authError' => 'Por favor inicia sesi&oacute;n para acceder a esta secci&oacute;n.',
      'authenticate' => array(
        'Admin' => array(
          'userModel' => 'UsuarioAdmin',        // Tabla TCUENTAUSUARIO
          'fields' => array(
            'username' => 'cu_sesion',          // Campo de la tabla que será el username.
            'password' => 'cu_password'         // Campo de la tabla que será el password.
          ),
          'scope' => array(
            'UsuarioAdmin.cu_status' => true,
          ),
          'recursive' => -1
        ),
        'Empresa' => array(
          'userModel' => 'UsuarioEmpresa',          // Tabla TCUENTAUSUARIO
          'fields' => array(
            'username' => 'cu_sesion',              // Campo de la tabla que será el username.
            'password' => 'cu_password'             // Campo de la tabla que será el password.
          ),
          'recursive' => 0,
        ),
        'Candidato' => array(
          'userModel' => 'CandidatoUsuario',            // Tabla tcuentausuarione
          'fields' => array(
            'username'=> 'cc_email',                  // campo de la tabla que será el usuario
            'password'=>'cc_password'                     // campo de la tabla que será la contraseÃ±a
          )
        )
      ),
      'authorize' => array('Controller'),
      'loginAction' => '/',
      'loginRedirect' => '/',
      'logoutRedirect' => '/',
    ),
    'DebugKit.Toolbar',
    'RequestHandler' => array(
      'viewClassMap' => array(
        'json' => 'AppJsonView'
      )
    ),
    'Session'
  );

  /**
    * Método que se ejecuta antes de cualquier acción.
    */
  public function beforeFilter() {
    parent::beforeFilter();
    $micrositio = array();

    if (!empty($this->request->params['compania'])) {
      $micrositio = $this->request->params['compania'];
    }

    $this->micrositio = $micrositio;
    $this->set(compact('micrositio'));

    // Propiedad corta para saber si la petición es ajax.
    $this->isAjax = $this->request->is('ajax') || $this->params['ext'] === 'json';
    /**
      * Obtiene al usuario autenticado y su rol.
      */
    $this->user = $authUser = $this->Auth->user();
    $role = $this->Acceso->is();
    $isAdmin = $role === 'admin';
    $isAuthUser = isset($authUser) && !empty($authUser);
    $title_layout = __('::Nuestro Empleo:: Tu espacio laboral en internet');
    $description_layout = __('Nuestro Empleo es una red laboral que te ayudará a conseguir contactos laborales confiables.');

    /**
     * (mixed)  $authUser    = Los datos del usuario autenticado.
     * (bool)   $isAdmin     = Si el usuario es amdinistrador.
     * (string) $role        = Rol del usuario: guest, candidato, empresa, admin.
     * (bool)   $isAuthUser  = Indica si el usuario se ha autenticado. En la vista se usa $isAuthUser.
     */
    $this->set(compact('authUser', 'isAuthUser', 'isAdmin', 'role', 'title_layout', 'description_layout'));

    /**
     * Establece el layout dependiendo del rol del usuario.
     */
    if ($noLayout = $this->request->header('No-Layout')) {
      $this->autoLayout = false;
    } else {
      $this->setLayout($role);
    }

    $isCandidato = $role === 'candidato';
    /**
     * En peticiones no Ajax o con layout, establecerá las notificaciones.
     */
    if ($isAuthUser &&  ((!$this->isAjax && !$noLayout)  || ($this->isAjax && $isCandidato))) {
      $userId = $authUser[$isCandidato ? 'candidato_cve' : 'cu_cve'];
      $notificaciones = ClassRegistry::init('Notificacion')->notificaciones($userId, $role, !$isCandidato);
      $this->set(compact('notificaciones'));
    }

    $this->set('_nolayout', $noLayout);

    $this->set('ajaxanizeTables', true);
    //*
    $referer = $this->referer();
    if ($this->request->is('get') && $referer !== $this->Session->read('App.referer')) {
      $this->Session->write('App.referer', $referer);
      $this->set('_referer', $referer);
    } else {
      $this->set('_referer', array('action' => 'index'));
    }
    //*/

    if (Configure::read('debug') > 0) {
      clearCache();
      $this->response->disableCache();
    }

    /**
     * Si el usuario no es empresa o admin, se define el estilo.
     */
    !in_array($role, array('empresa', 'admin')) && $this->Acceso->defineStyle();
  }

  /**
    * Verifica si el usuario está autorizado para determinadas acciones de los controladores.
    * @param  User    $user
    * @return boolean
    */
  public function isAuthorized($user) {
    $hasAccess = false;

    /**
     * Para acciones no administrativas, el usuario sólo tiene que estar autenticado como empresa o candidato.
     * Si son acciones de administrador, el usuario tiene que ser administrador.
     */
    if ($this->params['prefix'] != 'admin' && in_array($this->Acceso->is(), array('empresa', 'candidato'))) {
      $hasAccess = true;
    } elseif ($this->params['prefix'] === 'admin' && $this->Acceso->is('admin', $user)) {
      $hasAccess = true;
    }

    return $hasAccess;
  }

  /**
    * Función de redireccionamiento. Si la petición es ajax no redirecciona, agrega la variable redirectUrl
    * a la vista para ser enviada en el JSON.
    * @param string|array   $url      Url basado en string o array
    * @param integer        $status   Código de estado HTTP (ej: 404)
    * @param boolean        $exit     Si es true, exit() será llamada después de redireccionar.
    * @return void
    */
  public function redirect($url, $status = null, $exit = true) {
    if ($url === 'referer') {
      $url = $this->referer();
    }
    if(!empty($this->micrositio) && is_array($url)){
          $url['compania']=$this->micrositio['name'];
    }
    if (is_array($status) && !empty($status)) {
      $this->Session->write('App.persistData', $status);
      !$this->isAjax && $status = null;
    }

    if ($this->isAjax) {
      if ($this->autoLayout === false || $status === 'request' || !empty($status['request'])) {
        /**
         * Llama la acción definida por $url, y retorna el HTML.
         * NOTA: Esto es poco eficiente, así que se debe mejorar.
         */
        echo $this->requestAction($url, array('return'));
        $this->_stop();
      }

      if (!isset($this->request->data['noredirect']) || $this->request->data['noredirect'] == false) {
        $this->set('redirectUrl', Router::url($url));
      }

      /**
       * Verifica si la sesión es válida y si se ha recibido el código http 403 enviado el
       * componente de autenticación.
       * @var [type]
       */
      if ($status === 403/* Forbidden error. */) {
       throw new ForbiddenException(__('Tu sesión ha expirado.'), $status);
      } elseif (!$this->Auth->user()) {
       throw new UnauthorizedException(__('No tienes acceso a esta área.'), 401);
      }
    } else {
      parent::redirect($url, $status, $exit);
    }
  }

  /**
   * Función de renderizado.
   * Si en el query existe la llave suggestito, renderizará  (sólo si existe) con la vista suggestito.ctp.
   * @param  [type] $view   Vista
   * @param  [type] $layout Plantilla
   * @return [type]         Response
   */
  public function render($view = null, $layout = null) {
    if (isset($this->request->query['suggestito']) && $this->isAjax) {
      $paths = App::path('View');
      if (file_exists($paths[0] . $this->viewPath . '/suggestito.ctp')) {
        $view = 'suggestito';
        $this->set('noValidationErrors', true);
        $this->set('emptyResults', true);
      }
    }

    return parent::render($view, $layout);
  }

  /**
   * Establece la platilla de las vistas en base al rol del usuario.
   * @param string $role Rol del usuario.
   */
  public function setLayout($role = null) {
    switch ($role) {
      case 'empresa':
        $this->layout = 'empresas/home';
        break;
      case 'candidato':
        $this->layout = 'candidato/default';
        break;
      case 'admin':
        $this->layout = 'admin/home';
        break;
      default:
        $this->layout = 'default';
        break;
    }

    if ($this->isAjax || (
      isset($this->request->params['ext']) &&
      $this->request->params['ext'] === 'pdf'
    )) {
      $this->layout = 'default';
    }
  }

  /**
   * Establece mensajes de alerta en la sesión.
   * @param  string $message [description]
   * @param  array  $links   [description]
   * @param  string $class   [description]
   * @param  string $key     [description]
   * @return [type]          [description]
   */
  protected function alert($message, $element = true, $class = 'warning', $key = null) {
    if ($element === true) {
      $element = 'common/alert';
    }

    $this->Session->setFlash($message, $element, array(
      'class' => 'alert-' . $class
    ));

    return $this;
  }

  /**
    * Establece mensajes de error.
    * @param String $message
    */
  public function error($message, $element = true) {
    $this->response->statusCode(400);
    return $this->alert($message, $element, 'danger');
  }

  /**
    * Establece mensajes de éxito.
    * @param String $message
    */
  public function success($message, $element = true) {
    $this->response->statusCode(200);
    return $this->alert($message, $element, 'success');
  }

  /**
    * Establece mensajes de advertencia.
    * @param String $message
    */
  public function warning($message, $element = true) {
    return $this->alert($message, $element, 'warning');
  }

  /**
    * Establece mensajes de información.
    * @param String $message
    */
  public function info($message, $element = true) {
    return $this->alert($message, $element, 'info');
  }

  /**
   * Establece la variable 'callback', para ser enviada en el json con arreglo de parámetros.
   * @param  [type]   $fnCallback [description]
   * @param  array    $args       [description]
   * @return function             [description]
   */
  public function callback($fnCallback, $args = array()) {
    if ($this->isAjax) {
      $this->set('callback', array(
        'fn' => $fnCallback,
        'args' => $args
      ));
    }

    return $this;
  }

  /**
   * Establece la variable $html, se pueden renderizar elementos.
   * @return [type]       [description]
   */
  public function html() {
    $numArgs = func_num_args(); // # de argumentos.
    $args = func_get_args();    // Arreglo de argumentos.
    $html = '';

    /**
     * Si sólo existe un argumento, lo considera como el string HTML.
     */
    if ($numArgs === 1 && is_string($args[0])) {
      $html = $args[0];
    } else {
      $type = $args[0]; // Tipo
      if ($type === 'element') {
        $elementPath = $args[1];
        $elementVars = !empty($args[2]) && is_array($args[2]) ? $args[2] : array();

        $View = $this->_getViewObject();
        $html = $View->element($elementPath, $elementVars);
        if (!empty($elementVars['_modal'])) {
          $this->set('_modal', true);
        }
      }
    }

    $this->set(compact('html'));

    return $this;
  }

  public function modal($element, $vars = array()) {
    $vars['_modal'] = true;
    $this->html('element', $element, $vars);
  }

  /**
   * [responsejson description]
   * @param  array  $status       [description]
   * @param  [type] $url_redirect [description]
   * @return [type]               [description]
   */
  public function responsejson($status = array(), $url_redirect = null){
    $this->autoRender = false;
    $validations = array();
    $results = array();

    if($status[0]!="ok"){
      $this->response->statusCode(300);
    }

    if(count($status) === 3) {
      if($status[0]!=="ok"){
        $validations = $status[2];
      }
       $results = $status[2];
    }

    $rs = array(
      'statusCode' => $this->response->statusCode(),
      'type' => $status[0],
      'message' => $status[1],
      "name"=> $this->name,
      "results"=>$results,
      'validationErrors' =>  $validations
    );

    /* si contiene una url de redirección*/
    if ($url_redirect) {
      $rs['redirect'] = $url_redirect;
    }
   if (Configure::read('debug') > 0) {
      $db = ConnectionManager::getDataSource('default');
      $rs['logSql'] = $db->getLog(false, false);
    }


    $rs['debug'] =Configure::read('debug');

    echo json_encode($rs);
  }
}

<?php

App::uses('BaseEmpresasController', 'Controller');
App::uses('Folder', 'Utility');

/**
 * Controlador Empresa.
 */
class EmpresasController extends BaseEmpresasController {

  /**
   * Nombre del controlador.
   * @var string
   */
  public $name = 'Empresas';

  /**
   * Componentes necesarios que utiliza el Controlador.
   * @var array
   */
  public $components = array('Session', 'Emailer', 'VisualCaptcha');

  public $helpers = array('VisualCaptcha');

  /**
   * Opciones para la paginación de las Empresas.
   * @var array
   */
  public $paginate = array(
    'Empresa' => array(
      //'allowed',              // Específica que se usará la function _findAllowed
      'fields' => array('Empresa.cia_cve', 'Empresa.cia_nom', 'Empresa.cia_rfc'),
      'limit' => 20,
      'order' => array(
        'Empresa.cia_cve' => 'asc',
        'Empresa.cia_nom' => 'asc'
      ),
      'recursive' => -1
    ),
    'Facturas' => array(
      'recursive' => -1,
      'limit' => 20,
      'order' => array(
        'Factura.factura_folio' => 'asc',
      )
    )
  );

  private function _registrar($data, $perfil = null, $parentUser = null) {
    $this->loadModel('Empresa');
    $this->loadModel('UsuarioEmpresa');

    // Inician transacciones.
    $this->Empresa->begin();
    $this->UsuarioEmpresa->begin();

    $succesfulSaving = $empresaId = false;

    /**
     * Primero se validan los datos de la empresa y se registra al usuario.
     */
    if ($this->Empresa->saveAll($data, array('validate' => 'only'))
      && $this->UsuarioEmpresa->registrar($data, $perfil, $parentUser)) {

      /**
       * El id del usuario que se ha creado.
       * @var [type]
       */
      $userId = $this->UsuarioEmpresa->id;

      if ($this->Empresa->registrar($data, $userId, array('validate' => false))) {

        /**
          * Datos del usuario registrado.
          */
        $email = $this->UsuarioEmpresa->email;
        $password = $this->UsuarioEmpresa->password;
        $keycode = $this->UsuarioEmpresa->keycode;
        $cia_nom = $data['Empresa']['cia_nombre'];

        $this->Emailer->sendEmail(
          $email,                                                       //El email de ventas.
          __('Bienvenido. La cuenta de %s ha sido creada.', $cia_nom),  // Subject
          'empresas/bienvenida',                                         // Plantilla
          array(                                                        // Variables
            'email' => $email,
            'password' => $password,
            'cia_nom' => $cia_nom,
            'keycode' => $keycode
          )
        );

        $empresaId = $this->Empresa->getLastInsertID();
        $this->Empresa->commit();
        $this->UsuarioEmpresa->commit();

        $succesfulSaving = true;
      } else {
        $this->Empresa->rollback();
      }
    } else {
      $this->UsuarioEmpresa->rollback();
    }

    if ($succesfulSaving && $empresaId) {
      // $empresa = $this->Empresa->get($empresaId, 'basic_info');
      $data['Empresa']['cia_cve'] = $empresaId;
      $this->Emailer->sendEmail(array(
        'ventas.ne@nuestroempleo.com.mx',
        'jmreynoso@igenter.com',
        'flujano@igenter.com'
      ), __('Se ha registrado una nueva empresa.'),
        'admin/nueva_compania', array(
          'empresa' => $data
        ),
        'admin'
      );
    }

    return $succesfulSaving;
  }

  /**
   * Método que se ejecuta antes de cualquier acción.
   * @return [type] [description]
   */
  public function beforeFilter() {
    parent::beforeFilter();

    /**
      * Acciones que no necesitan autenticación.
      */
    $allowActions = array('iniciar_sesion', 'index', 'registrar', 'activar', 'enviar_activacion', 'planes');

    $this->Auth->allow($allowActions);
  }

  /**
   * [iniciar_sesion description]
   * @return [type] [description]
   */
  public function iniciar_sesion($keycode = null) {
    $this->layout = 'empresas/simple';
    /** Redireccionar al administrador de la empresa. */
    $redirectUrl = array('admin' => 0, 'controller' => 'empresas', 'action' => 'index');

    if (!$this->request->is('post')) { // GET, PUT, DELETE
      if ($keycode) {
        // Loguea al usuario.
      }

      if($this->Auth->user()) {
        $redirectUrl = $this->request->query('url') ?: array('admin' => 0, 'controller' => 'mi_espacio', 'action' => 'index');
        $this->redirect($redirectUrl);
        return;
      }
    }

    $this->request->data['UsuarioEmpresa']['cu_sesion'] = trim($this->request->data['UsuarioEmpresa']['cuenta']);
    $this->request->data['UsuarioEmpresa']['cu_password'] = $this->request->data['UsuarioEmpresa']['password'];

    $this->loadModel('UsuarioEmpresa');
    $user = $this->UsuarioEmpresa->find('first', array(
      'conditions' => array(
        'UsuarioEmpresa.cu_sesion' => $this->request->data['UsuarioEmpresa']['cu_sesion']
      ),
      'fields' => array('cu_sesion', 'cu_status', 'cu_cve', 'per_cve'),
      'recursive' => -1
    ));

    if (!empty($user)) {
      $redirectUrl = $this->Session->check('Auth.redirect') ? $this->Session->read('Auth.redirect') : array('admin' => 0, 'controller' => 'mi_espacio', 'action' => 'index');
      $this->Session->destroy();
      $_SESSION = array();

      if ((int)$user['UsuarioEmpresa']['cu_status'] > 0) {
        $this->UsuarioEmpresa->updateProfile($user['UsuarioEmpresa']['cu_cve']);
      }

      if ($user['UsuarioEmpresa']['cu_status'] == 0) {
        $this->warning(__('Su cuenta ha sido inactivada. Contacta a tu administrador.'));
      } elseif ($user['UsuarioEmpresa']['cu_status'] == -1) {
        $this->warning(__('Tu cuenta aún no ha sido verificada. Revisa tu correo electrónico.'));
      } elseif ($user['UsuarioEmpresa']['cu_status'] <= -2) {
        $this->warning(__('Esta cuenta ha sido eliminada.'));
      } elseif (!$this->UsuarioEmpresa->Perfil->hasAny(array(
        'Perfil.per_cve' => $user['UsuarioEmpresa']['per_cve']
      ))) {
        $this->error(__('El perfil que tienes no existe'));
      } elseif($this->Auth->login()) {
        // $redirectUrl = $this->Session->check('Auth.redirect') ? $this->Session->read('Auth.redirect') : array('admin' => 0, 'controller' => 'mi_espacio', 'action' => 'index');
        /*$this->success(__('Bienvenido, de un recorrido por Nuestro Empleo.'));*/

        /**
          * Carga en la sesión los datos de la empresa que pertenece el usuario.
          */
        $this->Session->write('Auth.User.Empresa', $this->UsuarioEmpresa->Empresa->getByUserId(
          $this->Auth->user('cu_cve'), true
        ));

        $this->Session->write('Auth.User.Creditos', ClassRegistry::init('Credito')->getByUser(
          $this->Auth->user('cu_cve'),
          $this->Auth->user('Empresa.cia_cve')
        ));

        $this->Session->write('Auth.User.Perfil', $this->UsuarioEmpresa->Perfil->getProfile(
          $this->Auth->user('cu_cve'),
          $this->Auth->user('Empresa.cia_cve'),
          $this->Auth->user('per_cve')
        ));

        $this->Session->write('Auth.User.Stats', $this->UsuarioEmpresa->getStats(
          $this->Auth->user('cu_cve'), $this->Auth->user('Empresa.cia_cve')
        ));

        $usuarioDatos = $this->UsuarioEmpresa->Contacto->getDatos(
          $this->Auth->user('cu_cve'), true
        );

        $this->Session->write('Auth.User.Datos', $usuarioDatos);
        $this->Session->write('Auth.User.fullName', $usuarioDatos['con_nombre'] . ' ' . $usuarioDatos['con_paterno']);

        $this->redirect($redirectUrl);
      } else {
        $this->error(__('Nombre de usuario o contraseña inválidos.'));
      }
    } else {
      $this->error(__('Nombre de usuario o contraseña inválidos.'));
    }
    $this->redirect($redirectUrl);
  }

  /**
   * [cerrar_sesion description]
   * @return [type] [description]
   */
  public function cerrar_sesion() {
    $this->success(__('Has cerrado tu sesión satisfactoriamente.'));
    $this->redirect(array(
      'controller' => 'empresas',
      'action' => 'index'
    ));
  }

  /**
   * [index description]
   * @return [type] [description]
   */
  public function index() {
    $this->layout = 'empresas/simple';

    if ($this->Acceso->is('empresa')) {
      $redirectUrl = array('controller' => 'mi_espacio', 'action' => 'index');
      $this->redirect($redirectUrl);
    }

    $this->loadModel('Catalogo');
    $this->set('list_medios', $this->Catalogo->lista('medioinf_cve'));
  }

  /**
   * [admin_index description]
   * @return [type] [description]
   */
  public function admin_index() {
    $this->set('title_for_layout', __('Administración de Empresas'));

    $this->loadModel('UsuarioAdmin');
    $usuarios = $this->UsuarioAdmin->getAdmins($this->Auth->user('cu_cve'));

    if ($this->isAjax) {
      $lista_empresas = $this->Empresa->find('basic_info', array(
        'order' => array(
          'Empresa.created' => 'DESC NULLS LAST'
        )
      ));
    }

    $this->set(compact('lista_empresas', 'usuarios'));
  }

  public function admin_convenios() {
    $title_for_layout = __('Convenios');

    if ($this->isAjax) {
      $lista_empresas = $this->Empresa->find('basic_info', array(
        'type' => 'convenio',
        'order' => array(
          'Empresa.created' => 'DESC NULLS LAST',
        )
      ));
    }

    $this->set(compact('title_for_layout','lista_empresas'));
  }

  public function admin_recientes() {
    $lista_empresas = $this->Empresa->getLast();

    $this->set(compact('lista_empresas'));

    $this->render('admin_index');
  }

  /**
   * [registrar description]
   * @return [type] [description]
   */
  public function registrar() {

    $this->layout = $this->isAjax ? 'default' : 'empresas/simple';

    if ($this->request->is('post')) {
      $data = $this->request->data;

      if(!$this->VisualCaptcha->isValid()){
        $this->response->statusCode(400);
        $sts = array('error', __('El Objeto arrastrado es distinto'));
        $this->responsejson($sts);
        return ;
      }

      /**
       * Por default, la empresas son tipo comercial.
       */
      $data['Empresa']['cia_tipo'] = 0;

      /**
       * Por default, registra la empresa con el perfil null que es igual a 100.
       */
      if ($this->_registrar($data)) {
        $this->success(__('Sus datos han sido enviados correctamente. Revise el correo electrónico registrado y active la cuenta.'), false);
      } else {
        $this->response->statusCode(400);
        $this->error(__('Ha ocurrido un error al registar tus datos.'), false);
      }
    }
  }

  public function admin_registrar() {
    if ($this->request->is('post')) {
      $data = $this->request->data;

      /*
        Se debe comprobar que el usuario exista.
       */
      $usuarioSuperior = $data['Empresa']['ejecutivo_cve'];

      if ($this->_registrar($data, null, $usuarioSuperior)) {
        $this->success(__('Se ha registrado la compañia correctamente. Se ha enviado un correo para confirmar la cuenta.'));

        $this->redirect(array(
          'admin' => true,
          'action' => 'index'
        ));

      } else {
        $this->response->statusCode(301);
        $this->error(__('Ha ocurrido un error al registar los datos.'));
      }
    }
  }

  /**
   * Activa la cuenta de UsuarioEmpresa verificando su correo electrónico.
   * Una vez activada la cuenta, cambia el status de UsuarioEmpresa para permitirle iniciar sesión.
   * @param  [type] $keycode [description]
   * @return [type]          [description]
   */
  public function activar($keycode = null) {
    if (is_null($keycode)) {
      throw new NotFoundException(__("La página que buscas acceder no existe."));
    }

    $this->loadModel('UsuarioEmpresa');

    /**
      * Busca al usuario por medio de su keycode.
      */
    $this->UsuarioEmpresa->recursive = -1;
    $usuario = $this->UsuarioEmpresa->findByKeycode($keycode);

    if (!empty($usuario)) {
      if ($usuario['UsuarioEmpresa']['cu_status'] == -1) {
        if (!$this->UsuarioEmpresa->activar($usuario['UsuarioEmpresa']['cu_cve'])) {
          $this->error(__('Ocurrió un error al actualizar tu cuenta. Intenta más tarde.'));
        }
      }
      $this->success(__('Su cuenta ha sido activada. Puede iniciar sesión.'));
      $this->redirect(array('controller' => 'empresas','action' => 'index'));
    } else {
      $this->error(__('El enlace no existe.'));
    }
  }

  public function enviar_activacion() {
    if ($this->request->is('post')) {
      if (!$this->VisualCaptcha->isValid()) {
        $this->response->statusCode(300);
        $this->error(__('Verifica el captcha'), false);
        return;
      }

      $this->loadModel('UsuarioEmpresa');
      $email = $this->request->data('Usuario.email');

      $user = $this->UsuarioEmpresa->find('first', array(
        'conditions' => array(
          'UsuarioEmpresa.cu_sesion' => $email,
          //'UsuarioEmpresa.cu_status' => -1
        ),
        'recursive' => -1
      ));

      if (!empty($user)) {
        if ($user['UsuarioEmpresa']['cu_status'] >= 0) {
          $this->response->statusCode(300);
          $this->error(__('Tu cuenta ya ha sido activada. Intenta recuperar tu contraseña'), false);
        } elseif ($this->UsuarioEmpresa->changePassword(null, $user['UsuarioEmpresa']['cu_cve'])) {
          //$email = $user['UsuarioEmpresa']['cu_sesion'];
          $password = $this->UsuarioEmpresa->password;
          $keycode = $this->UsuarioEmpresa->keycode;
          //$cia_nom = $this->Auth->user('Empresa.cia_nombre');
          $this->Emailer->sendEmail(
            $email,                                       //El email de ventas.
            __('Bienvenido. Su link de activación para Nuestro Empleo.'),      // Subject
            'empresas/activacion',                     // Plantilla
            array(
              'email' => $email,
              'password' => $password,
              'keycode' => $keycode
            )
          );

          $this->success(__('Se ha enviado el correo activación a %s correctamente.', $email), false);
        } else {
          $this->response->statusCode(300);
          $this->error(__('Ha ocurrido un error al guardar tus datos.'), false);
        }
      } else {
        $this->response->statusCode(300);
        $this->error(__('No existe el usuario.'), false);
      }
    }
  }

  /**
   * Cambia el tipo de compania.
   * @param  [type] $empresaId   [description]
   * @param  [type] $empresaSlug [description]
   * @return [type]              [description]
   */
  public function admin_tipo($empresaId, $empresaSlug = null, $type = null) {
    if (!$this->request->is('post')) {
      return ;
    }

    $data = $this->request->data;

    /**
     * Si se cambia a convenio, no debe contar con membresías activas.
     * @var [type]
     */
    if ($type === 'convenio' && $this->Empresa->PerfilMembresia->hasMembresia($empresaId)) {
      $this->error(__('Esta compañia ya cuenta con una membresía comercial activa.'));
    } elseif ($this->Empresa->changeCiaType($type, $empresaId)) {
      $this
        ->success(__('La empresa ya es %s.', $type))
        ->redirect('referer');
    } else {
      $this->error(__('Ocurrió un error al cambiar el tipo de empresa.'));
    }
  }

  public function admin_editar($empresaId) {
    $title_for_layout = __('Editar Cliente');

    if ($this->request->is('post') || $this->request->is('put')) {
      if (array_key_exists('Usuario', $this->request->data)) {
        $this->request->data['UsuarioEmpresaContacto'] = $this->request->data['Usuario'];
        if (ClassRegistry::init('UsuarioEmpresaContacto')->save($this->request->data)) {
          $this->success(__('Se han cambiado los datos satisfactoriamente.'));
          // $this->render('admin_editar');
        } else {
          $this->error(__('Ha ocurrido un error al intentar guardar los datos.'));
        }
      }

      if (array_key_exists('Empresa', $this->request->data)) {
        if ($this->Empresa->changeSuper($this->request->data['Empresa']['ejecutivo_cve'], $empresaId)) {
          $this
            ->success(__('Se ha cambiado el ejecutivo asignado.'))
            ->redirect('referer');
        } else {
          $this->error(__('Ha ocurrido un error al intentar cambiar de ejecutivo.'));
        }
      }
    } elseif ($this->request->is('get')) {
      $this->loadModel('UsuarioAdmin');
      $empresa = $this->Empresa->get($empresaId, 'data');

      $usuarios = $this->UsuarioAdmin->getAdmins($this->Auth->user('cu_cve'));
      $opcionesFacturacion =  $this->Empresa->FacturacionEmpresa->find('datos_facturacion', array(
        'all'=> true,
        'empresa' => $empresaId,
        'combine' => true,
      ));

      $new_password = $this->Empresa->Administrador->newPassword();

      $this->set(compact('title_for_layout', 'empresa', 'usuarios', 'new_password', 'opcionesFacturacion'));
    }
  }

  public function admin_facturacion($empresaId, $empresaSlug = null) {
    if ($this->request->is('post')) {
      if (array_key_exists('FacturacionEmpresa', $this->request->data)) {
        $this->loadModel('FacturacionEmpresa');
        if ($this->FacturacionEmpresa->createOrUpdate($empresaId, $this->request->data)) {
          $this->success(__('Se han cambiado tus datos satisfactoriamente.'));
        } else {
          $message = __('Ha ocurrido un error al intentar guardar los datos.');
          if ($this->FacturacionEmpresa->statusCode() === 400) {
            $message = $this->FacturacionEmpresa->message();
          }

          $this->response->statusCode(400);
          $this->error($message);
        }
      }
    }
  }

  public function admin_cambiar_contrasena($empresaId, $keycode) {
    // if (!$this->request->is('post')) {
    //   throw new MethodNotAllowedException("La página que buscas acceder no existe.");
    // }

    $this->loadModel('UsuarioEmpresa');

    $this->UsuarioEmpresa->recursive = -1;
    $user = $this->UsuarioEmpresa->get('data', array(
      'conditions' => array(
        'UsuarioEmpresa.keycode' => $keycode
      ),
      'first' => true
    ));

    if ($this->request->is('post')) {
      if (!empty($user)) {
        $userId = $user['UsuarioEmpresa']['cu_cve'];
        $canIChangePassword = $this->Empresa->isAdmin($userId ,$empresaId)
          && $user['UsuarioEmpresa']['cu_status'] == 1;
        $nombre = $user['Contacto']['con_nombre'] . ' ' . $user['Contacto']['con_paterno'];
      }

      if (!empty($userId) && !empty($canIChangePassword)) {
        $password = $this->request->data['UsuarioEmpresa']['new_password'];
        $passwordVerify = $this->request->data['UsuarioEmpresa']['new_password_verify'];

        if ($password !== $passwordVerify) {
          $this->error('Las contraseñas no coinciden');
          return false;
        }

        if ($result = $this->UsuarioEmpresa->changePassword($password, $userId)) {
          $email = $user['UsuarioEmpresa']['cu_sesion'];

          $this->Emailer->sendEmail(
            $email,                                 //El email de ventas.
            __('Ha sido cambiada tu contraseña.'),      // Subject
            'empresas/cambio_contrasena',           // Plantilla
            array_merge($result, compact('email', 'nombre'))
          );

          $this->success(__('Se ha enviado un correo con la nueva contraseña a %s.', $email));
        } else {
          $this->error(__('Ha ocurrido un error al guardar tus datos.'));
        }
      } else {
        $this->error(__('No existe el usuario o no se encuentra activo.'));
      }

      $this->redirect('referer');
    }

    $new_password = $this->UsuarioEmpresa->newPassword();
    $this->set(compact('user', 'new_password'));
  }

  /**
   * Función para cambiar el email de los administradores de una empresa.
   * @param  [type] $empresaId [description]
   * @param  [type] $keycode   [description]
   * @return [type]            [description]
   */
  public function admin_cambiar_email($empresaId, $keycode) {
    if (!$this->request->is('post')) {
      throw new MethodNotAllowedException(__("La página que buscas acceder no existe."));
    }

    $data = $this->request->data;
    if ($data['UsuarioEmpresa']['cu_sesion'] != $data['UsuarioEmpresa']['cu_sesion_verify']) {
      $this->error(__('Los correos no coinciden. Por favor verifica.'));
      return;
    }

    $this->loadModel('UsuarioEmpresa');
    $this->UsuarioEmpresa->recursive = -1;
    $user = $this->UsuarioEmpresa->get('data', array(
      'conditions' => array(
        'UsuarioEmpresa.keycode' => $keycode
      ),
      'first' => true
    ));

    if (!empty($user)) {
      $userId = $user['UsuarioEmpresa']['cu_cve'];
      $canIChangePassword = $this->Empresa->isAdmin($userId ,$empresaId);
      $email = $data['UsuarioEmpresa']['cu_sesion'];
      $oldEmail = $user['UsuarioEmpresa']['cu_sesion'];
      $nombre = $user['Contacto']['con_nombre'] . ' ' . $user['Contacto']['con_paterno'];
    }

    if (!empty($userId) && !empty($canIChangePassword)) {
      if (!empty($email) && $result = $this->UsuarioEmpresa->updateEmail($email, $userId)) {
        $this->Emailer->sendEmail(
          $email,                                               //El email de ventas.
          __('Hola. Esta es tu nueva cuenta de Nuestro Empleo.'),   // Subject
          'empresas/cambio_email',                              // Plantilla
          array_merge($result, compact('oldEmail', 'nombre'))
        );
        $successMsg = __('Se actualizó con éxito el correo electrónico de %s a %s. Se ha enviado un correo de activación.', $oldEmail, $email);
        $this->success($successMsg);
      } else {
        $this->error(__('Ha ocurrido un error al guardar tus datos.'));
      }
    } else {
      $this->error(__('No existe el usuario o no se encuentra activo.'));
    }

    $this->redirect('referer');
  }

  /**
   * [admin_ver description]
   * @param  [type] $id [description]
   * @return [type]     [description]
   */
  public function admin_ver($id) {
    if (!$this->Empresa->exists($id)) {
      throw new NotFoundException(__("La empresa que buscas no existe."));
    }

    $empresa = $this->Empresa->find('first', array(
      'conditions' => array(
        'Empresa.cia_cve' => $id
      ),
      'recursive' => -1,
      'contain' => array(
        'Administrador',
        'DatosEmpresa',
      )
    ));

    $datosFacturacion = $this->Empresa->FacturacionEmpresa->find('datos_facturacion', array(
      'all'=> true,
      'empresa' => $id,
      // 'combine' => true,
    ));

    // $facturas = ClassRegistry::init('Factura')->find('all_facturas', array(
    //   'conditions' => array(
    //     'Factura.cia_cve' => $id,
    //     'Factura.factura_status' => 0
    //   )
    // ));
    //$membresias = ClassRegistry::init('Membresia')->lista();

    $this->set(compact('empresa', 'datosFacturacion'));
  }

  /**
   * [admin_membresias description]
   * @return [type] [description]
   */
  // public function admin_membresias($empresaId, $type = 'index') {
  //   if ($this->request->is('post')) {
  //     if ($type === 'new') {
  //       $userId = $this->request->data['Empresa']['admin'];
  //       $membresiaId = $this->request->data['Empresa']['membresia'];

  //       if (!$this->Empresa->isAdmin($userId,$empresaId)) {
  //         $this->error(__('El usuario con el id: %s no es administrador de la compañia.', $userId));
  //         return;
  //       }
  //       if (ClassRegistry::init('Factura')->setMembresia($membresiaId, $empresaId, $userId)) {
  //         $this->success(__('Se han asignado correctamente los créditos a la compañia.'));
  //       } else {
  //         $this->error(__('Ocurrió un error al asignar los créditos.'));
  //       }
  //     }
  //   }
  // }

  public function admin_facturas($empresaId, $slug = null, $facturaId = null, $action = null) {
    $title_for_layout = __('Activar Servicio');

    if ($this->request->is('post')) {
      $data = $this->request->data;

      if (!empty($data['membresia'])) {
        if (!$this->Empresa->Facturas->changePromo($facturaId, $data['membresia'])) {
          $this->error(__('Ocurrió un error al actualizar la factura.'));
          return ;
        }
      }

      $this->Empresa->id = $empresaId;
      if ($this->Empresa->field('cia_tipo') === 1 /* Es convenio */) {
        $this->error(__('No puedes activar una factura de una empresa que es convenio.'));
      } elseif ($action === 'asignar' && $this->Empresa->Facturas->confirm($facturaId, $empresaId)) {
        $this
          ->success(__('El factura se asignó correctamente.'))
          ->reirect('referer');
      } else {
        $this->error(__('Ocurrió un error al procesar el factura.'));
      }

      $this->render("admin_facturas_$action");
    } else {
      $empresa = $this->Empresa->get($empresaId, 'facturas', array(
        'promos' => true,
        'factura' => $facturaId,
        'first' => true
      ));

      $membresias = $this->Empresa->Facturas->Membresia->find('list', array(
        'fields' => array('membresia_cve', 'membresia_nom'),
        'conditions' => array(
          'membresia_tipo' => 'P',
          'membresia_status' => 1
        ),
        'recursive' => -1
      ));

      $facturaDir = new Folder(ROOT . DS . 'documentos' . DS . 'empresas' . DS . $empresaId . DS . 'facturas' . DS . $facturaId);
      $files = $facturaDir->read()[1]; // Obtiene los archivos.
    }

    $this->set(compact('title_for_layout', 'empresa', 'files', 'membresias'));
  }

  public function admin_usuarios($empresaId = null, $userId = null) {
    if ($empresaId == null) {
      $this->redirect(array(
        'admin' => $this->Acceso->is('admin'),
        'controller' => 'empresas',
        'action' => 'index'
      ));
    }

    $this->paginate = array(
      'findType' => 'by_empresa',
      'empresaId' => $empresaId,
    );

    $empresa = $this->Empresa->get($empresaId, 'admin');
    $usuarios = $this->paginate('UsuarioEmpresa');

    $this->set(compact('usuarios', 'empresa'));
  }

  public function admin_historial($empresaId, $slugEmpresa) {
    $title_for_layout = 'Historial del Cliente';

    $empresa = $this->Empresa->get($empresaId, 'basic_info');
    $facturas = $this->Empresa->get('facturas', array(
      'conditions' => array(
        'Empresa.cia_cve' => $empresaId
      ),
      'promos' => true,
      'first' => true
    ));

    $this->set(compact('title_for_layout', 'empresa', 'facturas'));
  }

  public function datos_facturacion($rfc = null) {
    // Aquí se debe de checar que el rfc pertenezca a la empresa.

    $datos = $this->Empresa->FacturacionEmpresa->find('datos_facturacion', array(
      'empresa' => $this->Auth->user('Empresa.cia_cve'),
      'conditions' => array(
        'FacturacionEmpresa.cia_rfc' => $rfc
      )
    ));

    $this->set(compact('datos'));
  }

  public function admin_datos_facturacion($rfc = null) {
    $datos = $this->Empresa->FacturacionEmpresa->find('datos_facturacion', array(
      'empresa' => $this->Auth->user('Empresa.cia_cve'),
      'conditions' => array(
        'FacturacionEmpresa.cia_rfc' => $rfc
      )
    ));

    $this->set(compact('datos'));

    $this->render('datos_facturacion');
  }

  /**
   * [contacto description]
   * @return [type] [description]
   */
  public function contacto() {
    if ($this->request->is('post')) {
      $this->loadModel('FormularioContacto');

      $this->FormularioContacto->set($this->request->data);

      if ($this->FormularioContacto->validates()) {
        $vars = $this->request->data['FormularioContacto'] + array(
          'user' => array(
            'id' => $this->Auth->user('cu_cve'),
            'email' => $this->Auth->user('cu_sesion'),
            'nombre' => $this->Auth->user('fullName'),
            'tel' => $this->Auth->user('Contacto.con_tel'),
            'ext' => $this->Auth->user('Contacto.con_ext'),
          ),
          'empresa' => $this->Auth->user('Empresa') + array(
            'membresia' => $this->Auth->user('Perfil.membresia'),
            'tel' => $this->Auth->user('Empresa.cia_tel'),
            'web' => $this->Auth->user('Empresa.cia_web'),
          ),
        );

        $results = $this->Emailer->sendEmail(
          'contacto.ne@nuestroempleo.com.mx',                                    //El email de ventas.
          __('Contacto'),  // Subject
          'empresas/contacto',                                         // Plantilla
          $vars
        );

        $this->success(__('Hemos recibido tu correo satisfactoriamente. En breve nos pondremos en contacto contigo.'));
      } else {
        $this->error(__('Ha ocurrido un error, verifica por favor.'));
      }
    }
  }

  public function planes() {

  }
}
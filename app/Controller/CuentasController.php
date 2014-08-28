<?php

App::uses('BaseEmpresasController', 'Controller');
/**
 * Controlador general de la aplicación.
 */
class CuentasController extends BaseEmpresasController {

  /**
    * Nombre del controlador.
    */
  public $name = 'Cuentas';

  /**
    * Indica qué modelos se usarán. Un array vacío, indica que no usará algún modelo.
    */
  public $uses = array();

	/**
    * Componentes necesarios que utiliza el Controlador.
    * @var Array
  	*/
  public $components = array('Session', 'Emailer', 'Creditos');


  /**
     * Opciones para la paginación de los Usuarios.
     * @var Array
     */
  /*public $paginate = array(
    //'UsuarioEmpresa',
    'UsuarioAdmin' => array(
      'allowed',              // Específica que se usará la function _findAllowed
      'limit' => 20,
      'order' => array(
        'UsuarioAdmin.cu_sesion' => 'asc',
        'UsuarioAdmin.cu_cve' => 'asc'
      )
    )
  );*/

  /**
    * Método que se ejecuta antes de cualquier acción.
    */
  public function beforeFilter() {
    parent::beforeFilter();
    /**
    	* Acciones que no necesitan autenticación.
    	*/
    $allowActions = array('activar');

    $this->Auth->allow($allowActions);
  }

  /**
   * Muestra la lista de los administradores dependientes del administrador actual.
   * @return [type] [description]
   */
  public function admin_index() {
    $title_for_layout = __('Administración de Cuentas');

    $this->loadModel('UsuarioAdmin');

    $this->paginate = array(
      'findType' => 'dependents',
      'parent' => $this->Auth->user('cu_cve')
    );

    $usuarios = $this->paginate('UsuarioAdmin');
    $perfiles = ClassRegistry::init('Perfil')->lista($this->Auth->user('per_cve'));

    $this->set(compact('title_for_layout' ,'usuarios', 'perfiles'));
  }

  /**
   * Muestra la lista de los usuarios que son dependientes del usuario que ha iniciado sesión.
   * @return [type] [description]
   */
  public function admin_todas() {
    $title_for_layout = __('Administración de Todas las Cuentas');

    $this->paginate = array(
      'conditions' => array(
        'UsuarioBase.cu_cve >' => 0
      ),
      //'fields' => array('Empresa.*','UsuarioBase.*'),
      'contain' => array('Contacto' => array(
        'fields' => array('cu_cve', 'Contacto.con_nombre || \' \' || Contacto.con_paterno as nombre')
      )),
      'joins' => array(
        array(
          'alias' => 'UsuariosEmpresas',
          'fields' => array(
            'UsuariosEmpresas.cu_cve', 'UsuariosEmpresas.cia_cve'
          ),
          'table' => 'tusuxcia',
          'type' => 'LEFT',
          'conditions' => array(
            'UsuarioBase.cu_cve = UsuariosEmpresas.cu_cve'
          )
        ),
        array(
          'alias' => 'Empresa',
          'fields' => array(
            'Empresa.cia_cve', 'Empresa.cia_nom'
          ),
          'table' => 'tcompania',
          'type' => 'LEFT',
          'conditions' => array(
            'Empresa.cia_cve = UsuariosEmpresas.cia_cve'
          )
        )
      ),
      'order' => array('UsuarioBase.cu_cve' => 'ASC'),
      'recursive' => -1
    );

    $usuarios = $this->paginate();
    $this->set(compact('title_for_layout', 'usuarios'));
  }

  public function admin_nueva($type = null) {
    $title_for_layout = __('Nueva cuenta administrativa');

    $this->loadModel('UsuarioAdmin');

    if ($this->request->is('post')) {
      $data = $this->request->data;
      $user = $this->Auth->user();

      if ($data['UsuarioAdmin']['cu_sesion'] != $data['UsuarioAdmin']['cu_sesion_confirm']) {
        $this->error('El correo de confirmación es distinto.');
      } else {
        $perfil = $data['UsuarioAdmin']['per_cve'];

        if ($this->UsuarioAdmin->registrar($data, $perfil, $user)) {

          /**
            * Datos del usuario registrado.
            */
          $email = $this->UsuarioAdmin->email;
          $password = $this->UsuarioAdmin->password;
          $keycode = $this->UsuarioAdmin->keycode;

          $this->Emailer->sendEmail(
            $email,                                       //El email de ventas.
            __('Bienvenido. Su cuenta administrativa ha sido creada.'),      // Subject
            'admin/bienvenido_admin',                     // Plantilla
            array(                                        // Variables
              'email' => $email,
              'password' => $password,
              'keycode' => $keycode
            )
          );

          $this->success(__('Sus datos han sido enviados correctamente. Revise el correo electrónico registrado y active la cuenta.'));
          $this->redirect(array(
            'admin' => true,
            'action' => 'index'
          ));
        } else {
          $this->response->statusCode(301);
          $this->error(__('Ha ocurrido un error al intentar guardar los datos.'));
        }
      }
    }

    // $perfiles = ClassRegistry::init('Perfil')->lista($this->Auth->user('per_cve'));

    $this->set(compact('title_for_layout', 'perfiles'));
  }

  public function admin_editar($id, $keycode = null) {
    if ($id === $this->Auth->user('cu_cve')) {
      $this->redirect(array(
        'admin' => true,
        'controller' => 'mi_espacio',
        'action' => 'mi_cuenta'
      ));
    }

    $this->loadModel('UsuarioAdmin');

    $isAdminBy = $this->UsuarioAdmin->isAdminBy($this->Auth->user('cu_cve'), $id);

    if ($isAdminBy) {
      if ($this->request->is('get')) {
        $usuario = $this->UsuarioAdmin->get($id, 'data');
        // $usuario['UsuarioAdmin']['per_cve'] = $usuario['UsuarioAdmin']['per_cve']; % 100; // Reset el perfil al editar.

        $this->request->data = $usuario;

        $title_for_layout = __('Editar Cuenta');
        $new_password = $this->UsuarioAdmin->newPassword();
      } else {
        $data = $this->request->data;

        /**
         * Al crear un nueva cuenta, el índice sólo puede ser > 0.
         * 1 = Administrador
         * 2 = Ejecutivo de Ventas
         * @var [type]
         */
        // $perfilIndex = $data['UsuarioAdmin']['per_cve'] > 0 ? $data['UsuarioAdmin']['per_cve'] : 2;

        /**
         * Si el usuario va a ser Coordinador, entonces su superior es el admin de la Empresa
         * @var [type]
         */
        // if ((int)$perfilIndex === 1) {
          $data['UsuarioAdmin']['cu_cvesup'] = 1;
        // }

        if ($this->UsuarioAdmin->editar($data, $id)) {
          $this->success(__('Se actualizaron correctamente los datos.'))
            ->redirect('referer');
        } else {
          $this->response->statusCode(500);
          $this->error(__('Esta cuenta no existe o no tienes los permisos'));
        }
      }
    } else {
      $this->error(__('Esta cuenta no existe o no tienes los permisos'));
      $this->redirect('referer');
    }

    $perfiles = ClassRegistry::init('Perfil')->lista($this->Auth->user('per_cve'));
    $this->set(compact('title_for_layout', 'new_password', 'perfiles'));
  }

  public function admin_cambiar_contrasena($keycode) {
    $this->loadModel('UsuarioAdmin');

    $this->UsuarioAdmin->recursive = -1;
    $user = $this->UsuarioAdmin->get('data', array(
      'conditions' => array(
        'UsuarioAdmin.keycode' => $keycode
      ),
      'first' => true
    ));

    if ($this->request->is('post') || $this->request->is('put')) {
      if (!empty($user)) {
        $userId = $user['UsuarioAdmin']['cu_cve'];

        $canIChangePassword = $this->UsuarioAdmin->isAdminBy($this->Auth->user('cu_cve'), $userId)
          && $user['UsuarioAdmin']['cu_status'] == 1;
        $nombre = $user['Contacto']['con_nombre'] . ' ' . $user['Contacto']['con_paterno'];
      }

      if (!empty($userId) && !empty($canIChangePassword)) {
        $password = $this->request->data['UsuarioAdmin']['new_password'];
        $passwordVerify = $this->request->data['UsuarioAdmin']['new_password_verify'];

        if ($password !== $passwordVerify) {
          $this->error('Las contraseñas no coinciden');
          return false;
        }

        if ($result = $this->UsuarioAdmin->changePassword($password, $userId)) {
          $email = $user['UsuarioAdmin']['cu_sesion'];

          $this->Emailer->sendEmail(
            $email,                                 //El email de ventas.
            __('Su contraseña ha sido cambiada.'),  // Subject
            'admin/cambio_contrasena',           // Plantilla
            array_merge($result, compact('email', 'nombre'))
          );

          $this
            ->success(__('Se ha enviado un correo con la nueva contraseña a %s.', $email))
            ->redirect(array(
              'admin' => true,
              'controller' => 'cuentas',
              'action' => 'index'
            ));
        } else {
          $this->error(__('Ha ocurrido un error al intentar guardar los datos.'));
        }
      } else {
        $this->error(__('El usuario no existe o no se encuentra activo.'));
      }
    }

    $new_password = $this->UsuarioAdmin->newPassword();
    $this->set(compact('user', 'new_password'));
  }

    public function admin_eliminar($id, $slug = null, $keycode = null) {
    if (!$this->request->is('post')) {
      throw new MethodNotAllowedException(__('Error al procesar tu solicitud'));
    }

    $this->loadModel('UsuarioAdmin');
    $isAdminBy = $this->UsuarioAdmin->isAdminBy($this->Auth->user('cu_cve'), $id);

    if ($isAdminBy && $keycode) {
      $data = $this->request->data;
      $user = $this->UsuarioAdmin->findByKeycode($keycode, array(
        'UsuarioAdmin.cu_cve', 'UsuarioAdmin.cu_sesion'
      ));

      $userEmail = $user['UsuarioAdmin']['cu_sesion'];

      if (!empty($user)) {

        if (trim($data['confirm_email']) !== $userEmail) {
          $this->error(__('El correo electrónico no coincide con la cuenta que quieres borrar.'));
        } elseif ($this->UsuarioAdmin->eliminar($user['UsuarioAdmin']['cu_cve'], $data['Reassignments'])) {
          $this->success(__('%s ha sido borrado completamente.', $userEmail))
            ->redirect(array(
              'admin' => true,
              'controller' => 'cuentas',
              'action' => 'index'
            ));
        } else {
          $this->error(__('Ocurrió un error al intentar eliminar esta cuenta.'));
        }
      } else {
        $this->error(__('El código de seguridad del usuario ha cambiado o no existe.'));
      }
    } else {
      $this->error(__('No tienes los permisos sobre este usuario o su código de seguridad es erróneo.'));
    }
  }

  /**
   * Función para cambiar el email de los administradores de nuestro empleo.
   * @param  [type] $keycode [description]
   * @return [type]          [description]
   */
  public function admin_cambiar_email($keycode) {
    if (!$this->request->is('post') && !$this->request->is('put')) {
      throw new MethodNotAllowedException(__('La página que buscas acceder no existe.'));
    }

    $data = $this->request->data;

    if ($data['UsuarioAdmin']['cu_sesion'] != $data['UsuarioAdmin']['cu_sesion_verify']) {
      $this->error(__('Los correos no coinciden. Por favor verifica.'));
      return;
    }

    $this->load('UsuarioAdmin');
    $this->UsuarioAdmin->recursive = -1;
    $user = $this->UsuarioAdmin->get('data', array(
      'conditions' => array(
        'UsuarioAdmin.keycode' => $keycode
      ),
      'first' => true
    ));

    if (!empty($user)) {
      $userId = $user['UsuarioAdmin']['cu_cve'];
      $canIChangePassword = $this->UsuarioAdmin->isAdminBy($this->Auth->user('cu_cve'), $userId);
      $email = $data['UsuarioAdmin']['cu_sesion'];
      $oldEmail = $user['UsuarioAdmin']['cu_sesion'];
      $nombre = $user['Contacto']['con_nombre'] . ' ' . $user['Contacto']['con_paterno'];
    }

    if (!empty($userId) && !empty($canIChangePassword)) {
      if (!empty($email) && $result = $this->UsuarioAdmin->updateEmail($email, $userId)) {

        $this->Emailer->sendEmail(
          $email,                                               //El email de ventas.
          __('Hola. Ésta es tu nueva cuenta administrativa de Nuestro Empleo.'),   // Subject
          'admin/cambio_email',                              // Plantilla
          array_merge($result, compact('oldEmail', 'nombre'))
        );

        $successMsg = __('Se actualizó con éxito el correo electrónico de %s a %s. Se ha enviado un correo de activación.', $oldEmail, $email);
        $this
          ->success($successMsg)
          ->redirect(array(
            'admin' => true,
            'controller' => 'cuentas',
            'action' => 'index'
          ));
      } else {
        $this->error(__('Ha ocurrido un error al intentar guardar los datos.'));
      }
    } else {
      $this->error(__('El usuario no existe o no se encuentra activo.'));
    }
  }

  public function activar($keycode = null) {
    if (is_null($keycode)) {
      throw new NotFoundException(__("La página que buscas acceder no existe."));
    }

    $this->loadModel('UsuarioAdmin');

    /**
      * Busca al usuario por medio de su keycode.
      */
    $this->UsuarioAdmin->recursive = -1;
    $usuario = $this->UsuarioAdmin->findByKeycode($keycode);

    if (!empty($usuario)) {
      if ($usuario['UsuarioAdmin']['cu_status'] == -1) {
        if (!$this->UsuarioAdmin->activar($usuario['UsuarioAdmin']['cu_cve'])) {
          $this->error(__('Ocurrió un error al actualizar tu cuenta. Intenta más tarde.'));
        }
      }
      $this->success(__('Su cuenta ha sido activada. Puede iniciar sesión.'));
      $this->redirect(array(
        'controller' => 'nuestro_empleo',
        'action' => 'iniciar_sesion',
        'key' => 'ok'
      ));
    } else {
      $this->error(__('El enlace no existe.'));
      $this->redirect(array(
        'admin' => 0,
        'controller' => 'informacion',
        'action' => 'index'
      ));
    }
  }

  public function admin_enviar_activacion($keycode) {
    $this->loadModel('UsuarioAdmin');

    $this->UsuarioAdmin->recursive = -1;
    $user = $this->UsuarioAdmin->findByKeycode($keycode, array(
      'UsuarioAdmin.cu_cve', 'UsuarioAdmin.cu_sesion'
    ));

    if (!empty($user)) {
      if ($this->UsuarioAdmin->changePassword(null, $user['UsuarioAdmin']['cu_cve'])) {
        $email = $user['UsuarioAdmin']['cu_sesion'];
        $password = $this->UsuarioAdmin->password;
        $keycode = $this->UsuarioAdmin->keycode;

        $this->Emailer->sendEmail(
          $email,                                       //El email de ventas.
          __('Bienvenido. Su cuenta administrativa ha sido creada.'),      // Subject
          'admin/bienvenido_admin',                     // Plantilla
          array(                                        // Variables
            'email' => $email,
            'password' => $password,
            'keycode' => $keycode
          )
        );

        $this
          ->success(__('Se ha enviado el correo activación a %s correctamente.', $email))
          ->redirect(array(
            'admin' => true,
            'action' => 'index'
          ));
      } else {
        $this->error(__('Ha ocurrido un error al intentar actualizar los datos.'));
      }
    } else {
      $this->error(__('El usuario no existe o su código de seguridad ha cambiado.'));
    }
  }

  public function admin_activar($id, $slug = null) {
    if (!$this->request->is('post')) {
      throw new MethodNotAllowedException("Error Processing Request");
    }

    $this->_status($id, 1);
  }

  public function admin_bloquear($id, $slug = null) {
    if (!$this->request->is('post')) {
      throw new MethodNotAllowedException("Error Processing Request");
    }

    $this->_status($id, 0);
  }


  protected function _status($id, $status = 0) {
    if ($id == $this->Auth->user('cu_cve')) {
      $this->error(__('No puedes cambiar tu estado.'));
    } else {
      $this->loadModel('UsuarioBase');

      if ($this->UsuarioBase->exists($id)) {
        $this->UsuarioBase->cambiar_status($id, $status);
        $this->success(__('El usuario se ha %s correctamente.', $status ? 'activado' : 'inactivado'));
      } else {
        $this->error(__('El usuario que intentas inactivar no existe.'));
      }
    }

    $this->render('status');
  }
}

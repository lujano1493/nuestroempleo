<?php

App::uses('BaseEmpresasController', 'Controller');
/**
 * Controlador general de la aplicación.
 */
class MisCuentasController extends BaseEmpresasController {

  /**
    * Nombre del controlador.
    */
  public $name = 'MisCuentas';

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
    $allowActions = array();

    $this->Auth->allow($allowActions);
  }

  /**
   * Muestra la lista de los usuarios que son dependientes del usuario que ha iniciado sesión.
   * @return [type] [description]
   */
  public function index() {
    $title_for_layout = __('Mis Cuentas');
    $this->loadModel('UsuarioEmpresa');
    $this->loadModel('Credito');

    $creditos = $this->Credito->getByUser(
      $this->Auth->user('cu_cve'),
      $this->Auth->user('Empresa.cia_cve')
    );

    $cuentas = $this->UsuarioEmpresa->get('dependents', array(
      'parent' => $this->Auth->user('cu_cve'),
      'includeParent' => false,
      'limit' => 5,
      'order' => array(
        'UsuarioEmpresa.created' => 'DESC'
      )
    ));

    $this->set(compact('cuentas', 'creditos', 'title_for_layout'));
  }

  // public function recientes() {
  //   $this->loadModel('UsuarioEmpresa');

  //   $cuentas = $this->UsuarioEmpresa->get('dependents', array(
  //     'parent' => $this->Auth->user('cu_cve'),
  //     'includeParent' => false,
  //     'limit' => 3,
  //     'order' => array(
  //       'UsuarioEmpresa.created' => 'DESC'
  //     )
  //   ));

  //   $this->set(compact('cuentas'));
  // }

  public function todas() {
    $title_for_layout = __('Todas mis Cuentas');

    $this->loadModel('UsuarioEmpresa');

    $cuentas = $this->UsuarioEmpresa->get('dependents_with_credits', array(
      'includeParent' => false,
      'cia' => $this->Auth->user('Empresa.cia_cve'),
      'parent' => $this->Auth->user('cu_cve')
    ));

    $this->set(compact('cuentas', 'title_for_layout'));
  }

  public function administrar() {
    $title_for_layout = __('Administrar Cuentas');

    $this->set(compact('cuentas', 'title_for_layout'));
  }



  public function nueva() {
    $title_for_layout = __('Nueva Cuenta');
    // if (!$this->Acceso->hasCredits('creacion_cuenta')) {
    //   $this->Acceso->redirect('planes');
    // }

    $this->loadModel('UsuarioEmpresa');

    if ($this->request->is('post')) {
      $data = $this->request->data;
      $user = $this->Auth->user();

      if ($data['UsuarioEmpresa']['cu_sesion'] != $data['UsuarioEmpresa']['cu_sesion_confirm']) {
        $this->response->statusCode(400);
        $this->error(__('El correo de confirmación es distinto.'));
        return;
      }

      /**
       * Checamos el rol del usuario al crear cuentas.
       */
      if ($this->Acceso->checkRole('admin')) {
        $data['UsuarioEmpresa']['per_cve'] = $data['UsuarioEmpresa']['per_cve'] === 'coordinador' ? 1 : 2;
      } elseif ($this->Acceso->checkRole('coordinador')) {
        $data['UsuarioEmpresa']['per_cve'] = 2;
      } else {
        $this
          ->error(__('Tu perfil no permite crear cuentas'))
          ->redirect(array(
            'controller' => 'mi_espacio',
            'action' => 'index'
          ));
      }

      /**
       * Al crear un nueva cuenta, el índice sólo puede ser > 0.
       * 1 = Coordinador
       * 2 = Reclutador
       * @var [type]
       */
      $perfilIndex = $data['UsuarioEmpresa']['per_cve'] > 0 ? $data['UsuarioEmpresa']['per_cve'] : 2;

      /**
       * Si el usuario va a ser Coordinador, entonces su superior es el admin de la Empresa
       * @var [type]
       */
      if ((int)$perfilIndex === 1) {
        $data['UsuarioEmpresa']['cu_cvesup'] = $this->Auth->user('Empresa.cu_cve');
      }

      // Se obtiene la base en base al usuario.
      $perfilBase = $this->UsuarioEmpresa->getBaseProfile($this->Auth->user('cu_cve'));

      $perfil = $perfilBase + $perfilIndex;

      /**
       * Aquí se pasa los datos a guardar, qué perfil tendrá el usuario, y el usuario superior.
       */
      if ($this->UsuarioEmpresa->registrar($data, $perfil, $user)) {

        /**
          * Datos del usuario registrado.
          */
        $email = $this->UsuarioEmpresa->email;
        $password = $this->UsuarioEmpresa->password;
        $keycode = $this->UsuarioEmpresa->keycode;
        $cia_nom = $user['Empresa']['cia_nombre'];

        $this->Emailer->sendEmail(
          $email,                                       //El email de ventas.
          __('Bienvenido. Su cuenta ha sido creada.'),      // Subject
          'empresas/bienvenida',                // Plantilla
          array(
            'email' => $email,
            'password' => $password,
            'cia_nom' => $cia_nom,
            'keycode' => $keycode
          )
        );

        $this
          ->success(__('Sus datos han sido enviados correctamente. Revise el correo electrónico registrado y active la cuenta.'))
          ->redirect(array(
            'controller' => 'mis_cuentas',
            'action' => 'administrar'
          ));
      } else {
        $this->response->statusCode(400);
        $this->error(__('Ha ocurrido un error al intentar guardar los datos.'));
      }
    }

    $usuarios = $this->UsuarioEmpresa->getCoordinadores($this->Auth->user('cu_cve'));

    $this->set(compact('title_for_layout', 'usuarios'));
  }

  public function cambiar_contrasena($keycode) {
    $this->loadModel('UsuarioEmpresa');

    $this->UsuarioEmpresa->recursive = -1;
    $user = $this->UsuarioEmpresa->get('data', array(
      'conditions' => array(
        'UsuarioEmpresa.keycode' => $keycode
      ),
      'first' => true
    ));

    if ($this->request->is('post') || $this->request->is('put')) {
      if (!empty($user)) {
        $userId = $user['UsuarioEmpresa']['cu_cve'];
        $empresaId = $this->Auth->user('Empresa.cia_cve');

        $canIChangePassword = $this->UsuarioEmpresa->isAdminBy($this->Auth->user('cu_cve'), $userId)
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
            __('Su contraseña ha sido cambiada.'),      // Subject
            'empresas/cambio_contrasena',           // Plantilla
            array_merge($result, compact('email', 'nombre'))
          );

          $this->success(__('Se ha enviado un correo con la nueva contraseña a %s.', $email));

          $this->redirect(array(
            'controller' => 'mis_cuentas',
            'action' => 'index'
          ));
        } else {
          $this->error(__('Ha ocurrido un error al intentar guardar los datos.'));
        }
      } else {
        $this->error(__('El usuario no existe o no se encuentra activo.'));
      }
    }

    $new_password = $this->UsuarioEmpresa->newPassword();
    $this->set(compact('user', 'new_password'));
  }

  /**
   * Función para cambiar el email de los usuarios de una empresa.
   * @param  [type] $keycode [description]
   * @return [type]          [description]
   */
  public function cambiar_email($keycode) {
    if (!$this->request->is('post') && !$this->request->is('put')) {
      throw new MethodNotAllowedException(__('La página que buscas acceder no existe.'));
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
      $empresaId = $this->Auth->user('Empresa.cia_cve');
      $canIChangePassword = $this->UsuarioEmpresa->isAdminBy($this->Auth->user('cu_cve'), $userId);
      $email = $data['UsuarioEmpresa']['cu_sesion'];
      $oldEmail = $user['UsuarioEmpresa']['cu_sesion'];
      $nombre = $user['Contacto']['con_nombre'] . ' ' . $user['Contacto']['con_paterno'];
    }

    if (!empty($userId) && !empty($canIChangePassword)) {
      if (!empty($email) && $result = $this->UsuarioEmpresa->updateEmail($email, $userId)) {
        $this->Emailer->sendEmail(
          $email,                                               //El email de ventas.
          __('Hola. Ésta es tu nueva cuenta de Nuestro Empleo.'),   // Subject
          'empresas/cambio_email',                              // Plantilla
          array_merge($result, compact('oldEmail', 'nombre'))
        );

        $successMsg = __('Se actualizó con éxito el correo electrónico de %s a %s. Se ha enviado un correo de activación.', $oldEmail, $email);
        $this->success($successMsg);
        $this->redirect(array(
          'controller' => 'mis_cuentas',
          'action' => 'administrar'
        ));
      } else {
        $this->error(__('Ha ocurrido un error al intentar guardar los datos.'));
      }
    } else {
      $this->error(__('El usuario no existe o no se encuentra activo.'));
    }
  }

  public function editar($id, $keycode = null) {
    if ($id === $this->Auth->user('cu_cve')) {
      $this->redirect(array(
        'controller' => 'mi_espacio',
        'action' => 'mi_cuenta'
      ));
    }

    $this->loadModel('UsuarioEmpresa');

    $isAdminBy = $this->UsuarioEmpresa->isAdminBy($this->Auth->user('cu_cve'), $id);

    if ($isAdminBy) {
      if ($this->request->is('get')) {
        $usuario = $this->UsuarioEmpresa->get($id, 'data');
        $usuario['UsuarioEmpresa']['per_cve'] = $usuario['UsuarioEmpresa']['per_cve'] % 100; // Reset el perfil al editar.

        $this->request->data = $usuario;

        $title_for_layout = __('Editar Cuenta');
        $usuarios = $this->UsuarioEmpresa->getCoordinadores($this->Auth->user('cu_cve'));
        $userContent = $this->UsuarioEmpresa->hasContent($id);
        unset($usuarios[$id]);
        $new_password = $this->UsuarioEmpresa->newPassword();
      } else {
        $data = $this->request->data;

        /**
         * Checamos el rol del usuario al editar cuentas.
         */
        if ($this->Acceso->checkRole('admin')) {
          $data['UsuarioEmpresa']['per_cve'] = $data['UsuarioEmpresa']['per_cve'] === 'coordinador' ? 1 : 2;
        } elseif ($this->Acceso->checkRole('coordinador')) {
          $data['UsuarioEmpresa']['per_cve'] = 2;
        } else {
          $this
            ->error(__('Tu perfil no permite editar cuentas'))
            ->redirect(array(
              'controller' => 'mi_espacio',
              'action' => 'index'
            ));
        }

        /**
         * Al crear un nueva cuenta, el índice sólo puede ser > 0.
         * 1 = Coordinador
         * 2 = Reclutador
         * @var [type]
         */
        $perfilIndex = $data['UsuarioEmpresa']['per_cve'] > 0 ? $data['UsuarioEmpresa']['per_cve'] : 2;

        /**
         * Si el usuario va a ser Coordinador, entonces su superior es el admin de la Empresa
         * @var [type]
         */
        if ((int)$perfilIndex === 1) {
          $data['UsuarioEmpresa']['cu_cvesup'] = $this->Auth->user('Empresa.cu_cve');
        }

        // Se obtiene la base en base al usuario.
        $perfilBase = $this->UsuarioEmpresa->getBaseProfile($this->Auth->user('cu_cve'));

        $data['UsuarioEmpresa']['per_cve'] = $perfilBase + $perfilIndex;

        if ($this->UsuarioEmpresa->editar($data, $id)) {
          $this->success(__('Se actualizaron correctamente los datos.'))
            ->redirect(array(
              'controller' => 'mis_cuentas',
              'action' => 'administrar'
            ));
        } else {
          $this->response->statusCode(500);
          $this->error(__('Esta cuenta no existe o no tienes los permisos'));
        }
      }
    } else {
      $this->error(__('Esta cuenta no existe o no tienes los permisos'));
      $this->redirect('referer');
    }

    $this->set(compact('title_for_layout', 'usuarios', 'new_password', 'userContent'));
  }

  public function creditos($userId = null) {
    $title_for_layout = __('Asignación de Créditos');

    $this->loadModel('Credito');
    if ($this->request->is('post')) {
      $id = $this->Auth->user('cu_cve');
      $data = $this->request->data['Usuarios'];
      $canAssign = $this->Creditos->compare($data);

      /**
       * Filtra los usuarios a los que se van a actualizar sus créditos.
       * @var array
       */
      $data = array_filter($data, function ($d) {
        $counts = Hash::extract($d, 'Creditos.{s}.{s}');
        return array_sum($counts) > 0;
      });

      /**
       * Obtiene el id de los usuarios filtrados.
       * @var [type]
       */
      $users = Hash::extract($data, '{n}.id');

      /**
       * Si no hay usuarios.
       */
      if (empty($users)) {
        $this->info(__('No hay modificaciones'));
      } elseif ($canAssign) {
        foreach ($data as $k => $v) {
          $userId = $v['id'];

          if (!empty($v['Creditos']['asignados'])) {
            foreach ($v['Creditos']['asignados'] as $key => $value) {
              $this->Credito->asignar($id, $userId, array(
                $key => $value
              ));
            }
          }

          if (!empty($v['Creditos']['recuperados'])) {
            foreach ($v['Creditos']['recuperados'] as $key => $value) {
              $this->Credito->asignar($userId, $id, array(
                $key => $value
              ));
            }
          }
        }

        $this->Creditos->update($users);
        $this->html('element', 'empresas/credits');
        $this
          ->success(__('Créditos asignados correctamente'))
          ->redirect(array('action' => 'index'));

      } else {
        $this->response->statusCode(400);
        $this->error(__('Verifica que la suma de los créditos coincida.'));
      }
    } //elseif ($this->request->is('get')) {
      $this->loadModel('UsuarioEmpresa');

      $cuentas = $this->UsuarioEmpresa->get('dependents_with_credits', array(
        'includeParent' => false,
        'cia' => $this->Auth->user('Empresa.cia_cve'),
        'parent' => $this->Auth->user('cu_cve')
      ));
    // }

    $this->set(compact('title_for_layout', 'cuentas'));
  }

  public function quitar_creditos($userId) {
    $this->loadModel('Credito');

    if ($this->request->is('post')) {
      foreach ($this->request->data['Creditos'] as $data) {
        $this->Credito->asignar($userId, $this->Auth->user('cu_cve'), $data);
      }

      $this->Creditos->update();
      $this->redirect(array('action' => 'index'));
    }

    $creditos = $this->Credito->getByUser(
      $userId, $this->Auth->user('Empresa.cia_cve')
    );
    $this->set(compact('creditos'));
  }

  public function admin_status($id, $status = 0) {
    if (!$this->request->is('post')) {
      throw new MethodNotAllowedException(__('Método no permitido.'));
    }

    if ($id == $this->Auth->user('cu_cve')) {
      $this->error(__('No puedes cambiar tu estado.'));
    } else {
      $this->loadModel('UsuarioBase');

      if ($this->UsuarioBase->exists($id)) {
        $this->UsuarioBase->cambiar_status($id, $status);
        $this->success(__('El usuario se ha %s correctamente.', $status ? 'activado' : 'inactivado'));

        //if (!$this->isAjax) {
        //}
      } else {
        $this->error(__('El usuario que intentas inactivar no existe.'));
      }
    }

    $this->redirect($this->referer());
  }

  public function enviar_activacion($keycode) {
    $this->loadModel('UsuarioEmpresa');

    $this->UsuarioEmpresa->recursive = -1;
    $user = $this->UsuarioEmpresa->findByKeycode($keycode, array(
      'UsuarioEmpresa.cu_cve', 'UsuarioEmpresa.cu_sesion'
    ));

    if (!empty($user)) {
      if ($this->UsuarioEmpresa->changePassword(null, $user['UsuarioEmpresa']['cu_cve'])) {
        $email = $user['UsuarioEmpresa']['cu_sesion'];
        $password = $this->UsuarioEmpresa->password;
        $keycode = $this->UsuarioEmpresa->keycode;
        $cia_nom = $this->Auth->user('Empresa.cia_nombre');
        $this->Emailer->sendEmail(
          $email,                                       //El email de ventas.
          __('Bienvenido. Su cuenta ha sido creada.'),      // Subject
          'empresas/bienvenida',                     // Plantilla
          array(
            'cia_nom' => $cia_nom,                                     // Variables
            'email' => $email,
            'password' => $password,
            'keycode' => $keycode
          )
        );

        $this->success(__('Se ha enviado el correo activación a %s correctamente.', $email));
        $this->redirect(array(
          'admin' => false,
          'action' => 'index'
        ));
      } else {
        $this->error(__('Ha ocurrido un error al intentar guardar los datos.'));
      }
    } else {
      $this->error(__('El usuario no existe.'));
    }
  }

  public function premium() {
    $title_for_layout = __('Empresas Premium');

    $tipos_compania = ClassRegistry::init('Catalogo')->lista('tipo_cia');
    if ($this->request->is('post')) {
      $this->loadModel('FormularioContactoPremium');
      $data = $this->request->data;

      $data['FormularioContactoPremium']['cia_cve'] = $this->Auth->user('Empresa.cia_cve');
      $data['FormularioContactoPremium']['premium_status'] = 0;

      if ($this->FormularioContactoPremium->save($data)) {

        $this->Emailer->sendEmail(
          'contacto.ne@nuestroempleo.com.mx',                //El email de ventas.
          __('La Empresa %s quiere ser premium.', $this->Auth->user('Empresa.cia_nombre')),          // Subject
          'empresas/contacto_premium',                      // Plantilla
          array(
            'user' => $this->Auth->user(),
            'data' => $data['FormularioContactoPremium'],
            'tipos_compania' => $tipos_compania
          )
        );

        $this->success(__('La solicitud se guardó correctamente.'));
      } else {
        $this->error(__('Ocurrió un error al guardar los datos.'));
      }
    }

    $this->set(compact('title_for_layout', 'tipos_compania'));
  }

  public function activar($id) {
    if (!$this->request->is('post')) {
      throw new MethodNotAllowedException("Error Processing Request");
    }

    $this->_status($id, 1);
  }

  public function bloquear($id) {
    if (!$this->request->is('post')) {
      throw new MethodNotAllowedException("Error Processing Request");
    }

    $this->_status($id, 0);
  }

  public function eliminar($id, $slug = null, $keycode = null) {
    if (!$this->request->is('post')) {
      throw new MethodNotAllowedException(__('Error al procesar tu solicitud'));
    }

    $this->loadModel('UsuarioEmpresa');
    $isAdminBy = $this->UsuarioEmpresa->isAdminBy($this->Auth->user('cu_cve'), $id);

    if ($isAdminBy && $keycode) {
      $data = $this->request->data;
      $user = $this->UsuarioEmpresa->findByKeycode($keycode, array(
        'UsuarioEmpresa.cu_cve', 'UsuarioEmpresa.cu_sesion'
      ));

      $userEmail = $user['UsuarioEmpresa']['cu_sesion'];

      if (!empty($user)) {

        if (trim($data['confirm_email']) !== $userEmail) {
          $this->error(__('El correo electrónico no coincide con la cuenta que quieres borrar.'));
        } elseif ($this->UsuarioEmpresa->eliminar($user['UsuarioEmpresa']['cu_cve'], $data['Reassignments'])) {
          $this->success(__('%s ha sido borrado completamente.', $userEmail))
            ->redirect(array(
              'controller' => 'mis_cuentas',
              'action' => 'administrar'
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
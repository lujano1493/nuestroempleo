<?php

App::uses('AppController', 'Controller');

/**
 * Controlador general de la aplicación.
 */
class NuestroEmpleoController extends AppController {

  public $name = 'NuestroEmpleo';

  /**
    * Indica qué modelos se usarán. Un array vacío, indica que no usará algún modelo.
    */
  public $uses = array('UsuarioAdmin');

  /**
    * Componentes necesarios que utiliza el Controlador.
    * @var Array
    */
  public $components = array('Session');

  /**
   * Cadena de caracteres aleatoria que permite iniciar sesión al administrador.
   * http://www.nuestroempleo.com.mx/admin/iniciar_sesion/caracteres_aleatorios
   * @var string
   */
  public $adminKey = 'ok';

  /**
    * Método que se ejecuta antes de cualquier acción.
    */
  public function beforeFilter() {
    parent::beforeFilter();
    $this->layout = 'empresas/simple';
    /**
      * Acciones que no necesitan autenticación.
      */
    $allowActions = array('iniciar_sesion', 'cerrar_sesion');

    $this->Auth->allow($allowActions);
  }

  public function iniciar_sesion($key = null) {
    if ($key !== $this->adminKey) {
      throw new NotFoundException('La página que buscas acceder no existe');
    }

    $this->layout = 'admin/simple';

    /** Redireccionar al administrador de la empresa. */
    $redirectUrl = array('admin' => 1, 'controller' => 'mi_espacio', 'action' => 'index');

    if (!$this->request->is('post')) {
      if($this->Auth->user()) {
        $this->redirect($redirectUrl);
      }
      return;
    }

    $this->request->data['UsuarioAdmin']['cu_sesion'] = $this->request->data['UsuarioAdmin']['cuenta'];
    $this->request->data['UsuarioAdmin']['cu_password'] = $this->request->data['UsuarioAdmin']['password'];

    $user = ClassRegistry::init('UsuarioAdmin')->find('first', array(
      'conditions' => array(
        'UsuarioAdmin.cu_sesion' => $this->request->data['UsuarioAdmin']['cuenta']
      ),
      'fields' => array('cu_sesion', 'cu_status'),
      'recursive' => -1
    ));

    if (!empty($user)) {
      $this->Session->destroy();
      $_SESSION = array();

      if ($user['UsuarioAdmin']['cu_status'] == 0) {
        $this->warning(__('Su cuenta ha sido inactivada. Contacta a tu administrador.'));
        return;
      } elseif ($user['UsuarioAdmin']['cu_status'] < 0) {
        $this->warning(__('Tu cuenta aún no ha sido verificada. Revisa tu correo electrónico.'));
        return;
      } elseif ($this->Auth->login()) {
        $usuarioDatos = ClassRegistry::init('UsuarioEmpresaContacto')->getDatos(
          $this->Auth->user('cu_cve'), true
        );

        $this->Session->write('Auth.User.Datos', $usuarioDatos);
        $this->Session->write('Auth.User.fullName', $usuarioDatos['con_nombre'] . ' ' . $usuarioDatos['con_paterno']);

        $this->redirect($redirectUrl);
      }
    }

    $this->error(__('Nombre de usuario o contraseña inválidos.'));
  }

  public function cerrar_sesion() {
    $lastRole = $this->Acceso->is();
    $redirectUrl = $this->Auth->logout();

    if ($lastRole === 'empresa') {
      $redirectUrl = array(
        'controller' => 'empresas',
        'action' => 'index'
      );
    }

    $this->Session->delete('Auth');
    $this->success('Has cerrado tu sesión satisfactoriamente.');
    $this->redirect($redirectUrl);
  }
}
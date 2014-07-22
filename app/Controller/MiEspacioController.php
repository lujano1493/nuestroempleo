<?php

App::uses('BaseEmpresasController', 'Controller');

/**
*
*/
class MiEspacioController extends BaseEmpresasController {
  public $name = 'MiEspacio';

  public $uses = array();
  public $components = array('Session', 'Acceso');

  public function beforeFilter() {
    parent::beforeFilter();

    /**
      * Acciones que no necesitan autenticación.
      */
    $allowActions = array();

    $this->Auth->allow($allowActions);
  }

  public function index() {
    $title_for_layout = __('Mi Espacio');
    $stats = array(
      'ofertas' => ClassRegistry::init('Oferta')->getStatusStats($this->Auth->user('cu_cve'), $this->Auth->user('Empresa.cia_cve'), 'bprd'),
      'candidatos' => ClassRegistry::init('CandidatoEmpresa')->getStats(
        $this->Auth->user('cu_cve'), $this->Auth->user('Empresa.cia_cve')
      ),
      'productos' => ClassRegistry::init('Factura')->getStats(
        $this->Auth->user('cu_cve'), $this->Auth->user('Empresa.cia_cve')
      )
    );

    $candidatos = ClassRegistry::init('CandidatoB')->find('purchased', array(
      'fromUser' => $this->Auth->user('cu_cve'),
      'fromCia' => $this->Auth->user('Empresa.cia_cve'),
      'limit' => 4,
      'order' => array(
        'Empresa.created' => 'DESC'
      )
    ));

    $this->set(compact('title_for_layout', 'stats', 'candidatos'));
  }

  public function admin_index() {
    $title_for_layout = __('Mi Administrador');

    $last_convenios = ClassRegistry::init('Convenio')->getLast();
    $last_empresas = ClassRegistry::init('Empresa')->getLast();
    // $last_admins = ClassRegistry::init('UsuarioAdmin')->getLast();
    // $last_facturas = ClassRegistry::init('Factura')->getLast();

    $this->set(compact('title_for_layout', 'last_convenios', 'last_empresas', 'last_facturas'));
  }

  public function mi_empresa() {
    $empresaId = $this->Session->read('Auth.User.Empresa.cia_cve');
    if ($this->request->is('post') || $this->request->is('put')) {

      if (array_key_exists('Empresa', $this->request->data)) {
        $this->request->data['Empresa']['cia_cve'] = $empresaId;
        $this->request->data['DatosEmpresa'][0]['tipodom_cve'] = 0;
        $this->request->data['DatosEmpresa'][0]['cia_cve'] = $empresaId;;
        if (ClassRegistry::init('Empresa')->saveAll($this->request->data)) {
          $this->Session->write('Auth.User.Empresa', ClassRegistry::init('Empresa')->getByUserId(
            $this->Auth->user('cu_cve'), true
          ));
          $this->success(__('Se han cambiado tus datos satisfactoriamente.'));
        } else {
          $this->response->statusCode(400);
          $this->error(__('Ha ocurrido un error al intentar guardar los datos.'));
        }
      }
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
    $this->redirect(array(
      'action' => 'mi_cuenta'
    ));
  }

  public function mi_cuenta() {
    $title_for_layout = __('Mi Cuenta');
    $empresaId = $this->Auth->user('Empresa.cia_cve');

    if ($this->request->is('post') || $this->request->is('put')) {
      if (array_key_exists('Empresa', $this->request->data)) {
        $this->request->data['Empresa']['cia_cve'] = $empresaId;
        if (ClassRegistry::init('Empresa')->saveAll($this->request->data)) {
          $this->Session->write('Auth.User.Empresa', $this->request->data['Empresa']);
          $this->success(__('Se han cambiado tus datos satisfactoriamente.'));
        } else {
          $this->error(__('Ha ocurrido un error al intentar guardar los datos.'));
        }
      }

      if (array_key_exists('Usuario', $this->request->data)) {
        $this->request->data['UsuarioEmpresaContacto'] = $this->request->data['Usuario'];
        $this->request->data['UsuarioEmpresaContacto']['cu_cve'] = $this->Auth->user('cu_cve');
        if (ClassRegistry::init('UsuarioEmpresaContacto')->save($this->request->data)) {
          $this->Session->write('Auth.User.Datos', $this->request->data['UsuarioEmpresaContacto']);
          $this->success(__('Se han cambiado tus datos satisfactoriamente.'));
        } else {
          $this->error(__('Ha ocurrido un error al intentar guardar los datos.'));
        }
      }
    }

    if ($this->Acceso->checkProfile(null, 'diamond')) {
      $this->request->data['MicroSitio'] = ClassRegistry::init('MicroSitio')->get($empresaId, 'first');
    }

    $this->request->data['Empresa'] = $this->Session->read('Auth.User.Empresa');

    $datosEmpresa = ClassRegistry::init('DatosEmpresa')->find('first', array(
      'conditions' => array(
        'DatosEmpresa.cia_cve = ' . $empresaId,
        'DatosEmpresa.tipodom_cve = 0'
      ),
      'recursive' => -1
    ));

    $this->request->data['DatosEmpresa'][] = !empty($datosEmpresa['DatosEmpresa']) ? $datosEmpresa['DatosEmpresa'] : array();

    $opcionesFacturacion = ClassRegistry::init('FacturacionEmpresa')->find('datos_facturacion', array(
      'all'=> true,
      'empresa' => $empresaId,
      'combine' => true,
    ));

    // $facturacionEmpresa = ClassRegistry::init('FacturacionEmpresa')->find('datos_facturacion', array(
    //   'empresa' => $empresaId
    // ));

    // $this->request->data = array_merge($this->request->data, $facturacionEmpresa);
    //$this->request->data['FacturacionEmpresa'] = !empty($facturacionEmpresa['FacturacionEmpresa']) ? $facturacionEmpresa['FacturacionEmpresa'] : array();

    // $datosFacturacionEmpresa = ClassRegistry::init('DatosEmpresa')->find('first', array(
    //   'conditions' => array(
    //     'DatosEmpresa.cia_cve = ' . $empresaId,
    //     'DatosEmpresa.tipodom_cve = 1'
    //   ),
    //   'recursive' => -1
    // ));

    // $this->request->data['DatosFacturacionEmpresa'] = !empty($datosFacturacionEmpresa['DatosEmpresa']) ? $datosFacturacionEmpresa['DatosEmpresa'] : array();

    $this->request->data['Usuario'] = $this->Auth->user('Datos');

    if (!empty($datosEmpresa)) {
      $cp_cve = $this->request->data['DatosEmpresa'][0]['cp_cve'];
      $cp_cp = ClassRegistry::init('CodigoPostal')->getCP($cp_cve, true)['cp'];
    }

    if (!empty($facturacionEmpresa['DatosFacturacionEmpresa'])) {
      $cp_cve_fact = $this->request->data['DatosFacturacionEmpresa']['cp_cve'];
      $cp_cp_fact = ClassRegistry::init('CodigoPostal')->getCP($cp_cve_fact, true)['cp'];
    }

    $giros = ClassRegistry::init('Catalogo')->lista('giros');
    $isEmpresaAdmin = $this->Auth->user('cu_cve') === $this->Auth->user('Empresa.cu_cve');
    $this->set(compact('title_for_layout', 'cp_cve', 'cp_cp', 'cp_cve_fact', 'cp_cp_fact', 'giros', 'isEmpresaAdmin', 'opcionesFacturacion'));

  }

  public function cambiar_contrasena($keycode) {
    $this->loadModel('UsuarioEmpresa');

    if (!$this->UsuarioEmpresa->verifyPassword($this->request->data['UsuarioEmpresa']['old_password'], $this->Auth->user('cu_cve'))) {
      $this->error(__('Tu contraseña actual es incorrecta.'));
    } else if ($this->request->data['UsuarioEmpresa']['new_password'] != $this->request->data['UsuarioEmpresa']['confirm_password']) {
      $this->error(__('Verifica que las contraseñas sean iguales.'));
    } else {
      if ($this->UsuarioEmpresa->changePassword(
        $this->request->data['UsuarioEmpresa']['confirm_password'],
        $this->Auth->user('cu_cve')
      )) {
        $this->success(__('Se ha cambiado tu contraseña con éxito.'));
      }
    }

    /*if (!isset($keycode) && $keycode !== $this->Auth->user('keycode')) {
      $this->error('Tu código de seguridad es erróneo.');
      $this->redirect(array('admin' => 0, 'controller' => 'mi_espacio', 'action' => 'mi_cuenta'));
    }

    if ($this->Auth->user()) {
      $this->Session->write('Tokens.reset_password', $keycode);
      $this->Session->write('Tokens.user_model', 'UsuarioEmpresa');

      $this->redirect(array(
        'admin' => 0,
        'controller' => 'tickets',
        'action' => 'nueva_contrasena',
        $keycode
      ));
    }*/
  }

  public function admin_mi_cuenta() {
    $title_for_layout = __('Mi Cuenta');

    $this->set(compact('title_for_layout'));
  }

  public function micrositio() {
    if ($this->request->is('post') || $this->request->is('put')) {
      if (ClassRegistry::init('MicroSitio')->saveOrUpdate(
        $this->Auth->user('Empresa.cia_cve'), array(
          'cia_descrip' => $this->request->data('MicroSitio.cia_descrip')
        )
      )) {
        $this->success(__('Se guardó su configuración'));
      } else {
        $this->error(__('Ocurrió un error al guardar tu configuración'));
      }
    }
  }

}
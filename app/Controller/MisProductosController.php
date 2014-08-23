<?php

App::uses('BaseEmpresasController', 'Controller');
App::uses('CakeEvent', 'Event');
App::uses('ProductosListener', 'Event');

class MisProductosController extends BaseEmpresasController {

  public $name = 'MisProductos';

  public $components = array(
    'Emailer',
    'Carrito' => array(

    )
  );

  public $helpers = array('PaypalIpn.Paypal');

  public function __construct($request = null, $response = null) {
    parent::__construct($request, $response);

    // Agrega ProductosListener al manejador de eventos.
    $listener = new ProductosListener();
    $this->getEventManager()->attach($listener);
  }

  public function beforeFilter() {
    parent::beforeFilter();

    // if (!$this->Acceso->isDevCompany()) {
    //   if (in_array($this->request->params['action'], array('carrito', 'catalogo'))) {
    //     $this->redirect(array(
    //       'controller' => 'mis_productos',
    //       'action' => 'index'
    //     ));
    //   }
    // }
  }

  public function index() {
    $title_for_layout = __('Mis Productos');

    $this->set(compact('title_for_layout'));
  }

  public function adquiridos() {
    $title_for_layout = __('Mis Productos Adquiridos');
    $direccion = ClassRegistry::init('DatosEmpresa')->getStrDir($this->Auth->user('Empresa.cia_cve'));

    $this->set(compact('title_for_layout', 'direccion'));
  }

  public function confirmar($type = '', $idFactura = null) {
    $title_for_layout = __('Confirmación de Compra');

    $items = array();

    /**
     * Aquí obtendrá los items y el factura de la sesión.
     */
    if (!$idFactura) {
      $idFactura = $this->Session->read('App.persistData.factura');
    }

    $this->loadModel('Factura');
    $factura = $this->Factura->get('all_facturas', array(
      'first' => true,
      'conditions' => array(
        'factura_folio' => $idFactura,
        'Factura.cia_cve' => $this->Auth->user('Empresa.cia_cve')
      )
    ));

    if (empty($factura)) {
      $this
        ->error('El factura que buscas no existe.')
        ->redirect(array(
          'controller' => 'mis_productos',
          'action' => 'index'
        ));
    }

    foreach ($factura['FacturaDetalles'] as $key => $value) {
      $items[] = array(
        'item_name' => $value['Membresia']['nombre'],
        'amount' => $value['Membresia']['costo'],
        'quantity' => $value['cantidad'],
        'item_number' => $value['Membresia']['id']
      );
    }

    $this->set(compact('title_for_layout', 'items', 'factura'));
    $this->render('confirmar_' . $type);
  }

  public function carrito($step = '') {
    $title_for_layout = __('Carrito de Compras');

    $empresaId = $this->Auth->user('Empresa.cia_cve');
    $this->loadModel('FacturacionEmpresa');
    if ($this->request->is('post')) {
      $data = $this->request->data;
      $metodo_pago = $data['Carrito']['metodo_pago'];

      if (!in_array($metodo_pago, array('paypal', 'deposito', 'transferencia'))) {
        $this
          ->error(__('Error con el método de pago'))
          ->redirect(array(
            'controller' => 'mis_productos',
            'action' => 'carrito'
          ));
      }
      /**
       * Actualiza los items del carrito, esto implica actualizar la sesión
       * que es en donde se guardan los items comprados.
       */
      $this->Carrito->update($data['Carrito']['Items']);

      $rfc = $data['Carrito']['factura_rfc'];
      $ciaOwnsRFC = $this->FacturacionEmpresa->isOwnedBy($empresaId, $rfc, 'cia_cve');

      if ($ciaOwnsRFC) {
        // Obtenemos los datos del carrito antes de confirmarlo, ya que al confirmar se borra de la sesión.
        $carrito = $this->Carrito->get();

        if ((bool)($lastFactura = $this->Carrito->checkout($rfc))) {
          // $this->success(__('Se guardó la factura correctamente.'));
          $email = $this->Auth->user('cu_sesion');
          $nombre = $this->Auth->user('fullName');
          $cia_nom = $this->Auth->user('Empresa.cia_nombre');


          $url = array(
            'controller' => 'mis_productos',
            'action' => 'factura',
            'id' => $lastFactura['Factura']['factura_cve'],
            'ext' => 'pdf'
          );

          $this->Emailer->sendEmail(
            $email,                                                   //El email de ventas.
            __('Hola %s, has adquirido un nuevo producto para %s.', $nombre, $cia_nom),  // Subject
            'empresas/nuevo_producto',                                // Plantilla
            array(      // Variables
              'costo' => $carrito['total'],
              'url' => $url
            )
          );

          $this->redirect(array(
            'controller' => 'mis_productos',
            'action' => 'confirmar',
            $metodo_pago
          ), compact('url', 'carrito') + array(
            'factura' => $lastFactura['Factura']['factura_folio']
          ));
        } else {
          $this->error(__('Ocurrió un error al procesar tu carrito de compras.'));
        }
      } else {
        $this->error(__('El RFC no existe o no está asociado a tu compañia'));
      }
    } //else {
      $cart = $this->Carrito->get();

      if (!$this->Carrito->isEmpty()) {
        $membresias = ClassRegistry::init('Membresia')->find('detalles', array(
          'conditions' => array(
            'Membresia.membresia_cve' => $this->Carrito->getItems('id')
          )
        ));
      }

      $opcionesFacturacion = $this->FacturacionEmpresa->find('datos_facturacion', array(
        'all'=> true,
        'empresa' => $empresaId,
        'combine' => true
      ));

      // $facturacionEmpresa = ClassRegistry::init('FacturacionEmpresa')->find('datos_facturacion', array(
      //   'empresa' => $empresaId
      // ));

      // $this->request->data = array_merge($this->request->data, $facturacionEmpresa);

      // if (!empty($facturacionEmpresa['DatosFacturacionEmpresa'])) {
      //   $cp_cve_fact = $this->request->data['DatosFacturacionEmpresa']['cp_cve'];
      //   $cp_cp_fact = ClassRegistry::init('CodigoPostal')->getCP($cp_cve_fact, true)['cp'];
      //   $this->set(compact('cp_cve_fact', 'cp_cp_fact'));
      // }

      $this->set(compact('opcionesFacturacion'));
    // }

    $this->set(compact('title_for_layout', 'membresias', 'cart'));
  }

  public function actualizar_carrito() {

  }

  public function confirmar_carrito() {
    $title_for_layout = __('Confirmación de Pedido');

    $this->set(compact('title_for_layout'));
  }

  public function catalogo() {
    $title_for_layout = __('Catálogo de Productos');
    $conditions = array(
      'membresia_status' => 1,
      'membresia_tipo' => 'N'
    );

    /**
     * Si la compañia es convenio sólo se muestran las membresías.
     */
    if ((int)$this->Auth->user('Empresa.cia_tipo') === 1) {
      $conditions['membresia_clase'] = 'mbs';
    }

    $membresias = ClassRegistry::init('Membresia')->find('detalles', array(
      'combine' => true,
      'conditions' => $conditions
    ));

    $this->loadModel('Empresa');
    $hasPromo = $this->Empresa->hasPromo($this->Auth->user('Empresa.cia_cve'));
    $hasMembresia = $this->Empresa->PerfilMembresia->hasMembresia($this->Auth->user('Empresa.cia_cve'));

    $this->set(compact('title_for_layout', 'membresias', 'hasPromo', 'hasMembresia'));
  }

  public function agregar_a_carrito($id) {
    $item = ClassRegistry::init('Membresia')->get($id);

    if ($this->Carrito->add($item['membresia_nom'], $item)) {
      // $this->success(__('Se agregó al carrito satisfactoriamente'));
    }

    $this->html('element', 'empresas/carrito/dropdown_menu');
    //$this->redirect('referer');
  }

  public function facturas() {
    $title_for_layout = __('Mis Facturas');

    $facturas = ClassRegistry::init('Empresa')->get('facturas', array(
      'conditions' => array(
        'Empresa.cia_cve' => $this->Auth->user('Empresa.cia_cve')
      ),
      'first' => true
    ));

    $this->set(compact('title_for_layout', 'facturas'));
  }

  public function factura($folio, $subaction = null) {
    $this->loadModel('Factura');

    $isOwnedBy = $this->Factura->isOwnedBy($this->Auth->user('cu_cve'), $folio, array(
      'itemKey' => 'factura_folio'
    ));

    $factura = array();
    if ($isOwnedBy) {
      if ($subaction === 'cancelar') {
        if ((int)$this->Factura->field('factura_status', array(
          'factura_folio' => $folio
        )) != 0) {
          $this->error(__('No puedes cancelar una factura que no tiene status pendiente.'));
        } elseif ($this->Factura->borrar($folio)) {
          $this->success(__('Se ha cancelado el factura con éxito'));

          if (!empty($this->request->data['redirect'])) {
            $this->redirect(array(
              'controller' => 'mis_productos',
              'action' => 'facturas'
            ));
          } else {
            $this->callback('deleteRow');
          }
        } else {
          $this->error(__('Ocurrió un error al intentar cancelar el factura'));
        }
      } else {
        $factura = $this->Factura->find('all_facturas', array(
          'conditions' => array(
            'factura_folio' => $folio,
            'Factura.cia_cve' => $this->Auth->user('Empresa.cia_cve')
          )
        ));
      }
    } else {
      $this->error(__('Este factura no existe.'));

      if (isset($this->request->params['ext']) && $this->request->params['ext'] === 'pdf') {
        $this->redirect(array(
          'controller' => 'mis_productos',
          'action' => 'facturas'
        ));
      }
    }

    $this->set(compact('factura'));
  }

  public function historico() {
    $title_for_layout = __('Histórico de Productos adquiridos.');

    $facturas = ClassRegistry::init('Empresa')->get('facturas', array(
      'conditions' => array(
        'Empresa.cia_cve' => $this->Auth->user('Empresa.cia_cve')
      ),
      'first' => true
    ));

    $this->set(compact('title_for_layout', 'facturas'));
  }

  public function recomendaciones() {
    $title_for_layout = __('Te recomendamos');

    $membresias = ClassRegistry::init('Membresia')->find('recomendaciones', array(
      'combine' => true,
      'cia' => $this->Auth->user('Empresa.cia_cve')
    ));

    $this->set(compact('title_for_layout', 'membresias'));

    $this->render('catalogo');
  }

  public function compra_exitosa() {
    $title_for_layout = __('¡Gracias por tu compra!');

    $this->set(compact('title_for_layout') + array(
      '_mainContentClass' => 'no-bg'
    ));
  }

  /**
   * Promociones
   * Cuando es convenio, no se crea una factura, se asigna la membresía en tconvenios.
   * Cuando es comercial se crea una factura.
   * @param  [type] $keycode [description]
   * @return [type]          [description]
   */
  public function promociones($id = null, $slug = null) {
    $title_for_layout = __('Promociones');

    $this->loadModel('Empresa');
    $empresaId = $this->Auth->user('Empresa.cia_cve');

    if ($this->isAjax || $this->request->is('post')) {
      $admin = $this->Empresa->getAdmin($empresaId);
      // Verfica el administrador.
      if ($this->Auth->user('keycode') != $admin['Administrador']['keycode']) {
        $this->error(__('Lo sentimos, parece que tú no eres el administrador de tu empresa.'));
        return ;
      }

      // Verifica si ya se activó una membresía
      if ($this->Empresa->PerfilMembresia->hasMembresia($empresaId)) {
        $this
          ->info(__('Ya cuentas con una membresía activada.'));
        return ;
      } else if ($this->Empresa->is('convenio', $empresaId)) {
        $this->Empresa->Convenio->id = $empresaId;

        // Si el convenio ya tiene una membresía asignada.
        if ($this->Empresa->Convenio->hasMembresia()) {
          $this
            ->modal('modals/empresas/promocion_error_convenio');
          return ;
        } elseif ($this->Empresa->Convenio->saveField('membresia_cve', $id)) {
          $empresa = $this->Empresa->get($empresaId, 'basic_info');

          $event = new CakeEvent('Model.Productos.solicitud_promocion', $this, array(
            'folio' => null,
            'empresa' => $empresa
          ));

          $this->getEventManager()->dispatch($event);

          $this
            ->modal('modals/empresas/promocion_success_convenio');
        } else {
          $this->error(__('No se ha podido procesar tu solicitud.'));
        }
      } else { // Comercial
        if ($this->Empresa->hasPromo($empresaId)) {
          $factura = $this->Empresa->Facturas->get('first', array(
            'recursive' => -1,
            'conditions' => array(
              'cia_cve' => $empresaId,
              'factura_folio LIKE' => '%PROMO'
            )
          ));

          $this
            ->modal('modals/empresas/promocion_error', array(
              'factura' => $factura['factura_folio'],
              'created' => $factura['created']
            ));
          return ;
        }

        $this->_createPromo($empresaId, $admin['Administrador']['cu_cve'], $id);
      }
    } elseif ($this->request->is('get')) {
      $membresias = ClassRegistry::init('Membresia')->find('detalles', array(
        'combine' => true,
        'conditions' => array(
          'membresia_status' => 1,
          'membresia_tipo' => 'P'
        )
      ));

      $this->set(compact('title_for_layout', 'membresias'));
    }
  }

  private function _createPromo($empresaId, $userId, $membresiaId) {
    $this->loadModel('Factura');

    if ($this->Factura->savePromo($empresaId, $this->Auth->user('Empresa.cia_rfc'), $userId, $membresiaId)) {
      $factura = $this->Factura->lastFactura;
      $folio = $factura['Factura']['factura_folio'];
      $empresa = $this->Empresa->get($empresaId, 'basic_info');

      $event = new CakeEvent('Model.Productos.solicitud_promocion', $this, array(
        'folio' => $folio,
        'empresa' => $empresa
      ));

      $this->getEventManager()->dispatch($event);

      $this
        ->modal('modals/empresas/promocion_success', array(
          'factura' => $folio,
        ));
    } else {
      $this->error(__('No se ha podido procesar tu solicitud.'));
    }
  }
}
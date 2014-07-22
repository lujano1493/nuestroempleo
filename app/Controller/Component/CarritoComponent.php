<?php

App::uses('Component', 'Controller');

/**
 * Componente para verificar los permisos, accesos y créditos del Usuario.
 */
class CarritoComponent extends Component {

  public $settings = array(
    'key' => 'Auth.Cart',
  );

  protected $keys = array();

  /**
   * [$components description]
   * @var array
   */
  public $components = array('Session', 'Auth');

  public function __construct(ComponentCollection $collection, $settings = array()) {
    $settings = array_merge($this->settings, (array)$settings);

    parent::__construct($collection, $settings);
  }

  /**
   * Inicialización del componente.
   * @param  Controller $controller [description]
   * @return [type]                 [description]
   */
  public function initialize(Controller $controller) {
    $this->controller = $controller;
    $this->params = $this->controller->params;

    $this->keys = array(
      'items' => implode('.', array($this->settings['key'], 'items')),
      'total' => implode('.', array($this->settings['key'], 'total')),
      'count' => implode('.', array($this->settings['key'], 'count')),
    );

    if (!$this->Session->check($this->settings['key'])) {
      $this->Session->write($this->settings['key'], array(
        'items' => array(),
        'total' => 0,
        'count' => 0
      ));
    }
  }

  /**
   * Agrega un item al carrito de compras, si el producto ya está, aumenta su cantidad.
   * @param string $name [description]
   * @param array  $item [description]
   */
  public function add($name, $item = array()) {
    $products = $this->getItems(); // Obtiene items.

    if (isset($products[$name])) {
      $products[$name]['cant'] += 1;
    } else {
      $products[$name] = array(
        'cant' => 1,
        'desc' => $item // Agrega como descripción.
      );
    }

    $this->setItems($products); // Calcula el total.

    return true;
  }

  /**
   * Calcula el total del costo por todos los productos y su cantidad.
   * Lo escribe en la sesión, y lo retorna.
   * @param  array  $items [description]
   * @return [type]        [description]
   */
  public function calculateTotalCost($items = array()) {
    if (func_num_args() === 0) {
      $items = $this->getItems();
    }

    $totalCost = Hash::reduce($items, '{s}', function ($result, $item) {
      $result = (int)$result + (int)($item['cant'] * $item['desc']['costo']);
      return $result;
    });

    $this->Session->write($this->keys['total'], $totalCost);

    return $totalCost;
  }

  /**
   * Calcula el número de items, seleccionados.
   * @param  array  $items [description]
   * @return [type]        [description]
   */
  public function calculateTotalItems($items = array()) {
    if (func_num_args() === 0) {
      $items = $this->getItems();
    }

    $totalItems = Hash::reduce($items, '{s}', function ($result, $item) {
      $result = (int)$result + (int)$item['cant'];
      return $result;
    });

    $this->Session->write($this->keys['count'], $totalItems);
    return $totalItems;
  }

  /**
   * Verifica si items del carrito está vacío.
   * @return boolean [description]
   */
  public function isEmpty() {
    $items = $this->getItems();
    return empty($items);
  }

  /**
   * Actualiza el carrito de compras (sólo actualiza y elimina, no agrega nuevos).
   * @param  [type] $items [description]
   * @return [type]        [description]
   */
  public function update($items) {
    $_items = array();              // Aquí se guardarán los items actualizados.
    $products = $this->getItems();  // Obtiene los items del carrito.

    foreach ($items as $key => $value) {
      $name = $value['id'];
      $cant = $value['cant'];

      /**
       * Si existe el item en el carrito de compras lo actualiza con la nueva cantidad,
       * en caso de que no exista o la cantidad sea cero, lo descarta y por lo tanto,
       * elimina.
       */
      if (isset($products[$name]) && $cant > 0) {
        $_items[$name]['cant'] = $cant;
        $_items[$name]['desc'] = $products[$name]['desc'];
      }
    }

    $this->setItems($_items); // Establece los items.
  }

  /**
   * Guarda en Facturas y limpia la sesión del carrito.
   * @param  integer $status [description]
   * @return [type]          [description]
   */
  public function checkout($rfc, $status = 0) {
    $empresaId = $this->Auth->user('Empresa.cia_cve');
    $userId = $this->Auth->user('cu_cve');

    $total = (float)$this->Session->read($this->keys['total']);
    $data = array(
      'Factura' => array(
        'cia_cve' => $empresaId,
        'cia_rfc' => $rfc,
        'cu_cve' => $userId,
        'factura_status' => $status,
        'factura_subtotal' => $total,
        'factura_desc' => 0,
        'factura_total' => number_format($total * 1.16, 2, '.', '')
      ),
      'FacturaDetalles' => $this->getItems('save')
    );

    $Factura = ClassRegistry::init('Factura');

    $success = $Factura->saveAssociated($data);
    $id = $Factura->getLastInsertID();

    if ($success) {
      $this->Session->delete($this->settings['key']);
      return $Factura->lastFactura;
    }

    return $success;
  }

  /**
   * Establece items, en el carrito, calculando el costo total y el número de items.
   * @param array $items [description]
   */
  public function setItems($items = array()) {
    $this->calculateTotalCost($items);
    $this->calculateTotalItems($items);

    $this->Session->write($this->keys['items'], $items);
  }

  /**
   * Obtiene los productos seleccionados.
   * @return [type] [description]
   */
  public function getItems($type = null) {
    $items = $this->Session->read($this->keys['items']);

    if (is_null($type)) {
      return $items;
    } else if ($type === 'id') {
      return Hash::extract($items, '{s}.desc.membresia_cve');
    } elseif($type === 'save') {
      $_items = array();
      foreach ($items as $key => $value) {
        $_items[] = array(
          'cantidad' => $value['cant'],
          'membresia_cve' => $value['desc']['membresia_cve']
        );
      }
      return $_items;
    }
  }

  /**
   * Obtiene todo el carrito.
   * @param  [type] $type [description]
   * @return [type]       [description]
   */
  public function get($type = null) {
    return $this->Session->read($this->settings['key']);
  }
}
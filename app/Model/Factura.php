<?php

App::uses('CakeEvent', 'Event');
App::uses('ProductosListener', 'Event');

class Factura extends AppModel {
  /**
   * [$actsAs description]
   * @var array
   */
  public $actsAs = array('Containable');

  /**
   * [$name description]
   * @var string
   */
  public $name = 'Factura';

  /**
   * [$primaryKey description]
   * @var string
   */
  public $primaryKey = 'factura_cve';

  public $lastFactura = array();

  /**
   * [$useTable description]
   * @var string
   */
  public $useTable = 'tfacturacion';

  /**
   * [$findMethods description]
   * @var array
   */
  public $findMethods = array('all_facturas' => true,);

  /**
   * [$belongsTo description]
   * @var array
   */
  public $belongsTo = array(
    'Empresa' => array(
      'className' => 'Empresa',
      // 'fields' => array('Empresa.cia_cve', 'Empresa.cia_nombre'),
      'foreignKey' => 'cia_cve',
    ),
    'FacturacionEmpresa' => array(
      'className' => 'FacturacionEmpresa',
      // 'fields' => array('Empresa.cia_cve', 'Empresa.cia_nombre'),
      'foreignKey' => 'cia_rfc',
    ),
    // 'Membresia' => array(
    //   'className' => 'Membresia',
    //   'foreignKey' => 'membresia_cve'
    // )
  );

  public $hasMany = array(
    'FacturaDetalles' => array(
      'className' => 'FacturaDetalle',
      'foreignKey' => 'factura_cve',
      'finderQuery' => 'SELECT
        FacturaDetalles.factura_id,
        FacturaDetalles.factura_cve,
        FacturaDetalles.cantidad,
        Membresia.membresia_cve Membresia__id,
        Membresia.membresia_nom Membresia__nombre,
        Membresia.membresia_desc Membresia__desc,
        Membresia.per_cve Membresia__perfil,
        Membresia.membresia_clase Membresia__css_class,
        Membresia.vigencia,
        Membresia.costo,
        PerfilMembresia.fec_ini Membresia__inicio,
        PerfilMembresia.fec_fin Membresia__vence
          FROM tfacturaxmembresias FacturaDetalles
          INNER JOIN tmembresias Membresia ON (
            FacturaDetalles.membresia_cve = Membresia.membresia_cve
          )
          LEFT JOIN tperfilxmembresia PerfilMembresia ON (
            PerfilMembresia.factura_cve = FacturaDetalles.factura_cve AND
            PerfilMembresia.membresia_cve = Membresia.membresia_cve
          )
          LEFT JOIN tcatalogo Clase ON (
            Membresia.membresia_clase = Clase.opcion_valor AND
            Clase.ref_opcgpo = \'MEMBRESIA_CLASE\'
          )
          WHERE FacturaDetalles.factura_cve IN ({$__cakeID__$})
          ORDER BY Clase.opcion_sec ASC'
    )
  );

  public $knows = array(
    'Membresia'
  );

  public $status = array(
    'pendiente' => array(
      'val' => 0,
      'text' => 'Pendiente'
    ),
    'pagado' => array(
      'val' => 1,
      'text' => 'Pagado'
    ),
    'activado' => array(
      'val' => 2,
      'text' => 'Activado',
    ),
    'vencido' => array(
      'val' => -1,
      'text' => 'Vencido',
    )
  );

  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);

    // Agrega ProductosListener al manejador de eventos.
    $listener = new ProductosListener();
    $this->getEventManager()->attach($listener);
  }

  /**
   * Genera el folio de la factura de la forma 00000000,
   * donde los primeros 5 dígitos son el id de la compañia y los últimos 3
   * son el número de facturas.
   * @param  [type]  $data   [description]
   * @param  boolean $result [description]
   * @param  boolean $promo  [description]
   * @return [type]          [description]
   */
  protected function generateFolio($data = null, $result = false, $promo = false) {
    if (is_null($data)) {
      $data = $this->data;
    }

    //$membresiaId = $data[$this->alias]['membresia_cve'];
    $empresaId = $data[$this->alias]['cia_cve'];

    if (!$result) {
      $conditions = array(
        'Factura.cia_cve' => $empresaId,
        (!$promo
        ? 'Factura.factura_folio NOT LIKE'
        : 'Factura.factura_folio LIKE'
        ) => '%PROMO',
      );

      $result = $this->find('count', array(
        'recursive' => -1,
        'conditions' => $conditions
      ));
    }

    $folio = str_pad($empresaId, 5, '0', STR_PAD_LEFT)
      . str_pad($result + 1, 3, '0', STR_PAD_LEFT)
      . ($promo ? 'PROMO' : '' );

    if ($this->hasAny(array(
      $this->alias . '.' . 'factura_folio' => $folio
    ))) {
      return $this->generateFolio($data, $result + 1, $promo);
    }

    return $folio;
  }

  /**
   * [_findFacturas description]
   * @return [type] [description]
   */
  public function _findAll_facturas($state, $query, $results = array()) {
    if ($state === 'before') {
      $this->bindModel(
        array('belongsTo' => array(
          'GiroEmpresa' => array(
            'className' => 'Giros',
            'foreignKey' => false
          ),
          'GiroFactEmpresa' => array(
            'className' => 'Giros',
            'foreignKey' => false
          ),
          'Administrador' => array(
            'className' => 'UsuarioEmpresa',
            'foreignKey' => false
          ),
          'AdministradorContacto' => array(
            'className' => 'UsuarioEmpresaContacto',
            'foreignKey' => false
          ),
          // 'Perfil' => array(
          //   'className' => 'Perfil',
          //   'foreignKey' => false
          // )
        ))
      );

      $query['contain'] = array(
        'FacturacionEmpresa',
        'GiroFactEmpresa' => array(
          'conditions' => array(
            'FacturacionEmpresa.giro_cve = GiroFactEmpresa.giro_cve'
          ),
          'fields' => array(
            'GiroFactEmpresa.giro_nom FacturacionEmpresa__giro'
          ),
        ),
        'Empresa',
        'Administrador' => array(
          'conditions' => array(
            'Empresa.cu_cve = Administrador.cu_cve'
          )
        ),
        'AdministradorContacto' => array(
          'conditions' => array(
            'Empresa.cu_cve = AdministradorContacto.cu_cve'
          )
        ),
        // 'Perfil' => array(
        //   'conditions' => array(
        //     'Perfil.per_cve = Administrador.per_cve'
        //   )
        // ),
        'GiroEmpresa' => array(
          'conditions' => array(
            'Empresa.giro_cve = GiroEmpresa.giro_cve'
          ),
          'fields' => array(
            'GiroEmpresa.giro_nom Empresa__giro'
          ),
        ),
        'FacturaDetalles',
      );
      if (!isset($query['order'])) {
        $query['order'] = array(
          $this->alias . '.' . $this->primaryKey => 'ASC',
          'Empresa.cia_cve' => 'ASC'
        );
      }
      //$query['recursive'] = -1;
      return $query;
    } elseif ($state === 'after') {

    }
    return $results;
  }

  public function getLast($limit = 5) {
    return $this->find('all_facturas', array(
      'limit' => $limit,
      'order' => array(
        'Factura.created' => 'DESC NULLS LAST'
      )
    ));
  }

  /**
   * [setMembresia description]
   * @param [type] $membresiaId [description]
   * @param [type] $empresaId   [description]
   * @param [type] $userId      [description]
   */
  public function confirm($folio, $empresaId, $userId = null) {
    $successAssigment = false;

    /**
     * Si $userId es null, obtendrá el administrador de la compañia.
     */
    if (is_null($userId)) {
      $admin = $this->Empresa->getAdmin($empresaId);
      $userId = $admin['Empresa']['cu_cve'];
    }

    // Obtiene los detalles del factura.
    $detalles = $this->get('first', array(
      'contain' => array(
        'FacturaDetalles'
      ),
      'conditions' => array(
        $this->alias . '.factura_folio' => $folio,
        $this->alias . '.cia_cve' => $empresaId
      )
    ));

    $facturaId = !empty($detalles) ? $detalles[$this->alias][$this->primaryKey] : false;

    // Comienza transacción
    $this->begin();
    if ($facturaId && !empty($detalles['FacturaDetalles'])) {

      // Si la empresa es convenio se convierte en comercial.
      $this->Empresa->id = $empresaId;
      $successAssigment = (int)$this->Empresa->field('cia_tipo') === 1 ? $this->Empresa->makeComercial() : true;

      if ($successAssigment) {
        foreach ($detalles['FacturaDetalles'] as $_v => $v) {
          $cantidad = $v['cantidad'];
          $membresiaId = $v['Membresia']['id'];

          /**
           * Asigna los créditos de la membresía al administrador de la empresa.
           * @var [type]
           */
          $successAssigment = $this->Membresia->assign($membresiaId, $empresaId, $userId, $facturaId, array(
            'cant' => $cantidad,
            'save' => true
          ));

          /**
           * Si ocurrió un error al guardar los créditos, rompe la iteración,
           * por lo tanto hará un rollback.
           */
          if (!$successAssigment) {
            break;
          }
        }
      }
    }

    /**
     * Una vez que se asignaron todos los créditos, establece el factura con
     * $status = 2 que quiere decir que el factura o factura ha sido asignada.
     */
    if ($successAssigment && $facturaId && $this->changeStatus($facturaId, 2)) {
      $event = new CakeEvent('Model.Productos.servicios_activados', $this, array(
        'factura_folio' => $folio,
        'empresa' => $this->Empresa->get($empresaId, 'basic_info')
      ));

      $this->getEventManager()->dispatch($event);

      $this->commit();
      return true;
    } else {
      $this->rollback();
      return false;
    }
  }

  public function changeStatus($facturaId, $status = 0) {
    $this->id = $facturaId;

    return $this->saveField('factura_status', $status);
  }

  public function markAsPaid($folio) {
    $factura = $this->find('first', array(
      'fields' => array(
        'Factura.factura_cve', 'Factura.factura_folio', 'Factura.cia_cve'
      ),
      'conditions' => array(
        'Factura.factura_folio' => $folio
      ),
      'recursive' => -1
    ));

    if (!empty($factura) && !empty($factura[$this->alias][$this->primaryKey])) {
      return $this->changeStatus($factura[$this->alias][$this->primaryKey], 1);
    }

    return false;
  }

  public function cancelar($folio) {
    $factura = $this->find('first', array(
      'fields' => array(
        'Factura.factura_cve', 'Factura.factura_folio', 'Factura.cia_cve', 'Factura.factura_status'
      ),
      'conditions' => array(
        'Factura.factura_folio' => $folio
      ),
      'recursive' => -1
    ));

    $success = false;
    if (!empty($factura) && (int)$factura[$this->alias]['factura_status'] === 0) {
      $facturaId = $factura[$this->alias][$this->primaryKey];
      if ($this->FacturaDetalles->deleteAll(array(
        'FacturaDetalles.factura_cve' => $facturaId
      )) && $this->deleteAll(array(
        $this->primaryKey => $facturaId
      ))) {

        $success = true;
      }
    }

    return $success;
  }

  /**
   * Obtiene las estadísticas de los productos adquiridos.
   * @param  [type] $userId [description]
   * @param  [type] $ciaId  [description]
   * @return [type]         [description]
   */
  public function getStats($userId, $ciaId) {
    $stats = $this->find('first', array(
      'fields' => array(
        // 'COUNT(CASE WHEN ' . $this->alias . '.factura_status = 0 AND PM.fecha_fin is null THEN 1 END) pendientes',
        // 'COUNT(CASE WHEN ' . $this->alias . '.factura_status = 1 AND PM.fecha_fin is null THEN 1 END) verificacion',
        // 'COUNT(CASE WHEN ' . $this->alias . '.factura_status = 2 AND PM.fecha_fin > CURRENT_DATE THEN 1 END) activas',
        // 'COUNT(CASE WHEN PM.fecha_fin <= CURRENT_DATE THEN 1 END) vencidas',
        'COUNT(CASE WHEN ' . $this->alias . '.factura_status = 2 THEN 1 END) adquiridos',
      ),
      'conditions' => array(
        $this->alias . '.cu_cve' => $userId,
        $this->alias . '.cia_cve' => $ciaId
      ),
      // 'joins' => array(
      //   array(
      //     'alias' => 'PM',
      //     'conditions' => array(
      //       'PM.factura_cve = ' . $this->alias . '.factura_cve'
      //     ),
      //     'table' => '(SELECT M.factura_cve, max(M.fec_fin) fecha_fin FROM tperfilxmembresia M GROUP BY M.factura_cve)',
      //     'type' => 'LEFT'
      //   )
      // ),
      'recursive' => -1
    ));

    return reset($stats);
  }

  /*public function saveFactura($data, $empresaId, $userId) {
    $detalles = array();

    foreach ($variable as $key => $value) {
      # code...
    }

    $factura = array(
      'Factura' => array(
        'cia_cve' => $empresaId,
        'cu_cve' => $userId,
        'factura_status' => 0,
        'factura_total' =>
      ),
      'FacturaDetalles' => $data
    );

    return $this->save($factura);
  }*/


  /**
    * Función se ejecuta antes de que se guarde una Factura.
    */
  public function beforeSave($options = array()) {
    if (!$this->issetId()) { //Nuevo Registro
      if (!empty($this->data[$this->alias]['promo'])) {
        $this->data[$this->alias]['factura_folio'] = $this->generateFolio($this->data, false, true);
      } else {
        $this->data[$this->alias]['factura_folio'] = $this->generateFolio($this->data);
      }
    }

    return parent::beforeSave($options);
  }

  /**
    * Función se ejecuta antes de que se guarde una Factura.
    */
  public function afterSave($created, $options = array()) {
    if ($created) {
      $this->lastFactura = $this->data;
    }

    return parent::afterSave($options);
  }

  /**
   * [afterFind description]
   * @param  [type]  $results [description]
   * @param  boolean $primary [description]
   * @return [type]           [description]
   */
  public function afterFind($results, $primary = false) {
    foreach ($results as $key => $value) {
      if (isset($value['Membresia'])) {
        $ini = $results[$key][$this->alias]['created'];
        $results[$key][$this->alias]['fin'] = (new Datetime($ini))->format('Y-m-d');
      }

      if (isset($value[$this->alias]['factura_status'])) {
        $results[$key][$this->alias]['status_str'] = $this->getStatus($value[$this->alias]['factura_status'], 'text');
      }

      if (isset($value[$this->alias]['factura_folio'])) {
        $folio = $value[$this->alias]['factura_folio'];
        $results[$key][$this->alias]['is_promo'] = substr($folio, -strlen('PROMO')) === 'PROMO';
      }
    }

    return $results;
  }

  public function savePromo($empresaId, $ciaRFC ,$userId, $membresiaId) {
    $data = array(
      'Factura' => array(
        'cia_cve' => $empresaId,
        'cia_rfc' => $ciaRFC,
        'cu_cve' => $userId,
        'factura_status' => 0,
        'factura_subtotal' => 0,
        'factura_desc' => 0,
        'factura_total' => 0,
        'promo' => true,
      ),
      'FacturaDetalles' => array(
        array(
          'cantidad' => 1,
          'membresia_cve' => $membresiaId
        )
      )
    );

    return $this->saveAssociated($data);
  }

  public function changePromo($facturaFolio, $membresia) {
    $facturaId = $this->field($this->primaryKey, array(
      'factura_folio' => $facturaFolio,
      'factura_status' => 0
    ));

    if ($facturaId) {
      $detalleId = $this->FacturaDetalles->field($this->FacturaDetalles->primaryKey, array(
        $this->primaryKey => $facturaId
      ));

      /**
       * Antes de actualizar debemos verificar que la membresia_id es promocional.
       */
      return $this->FacturaDetalles->updateAll(array(
        'membresia_cve' => $membresia
      ), array(
        $this->FacturaDetalles->primaryKey => $detalleId
      ));
    }

    return false;
  }

  /**
   * Borramos las facturas.
   * @param  [type] $typeOrFolio [description]
   * @param  [type] $empresaId   [description]
   * @return [type]              [description]
   */
  public function deleteFacturas($typeOrFolio, $empresaId) {
    if ($typeOrFolio === 'promos') {
      $results = $this->find('all', array(
        'fields' => array($this->primaryKey),
        'conditions' => array(
          'cia_cve' => 54, //$empresaId,
          'factura_folio LIKE' => '%PROMO',
          'factura_status' => 0
        ),
        'recursive' => -1
      ));
      $ids = Hash::extract($results, '{n}.' . $this->alias . '.' . $this->primaryKey);
    }

    if (!empty($ids)) {
      return $this->FacturaDetalles->deleteAll(array(
        'FacturaDetalles.' . $this->primaryKey => $ids
      )) && $this->deleteAll(array(
        $this->primaryKey => $ids
      ));
    } else {
      return true;
    }
  }

  /**
   * Actualiza la membresías a vencidas, sí la fecha en la que fueron activadas ya pasó,
   * su estatus se establece en -1
   * @return [type] [description]
   */
  public function purgeFacturas() {
    // QUERY para actualizar a vencidas las facturas.
    //
    $results = $this->query('SELECT factura_cve Factura__factura_cve
      FROM (
        SELECT
          MAX(P.fec_fin) max_fec_fin,
          P.cia_cve,
          P.factura_cve
        FROM tperfilxmembresia P
        INNER JOIN tfacturacion F ON (
          F.factura_cve = P.factura_cve AND F.factura_status >= 0
        )
        WHERE P.factura_cve IS NOT NULL
        GROUP BY
          P.cia_cve,
          P.factura_cve
        )
      WHERE max_fec_fin <= CURRENT_DATE'
    );

    $ids = Hash::extract($results, '{n}.Factura.factura_cve');

    if (!empty($ids)) {
      return $this->updateAll(array(
        $this->alias . '.factura_status' => -1 // Status de vencido
      ), array(
        $this->alias . '.' . $this->primaryKey => $ids
      ));
    }
    return true;
  }
}
<?php

App::uses('AppModel', 'Model');

class Empresa extends AppModel {
  /**
   *
   */
  public $actsAs = array('Containable');

  /**
   * [$name description]
   * @var string
   */
  public $name = 'Empresa';

  /**
   * [$primaryKey description]
   * @var string
   */
  public $primaryKey = 'cia_cve';

  /**
   * [$useTable description]
   * @var string
   */
  public $useTable = 'tcompania';

  public $type = array(
    'comercial' => 0,
    'convenio' => 1
  );

  /**
    * Métodos de búsqueda personalizados.
    */
  public $findMethods = array(
    'basic_info' => true,
    'data' => true,
    'admin' => true,
    'users' => true,
    'facturas' => true
  );

  public $knows = array(
    'Convenio',
    'PerfilMembresia',
    'Ticket'
  );

  /**
   * [$belongsTo description]
   * @var array
   */
  public $belongsTo = array(
    'Administrador' => array(
      'className' => 'UsuarioEmpresa',
      'foreignKey' => 'cu_cve'
    ),
    'Contacto' => array(
      'className' => 'UsuarioEmpresaContacto',
      'foreignKey' => 'cu_cve'
    )
  );


  public $hasMany = array(
    'Facturas' => array(
      'className' => 'Factura',
      'foreignKey' => 'cia_cve',
      'finderQuery' => 'SELECT
        PM.fecha_inicio Facturas__fecha_activacion,
        Facturas.cia_rfc,
        Facturas.created,
        Facturas.modified,
        Facturas.factura_cve,
        Facturas.cia_cve,
        Facturas.factura_subtotal,
        Facturas.factura_folio,
        Facturas.cu_cve,
        Facturas.factura_desc,
        Facturas.factura_total,
        Facturas.factura_status,
        FacturacionEmpresa.cia_cve,
        FacturacionEmpresa.cia_nombre,
        FacturacionEmpresa.cia_razonsoc,
        FacturacionEmpresa.giro_cve,
        FacturacionEmpresa.cia_rfc,
        FacturacionEmpresa.datos_cve,
        FacturacionEmpresa.created,
        FacturacionEmpresa.modified,
        Giro.giro_nom FacturacionEmpresa__giro,
        Datos.cia_tel FacturacionEmpresa__telefono,
        Datos.calle Direccion__calle,
        Datos.num_int Direccion__num_interior,
        Datos.num_ext Direccion__num_exterior,
        CP.cp_cp Direccion__cp,
        CP.cp_asentamiento Direccion__colonia,
        Ciudad.ciudad_nom Direccion__ciudad,
        Edo.est_nom Direccion__estado,
        Pais.pais_nom Direccion__pais
        FROM tfacturacion Facturas
        LEFT JOIN tfactcompania FacturacionEmpresa ON (
          FacturacionEmpresa.cia_rfc = Facturas.cia_rfc
        )
        LEFT JOIN tgiros Giro ON (
          FacturacionEmpresa.giro_cve = Giro.giro_cve
        )
        LEFT JOIN tdatoscompania Datos ON (
          FacturacionEmpresa.datos_cve = Datos.datos_cve
        )
        LEFT JOIN tcodigopostal CP ON (
          Datos.cp_cve = CP.cp_cve
        )
        LEFT JOIN tciudad Ciudad ON (
          Ciudad.ciudad_cve = CP.ciudad_cve
        )
        LEFT JOIN testado Edo ON (
          Edo.est_cve = Ciudad.est_cve
        )
        LEFT JOIN tpais Pais ON (
          Edo.pais_cve = Pais.pais_cve
        )
        LEFT JOIN (
          SELECT
            M.factura_cve,
            min(M.fec_ini) fecha_inicio
          FROM tperfilxmembresia M
          GROUP BY M.factura_cve
        ) PM ON (
          PM.factura_cve = Facturas.factura_cve
        )
        WHERE Facturas.cia_cve IN ({$__cakeID__$}) AND ({$__conditions__$})
        ORDER BY
          Facturas.factura_cve DESC,
          Facturas.factura_status DESC,
          PM.fecha_inicio DESC,
          Facturas.created DESC
      '
    ),
    'Creditos' => array(
      'className' => 'Credito',
      'foreignKey' => 'cia_cve'
    ),
    'DatosEmpresa' => array(
      'className' => 'DatosEmpresa',
      'foreignKey' => 'cia_cve'
    )
  );

  /**
   * [$hasOne description]
   * @var array
   */
  public $hasOne = array(
    'FacturacionEmpresa' => array(
      'className' => 'FacturacionEmpresa',
      'foreignKey' => 'cia_cve'
    )
  );

  /**
   * [$hasAndBelongsToMany description]
   * @var array
   */
  public $hasAndBelongsToMany = array(
    'UsuarioEmpresa' => array(
      'className' => 'UsuarioEmpresa',
      //'joinTable' => 'tcuentaxciane',
      'with' => 'EmpresasUsuarios',
      'foreignKey' => 'cia_cve',
      'associationForeignKey' => 'cu_cve',
      'unique' => false
    )
  );

  protected $joins = array(
    'producto' => array(
      'alias' => 'Producto',
      'table' => '(SELECT PM.cia_cve, FM.membresia_nom, PM.membresia_cve, PM.per_cve, FM.membresia_clase
        FROM (
          SELECT cia_cve, max(per_cve) per_cve, min(membresia_cve) membresia_cve
          FROM tperfilxmembresia WHERE fec_fin > CURRENT_DATE GROUP BY cia_cve) PM
        LEFT JOIN tmembresias FM ON (
          FM.membresia_cve = PM.membresia_cve
        ))',
      'type' => 'LEFT',
      'conditions' => array(
        'Producto.cia_cve = Empresa.cia_cve'
      ),
      'fields' => array(
        'Producto.membresia_clase',
        'Producto.membresia_nom',
        'Producto.membresia_cve',
      )
    ),
    'giro' => array(
      'table' => 'tgiros',
      'alias' => 'Giro',
      'type' => 'LEFT',
      'conditions' => array(
        'Giro.giro_cve = Empresa.giro_cve'
      ),
      'fields' => array(
        'Giro.giro_nom Empresa__giro'
      )
    ),
    'administrador' => array(
      'table' => 'tcuentausuario',
      'alias' => 'Admin',
      'type' => 'LEFT',
      'conditions' => array(
        'Empresa.cu_cve = Admin.cu_cve'
      ),
      'fields' => array(
        'Admin.cu_cve', 'Admin.cu_sesion', 'Admin.cu_status', 'Admin.per_cve',
        'Admin.keycode', 'Admin.cu_cvesup', 'Admin.created', 'Admin.modified',
      ),
    ),
    'administrador_contacto' => array(
      'table' => 'tcontacto',
      'alias' => 'AdminContacto',
      'type' => 'LEFT',
      'conditions' => array(
        'Empresa.cu_cve = AdminContacto.cu_cve'
      ),
      'fields' => array(
        'AdminContacto.cu_cve', 'AdminContacto.con_nombre', 'AdminContacto.con_paterno', 'AdminContacto.con_materno',
        'AdminContacto.con_ubicacion', 'AdminContacto.con_tel', 'AdminContacto.con_ext'
      ),
    ),
    'ejecutivo' => array(
      'table' => 'tcuentausuario',
      'alias' => 'Ejecutivo',
      'type' => 'LEFT',
      'conditions' => array(
        'Ejecutivo.cu_cve = Admin.cu_cvesup'
      ),
      'fields' => array(
        'Ejecutivo.cu_cve', 'Ejecutivo.cu_sesion', 'Ejecutivo.cu_status', 'Ejecutivo.per_cve',
        'Ejecutivo.keycode', 'Ejecutivo.cu_cvesup', 'Ejecutivo.created', 'Ejecutivo.modified',
      ),
    ),
    'ejecutivo_contacto' => array(
      'table' => 'tcontacto',
      'alias' => 'EjecutivoContacto',
      'type' => 'LEFT',
      'conditions' => array(
        'EjecutivoContacto.cu_cve = Admin.cu_cvesup'
      ),
      'fields' => array(
        'EjecutivoContacto.cu_cve', 'EjecutivoContacto.con_nombre', 'EjecutivoContacto.con_paterno', 'EjecutivoContacto.con_materno',
        'EjecutivoContacto.con_ubicacion', 'EjecutivoContacto.con_tel', 'EjecutivoContacto.con_ext'
      ),
    ),
    'convenio' => array(
      'table' => 'tconvenios',
      'fields' => array(
        'Convenio.convenio_status Empresa__convenio_status'
      ),
      'type' => 'LEFT',
      'alias' => 'Convenio',
      'conditions' => array(
        "Empresa.cia_cve = Convenio.cia_cve"
      )
    ),
    'membresia' => array(
      'alias' => 'Membresia',
      'type' => 'LEFT'
    )
  );

  /**
   * Condiciones que validarán la información de contacto.
   * @var array
   */
  public $validate = array(
    'cia_rfc' => array(
      'validateRFC' => array(
        'rule' => 'alphaNumeric',
        'allowEmpty' => false,
        'required' => true,
        'message' => 'El RFC de la empresa debe contener letras y números.'
      ),
      'uniqueRFC' => array(
        'rule' => 'isUnique',
        'message' => 'Ya existe una empresa registrada con este RFC.'
      ),
      'minAndMaxLength' => array(
        'rule' => array('between', 12, 13),
        'message' => 'El RFC debe ser de 13 caracteres.'
      )
    ),
    'cia_nombre' => array(
      'required' => array(
        'rule' => 'notEmpty',
        'required' => true,
        'message' => 'Por favor ingresa el nombre de tu empresa.'
      ),
      'unique' => array(
        'rule' => 'isUnique',
        'message' => 'Ya existe una empresa registrada con este nombre.'
      ),
      'maxlength' => array(
        'rule' => array('maxLength', 100),
        'message' => 'El nombre de la compañia no debe superar los 100 caracteres.'
      )
    )
  );

  protected function _findAdmin($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['contain'] = array(
        'Administrador' => array(
          'fields' => array(
            'Administrador.cu_cve', 'Administrador.cu_sesion', 'Administrador.cu_status', 'Administrador.per_cve',
            'Administrador.keycode', 'Administrador.cu_cvesup', 'Administrador.created', 'Administrador.modified',
          )
        ),
        'Contacto' => array(
          'fields' => array('cu_cve', 'Contacto.con_nombre || \' \' || Contacto.con_paterno as nombre')
        )
      );
      if (!isset($query['order'])) {
        $query['order'] = array(
          'Empresa.cia_cve' => 'asc',
          'Empresa.cia_nombre' => 'asc'
        );
      }

      $query['recursive'] = -1;
      return $query;
    } elseif ($state === 'after') {

    }
    return $results;
  }

  protected function _findBasic_info($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['joins'] = array(
        $this->joins['giro'],
        $this->joins['administrador'],
        $this->joins['administrador_contacto'],
        $this->joins['ejecutivo'],
        $this->joins['ejecutivo_contacto'],
        $this->joins['producto'],
        $this->joins['convenio'],
      );

      $query['conditions'] = !empty($query['conditions']) ? $query['conditions'] : array();

      if (!empty($query['type'])) {
        $type = $query['type'];

        $query['conditions']["$this->alias.cia_tipo"] = $this->type[$type];

        $query['joins'][] = array(
          'table' => 'tdatoscompania',
          'fields' => array(
            'Datos.calle', 'Datos.num_int', 'Datos.num_ext', 'Datos.cia_web Datos__web', 'Datos.cia_tel telefono'
          ),
          'type' => 'INNER',
          'alias' => 'Datos',
          'conditions' => array(
            "$this->alias.cia_cve = Datos.cia_cve",
            'Datos.tipodom_cve' => 0
          )
        );
      }

      $query['recursive'] = -1;

      return $query;
    }

    return $results;
  }

  /**
   * Busca los datos de la Empresa: Empresa, DatosEmpresa, Administrador, Contacto
   * @param  [type] $state   [description]
   * @param  [type] $query   [description]
   * @param  array  $results [description]
   * @return [type]          [description]
   */
  protected function _findData($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['contain'] = array(
        'DatosEmpresa'
      );


      if (!isset($query['order'])) {
        $query['order'] = array(
          'Empresa.cia_cve' => 'asc',
          'Empresa.cia_nombre' => 'asc'
        );
      }

      $query['recursive'] = -1;
    }

    return $this->_findBasic_info($state, $query, $results);
  }

  /**
   * [_findData description]
   * @param  [type] $state   [description]
   * @param  [type] $query   [description]
   * @param  array  $results [description]
   * @return [type]          [description]
   */
  protected function _findFacturas($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['joins'] = array(
        array(
          'table' => 'tgiros',
          'alias' => 'Giro',
          'type' => 'LEFT',
          'conditions' => array(
            $this->alias . '.giro_cve = Giro.giro_cve',
          ),
          'fields' => array(
            'Giro.giro_nom ' . $this->alias . '__giro_nombre'
          )
        )
      );

      $facturaConditions = array();
      if (!empty($query['factura'])) {
        $facturaConditions['Facturas.factura_folio'] = $query['factura'];
      }

      if (empty($query['promos'])) {
        $facturaConditions['Facturas.factura_folio NOT LIKE'] = '%PROMO';
      }


      $query['contain'] = array(
        'Facturas' => array(
          'conditions' => $facturaConditions,
          'FacturaDetalles'
        )
      );
      if (!isset($query['order'])) {
        $query['order'] = array(
          'Empresa.cia_cve' => 'ASC',
          'Empresa.cia_nombre' => 'ASC'
        );
      }

      $query['recursive'] = -1;
      return $query;
    } elseif ($state === 'after') {

    }

    return $results;
  }

  public function changeSuper($userId, $empresaId = null) {
    if (!$empresaId) {
      $empresaId = $this->id;
    }

    $admin = $this->getAdmin($empresaId);

    return $this->UsuarioEmpresa->updateAll(array(
      'cu_cvesup' => $userId
    ), array(
      'cu_cve' => $admin['Administrador']['cu_cve']
    ));
  }

  public function getAdmin($empresaId = null) {
    return $this->get($empresaId, 'admin', array(
      'first' => true
    ));
  }

  public function isAdmin($userId, $empresaId = null) {
    return $this->hasAny(array(
      'Empresa.cia_cve' => $empresaId,
      'Empresa.cu_cve' => $userId
    ));
  }

  public function isUser($userId, $empresaId = null) {
    return ClassRegistry::init('EmpresasUsuarios')->hasAny(array(
      'cia_cve' => $empresaId,
      'cu_cve' => $userId
    ));
  }

  public function afterFind($results, $primary = false) {
    foreach ($results as $key => $value) {
      if (!empty($value[$this->alias]['cia_cve'])) {
        $results[$key][$this->alias]['logo'] = $this->getLogoPath($value[$this->alias]['cia_cve']);
      }

      if (isset($value[$this->alias]['convenio_status'])) {
        $status = $value[$this->alias]['convenio_status'];
        $status = current(Hash::extract($this->Convenio->status, "{s}[val=$status]"));
        $results[$key][$this->alias]['convenio_status_text'] = isset($status['text']) ? $status['text'] : '';
      }
    }

    return $results;
  }

  public function beforeSave($options = array()) {
    if(isset($this->data[$this->alias]['cia_rfc'])) {
      $this->data[$this->alias]['cia_rfc'] = strtoupper($this->data[$this->alias]['cia_rfc']);
    }

    if(isset($this->data[$this->alias]['giro_cve'])) {
      // $this->data[$this->alias]['cia_rfc'] = strtoupper($this->data[$this->alias]['cia_rfc']);
    }

    return parent::beforeSave($options);
  }

  public function afterSave($created, $options = array()) {
    if ($created) {

      /**
       * PROMOCION
       */
      $this->Ticket->create();
      $this->Ticket->save(array(
        'hash' => 'PROMO_CIA_' . $this->id,
        'info' => $this->id,
        'fec_exp' => $this->Ticket->getExpirationDate(180),
      ));

      /**
       * PROMOCIÓN
       */
    }
  }

  public function getByUserId($id, $onlyData = false) {
    $results = $this->find('first', array(
      'recursive' => -1,
      'joins' => array(
        array(
          'table' => 'tusuxcia',
          'alias' => 'EmpresasUsuarios',
          'type' => 'INNER',
          'conditions' => array(
            'EmpresasUsuarios.cu_cve = ' . $id,
            'EmpresasUsuarios.cia_cve = Empresa.cia_cve'
          )
        ),
        array(
          'table' => 'tdatoscompania',
          'alias' => 'DatosEmpresa',
          'type' => 'LEFT',
          'conditions' => array(
            'DatosEmpresa.cia_cve = Empresa.cia_cve',
            'DatosEmpresa.tipodom_cve' => 0
          ),
          'fields' => array(
            'DatosEmpresa.cia_tel Empresa__cia_tel',
            'DatosEmpresa.cia_web Empresa__cia_web',
          )
        ),
        array(
          'table' => 'tgiros',
          'alias' => 'Giro',
          'type' => 'LEFT',
          'conditions' => array(
            $this->alias . '.giro_cve = Giro.giro_cve',
          ),
          'fields' => array(
            'Giro.giro_nom ' . $this->alias . '__giro_nombre'
          )
        )
      )
    ));

    $results['Empresa']['logo'] = $this->getLogoPath($results['Empresa']['cia_cve']);

    return $onlyData ? $results['Empresa'] : $results;
  }

  public function getUsuarios($empresaId, $format = 'complete') {
    $conditions = array(
      'recursive' => -1,
      'joins' => array(
        array(
          'table' => 'tusuxcia',
          'alias' => 'EmpresasUsuarios',
          'type' => 'INNER',
          'conditions' => array(
            'EmpresasUsuarios.cia_cve = ' . $empresaId,
            'EmpresasUsuarios.cu_cve = UsuarioEmpresa.cu_cve'
          )
        )
      )
    );

    $results = $this->UsuarioEmpresa->find('all', $conditions);

    if ($format === 'complete') {
      return $results;
    } elseif ($format === 'ids') {
      return Hash::extract($results, '{n}.UsuarioEmpresa.cu_cve');
    } elseif ($format === 'list') {
      return Hash::combine($results, '{n}.UsuarioEmpresa.cu_cve', '{n}.UsuarioEmpresa.cu_sesion');
    }
  }

  public function inactivarUsuarios($empresaId = null, $status = 0) {
    $usuarios = $this->getUsuarios($empresaId, 'ids');

    return $this->UsuarioEmpresa->updateAll(array(
      $this->UsuarioEmpresa->statusKey => $status
    ), array(
      $this->UsuarioEmpresa->primaryKey => $usuarios
    ));
  }

  public function getLast($limit = 5) {
    return $this->find('data', array(
      'limit' => $limit,
      'order' => array(
        'Empresa.created' => 'DESC'
      )
    ));
  }

  public function editar($data, $id = null) {
    if (isset($id)) {
      $this->id = $id;
      $data[$this->alias][$this->primaryKey] = $id;
    }

    //$formatedData = array();

    /*$formatedData['Empresa'] = $data['Empresa'];
    $formatedData['DatosEmpresa'] = array(
      'cp_cve' => $data['Empresa']['colonia'],
      'cia_tel' => $data['Empresa']['cia_tel']
    );*/

    return $this->saveAll($data, $options);
  }

  /**
   * Registra una nueva empresa en nuestro empleo.
   * @param  array    $data    Datos de la empresa.
   * @param  int      $userId  Id del usuario administrador.
   * @param  array    $options Opciones
   * @return boolean           Retorna true si la compañia se guardo con éxito.
   */
  public function registrar($data, $userId, $options = array()) {
    /**
      * Reinicia los valores por default de Empresa y limpia el id.
      */
    $this->create();
    $data['Empresa']['cia_razonsoc'] = $data['Empresa']['cia_nombre'];

    /**
     * Por ahora, todas las empresas que se registren van a ser convenios.
     * HASTA 2015
     */
    if ((int)date('Y') === 2014) {
      $data['Empresa']['cia_tipo'] = 1;
    }
    /**
     * Por ahora, todas las empresas que se registren van a ser convenios.
     * HASTA 2015
     */

    $formatedData = array(
      'Empresa' => $data['Empresa'],
      'DatosEmpresa' => array(
        array(
          'tipodom_cve' => 0,
          'cp_cve' => $data['Empresa']['colonia'],
          'cia_tel' => $data['Empresa']['cia_tel']
        ),
      )
    );

    /**
     * Si se pasa el id del usuario, lo agrega como usuario de esa compañia en UsuariosEmpresas, y
     * también lo agrega como administrador de esa compañia.
     */
    if (isset($userId)) {
      $formatedData['UsuarioEmpresa'] = array(
        array(
          'cu_cve' => $userId,
        )
      );

      $formatedData['Empresa']['cu_cve'] = $userId;
    }

    /**
     * Guardar los datos de la compañia.
     */
    if ($success = $this->saveAll($formatedData, $options)) {
      // Obtiene el id de la compañia.
      $ciaId = $this->getLastInsertID();

      $data['Empresa'][$this->primaryKey] = $ciaId;
      $formatedData = array(
        'FacturacionEmpresa' => $data['Empresa'],
        'DatosFacturacionEmpresa' => array(
          'cia_cve' => $ciaId,
          'tipodom_cve' => 1,
          'cp_cve' => $data['Empresa']['colonia'],
          'cia_tel' => $data['Empresa']['cia_tel']
        )
      );

      /**
       * Aquí se crea el convenio.
       */
      if (!empty($data['Empresa']['cia_tipo']) && (int)$data['Empresa']['cia_tipo'] === $this->type['convenio']) {
        $success = $this->Convenio->save(array(
          'cia_cve' => $ciaId,
          'convenio_status' => 0
        ));
      }

      /**
       * Guarda los datos de facturación de la compañia.
       */
      $success = $success && $this->FacturacionEmpresa->saveAll($formatedData, $options);
    }

    return $success;
  }

  public function changeCiaType($type, $empresaId = null) {
    if ($empresaId) {
      $this->id = $empresaId;
    }

    $typeVal = is_numeric($type) ? $type : (
      isset($this->type[$type]) ? $this->type[$type] : 0 // default comercial.
    );

    $this->begin();
    if ($typeVal === 0) {
      // Se hace a la compañia comercial.
      $success = $this->makeComercial($this->id);

    } elseif ($typeVal === 1) {
      $success = $this->saveField('cia_tipo', 1) &&
        $this->Convenio->save(array(
          $this->Convenio->primaryKey => $this->id,
          'convenio_status' => 0,
          'membresia_cve' => null
        )) && $this->Facturas->deleteFacturas('promos', $empresaId);
    }

    !$success && $this->rollback();
    $success && $this->commit();

    return $success;
  }

  /**
   * Cuando se cambia de convenio a comercial se borra el convenio,
   * créditos y perfiles de la empresa.
   * @var [type]
   */
  public function makeComercial($empresaId = null) {
    if ($empresaId) {
      $this->id = $empresaId;
    }

    $this->begin();
    $success = $this->saveField('cia_tipo', 0) &&
      $this->Convenio->delete($this->id) &&
      $this->Creditos->deleteAll(array( // Borra créditos
        $this->primaryKey => $this->id
      )) && $this->PerfilMembresia->deleteAll(array( // Borra perfil
        $this->primaryKey => $this->id
      ));

    !$success && $this->rollback();
    $success && $this->commit();

    return $success;
  }

  public function getLogoPath($id) {
    App::uses('Usuario', 'Utility');

    return Usuario::getPhotoPath($id, 'empresas');
  }

  public function hasPromo($empresaId = null) {
    if ($empresaId) {
      $this->id = $empresaId;
    }

    return $this->Facturas->hasAny(array(
      'cia_cve' => $this->id,
      'factura_folio LIKE' => '%PROMO'
    ));
  }

  /**
   * Verfica qué es la compañia.
   * Por ahora sólo qué tipo de compañia es.
   * @param  [type]  $type      [description]
   * @param  [type]  $empresaId [description]
   * @return boolean            [description]
   */
  public function is($type, $empresaId = null) {
    if ($empresaId) {
      $this->id = $empresaId;
    }

    if (in_array($type, array_keys($this->type))) {
      return (int)$this->field('cia_tipo') === $this->type[$type];
    }

    return false;
  }

}
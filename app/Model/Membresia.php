<?php

App::uses('AppModel', 'Model');

class Membresia extends AppModel {

  /**
   * Behaviors.
   * @var array
   */
  public $actsAs = array('Containable');


  /**
   * Nombre del Modelo.
   * @var string
   */
  public $name = 'Membresia';

  /**
   * Nombre de la llave primaria.
   * @var string
   */
  public $primaryKey = 'membresia_cve';

  /**
   * Tabla en la BD.
   * @var string
   */
  public $useTable = 'tmembresias';

  public $joins = array(
    'membresias_usadas' => array(
      'fields' => array(
        '(CASE WHEN MembresiasUsadas.membresia_cve IS NULL THEN 0 ELSE 1 END) Membresia__usada'
      ),
      'alias' => 'MembresiasUsadas',
      'table' => '(SELECT DISTINCT(FXM.membresia_cve) FROM tfacturaxmembresias FXM
        INNER JOIN tfacturacion FACT ON (FXM.factura_cve = FACT.factura_cve AND FACT.factura_status = 2))',
      'type' => 'LEFT',
      'conditions' => array(
        'MembresiasUsadas.membresia_cve = Membresia.membresia_cve'
      )
    )
  );

  /**
   * Tipos de búsqueda.
   * @var array
   */
  public $findMethods = array(
    'detalles' => true,
    'recomendaciones' => true
  );

  public $belongsTo = array(
    'Clase' => array(
      'className' => 'Catalogo',
      'foreignKey' => false,
      'conditions' => array(
        'Membresia.membresia_clase = Clase.opcion_valor',
        'Clase.ref_opcgpo = \'MEMBRESIA_CLASE\''
      ),
      'fields' => array(
        'Clase.opcion_texto Membresia__clase_texto',
        'Clase.opcion_sec'
      )
    )
  );

  /**
   * Relación "Tiene muchos".
   * @var array
   */
  public $hasMany = array(
    'Detalle' => array(
      'className' => 'MembresiaDetalle',
      'foreignKey' => 'membresia_cve'
    )
  );

  public $knows = array(
    'Credito',
    'PerfilMembresia',
    'MicroSitio'
  );

  /**
   * Validaciones.
   * @var array
   */
  public $validate = array(
    'membresia_nom' => array(
      'validateNombre' => array(
        'allowEmpty' => false,
        'rule' => 'isUnique',
        'required' => 'create',
        'message' => 'El nombre para la membresía ya existe. Ingresa otro.',
        'on' => 'create',
      )
    ),
    // 'membresia_costo' => array(
    //   'validateCost' => array(
    //     'rule' => array('comparison', '>=', 1),
    //     'allowEmpty' => false,
    //     'required' => 'create',
    //     'message' => 'El costo de la membresía debe ser mayor a 1'
    //   )
    // )
  );

  /**
   * Tipos de créditos como servicios y cuánto créditos se gastan.
   * @var array
   */
  public $services = array(
    'micrositio' => 1
  );

  private $_services = array();

  /**
   * [getEndDate description]
   * @param  integer $days [description]
   * @return [type]        [description]
   */
  public function getEndDate($days = 60) {
    $date = new DateTime('NOW');
    $date->add(new DateInterval('P'. $days . 'D')); //Periodo en dias.
    return $date->format('Y-m-d H:i:s');
  }

  /**
   * Busqueda personalizada de Membresías que incluye sus detalles y el nombre de los servicio que ofrece.
   * @param  string $state    Si la ejecución de la búsqueda es antes (before) o después (after).
   * @param  array  $query    Opciones.
   * @param  array  $results  Resultados.
   * @return mixed            Retorna los resultados.
   */
  protected function _findDetalles($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['joins'] = array(
        $this->joins['membresias_usadas']
      );

      $query['contain'] = array(
        'Clase'
      );
      $query['order'] = array(
        'Clase.opcion_sec' => 'ASC',
        $this->alias . '.' . $this->primaryKey => 'ASC',
      );
      $query['recursive'] = -1;
      return $query;
    } elseif ($state === 'after') {
      $path = implode('.', array('{n}', $this->alias, $this->primaryKey));
      $ids = Hash::extract($results, $path);
      if (empty($ids)) {
        return $results;
      }

      $detalles = $this->Detalle->find('all', array(
        'conditions' => array(
          $this->Detalle->alias . '.' . $this->primaryKey => $ids
        ),
        'contain' => array('Servicio'),
        'order' => array(
          $this->Detalle->alias . '.' . $this->primaryKey,
          $this->Detalle->alias . '.' . $this->Detalle->primaryKey,
        ),
        'recursive' => -1
      ));

      if (!empty($detalles)) {
        $detalles = Hash::combine($detalles, '{n}.Detalle.paquete_cve', '{n}', '{n}.Detalle.membresia_cve');
        for ($index = 0; $index < count($results); $index++) {
          $i = $results[$index][$this->alias]['membresia_cve'];
          $results[$index][$this->alias]['Detalles'] = !empty($detalles[$i]) ? $detalles[$i] : array();
        }
      }
    }
    $combine = isset($query['combine']) ? '{n}.Membresia.clase_texto' : null;

    return Hash::combine($results, '{n}.Membresia.membresia_nom', '{n}.Membresia', $combine); //$results;
  }

  protected function _findRecomendaciones($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['conditions'] = array(
        $this->alias . '.' . $this->primaryKey . ' NOT IN (SELECT
          DISTINCT(membresia_cve)
          FROM tfacturaxmembresias
          WHERE factura_cve IN (
            SELECT factura_cve
            FROM tfacturacion
            WHERE cia_cve IN (' . implode(',', (array)$query['cia']) . ')
          ))',
        $this->alias . '.membresia_tipo' => 'N',
        $this->alias . '.membresia_status' => 1
      );
    }

    return $this->_findDetalles($state, $query, $results);
  }

  /**
   * [lista description]
   * @return [type] [description]
   */
  public function lista() {
    $results = $this->find('list', array(
      'fields' => array(
        'Membresia.membresia_cve', 'Membresia.membresia_nom'
      ),
      'order' => array('Membresia.membresia_cve'),
      'recursive' => -1
    ));

    return $results;
  }

  public function verifyCost ($detalles) {
    $total = 0;
    foreach ($detalles as $value) {
      $total += $value['credito_num'] * $value['servicio_precio'];
    }

    return $total;
  }

  /**
   * Borra un servicio de los detalles de la membresía.
   * @param  [type] $membresiaId [description]
   * @param  [type] $servicioId  [description]
   * @return [type]              [description]
   */
  public function borrar_servicio($membresiaId, $servicioId) {
    if (!$this->exists($membresiaId)) {
      return false;
    }

    return $this->Detalle->deleteAll(array(
      'AND' => array(
        'Detalle.membresia_cve' => $membresiaId,
        'Detalle.paquete_cve' => $servicioId
      )
    ));
  }

  public function assign($membresiaId, $empresaId, $userId, $facturaId, $options = false) {
    $data = array(); // Array dónde se guardan los créditos.
    $returnValue = false; // Valor a retornar.

    // Indica que se van a insertar nuevos registros.
    $this->Credito->create();
    $this->PerfilMembresia->create();

    $cant = is_array($options) && !empty($options['cant']) ?
      (int)$options['cant'] : 1;

    // Obtiene los detalles de la membresía.
    $detalles = $this->get($membresiaId, 'detalles');
    $detalles = current($detalles);

    /**
     * Si $detalles es array, entonces se pasan los detalles de la membresia
     * para asignarlos.
     */
    if (is_array($detalles) && isset($detalles['Detalles'])) {
      // Fecha de termino de los créditos
      $endDate = $this->getEndDate($detalles['vigencia']);

      /**
       * Itera en los detalles para generar el array de créditos a insertar.
       */
      foreach ($detalles['Detalles'] as $d) {
        $numCredits = (int)$d['Detalle']['credito_num'];

        if (($c = $this->inspectService($d)) > 0) {
          $numCredits -= $c;
        }

        $credito = array(
          'cia_cve' => $empresaId,
          'cu_cve' => $userId,
          'servicio_cve' => $d['Detalle']['servicio_cve'],
          'cred_disponibles' => $numCredits * $cant,
          'fec_fin' => $endDate
        );
        $data[] = $credito;
      }

      /**
       * Datos del perfil para la membresía.
       * @var array
       */
      $perfilMembresia = array(
        'membresia_cve' => $membresiaId,
        'per_cve' => $detalles['per_cve'],
        'cia_cve' => $empresaId,
        'fec_ini' => date('Y-m-d H:i:s'),
        'fec_fin' => $endDate,
        'factura_cve' => $facturaId
      );

      if ($options === true || (is_array($options) && !empty($options['save']))) {
        // Transacción.
        $this->begin();

        /**
         * Intenta guardar en una misma transacción el perfil para la membresía y
         * los créditos.
         * @var [type]
         */
        $successSave = $this->PerfilMembresia->save($perfilMembresia) &&
          $this->Credito->saveMany($data) &&
          $this->processServices($empresaId);

        // Commit si los datos se guardaron exitosamente o Rollback si ocurre lo contrario.
        if ($successSave) {
          $this->commit();
        } else {
          $this->rollback();
        }
        $returnValue = $successSave;
      } else {
        $returnValue = $data;
      }
    }

    return $returnValue;
  }

  /**
   * Función se ejecuta antes de que se guarde una membresía.
   * @param  array    $options [description]
   * @return boolean           [description]
   */
  public function beforeSave($options = array()) {

    return parent::beforeSave($options);
  }

  /**
   * Verifica que tipo de créditos se tomarán como servicios.
   * @param  [type] $credito [description]
   * @return [type]          [description]
   */
  public function inspectService($credito) {
    $type = $credito['Servicio']['identificador'];

    if (isset($this->services[$type]) && ($c = $this->services[$type]) > 0) {
      $this->_services[$type] = $c;
    }

    return !empty($c) ? $c : 0;
  }

  /**
   * Los créditos que se procesan como servicios.
   * @param  [type] $empresaId [description]
   * @return [type]            [description]
   */
  public function processServices($empresaId) {
    $success = true;

    if (empty($this->_services)) {
      return true;
    }

    if (!empty($this->_services['micrositio'])) {
      $success = $success && $this->MicroSitio->saveOrUpdate($empresaId);
    }

    return $success;
  }

  /**
   * Edición de Membresía.
   * @param  [type] $data [description]
   * @param  [type] $id   [description]
   * @return [type]       [description]
   */
  public function editar($data, $id = null) {
    $success = false;
    if (!$id) {
      $id = $this->id;
    }

    $data[$this->alias][$this->primaryKey] = $id;

    // Transacción
    $this->begin();

    // Borramos los detalles de la membresía primero.
    if ($this->Detalle->deleteAll(array(
      'Detalle.membresia_cve' => $id
    ))) {
      $this->id = $id;

      // Actualizamos.
      $success = $this->saveAll($data);
      $success && $this->commit();
    }

    !$success && $this->rollback();

    return $success;
  }
}
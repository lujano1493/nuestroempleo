<?php

App::uses('AppModel', 'Model');

class FacturacionEmpresa extends AppModel {
  /**
   *
   */
  public $actsAs = array('Containable');

  /**
   * [$name description]
   * @var string
   */
  public $name = 'FacturacionEmpresa';

  /**
   * [$primaryKey description]
   * @var string
   */
  public $primaryKey = 'cia_rfc';

  /**
   * [$useTable description]
   * @var string
   */
  public $useTable = 'tfactcompania';

  /**
    * Métodos de búsqueda personalizados.
    */
  public $findMethods = array('datos_facturacion' => true);

  /**
   * [$belongsTo description]
   * @var array
   */
  public $belongsTo = array(
    'Empresa' => array(
      'className' => 'Empresa',
      'foreignKey' => 'cia_cve'
    ),
    'DatosFacturacionEmpresa' => array(
      'className' => 'DatosEmpresa',
      'foreignKey' => 'datos_cve',
    )
  );

  protected $_joins = array(
    'datos' => array(
      array(
        'alias' => 'Datos',
        'conditions' => array(
          'Datos.datos_cve = FacturacionEmpresa.datos_cve'
        ),
        'fields' => array(
          'Datos.calle Direccion__calle',
          'Datos.cia_tel Direccion__tel',
        ),
        'table' => 'tdatoscompania',
      )
    ),
    'giro' => array(
      array(
        'table' => 'tgiros',
        'alias' => 'Giro',
        'type' => 'LEFT',
        'fields' => array(
          'Giro.giro_nom FacturacionEmpresa__giro'
        ),
        'conditions' => array(
          'Giro.giro_cve = FacturacionEmpresa.giro_cve'
        )
      )
    ),
    'direccion' => array(
      array(
        'alias' => 'CP',
        'conditions' => array(
          'Datos.cp_cve = CP.cp_cve'
        ),
        'fields' => array('CP.cp_cp Direccion__cp', 'CP.cp_asentamiento Direccion__colonia'),
        'table' => 'tcodigopostal',
        'type' => 'LEFT',
      ),
      array(
        'alias' => 'Ciudad',
        'conditions' => array(
          'Ciudad.ciudad_cve = CP.ciudad_cve'
        ),
        'fields' => array('Ciudad.ciudad_nom Direccion__ciudad'),
        'table' => 'tciudad',
        'type' => 'LEFT',
      ),
      array(
        'alias' => 'Estado',
        'conditions' => array(
          'Estado.est_cve = CP.est_cve'
        ),
        'fields' => array('Estado.est_nom Direccion__estado'),
        'table' => 'testado',
        'type' => 'LEFT',
      ),
      array(
        'alias' => 'Pais',
        'conditions' => array(
          'Pais.pais_cve = CP.pais_cve'
        ),
        'fields' => array('Pais.pais_nom Direccion__pais'),
        'table' => 'tpais',
        'type' => 'LEFT',
      )
    )
  );

  /**
   * Actualiza o crea nuevos datos de facturación para la empresa.
   * Si $verify es true, verificará si existen los datos.
   * @param  [type]  $empresaId [description]
   * @param  [type]  $data      [description]
   * @param  boolean $verify    [description]
   * @return [type]             [description]
   */
  public function createOrUpdate($empresaId, $data, $verify = false) {
    $rfc = $data[$this->alias][$this->primaryKey];

    $datoFacturacion = $this->find('first', array(
      'conditions' => array(
        $this->alias . '.cia_rfc' => $rfc
      ),
      'recursive' => -1
    ));

    if (!$this->validateRFC($rfc)) {
      return $this->error(__('El RFC proporcionado no está bien formado.'));
    } elseif (!empty($datoFacturacion)) {
      if ($datoFacturacion[$this->alias]['cia_cve'] != $empresaId) {
        return $this->error(__('Parece que este RFC pertenece a otra compañia.')); // Existe el RFC pero es de otra compañia....
      } else {
        // Actualizar...
      }
    } else {
      // No existe, por lo tanto se va a crear un nuevo RFC.
      unset($data['DatosFacturacionEmpresa']['datos_cve']);
    }

    $data[$this->alias]['cia_cve'] = $data['DatosFacturacionEmpresa']['cia_cve'] = $empresaId;
    $data['DatosFacturacionEmpresa']['tipodom_cve'] = 1;

    return $this->saveAll($data);
  }

  public function beforeSave($options = array()) {
    if(isset($this->data[$this->alias]['cia_rfc'])) {
      $this->data[$this->alias]['cia_rfc'] = strtoupper($this->data[$this->alias]['cia_rfc']);
    }

    return parent::beforeSave($options);
  }

  protected function _findDatos_facturacion($state, $query, $results = array()) {
    if ($state == 'before') {
      $first = isset($query['first']);

      if (isset($query['empresa'])) {
        $query['conditions'][] = //array(
          $this->alias . '.cia_cve = ' . $query['empresa'];
        //);
      }

      $query['contain'] = array(
        'DatosFacturacionEmpresa'
      );

      $query['joins'] = array_merge($this->_joins['datos'], $this->_joins['direccion']);

      $query['order'] = array(
        $this->alias . '.created' => $first ? 'ASC' : 'DESC'
      );

      if (!isset($query['all'])) {
        $query['limit'] = 1;
      }

      $query['recursive'] = -1;
      return $query;
    }

    if (!isset($query['all'])) {
      return $results[0];
    }

    return !isset($query['combine']) ? $results : Hash::combine($results,
      '{n}.FacturacionEmpresa.cia_rfc', array(
      '%s - %s', '{n}.FacturacionEmpresa.cia_rfc', '{n}.FacturacionEmpresa.cia_razonsoc'
    ));
  }

  public function validateRFC($rfc) {
    $validateRFC = "/^(([A-ZÑ&]{3,4})([0-9]{2})([0][13578]|[1][02])(([0][1-9]|[12][\d])|[3][01])([A-Z0-9]{3}))"
    . "|(([A-ZÑ&]{3,4})([0-9]{2})([0][13456789]|[1][012])(([0][1-9]|[12][\d])|[3][0])([A-Z0-9]{3}))"
    . "|(([A-ZÑ&]{3,4})([02468][048]|[13579][26])[0][2]([0][1-9]|[12][\d])([A-Z0-9]{3}))"
    . "|(([A-ZÑ&]{3,4})([0-9]{2})[0][2]([01][1-9]|[2][0-8])([A-Z0-9]{3}))$/";

    return (bool)preg_match($validateRFC, $rfc);
  }
}
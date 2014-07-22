<?php

App::uses('AppModel', 'Model');

class MembresiaDetalle extends AppModel {

  public $actsAs = array('Containable');

  public $name = 'MembresiaDetalle';

  /**
    * Nombre de la llave primaria, en este caso es cia_cve, tabla tcompania.
    */
  public $primaryKey = 'paquete_cve';


  public $useTable = 'tdetallemembresia';

  public $belongsTo = array(
    'Membresia' => array(
      'className' => 'Membresia',
      'foreignKey' => 'membresia_cve'
    ),
    'Servicio' => array(
      'className' => 'Servicio',
      'foreignKey' => 'servicio_cve'
    )
  );

  public function afterFind($results, $primary = false) {
    if ($primary) {
      foreach ($results as $key => $value) {
        $results[$key][$this->alias]['creditos_infinitos'] = isset($value[$this->alias]['credito_num']) && $value[$this->alias]['credito_num'] < 0;
      }
    }

    return $results;
  }

  /**
    * Función se ejecuta antes de que se guarde una factura.
    */
  public function beforeSave($options = array()) {

    return parent::beforeSave($options);
  }
}
<?php

App::uses('AppModel', 'Model');

class Servicio extends AppModel {
  public $name = 'Servicio';

  public $useTable = 'tservicios';

  public $primaryKey = "servicio_cve";

  public $hasMany = array(
    'MembresiaDetalle' => array(
      'className' => 'MembresiaDetalle',
      'foreignKey' => 'servicio_cve'
    )
  );

  public $validate = array(
    'servicio_nom' => array(
      'validateNombre' => array(
        'allowEmpty' => false,
        'message' => 'Ingresa el nombre del puesto.',
        'required' => true,
        'rule' => 'notEmpty'
      )
    )
  );

  public function lista($query = null) {
    $conditions = array();

    if (!empty($query)) {
      $conditions['Servicio.servicio_nom LIKE'] = '%' . $query . '%';
    }

    $results = $this->find('all', array(
      'fields' => array('Servicio.servicio_cve', 'Servicio.servicio_nom', 'Servicio.servicio_precio'),
      'conditions' => $conditions,
      'limit' => 20,
      'recursive' => -1
    ));
    $results = Hash::extract($results, '{n}.Servicio');
    return $results;
  }
}
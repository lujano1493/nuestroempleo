<?php

class FacturaDetalle extends AppModel {

  /**
   * [$name description]
   * @var string
   */
  public $name = 'FacturaDetalle';

  /**
   * [$primaryKey description]
   * @var string
   */
  public $primaryKey = 'factura_id';

  /**
   * [$useTable description]
   * @var string
   */
  public $useTable = 'tfacturaxmembresias';

  /**
   * [$belongsTo description]
   * @var array
   */
  public $belongsTo = array(
    'Factura' => array(
      'className' => 'Factura',
      'foreignKey' => 'factura_cve'
    ),
    'Membresia' => array(
      'className' => 'Membresia',
      'foreignKey' => 'membresia_cve'
    )
  );

}
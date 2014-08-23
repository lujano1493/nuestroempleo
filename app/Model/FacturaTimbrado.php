<?php

App::uses('CakeEvent', 'Event');
App::uses('ProductosListener', 'Event');

class FacturaTimbrado extends AppModel {
  /**
   * [$actsAs description]
   * @var array
   */
  public $actsAs = array('Containable', 'Clob');

  /**
   * [$name description]
   * @var string
   */
  public $name = 'FacturaTimbrado';

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
  public $useTable = 'ttimbrado';

  /**
   * [$belongsTo description]
   * @var array
   */
  public $belongsTo = array(
    'Factura' => array(
      'className' => 'Factura',
      // 'fields' => array('Empresa.cia_cve', 'Empresa.cia_nombre'),
      'foreignKey' => 'factura_cve',
    )
  );
}
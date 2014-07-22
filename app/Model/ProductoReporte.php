<?php

App::uses('Reporte', 'Model');

class ProductoReporte extends Reporte {
  /**
   * tabla
   * @var string
   */
  public $useTable = 'tfacturaxmembresias';

  public $actsAs = array('Containable');

  public $primaryKey = 'factura_id';

  public $findMethods = array(
    'productos_adquiridos' => true,
  );

  // protected function settingDates($dates) {
  //   $conditions = array();

  //   if (!empty($dates)) {
  //     $conditions['oferta_fecini >='] = date('Y-m-d H:i:s', $dates['ini']);
  //     $conditions['oferta_fecini <='] = date('Y-m-d H:i:s', $dates['end']);
  //   }

  //   return $conditions;
  // }

  protected function _findProductos_adquiridos($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['fields'] = array(
        // 'Membresia.membresia_cve ProductoReporte__id',
        // 'Membresia.membresia_nom ProductoReporte__membresia',
        'COUNT(Membresia.membresia_cve) ProductoReporte__total',
      );

      $query['joins'] = array(
        array(
          'alias' => 'Membresia',
          'conditions' => array(
            'Membresia.membresia_cve = ProductoReporte.membresia_cve',
            'Membresia.membresia_status' => 1
          ),
          'fields' => array(
            'Membresia.membresia_cve ProductoReporte__id',
            'Membresia.membresia_nom ProductoReporte__membresia',
          ),
          'table' => 'tmembresias',
          'type' => 'LEFT',
        ),
      );

      $query['group'] = array(
        'Membresia.membresia_cve',
        'Membresia.membresia_nom'
      );

      $query['order'] = array(
        'ProductoReporte__id' => 'ASC',
      );

      $query['recursive'] = -1;
      return $query;
    }

    return $results;
  }
}
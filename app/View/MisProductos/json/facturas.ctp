<?php
  $results = array();

  foreach ($facturas['Facturas'] as $key => $v) {
    // $r = $v['Factura'];
    $d = $v['FacturaDetalles'];
    $detalles = array();

    foreach ($d as $key => $value) {
      $detalles[] = array(
        'cant' => (int)$value['cantidad'],
        'producto' => $value['Membresia']['nombre'],
        'costo' => (int)$value['Membresia']['costo'],
        'vigencia' => (int)$value['Membresia']['vigencia']
      );
    }

    $results[] = array(
      'id' => (int)$v['factura_cve'],
      'folio' => $v['factura_folio'],
      'total' => array(
        'val' => (float)$v['factura_total'],
        'str' => $this->Number->currency($v['factura_total'])
      ),
      'status' => array(
        'val' => (int)$v['factura_status'],
        'str' => $v['status_str'],
      ),
      'detalles' => $detalles,
      'fecha_creacion' => array(
        'val' => $v['created'],
        'str' => $this->Time->d($v['created'])
      ),
    );
  }

  $this->_results = $results;
?>
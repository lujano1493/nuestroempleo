<?php
  $results = array();

  foreach ($facturas as $k => $v) {
    $r = $v['Factura'];
    $e = $v['Empresa'];
    $f = $v['FacturacionEmpresa'];
    $a = $v['Administrador'];

    $rec = array(
      'id' => (int)$r['factura_cve'],
      'folio' => $r['factura_folio'],
      'empresa' => array(
        'id' => (int)$e['cia_cve'],
        'nombre' => $e['cia_nombre'],
        'admin' => array(
          'email' => $a['cu_sesion'],
        )
      ),
      'facturacion' => array(
        'empresa' => $f['cia_nombre'],
        'rfc' => $f['cia_rfc'],
        'razon_social' => $f['cia_razonsoc'],
        'giro' => $f['giro'],
      ),
      'total' => array(
        'value' => (float)$r['factura_total'],
        'text' => $this->Number->currency($r['factura_total']),
      ),
      'fecha_alta' => array(
        'val' => $r['created'],
        'str' => $this->Time->dt($r['created'])
      ),
    );

    $results[] = $rec;
  }

  $this->_results = $results;
?>
<?php
  $results = array();

  foreach ($facturas as $k => $v) {
    $r = $v['Factura'];
    $e = $v['Empresa'];
    $f = $v['FacturacionEmpresa'];
    $a = $v['Administrador'];
    $ac = $v['AdministradorContacto'];
    $t = $v['Timbrado'];

    $rec = array(
      'id' => (int)$r['factura_cve'],
      'folio' => $r['factura_folio'],
      'empresa' => array(
        'id' => (int)$e['cia_cve'],
        'nombre' => $e['cia_nombre'],
        'slug' => Inflector::slug($e['cia_nombre'], '-') . '-' . (int)$e['cia_cve'],
        'admin' => array(
          'email' => $a['cu_sesion'],
          'nombre' => $ac['con_nombre'] . ' ' . $ac['con_paterno']
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
      'fecha_creacion' => array(
        'val' => $r['created'],
        'str' => $this->Time->dt($r['created'])
      ),
      'status' => array(
        'val' => (int)$r['factura_status'],
        'str' => $r['status_str'],
      ),
      'is_promo' => $r['is_promo']
    );

    if (!empty($t['created'])) {
      $rec['datos_timbrado'] = array(
        'uuid' => $t['uuid'],
        'url_pdf' => $t['url_pdf'],
        'url_xml' => $t['url_xml'],
      );

      $rec['fecha_timbrado'] = array(
        'val' => $t['created'],
        'str' => $this->Time->dt($t['created'])
      );
    }

    $results[] = $rec;
  }

  $this->_results = $results;
?>
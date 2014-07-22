<?php
  $this->set('noValidationErrors', true);

  $facturas = array();
  $empresaId = $empresa['Empresa']['cia_cve'];
  foreach ($empresa['Facturas'] as $_v => $v) {
    $r = array(
      'id' => (int)$v['factura_cve'],
      'rfc' => $v['cia_rfc'],
      'razon_soc' => $v['FacturacionEmpresa']['cia_razonsoc'],
      'folio' => $v['factura_folio'],
      'empresa' => $empresaId,
      'total' => array(
        'value' => (float)$v['factura_total'],
        'text' => $this->Number->currency($v['factura_total'])
      ),
      'created' => $this->Time->dt($v['created']),
      'status' => (int)$v['factura_status'],
    );

    $detalles = array();

    foreach ($v['FacturaDetalles'] as $_d => $d) {
      $cant = (int)$d['cantidad'];
      $costo = (float)$d['Membresia']['costo'];

      $detalles[] = array(
        'nombre' => $d['Membresia']['nombre'],
        'desc' => $d['Membresia']['desc'],
        'costo' => array(
          'value' => $costo,
          'text' => $this->Number->currency($costo),
        ),
        'vigencia' => __('%s días.', $d['Membresia']['vigencia']),
        'cant' => $cant,
        'subtotal' => array(
          'value' => $cant * $costo,
          'text' => $this->Number->currency($cant * $costo)
        ),
        'css_class' => $d['Membresia']['css_class']
      );
    }

    $r['detalles'] = $detalles;
    $facturas[] = $r;
  }

  $empr = array(
    'id' => $empresaId,
    'nombre' => $empresa['Empresa']['cia_nombre'],
    'razon_soc' => $empresa['Empresa']['cia_razonsoc'],
    'giro' => $empresa['Empresa']['giro_cve'],
    'rfc' => $empresa['Empresa']['cia_rfc'],
    'reg_desde' => $this->Time->dt($empresa['Empresa']['created']),
  );

  $this->_results = array(
    'empresa' => $empr,
    'facturas' => $facturas
  );
?>
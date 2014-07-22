<?php
  $this->set('noValidationErrors', true);

  $e = $facturas['Empresa'];
  $results = array('empresa'=> array(
    'nombre' => $e['cia_nombre'],
    'razon_social' => $e['cia_razonsoc'],
    'rfc' => $e['cia_rfc'],
    'giro' => $e['giro_nombre'],
  ),
  'facturas' => array(

  ));

  foreach ($facturas['Facturas'] as $k => $v) {
    //$r = $v['Factura'];
    $fe = $v['FacturacionEmpresa'];
    $dir = $v['Direccion'];

    $productoActivo = false;
    $mayorMembresia = array();

    $detalles = array();
    foreach ($v['FacturaDetalles'] as $_k  => $_v) {
      $m = $_v['Membresia'];
      $fechaInicio = $m['inicio'];
      $fechaFin = $m['vence'];

      $_d = array(
        'nombre' => $m['nombre'],
        'desc' => $m['desc'],
        'costo' => array(
          'value' => (float)$m['costo'],
          'text' => $this->Number->currency($m['costo']),
        ),
        'cant' => (int)$_v['cantidad'],
        'css_class' => $m['css_class'],
        'vigencia' => __('%s días.', $m['vigencia']),
        'subtotal' => array(
          'value' => $_v['cantidad'] * $m['costo'],
          'text' => $this->Number->currency($_v['cantidad'] * $m['costo'])
        ),
      );

      if (empty($mayorMembresia) || $mayorMembresia['perfil'] < $m['perfil']) {
        $mayorMembresia = $m;
      }

      if (!$productoActivo) {
        $productoActivo = !is_null($m['vence']);
      }

      $detalles[] = $_d;
    }

    $classsId = strtolower($mayorMembresia['nombre']);
    $classsId = in_array($classsId, array('diamond', 'silver', 'golden')) ? $classsId : 'basic';

    $results['facturas'][] = array(
      'id' => (int)$v['factura_cve'],
      'folio' => $v['factura_folio'],
      'subtotal' => $this->Number->currency($v['factura_subtotal']),
      'total' => array(
        'val' => (float)$v['factura_total'],
        'text' => $this->Number->currency($v['factura_total'])
      ),
      'empresa' => array(
        'slug' => Inflector::slug($e['cia_nombre'] . '-' . $e['cia_cve'], '-')
      ),
      'classId' => $classsId,
      'nombre' => $mayorMembresia['nombre'],
      'fecha' => array(
        'contratacion' => array(
          'str' => $this->Time->dt($v['created']),
          'val' => $v['created']
        ),
        'inicio' => $this->Time->dt($mayorMembresia['inicio']),
        'vencimiento' => $this->Time->dt($mayorMembresia['vence'])
      ),
      'status' => array(
        'value' => $v['factura_status'],
        'text' => $v['status_str'],
      ),
      'facturacion' => array(
        'rfc' => $fe['cia_rfc'],
        'empresa' => $fe['cia_nombre'],
        'giro' => $fe['giro'],
        'telefono' => $fe['telefono'],
        'ubicacion' => implode(', ', array(
          $dir['colonia'],
          $dir['ciudad'],//$value['Direccion']['ciudad'],
          $dir['estado'],//$value['Direccion']['estado'],
          $dir['pais'],//$value['Direccion']['pais'],
          $dir['cp'],//$value['Direccion']['cp']
        )),
      ),
      'detalles' => $detalles
    );

  }

  $this->_results = $results;
?>
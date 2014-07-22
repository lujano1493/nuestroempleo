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
        'costo' => $this->Number->currency($m['costo']),
        'cant' => (int)$_v['cantidad'],
      );

      if (empty($mayorMembresia) || $mayorMembresia['perfil'] < $m['perfil']) {
        $mayorMembresia = $m;
      }

      if (!$productoActivo) {
        $productoActivo = !is_null($m['vence']);
      }

      // if ($fechaInicio != null && $fechaFin != null) {
      //   $_d['fecha_inicio'] = $this->Time->dt($m['inicio']);
      //   $_d['fecha_vencimiento'] = $this->Time->dt($m['vence']);
      // }

      $detalles[] = $_d;
    }

    // $statusStr = array('Pendiente', 'Vencida', 'Activa');
    // $status = is_null($mayorMembresia['vence']) ? 0 : (
    //   $this->Time->isPast($mayorMembresia['vence']) ? 1 : 2
    // );

    $classsId = strtolower($mayorMembresia['nombre']);
    $classsId = in_array($classsId, array('diamond', 'silver', 'golden')) ? $classsId : 'basic';

    $results['facturas'][] = array(
      'id' => (int)$v['factura_cve'],
      'folio' => $v['factura_folio'],
      'subtotal' => $this->Number->currency($v['factura_subtotal']),
      'total' => $this->Number->currency($v['factura_total']),
      'classId' => $classsId,
      'nombre' => $mayorMembresia['nombre'],
      'fecha' => array(
        'contratacion' => $this->Time->dt($v['created']),
        'inicio' => $this->Time->dt($mayorMembresia['inicio']),
        'vencimiento' => $this->Time->dt($mayorMembresia['vence'])
      ),
      'status' => array(
        'value' => (int)$v['factura_status'],
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
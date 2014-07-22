<?php
  $results = array();

  foreach ($membresias as $k => $v) {

    $m = array(
      'id' => (int)$v['membresia_cve'],
      'nombre' => $k,
      'vigencia' => $v['vigencia'],
      'costo' => array(
        'val' => (float)$v['costo'],
        'str' => $this->Number->currency($v['costo'])
      ),
      'fecha_creacion' => array(
        'val' => $v['created'],
        'str' => $this->Time->dt($v['created'])
      )
    );
    $detalles = array();

    foreach ($v['Detalles'] as $kd => $vd) {
      $d = $vd['Detalle'];
      $s = $vd['Servicio'];

      $det = array(
        '_class' => $s['identificador'],
        'servicio' => $s['servicio_nom'],
        'creditos' => $d['creditos_infinitos'] ? 'infinity' : (int)$d['credito_num']
      );

      $detalles[] = $det;
    }

    $m['detalles'] = $detalles;

    $results[] = $m;
  }

  $this->_results = $results;
?>
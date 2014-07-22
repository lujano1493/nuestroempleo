<?php
  $tests = array();

  foreach ($evaluaciones as $key => $value) {
    $e = $value['Evaluacion'];
    $id = +$e['evaluacion_cve'];
    $tests[] = array(
      'id' => $id,
      'slug' => Inflector::slug($e['evaluacion_nom'], '-') . '-' . $id,
      'nombre' => $e['evaluacion_nom'],
      'desc' => $e['evaluacion_descrip'],
      'created' => $e['created'],
      'borrador' => (int)$e['evaluacion_status'] === 0,
      'tipo' => array(
        'value' => +$e['tipoeva_cve'],
        'texto' => +$e['tipoeva_cve'] === 3 ? 'Conocimientos' : 'Desempeño',
      ),
      'asignadas' => +$e['total'],
      'resueltas' => +$e['aplicadas'],
      'usuario' => $value['Creador']
    );
  }

  $this->_results = $tests;
?>
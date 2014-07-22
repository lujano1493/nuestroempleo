<?php
  $ev = $evaluacion['Evaluacion'];
  $slug = Inflector::slug($ev['evaluacion_nom'], '-') . '-' . $ev['evaluacion_cve'];
  $assigns = array();

  foreach ($evaluacion['Asignaciones'] as $key => $value) {
    $status = (int)$value['evaluacion_status'];
    $assigment = array(
      'nombre' => $ev['evaluacion_nom'],
      'slug' => $slug,
      'candidato' => array(
        'id' => (int)$value['Candidato']['id'],
        'nombre' => $value['Candidato']['nombre']
      ),
      'status' => array(
        'value' => $status,
        'text' => $value['status']
      ),
      'creada' => $value['created'],
      'aplicada' => $status === 1 ? $value['modified'] : null
    );

    $assigns[] = $assigment;
  }

  $this->_results = $assigns;
?>
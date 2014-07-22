<?php
  $this->set('noValidationErrors', true);
  $results = array();

  foreach ($postulaciones as $k => $v) {
    $postu = array(
      'id' => (int)$v['Postulacion']['postulacion_cve'],
      'idOferta' => (int) $v['Oferta']['oferta_cve'],
      'status' => $v['Oferta']['oferta_inactiva'],
      'empresa' => $v['Postulacion']['empresa'],
      'puesto' => $v['Oferta']['puesto_nom'],
      'fecha' => $v['Postulacion']['fecha'],
    );

    $results[] = $postu;
  }

  $this->_results = $results;
?>
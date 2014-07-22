<?php
  $this->set('noValidationErrors', true);
  $this->_results = $this->Candidato->formatToJson($candidatos['CandidatosPostulados'], array(
    'alias' => false
  ), array(
    'oferta' => array(
      'id' => (int)$candidatos['Oferta']['oferta_cve'],
      'slug' => Inflector::slug($candidatos['Oferta']['puesto_nom'] . '-' . $candidatos['Oferta']['oferta_cve'], '-')
    )
  ));
?>
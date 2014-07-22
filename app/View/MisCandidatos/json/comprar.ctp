<?php

  $this->set('noValidationErrors', true);

  if (!empty($callback) && !empty($candidato)) {
    $callback['args'] = array(
      $this->Candidato->formatToJson($candidato, array(
        'alias' => 'CandidatoB'
      ))
    );

    $this->set(compact('callback'));
  }

?>
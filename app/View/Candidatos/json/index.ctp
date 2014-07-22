<?php
  $this->set('noValidationErrors', true);

  $this->_results = $this->Candidato->formatToJson($candidatos);
?>
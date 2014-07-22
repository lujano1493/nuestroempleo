<?php
  $formattedUsuarios = [];

  foreach ($candidatos as $key => $value) {
    $formattedUsuarios[] = array(
      'id' => $value['CandidatoEmpresa']['candidato_cve'],
      'name' => $value['Cuenta']['cc_email']
    );
  }

  $this->_results = $formattedUsuarios;
?>
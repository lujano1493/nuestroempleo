<?php
  $formattedUsuarios = [];

  foreach ($candidatos as $key => $value) {
    $id = (int)$value['CandidatoB']['candidato_cve'];
    $c = array(
      'id' => $id,
      'name' => $value['CandidatoB']['cc_email'],
      'desc' => $value['CandidatoB']['candidato_perfil']
    );

    /**
     * Temporal...
     */
    if (file_exists(WWW_ROOT . "documentos/candidatos/$id/foto.jpg")) {
      $c['foto'] = "/documentos/candidatos/$id/foto.jpg";
    } else {
      $c['foto'] = "/img/candidatos/default.jpg";
    }

    $formattedUsuarios[] = $c;
  }

  $this->_results = $formattedUsuarios;
?>
<?php
  $this->set('noValidationErrors', true);
  $this->set('emptyResults', true);

  $results = array();

  foreach ($mensajes as $k => $v) {
    $msj = array(
      'id' => (int)$v['MensajeData']['receptormsj_cve'],
      'asunto' => $v['Mensaje']['msj_asunto'],
      'contenido' => nl2br($v['Mensaje']['msj_texto']),
      'importante' => (int)$v['Mensaje']['msj_importante'],
      'recibido' => array(
        'val' => $v['Mensaje']['created'],
        'str' => $this->Time->dt($v['Mensaje']['created'])
      ),
      'leido' => (int)$v['MensajeData']['msj_leido'],
      'emisor' => array(
        'id' => isset($v['Emisor']['cu_cve']) ? (int)$v['Emisor']['cu_cve'] : (int)$v['Emisor']['candidato_cve'],
        'tipo' => (int)$v['Mensaje']['emisor_tipo'],
        'nombre' => $v['Emisor']['nombre'],
        'email' => $v['Emisor']['email'],
      ),
    );

    // if (!is_null($v['Carpeta']['carpeta_cve'])) {
    //   $msj['carpeta'] = array(
    //     'id' => $v['Carpeta']['carpeta_cve'],
    //     'nombre' => $v['Carpeta']['carpeta_nombre'],
    //     'slug' => Inflector::slug($v['Carpeta']['carpeta_nombre'], '-') . '-' . $v['Carpeta']['carpeta_cve']
    //   );
    // }

    $results[] = $msj;
  }

  $this->_results = $results;
?>
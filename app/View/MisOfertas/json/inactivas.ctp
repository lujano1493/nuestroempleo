<?php
  $this->set('noValidationErrors', true);

  $results = array();

  foreach ($ofertas as $key => $value) {
    $id = (int)$value['Oferta']['oferta_cve'];
    $nombre = $value['Oferta']['puesto_nom'];

    // if (empty($value['Carpeta']) && !empty($carpeta)) {
    //   $value['Carpeta'] = $carpeta;
    // }

    $oferta = array(
      //'oferta' => array(
        'id' => $id,
        'nombre' => $nombre,
        'codigo' => $value['Oferta']['oferta_cvealter'],
        'vigencia' => $value['Oferta']['vigencia'],
        'status' => $value['Oferta']['status'],
        'slug' => Inflector::slug($nombre, '-') . '-' . $id,
        //'contenido' => $value['Oferta']['oferta_descrip'],
        'usuario' => array(
          'id' => (int)$value['UsuarioEmpresa']['cu_cve'],
          'email' => $value['UsuarioEmpresa']['cu_sesion'],
          'keycode' => $value['UsuarioEmpresa']['keycode'],
        ),
        'pausada' => (int)((int)$value['Oferta']['oferta_inactiva'] === -1),
        'es_compartida' => (int)$value['Oferta']['oferta_publica'],
        'fecha_creacion' => array(
          'val' => $value['Oferta']['oferta_fecini'],
          'str' => $this->Time->d($value['Oferta']['oferta_fecini'])
        ),
        'fecha_vence' => array(
          'val' => $value['Oferta']['oferta_fecfin'],
          'str' => $this->Time->d($value['Oferta']['oferta_fecfin'])
        ),
        //'postulaciones' => isset($value['Oferta']['postulaciones']) ? (int)$value['Oferta']['postulaciones'] : 0
      //)
    );

    // if ($value['Carpeta']['carpeta_cve']) {
    //   $oferta['carpeta'] = array(
    //     'id' => $value['Carpeta']['carpeta_cve'],
    //     'nombre' => $value['Carpeta']['carpeta_nombre'],
    //     'slug' => Inflector::slug($value['Carpeta']['carpeta_nombre'], '-') . '-' . $value['Carpeta']['carpeta_cve']
    //   );
    // }

    $results[] = $oferta;
  }


  $this->_results = $results;
?>
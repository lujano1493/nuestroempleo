<?php
  $this->set('noValidationErrors', true);
  $results = array();

  foreach ($ofertas as $key => $value) {
    $id = (int)$value['Oferta']['oferta_cve'];
    $nombre = $value['Oferta']['puesto_nom'];

    if (empty($value['Carpeta']) && !empty($carpeta)) {
      $value['Carpeta'] = $carpeta;
    }

    $status = $value['Oferta']['status'];

    $oferta = array(
      //'oferta' => array(
        'id' => $id,
        'nombre' => $nombre,
        'codigo' => $value['Oferta']['oferta_cvealter'],
        'vigencia' => $value['Oferta']['vigencia'],
        'status' => $value['Oferta']['status'],
        'slug' => Inflector::slug($nombre, '-') . '-' . $id,
        'contenido' => $value['Oferta']['oferta_descrip'],
        'usuario' => array(
          'id' => (int)$value['UsuarioEmpresa']['cu_cve'],
          'email' => $value['UsuarioEmpresa']['cu_sesion'],
          'keycode' => $value['UsuarioEmpresa']['keycode'],
        ),
        'es_propia' => (int)$value['Oferta']['cu_cve'] === (int)$authUser['cu_cve'],
        'fecha_creacion' => array(
          'val' => $value['Oferta']['oferta_fecini'],
          'str' => $this->Time->d($value['Oferta']['oferta_fecini'])
        ),
      //)
    );

    if ($value['Carpeta']['carpeta_cve']) {
      $oferta['carpeta'] = array(
        'id' => $value['Carpeta']['carpeta_cve'],
        'nombre' => $value['Carpeta']['carpeta_nombre'],
        'slug' => Inflector::slug($value['Carpeta']['carpeta_nombre'], '-') . '-' . $value['Carpeta']['carpeta_cve']
      );
    }

    $results[] = $oferta;
  }


  $this->_results = $results;
?>

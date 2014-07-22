<?php
  $this->set('noValidationErrors', true);

  $results = array();

  foreach ($ofertas as $key => $value) {
    $id = (int)$value['Oferta']['oferta_cve'];
    $nombre = $value['Oferta']['puesto_nom'];

    $oferta = array(
      //'oferta' => array(
        'id' => $id,
        'nombre' => $nombre,
        'codigo' => $value['Oferta']['oferta_cvealter'],
        'vigencia' => $value['Oferta']['vigencia'],
        'status' => $value['Oferta']['status'],
        'slug' => Inflector::slug($nombre, '-') . '-' . $id,
        'content' => $value['Oferta']['oferta_descrip'],
        'usuario' => array(
          'id' => (int)$value['UsuarioEmpresa']['cu_cve'],
          'email' => $value['UsuarioEmpresa']['cu_sesion'],
          'keycode' => $value['UsuarioEmpresa']['keycode'],
        ),
        'is_public' => (int)$value['Oferta']['oferta_publica'],
        'created' => $this->Time->d($value['Oferta']['oferta_fecini']),
        'modified' => $this->Time->dt($value['Oferta']['modified'])
      //)
    );

    $results[] = $oferta;
  }


  $this->_results = $results;
?>
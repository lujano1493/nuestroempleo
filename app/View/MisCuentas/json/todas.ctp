<?php
  $results = array();

  foreach ($cuentas as $k => $v) {
    $id = (int)$v['UsuarioEmpresa']['cu_cve'];
    $email = $v['UsuarioEmpresa']['cu_sesion'];
    $c = array(
      'id' => $id,
      'slug' => Inflector::slug($email, '-') . '-' . $id,
      'email' => $email,
      'nombre' => $v['Contacto']['nombre'],
      'keycode' => $v['UsuarioEmpresa']['keycode'],
      'perfil' => array(
        'nombre' => $v['Perfil']['per_nom'],
        'descripcion' => $v['Perfil']['per_descrip']
      ),
      'status' => (int)$v['UsuarioEmpresa']['cu_status'],
      'created' => $this->Time->d($v['UsuarioEmpresa']['created'])
    );

    foreach ($v['Creditos'] as $k_c => $v_c) {
      $credito = array(
        'id' => $v_c['identificador'],
        'descripcion' => $v_c['nombre'],
        'disponibles' => (int)$v_c['disponibles'],
        'ocupados' => (int)$v_c['ocupados'],
      );

      $c['creditos'][] = $credito;
    }

    $results[] = $c;
  }

  $this->_results = $results;

?>
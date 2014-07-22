<?php
  $results = array();

  foreach ($cuentas as $k => $v) {
    $c = array(
      'id' => (int)$v['UsuarioEmpresa']['cu_cve'],
      'email' => $v['UsuarioEmpresa']['cu_sesion'],
      'nombre' => $v['Contacto']['nombre'],
      'keycode' => $v['UsuarioEmpresa']['keycode'],
      'perfil' => array(
        'descripcion' => $v['Perfil']['per_descrip']
      ),
      'status' => (int)$v['UsuarioEmpresa']['cu_status'],
    );

    foreach ($v['Creditos'] as $k_c => $v_c) {
      $credito = array(
        'id' => $v_c['identificador'],
        'descripcion' => $v_c['nombre'],
        'total' => (int)$v_c['disponibles'],
      );

      $c['creditos'][] = $credito;
    }

    $results[] = $c;
  }

  $this->_results = $results;

?>
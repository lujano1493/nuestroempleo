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

    $results[] = $c;
  }

  $this->set('noValidationErrors', true);
  $this->_results = $results;
?>
<?php
  $cuentas = array();

  foreach ($usuarios as $k => $u) {
    $a = $u['UsuarioAdmin'];
    $c = $u['Contacto'];
    $p = $u['Perfil'];
    $s = $u['Superior'];

    $id = (int)$a['cu_cve'];
    $usuario = array(
      'id' => $id,
      'nombre' => $c['nombre'],
      'email' => $a['cu_sesion'],
      'key' => $a['keycode'],
      'registrado' => $this->Time->dt($a['created']),
      'perfil' => array(
        'val' => $p['per_nom'],
        'desc' => $p['per_descrip'],
      ),
      'slug' => Inflector::slug($a['cu_sesion'], '-') . '-' . $id,
      'superior' => !is_null($s['cu_cve']) ? array(
        'id' => (int)$s['cu_cve'],
        'email' => $s['cu_sesion'],
        'key' => $s['keycode'],
      ) : null,
      'status' => array(
        'val' => (int)$a['cu_status'],
        'desc' => $a['status'],
      )
    );

    $cuentas[] = $usuario;
  }


  $this->_results = $cuentas;
?>
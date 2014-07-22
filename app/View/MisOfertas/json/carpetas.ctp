<?php
  // $carpetas = Hash::nest($carpetas, array(
  //   'idPath' => '{n}.Carpeta.carpeta_cve',
  //   'parentPath' => '{n}.Carpeta.carpeta_cvesup'
  // ));
  $results = array();

  foreach ($carpetas as $k => $v) {
    $c = $v['Carpeta'];
    $u = $v['Usuario'];

    $folder = array(
      'id' => (int)$c['carpeta_cve'],
      'nombre' => $c['carpeta_nombre'],
      'fecha_creacion' => array(
        'val' => $c['created'],
        'str' => $this->Time->dt($c['created'])
      ),
      'slug' => Inflector::slug($c['carpeta_nombre'] . '-' . $c['carpeta_cve'], '-'),
      'ofertas' => (int)$c['total'],
      'usuario' => array(
        'id' => (int)$u['cu_cve'],
        'email' => $u['cu_sesion'],
        'nombre' => $u['cu_sesion'],
      )
    );

    $results[] = $folder;
  }


  $this->_results = $results;
?>
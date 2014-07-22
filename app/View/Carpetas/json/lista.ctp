<?php 
  $results = array(array(
    'id' => 0,
    'name' => 'En la raíz',
  ));

  foreach ($carpetas as $key => $value) {
    $id = (int)$value['Carpeta']['carpeta_cve'];
    $name = $value['Carpeta']['carpeta_nombre'];
    $pad = $value['Carpeta']['nivel_max'];
    
    $folder = array(
      'id' => $id,
      'name' => str_repeat('---', $pad) . ' ' . $name,
    );

    $results[] = $folder;
  }

  $this->_results = array(
    'folders' => $results
  );
?>
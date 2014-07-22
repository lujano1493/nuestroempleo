<?php
  $results = array();

  foreach ($carpetas as $key => $value) {
    $id = (int)$value['Carpeta']['carpeta_cve'];
    $name = $value['Carpeta']['carpeta_nombre'];

    $folder = array(
      'id' => $id,
      'folder_name' => $name,
      'slug' => Inflector::slug($name, '-') . '-' . $id,
      'tipo' => array(
        'value' => (int)$value['Carpeta']['tipo_cve'],
        'text' => $value['Carpeta']['tipo_text']
      ),
      'user' => array(
        'id' => $value['Usuario']['cu_cve'],
        'mail' => $value['Usuario']['cu_sesion'],
        //'name' => $value['Contacto']['con_nombre']
      ),
      'created' => $this->Time->dt($value['Carpeta']['created'])
    );

    $results[] = $folder;
  }

  $this->_results = $results;
?>
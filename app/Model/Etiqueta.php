<?php 

App::uses('AppModel', 'Model');

class Etiqueta extends AppModel {

  /**
    * Nombre del Modelo
    */
  public $name = 'Etiqueta';

  /**
    * Nombre de la llave primaria, en este caso es multiple, tabla tcatalogos.
    */
  public $primaryKey = 'etiqueta_cve';
  
  /**
    * Tabla.
    */
  public $useTable = 'tetiquetas';

  public $inserted_ids = array();

  public function afterSave($created, $options = array()) {
    if ($created) {
      $this->inserted_ids[] = $this->getInsertID();
    }
    return true;
  }

  public function lista($query) {
    $results = $this->find('all', array(
      'fields' => array('Etiqueta.etiqueta_cve as id', 'Etiqueta.etiqueta_nombre as name'),
      'conditions' => array('Etiqueta.etiqueta_nombre LIKE' => '%' . $query . '%'),
      'limit' => 20,
      'recursive' => -1
    ));
    $results = Hash::extract($results, '{n}.Etiqueta');
    
    return $results;
  }

  /**
    *
    * @param  mixed   $values
    * @return mixed
    */
  public function exists($values = null) {
    /**
      * Si $values es nulo o no es un array, llama a la función padre.
      */
    if (is_null($values) || !is_array($values)) {
      return parent::exists($values);
    }
    $numbers = array();
    $strings = array();
    foreach ($values as $e) {
      if (is_numeric($e)) {
        array_push($numbers, (int)$e);
      } elseif (is_string($e)) {
        array_push($strings, $e);
      }
    }

    $results = $this->find('list', array(
      'fields' => array($this->primaryKey, 'etiqueta_nombre'),
      'conditions' => array(
        'OR' => array(
          $this->primaryKey => isset($numbers) && !empty($numbers) ? $numbers : 0,
          'etiqueta_nombre' => isset($strings) && !empty($strings) ? $strings : '',
        )
      ),
      'recursive' => -1
    ));
    return $results;
  }

  public function verificar($etiquetas) {
    $data = array();
    $existingTags = $this->exists($etiquetas);
    $tags = array(
      'keys' => array_keys($existingTags),
      'values' => array_values($existingTags)
    );
    $notExistingTags = array_diff($etiquetas, $tags['keys'], $tags['values']);
    foreach ($notExistingTags as $value) {
      array_push($data, array('etiqueta_nombre' => $value));
    }
    if (!empty($data)) {
      $this->saveMany($data);  
    }
    return array_map(function ($value) {
      return array('etiqueta_cve' => (int)$value);
    },array_merge($this->inserted_ids, array_keys($existingTags)));
  }

}
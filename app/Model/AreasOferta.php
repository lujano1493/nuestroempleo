<?php

App::uses('AppModel', 'Model');

class AreasOferta extends AppModel {
  public $name = 'AreasOferta';
  
  /**
    * Nombre de la llave primaria, en este caso es cia_cve, tabla tcompania.
    */
  public $primaryKey = 'ofertaxarea_cve';

  public $useTable = 'tofertaxarea';

  public function format($etiquetas, $id = null) {
    if ($id) {
      $this->deleteAll(array(
        'oferta_cve' => $id
      ));
    }

    return array_map(function ($value) {
      return array('area_cve' => (int)$value);
    }, $etiquetas);
  }
  
}
<?php

App::uses('Acceso', 'Utility');

class PerfilMembresia extends AppModel {

  /**
    * Nombre del Modelo
    */
  public $name = 'PerfilMembresia';

  /**
    * Nombre de la llave primaria, en este caso es cia_cve, tabla tcompania.
    */
  public $primaryKey = 'perfilxmembresia_cve';

  /**
    * Tabla.
    */
  public $useTable = 'tperfilxmembresia';

  public function hasMembresia($empresaId) {
    $results = $this->find('all', array(
      'conditions' => array(
        $this->alias . '.cia_cve' => $empresaId,
        $this->alias . '.fec_fin > CURRENT_DATE'
      ),
      'joins' => array(
        array(
          'alias' => 'Membresia',
          'conditions'=> array(
            $this->alias . '.membresia_cve = Membresia.membresia_cve',
            'Membresia.membresia_clase' => 'mbs'
          ),
          'table' => 'tmembresias',
          'type' => 'INNER',
        )
      )
    ));

    return !empty($results);
  }

}
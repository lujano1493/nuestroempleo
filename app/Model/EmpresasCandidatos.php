<?php

App::uses('AppModel', 'Model');

class EmpresasCandidatos extends AppModel {
  public $name = 'EmpresasCandidatos';

  /**
    * Nombre de la llave primaria, en este caso es cia_cve, tabla tcompania.
    */
  public $primaryKey = 'candidatoxcia_cve';

  public $useTable = 'tcandidatosxcia';

  public $belongsTo = array(
    'UsuarioEmpresa' => array(
      'className' => 'UsuarioEmpresa',
      'foreignKey' => 'cu_cve'
    ),
    'Contacto' => array(
      'className' => 'UsuarioEmpresaContacto',
      'foreignKey' => 'cu_cve'
    )
  );

  public function isAcquired($ciaId, $candidatoId = null) {
    return $this->hasAny(array(
      $this->alias . '.cia_cve' => $ciaId,
      $this->alias . '.candidato_cve' => $candidatoId
    ));
  }

}
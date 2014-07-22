<?php

App::uses('AppModel', 'Model');

class CarpetasCandidatos extends AppModel {
  public $name = 'CarpetasCandidatos';

  /**
    * Nombre de la llave primaria, en este caso es cia_cve, tabla tcompania.
    */
  public $primaryKey = 'carpetaxcandidato_cve';

  public $useTable = 'tcarpetaxcandidato';

  /**
   * Crea los nuevos registros de los candidatos con la carpeta del usuario.
   * @param int     $userId         id del usuario
   * @param array   $candidatoId    id(s) de candidato(s).
   * @param array   $attributes     atributos.
   */
  private function add($userId, $candidatoId, $carpetaId) {
    $data = array();

    foreach ($candidatoId as $key => $id) {
      $data[] = array(
        'cu_cve' => $userId,
        'candidato_cve' => $id,
        'carpeta_cve' => $carpetaId
      );
    }

    $this->create();
    return $this->saveMany($data);
  }

  /**
   * Guarda o actualiza.
   * Dependiendo de si el candidato ya está en la tabla de carpetas creará el registro.
   * @param  mixed  $candidatoId  id(s) de candidato(s).
   * @param  int    $userId       id del usuario.
   * @param  int    $carpetaId    id de la carpeta.
   * @return bool                 si las actualizaciones y creaciones se crearon con éxito.
   */
  protected function saveOrUpdate($candidatoId = null, $userId = null, $carpetaId = null) {
    $success = true;
    /**
     * Verifica si existe el registro del candidato con la carpeta del usuario.
     * @var [type]
     */
    $record = $this->getRecord($candidatoId, $userId, $carpetaId);

    // Si existen actualiza, descartará los existentes para agregar sólo los que no están.
    if ($record) {
      // Obtenemos los candidatos que aún no están en atributos, para agregarlos.
      $candidatosIds = Hash::extract($record, '{n}.CarpetasCandidatos.candidato_cve');
      $candidatoId = array_diff((array)$candidatoId, $candidatosIds);
    }

    /**
     * Guardará los candidatos.
     */
    if ($candidatoId) {
      $success = $this->add($userId, (array)$candidatoId, $carpetaId);
    }

    return $success;
  }


  /**
   * Obtiene los registros.
   * @param  mixed  $candidatoId  id(s) de candidato(s).
   * @param  int    $userId       id del usuario.
   * @param  int    $carpetaId    id de la carpeta.
   * @return mixed                los registros si es que hay o false en caso contrario.
   */
  protected function getRecord($candidatoId = null, $userId = null, $carpetaId = null) {
    $record = $this->get(array(
      'conditions' => array(
        'cu_cve' => $userId,
        'candidato_cve' => $candidatoId,
        'carpeta_cve' => $carpetaId
      )
    ));

    return !empty($record) ? $record : false;
  }

  /**
   * Agrega a favoritos.
   * @param mixed $candidatoId    Id(s) de los candidatos.
   * @param int $userId           Id del usuario.
   */
  public function addToFolder($carpetaId, $candidatoId = null, $userId = null) {
    return $this->saveOrUpdate($candidatoId, $userId, $carpetaId);
  }

  public function removeFromFolder($carpetaId, $candidatoId = null, $userId = null) {
    return $this->deleteAll(array(
      'cu_cve' => $userId,
      'candidato_cve' => $candidatoId,
      'carpeta_cve' => $carpetaId
    ));
  }
}
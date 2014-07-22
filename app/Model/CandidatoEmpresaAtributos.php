<?php

App::uses('AppModel', 'Model');

class CandidatoEmpresaAtributos extends AppModel {
  public $name = 'CandidatoEmpresaAtributos';
  
  public $ownerId = null;

  /**
    * Nombre de la llave primaria, en este caso es cia_cve, tabla tcompania.
    */
  public $primaryKey = 'candidatoxcu_cve';

  public $useTable = 'tcandidatoatributos';

  /**
   * Actualiza los atributos de los registros que existen.
   * @param array   $ids          ids de los registros.
   * @param array   $attributes   atributos que se actualizarán.
   */
  private function setAttrs($ids, $attributes) {
    return $this->updateAll($attributes, array(
      $this->primaryKey => $ids
    ));
  }

  /**
   * Crea los nuevos registros de los candidatos, con el usuario y sus atributos.
   * @param int     $userId         id del usuario
   * @param array   $candidatoId    id(s) de candidato(s).
   * @param array   $attributes     atributos.
   */
  private function add($userId, $candidatoId, $attributes = array()) {
    $data = array();

    foreach ($candidatoId as $key => $id) {
      $data[] = array(
        'cu_cve' => $userId,
        'candidato_cve' => $id
      ) + $attributes;
    }

    $this->create();
    return $this->saveMany($data);
  }

  /**
   * Guarda o actualiza.
   * Dependiendo de si el candidato ya está en la tabla de atributos, actualizará o creará el registro.
   * @param  mixed  $candidatoId  id(s) de candidato(s).
   * @param  int    $userId       id del usuario.
   * @param  array  $attributes   atributos que se actualizarán.
   * @return bool                 si las actualizaciones y creaciones se crearon con éxito.
   */
  protected function saveOrUpdate($candidatoId = null, $userId = null, $attributes = array()) {
    // De antemano se establece como exitosa, ya que pueden existir sólo creaciones.
    $success = true;
    
    /**
     * Verifica si existe(n) el(los)  registro(s) del usuario con el(los) candidato(s).
     * @var [type]
     */
    $record = $this->getRecord($candidatoId, $userId);

    // Si existe, actualiza, sino registra.
    if ($record) { //Actualiza
      //Actualizará los registros que existen.
      $ids = Hash::extract($record, '{n}.Atributos.candidatoxcu_cve');
      $success = $this->setAttrs($ids, $attributes);

      // Obtenemos los candidatos que aún no están en atributos, para agregarlos.
      $candidatosIds = Hash::extract($record, '{n}.Atributos.candidato_cve');
      $candidatoId = array_diff((array)$candidatoId, $candidatosIds);
    }

    // Si hay candidatos que no hay en la tabla, los agregará.
    if ($candidatoId) {
      $success = $success && $this->add($userId, (array)$candidatoId, $attributes);
    }
    
    return $success;
  }

  /**
   * Obtiene los registros.
   * @param  mixed  $candidatoId  id(s) de candidato(s).
   * @param  int $userId          id del usuario.
   * @return mixed                los registros si es que hay o false en caso contrario.
   */
  protected function getRecord($candidatoId = null, $userId = null) {
    $record = $this->get(array(
      'conditions' => array(
        'cu_cve' => $userId,
        'candidato_cve' => $candidatoId
      )
    ));

    return !empty($record) ? $record : false;
  }
  
  /**
   * Agrega a favoritos.
   * @param mixed $candidatoId    Id(s) de los candidatos.
   * @param int $userId           Id del usuario.
   */
  public function addToFavorites($candidatoId = null, $userId = null) {
    return $this->saveOrUpdate($candidatoId, $userId, array(
      'favorito' => 1
    ));
  }
}
<?php

App::uses('AppModel', 'Model');
App::uses('CakeEvent', 'Event');
App::uses('CandidatoListener', 'Event');

class VisitaCV extends AppModel {

	public $useTable = 'tvisitacv';

	public $name = 'VisitaCV';

	public $primaryKey = 'visitacv_cve';

	public $actsAs = array('Containable');

	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$listener = new CandidatoListener();
    $this->getEventManager()->attach($listener);
	}

	public function num_visitas($idCan = null) {
		return  $this->find('count', array(
			'conditions' => array(
				"$this->alias.candidato_cve" => $idCan
			)
		));
	}

	/**
	 * Guarda si el registro con las condiciones no existe.
	 * @param  [type] $userId      Id. del Usuario
	 * @param  [type] $candidatoId Id. del Candidato
	 * @return [type]              [description]
	 */
	public function saveIfNotExists($userId, $candidatoId) {
		/**
		 * Verifica si el registro existe.
		 * @var [type]
		 */
		$hasVisited = $this->hasAny(array(
      'cu_cve' => $userId,
      'candidato_cve' => $candidatoId
    ));

		/**
		 * Si no existe, lo guarda.
		 */
		if (!$hasVisited) {
			$isSaved = $this->save(array(
				'cu_cve' => $userId,
      	'candidato_cve' => $candidatoId
			));

			return $isSaved ? 'saved' : false;
		}

		return (bool)$hasVisited;
	}

	public function afterSave($created, $options = array()) {
    if ($created) {
      $event = new CakeEvent('Model.Candidato.viewCV', $this, array(
        'id' => $this->id,
        'data' => $this->data //[$this->alias]
      ));

      $this->getEventManager()->dispatch($event);
    }
  }
}


<?php

App::import('Model', 'ModelCan');
App::uses('CakeEvent', 'Event');
App::uses('EvaluacionListener', 'Event');

class EvaCan extends ModelCan {
  public $name = 'EvaCan';

  public $useTable = 'tevaluacandidato';

  public $actsAs = array("GraficaCan");

  public $primaryKey = "evaxcan_cve";

  public $findMethods = array('data' => true);

  public $create_update = true;

  public $tipo_eva = "0";

  public $finalizado = false;

  public $idCandidato= null;

  public $belongsTo = array(
  	'Evaluacion' => array(
			'className' => 'Evaluacion',
			'foreignKey' => 'evaluacion_cve'
		),
 		'Reclutador' => array(
			'className' => 'UsuarioEmpresa',
 			'foreignKey' => 'cu_cve'
		),
    'ReclutadorContacto'=> array(
      'className'=> 'UsuarioEmpresaContacto',
      'foreignKey'=> 'cu_cve'
    ),
    'Candidato' => array(
      'className' => 'Candidato',
      'foreignKey' => 'candidato_cve'
    ),
    'CandidatoContacto' => array(
      'className' => 'CandidatoUsuario',
      'foreignKey' => 'candidato_cve'
    )
 	);

  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);

    $this->virtualFields = array(
      'status'=> "decode($this->alias.evaluacion_status,0,'Pendiente',1,'Finalizada',2,'Caducada')",
      'created_order' => " to_char($this->alias.created,'YYYY/MM/DD hh24:mi:ss')",
      'modified_order' => " to_char($this->alias.modified,'YYYY/MM/DD hh24:mi:ss')"
    );

    $listener = new EvaluacionListener();
    $this->getEventManager()->attach($listener);
  }


  //cambiamos el estatus de nuestra evaluacion
  public function cambiaStatus($id = null, $status = 0) {
    $this->id = $id;
    return $this->saveField("evaluacion_status", $status, false);
  }


  public function _findData($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['conditions']= array(
				"$this->alias.candidato_cve" => $query['user']
			);

      $query['joins'] = array(
        array(
          'table' => 'tevaluacion',
          'alias' => 'Eval',
          'type' => 'LEFT',
          'fields' => array(),
          'conditions' => array(
            "Eval.evaluacion_cve = $this->alias.evaluacion_cve"
          )
        ),
        array(
          'table' => 'tcompania',
          'alias' => 'Cia',
          'type' => 'LEFT',
          'fields' => array(
            "Cia.cia_nombre  {$this->alias}__nombre_empresa"
          ),
          'conditions' => array(
            "Eval.cia_cve = Cia.cia_cve"
          )
        )
      );

      $query['order'] = array(
        "$this->alias.created desc"
      );
      return $query;
    }
    return $results;
  }
  private function _evaluacion($id=null ,$options){
      $options= array_merge($options,array(
                      "conditions" => array("$this->alias.$this->primaryKey" => $id)                    
        ));
      $result=$this->find("first",$options);
      return empty($result) ? $result: $result[$this->alias];
  }
  public function status ($id=null){
        $result= $this->_evaluacion($id,array("fields" => "$this->alias.evaluacion_status"));
        return empty($result) ?  false:  $result["evaluacion_status"];
  }
  

  /*verificamos que tipo de evaliacion es y en que estado termino para poderlo contar en la grafica
    checamos que la evaluacion DISC tenga un status finalizado para contarlo

  */
  public function checkBeforeInsertGrafCan($options = array()) {
    return $this->tipo_eva == "2" && $this->finalizado;
  }

  public function afterSave($created, $options = array()) {
    if ($created) {

    } else {
      // Se actualizó.
      $status = !empty($this->data[$this->alias]['evaluacion_status'])
      ? $this->data[$this->alias]['evaluacion_status']
      : (!empty($this->data['evaluacion_status'])
        ? $this->data['evaluacion_status']
        : 0
      );

      // Esto quiere decir que la evaluación ya se contesto.
      if ((int)$status === 1) {
        $event = new CakeEvent('Model.Evaluacion.completed', $this, array(
          // 'id' => $evaluacionId,
          'data' => $this->get('first', $this->id, array(
              'contain' => 'Evaluacion'
            )
          ))
        );

        $this->getEventManager()->dispatch($event);
      }
    }
  }
  public function checarPruebaPsy($idUser=null){
    App::import('Model', 'Evaluacion');

      $conditions=array(
           "$this->alias.candidato_cve "=> $idUser,
          "$this->alias.evaluacion_cve" => Evaluacion::EVALUACION_DISC
        );

      $c= array_merge($conditions,array( " ( sysdate - $this->alias.modified ) >= 30*6  "));
      $is= $this->hasAny( $c );
        if($is ){
              $this->updateAll(
                array(
                  "$this->alias.modified" =>  null,
                  "$this->alias.evaluacion_status" => 0
                  ),$conditions );
        }

  }
}

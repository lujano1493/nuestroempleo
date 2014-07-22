<?php

App::uses('AppModel', 'Model');
App::uses('CakeEvent', 'Event');
App::uses('EvaluacionListener', 'Event');

class Evaluacion extends AppModel {
  public $name = 'Evaluacion';

  /**
   * Utiliza el comportamiento: Containable
   * @var array
   */
  public $actsAs = array('Containable');

  public $useTable = 'tevaluacion';

  public $primaryKey = 'evaluacion_cve';

  public $belongsTo = array(
    'Creador' => array(
      'className' => 'UsuarioEmpresa',
      'foreignKey' => 'cu_cve',
    ),
    'CreadorContacto' => array(
      'className' => 'UsuarioEmpresaContacto',
      'foreignKey' => 'cu_cve',
    )
  );

  const EVALUACION_DISC=2;

  public $hasMany = array(
    'Preguntas' => array(
      'className' => 'EvalPreg',
      'foreignKey' => 'evaluacion_cve',
      'order' => 'pregunta_sec ASC'
    ),
    'EvaCan' =>array(
      'className' =>'EvaCan',
      'foreignKey' => 'evaluacion_cve'
    ),
    'Asignaciones' => array(
      'className' => 'EvaCan',
      'foreignKey' => 'evaluacion_cve',
      'finderQuery' => 'SELECT
        Asignaciones.evaxcan_cve,
        Asignaciones.evaluacion_cve,
        Asignaciones.candidato_cve,
        Asignaciones.cu_cve,
        Asignaciones.evaluacion_fec,
        Asignaciones.evaluacion_status,
        decode(Asignaciones.evaluacion_status,0,\'Pendiente\',1,\'Finalizada\',2,\'Caducada\') Asignaciones__status,
        Asignaciones.created,
        Asignaciones.modified,
        Candidato.candidato_nomcom Candidato__nombre,
        Candidato.candidato_cve Candidato__id,
        Candidato.cc_email Candidato__email
          FROM tevaluacandidato Asignaciones
            INNER JOIN vcandidatos Candidato ON (
            Candidato.candidato_cve = Asignaciones.candidato_cve AND ({$__conditions__$})
          )
          WHERE Asignaciones.evaluacion_cve IN ({$__cakeID__$})'
    )
  );

  public $findMethods = array(
    'by_cia' => true,
    'evaluacion' => true,
    'asignaciones' => true
  );

  public $validate = array(
    'evaluacion_nom' => array(
      'required' => array(
        'rule' => 'notEmpty',
        'required' => true,
        'message' => 'Ingresa el nombre de la evaluación.'
      ),
      'maxlength' => array(
        'rule' => array('maxLength', 50),
        'message' => 'El máximo de caracteres para el nombre de la evaluación es 50.'
      )
    ),
    'evaluacion_descrip' => array(
      'required' => array(
        'rule' => 'notEmpty',
        'required' => true,
        'message' => 'Ingresa la descripción de la evaluación.'
      ),
      'maxlength' => array(
        'rule' => array('maxLength', 500),
        'message' => 'El máximo de caracteres para el nombre de la evaluación es 500.'
      )
    ),
  );

  /**
   * Status para las evaluaciones.
   * @var array
   */
  private $status = array(
    'borrador' => array(
      'name' => 'borrador',
      'value' => 0
    ),
    'publicada' => array(
      'name' => 'publicada',
      'value' => 1,
    )
  );

  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);

    $listener = new EvaluacionListener();
    $this->getEventManager()->attach($listener);
  }

  public function saveTest($data) {
    if (!empty($data['Preguntas'])) {
      $this->begin();
      $this->Preguntas->begin();

      $data['Preguntas'] = array_values($data['Preguntas']);

      $this->create();
      if ($this->save($data)) {
        $evaluacionId = $this->getLastInsertID();
        if ($this->Preguntas->saveQuestions($data, $evaluacionId)) {
          $this->commit();
          $this->Preguntas->commit();
          return true;
        }
      }
      $this->rollback();
    }
    return false;
  }

  public function editTest($id, $data = array()) {
    $this->id = $id;

    $this->begin();
    $this->Preguntas->begin();
    if ($this->save($data)) {
      if ($this->Preguntas->editQuestions($data, $id)) {
        $this->commit();
        $this->Preguntas->commit();
        return true;
      }
    }
    $this->rollback();

    return false;
  }

  public function saveAsignaciones($data, $userId) {
    $evaluacionId = $data['id'][0];
    $users = $data['users_id'];
    $idAsig = array();
    $success = true;

    $this->begin();
    foreach ($users as $value) {
      $eval = array(
        'cu_cve' => $userId,
        'candidato_cve' => $value,
        'evaluacion_cve' => $evaluacionId,
        'evaluacion_fec' => null,
        'evaluacion_status' => 0,
        'evaluacion_plazo' => $data['plazo']
      );

      $this->Asignaciones->create();
      if ($success && $success = $this->Asignaciones->save($eval)) {
        $idAsig[] = $this->Asignaciones->id;
      } else {
        break;
      }
    }

    if ($success) {
      $this->commit();
      $asignaciones = $this->get($evaluacionId, array(
        'contain' => array(
          'Asignaciones' => array(
            'conditions' => array(
              'Asignaciones.evaxcan_cve' => $idAsig
            )
          )
        )
      ));

      $event = new CakeEvent('Model.Asignacion.created', $this, array(
        // 'id' => $evaluacionId,
        'data' => $asignaciones
      ));

      $this->getEventManager()->dispatch($event);
    } else {
      $this->rollback();
    }
    return $success;
  }

  // public function leerAsignaciones($id = null, $candidatos = array(), $user = null, $idEva = null) {
  //   $candidatos= !is_array($user) ? (array)$candidatos :$candidatos;
  //   $conditions = array(
  //     'EvaCan.candidato_cve' => $candidatos
  //   );

  //   !empty($user) && $conditions['EvaCan.cu_cve'] = $user;
  //   !empty($idEva) && $conditions['EvaCan.evaxcan_cve'] = $idEva;

  //   return $this->find('first', array(
  //     'conditions' => array(
  //       'Evaluacion.evaluacion_cve' => $id
  //     ),
  //     'contain' => array(
  //       'EvaCan' => array(
  //         'CandidatoUsuario',
  //         'conditions' => $conditions
  //       )
  //     )
  //   ));
  // }


  public function beforeSave($options = array()) {
    if (!$this->issetId()) { // Se va a crear un nuevo registro.
      switch ($this->data[$this->alias]['tipo_tiempo']) {
        case 'n':
          $this->data[$this->alias]['evaluacion_time'] = null;
          break;
        case 'p':
          $this->data[$this->alias]['evaluacion_time'] = -1;
          break;
        default:
          break;
      }

      $this->data[$this->alias]['tipoeva_cve'] = 3;
    }

    return parent::beforeSave($options);
  }


  protected function _findEvaluacion($state, $query, $results=array()) {
    if($state==='before'){
      $model_unbind = array(
        'hasMany' => array('Asignaciones'),
        'belongsTo'=> array(
          'Creador',
          'CreadorContacto'
        )
      );

      $this->unbindModel($model_unbind);

      $query['conditions'] =array(
        "$this->alias.evaluacion_cve" => $query['id']
      );

      return $query;
    }

    if (empty($results)) {
      return array();
    }

    $fields = array(
      "pregunta_cve",
      "opcpre_cve",
      "opcpre_opcion",
      "opcpre_nom"
    );

    $order_pregunta = isset($query['order_pregunta']) ? $query['order_pregunta'] : "ASC";
    $order_pregunta = $order_pregunta == "ASC" ? $order_pregunta :"DESC";
    $options = array(
      "conditions" => array(
        "OpcPreg.evaluacion_cve" => $query['id']
      ),
      'fields' => $fields,
      'order' => array(
        "opcpre_opcion $order_pregunta"
      )
    );

    if(isset($query['idUser'])){
      $options["joins"] = array(
        array(
          "table"=> "tevaxcanresp",
          "alias" => "ResCan",
          "type" => "LEFT",
          "conditions" => array(
            "ResCan.evaluacion_cve = OpcPreg.evaluacion_cve",
            "ResCan.pregunta_cve = OpcPreg.pregunta_cve",
            "ResCan.opcpre_cve = OpcPreg.opcpre_cve",
            "ResCan.evaluacion_cve" => $query['id'],
            "ResCan.candidato_cve" => $query["idUser"]
          )
        )
      );
      $options['fields'][] = "ResCan.evaxcanresp_cve OpcPreg__canresp";
    }

    $opciones=classRegistry::init("OpcPreg")->find("all", $options);

    $results = $results[0];

    if(empty($opciones) || empty($results['Preguntas'])) {
      return $results;
    }

    foreach ($results['Preguntas'] as $index_total=> $pregunta) {
      $pregunta_cve = $pregunta['pregunta_cve'];
      $index_opcion = -1;
      foreach ($opciones as $index => $opcion) {
        if ($opcion['OpcPreg']['pregunta_cve'] == $pregunta_cve){
          $results['Preguntas'][$index_total]['Opciones'][] = $opcion['OpcPreg'];
        }
      }
    }
    return $results;
  }

  protected function _findBy_cia($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['conditions'] = array_merge(array(
        'Evaluacion.cia_cve' => $query['cia'],
        'Evaluacion.tipoeva_cve > 2'
      ), (isset($query['conditions']) ? $query['conditions'] : array()));

      if (!empty($query['stats'])) {
        $query['joins'] = array(
          array(
            'table' => '(SELECT
              E.evaluacion_cve,
              COUNT(CASE WHEN 1 = 1 THEN 1 END) totales,
              COUNT(CASE WHEN E.evaluacion_status = 1 THEN 1 END) aplicadas
              FROM tevaluacandidato E
              GROUP BY E.Evaluacion_cve)',
            'alias' => 'Evaluaciones',
            'fields' => array(
              'nvl(Evaluaciones.totales,0) Evaluacion__total',
              'nvl(Evaluaciones.aplicadas,0) Evaluacion__aplicadas'
            ),
            'type' => 'LEFT',
            'conditions' => array(
              'Evaluaciones.evaluacion_cve = Evaluacion.evaluacion_cve'
            )
          )
        );
      }

      if (!isset($query['order'])) {
        $query['order'] = array(
          'Evaluacion.created' => 'DESC'
        );
      }

      $query['contain'] = array(
        'Creador' => array(
          'fields' => array(
            'cu_sesion Creador__email'
          )
        ),
        'CreadorContacto' => array(
          'fields' => array(
            '(con_nombre || \' \' || con_paterno || \' \' || con_materno) Creador__nombre'
          )
        )
      );

      $query['recursive'] = -1;
      return $query;
    }

    return $results;
  }

  /**
   * [beforeFind description]
   * @param  array  $queryData [description]
   * @return [type]            [description]
   */
  public function beforeFind($queryData = array()) {
    $queryData['conditions']["$this->alias.evaluacion_status >= "] = 0;

    return parent::beforeFind($queryData);
  }

  /**
   * Obtiene el status
   * @param  [type] $type [description]
   * @return [type]       [description]
   */
  public function getStatus($type,$key=null) {
    if (isset($this->status[$type])) {
      return (int)$this->status[$type]['value'];
    }

    return 0;
  }

  /**
   * Cambia el estado de una evaluación.
   * @param  integer  $id     Id. de la oferta
   * @param  integer  $status StatusgetStatus
   * @return boolean          Si se actualizó correctamente.
   */
  public function changeStatus($status = 0, $id = null) {
    if ($id !== null) {
      $this->id = $id;
    }

    return $this->saveField('evaluacion_status', $status);
  }

  /**
   * Verifica si ya ha sido asignada.
   * @param  [type]  $evaluacionId [description]
   * @return boolean               [description]
   */
  public function hasAsignaciones($evaluacionId = null) {
    if ($evaluacionId !== null) {
      $this->id = $evaluacionId;
    }

    return $this->Asignaciones->hasAny(array(
      'evaluacion_cve' => $this->id
    ));
  }

}
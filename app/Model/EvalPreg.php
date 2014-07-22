<?php
class EvalPreg extends AppModel {
  public $name='EvalPreg';
  public $useTable = 'tevaluapreg';
  public $primaryKey="pregunta_cve";

  public $actsAs = array('Containable');
  public $belongsTo = array(

  );

  public $hasMany= array(
    'OpcPreg'=> array(
      'className' => 'OpcPreg',
      'foreignKey' => 'pregunta_cve',
      'fields' => array(
        'OpcPreg.opcpre_cve OpcPreg__opcpre_cve',
        "OpcPreg.opcpre_opcion  OpcPreg__opcpre_opcion",
        "OpcPreg.opcpre_nom  OpcPreg__opcpre_nom"
      ),
      "order" => array( "OpcPreg.opcpre_cve" )
    ),
    'Respuestas' => array(
      'className' => 'OpcPreg',
      'foreignKey' => 'pregunta_cve',
    ),
    'RespuestasPorUsuario' => array(
      'className' => 'OpcPreg',
      'foreignKey' => 'pregunta_cve',
      'finderQuery' => 'SELECT
        RespuestasPorUsuario.evaluacion_cve,
        RespuestasPorUsuario.pregunta_cve,
        RespuestasPorUsuario.opcpre_cve,
        RespuestasPorUsuario.opcpre_opcion,
        RespuestasPorUsuario.opcpre_nom,
        RespuestasPorUsuario.opcpre_cor,
        RespuestasPorUsuario.created,
        RespuestasPorUsuario.modified,
        (CASE WHEN
          RespuestaUsuario.evaxcanresp_cve is not NULL THEN 1 ELSE 0 END
        ) RespuestasPorUsuario__usu_resp
          FROM topcpreguntas RespuestasPorUsuario
            LEFT JOIN tevaxcanresp RespuestaUsuario ON (
              RespuestasPorUsuario.opcpre_cve = RespuestaUsuario.opcpre_cve AND
              ({$__conditions__$})
          )
          WHERE RespuestasPorUsuario.pregunta_cve IN ({$__cakeID__$})'
    )
  );

  public $findMethods = array(
    'encuesta'    => true
  );

  protected function _findEncuesta($state, $query, $results = array()) {
    if ($state == 'before') {
      $query['fields'] = array(
        "$this->alias.pregunta_cve",
        "$this->alias.pregunta_tipo",
        "$this->alias.pregunta_nom",
        "$this->alias.pregunta_tiempo",
        "$this->alias.pregunta_porc"
      );

      $query['order'] = array(
        "$this->alias.pregunta_cve ASC",
      );
      $query['contain'] = array(

                                  'OpcPreg'
        );    

      $query['conditions'] = array(
        "$this->alias.evaluacion_cve" => $query['idEva']
      );
      return $query;
    }
    return $results;
  }

  public function getEncuestaRef ($id = "1") {
  	return $this->find("all", array(
      'contain' => array(),
      'conditions' => array(
        "{$this->alias}.evaluacion_cve" => $id
      )
    ));
  }

  public function saveQuestions($data, $evalaucionID) {
    //$testType = $data['Evaluacion']['tipoeva_cve'];
    $timeType = $data['Evaluacion']['tipo_tiempo'];

    $data['Preguntas'] = array_values($data['Preguntas']);
    foreach ($data['Preguntas'] as $key => $value) {
      $data['Preguntas'][$key]['evaluacion_cve'] = $evalaucionID;
      $data['Preguntas'][$key]['pregunta_sec'] = $key + 1;
      if ($timeType !== 'p') {
        $data['Preguntas'][$key]['pregunta_tiempo'] = null;
      }

      $data['Preguntas'][$key]['Respuestas'] = $value['Respuestas'] = array_values($value['Respuestas']);
      if (!empty($value['Respuestas']) && is_array($value['Respuestas'])) {
        foreach ($value['Respuestas'] as $k => $v) {
          $data['Preguntas'][$key]['Respuestas'][$k]['opcpre_cor'] = (int)!empty($v['opcpre_cor']);
          $data['Preguntas'][$key]['Respuestas'][$k]['opcpre_opcion'] = $k + 1;
          $data['Preguntas'][$key]['Respuestas'][$k]['evaluacion_cve'] = $evalaucionID;
        }
      }
    }

    return $this->saveAll($data['Preguntas'], array('deep' => true));
  }

  public function editQuestions($data, $evalaucionID) {
    $save = $deleteQ = $deleteA = true;

    $ids = Hash::extract($data, 'Preguntas.{n}.' . $this->primaryKey);
    $isOwnedBy = $this->isOwnedBy($evalaucionID, $ids, array(
      'userKey' => 'evaluacion_cve',
      'extract' => '{n}.' . $this->alias . '.' . $this->primaryKey
    ));

    $timeType = $data['Evaluacion']['tipo_tiempo'];

    $data['Preguntas'] = array_values($data['Preguntas']);
    foreach ($data['Preguntas'] as $key => $value) {
      if (empty($value[$this->primaryKey]) || in_array($value[$this->primaryKey], $isOwnedBy)) {
        $data['Preguntas'][$key]['evaluacion_cve'] = $evalaucionID;
        $data['Preguntas'][$key]['pregunta_sec'] = $key + 1;
        if ($timeType !== 'p') {
          $data['Preguntas'][$key]['pregunta_tiempo'] = null;
        }

        $data['Preguntas'][$key]['Respuestas'] = $value['Respuestas'] = array_values($value['Respuestas']);
        if (!empty($value['Respuestas']) && is_array($value['Respuestas'])) {
          foreach ($value['Respuestas'] as $k => $v) {
            $data['Preguntas'][$key]['Respuestas'][$k]['opcpre_cor'] = (int)!empty($v['opcpre_cor']);
            $data['Preguntas'][$key]['Respuestas'][$k]['opcpre_opcion'] = $k + 1;
            $data['Preguntas'][$key]['Respuestas'][$k]['evaluacion_cve'] = $evalaucionID;
          }
        }
      } else {
        unset($data['Preguntas'][$key]);
      }
    }

    $save = $this->saveAll($data['Preguntas'], array('deep' => true));

    if (!empty($data['questions'])) {
      $deleteQ = $this->deleteAll(array(
        $this->primaryKey => $data['questions']
      ));
    }

    if (!empty($data['answers'])) {
      $deleteA = $this->Respuestas->deleteAll(array(
        $this->Respuestas->primaryKey => $data['answers']
      ));
    }

    return $save && $deleteQ & $deleteA;
  }

}
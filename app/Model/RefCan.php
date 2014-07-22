<?php
App::import('Model', 'ModelCan');
class RefCan extends ModelCan {
  public $name='RefCan';
  public $useTable = 'trefcandidato';
  public $primaryKey="refcan_cve";
  public $msg_succes="Referencias de Candidato";

  public $validate = array(
    'refcan_nom' => array(
        'required'=>  array(
         'rule' => 'notEmpty',
         'required' => true,
        'message'    => 'Ingresa el nombre de la referencia.'
      )
    ),
     'refcan_mail' => array(
        'required'=>  array(
         'rule' => 'notEmpty',
         'required' => true,
        'message'    => 'Ingresa correo electrónico.'
      ),
       'email' => array(
                        'rule'       => array('email', true), // or: array('ruleName', 'param1', 'param2' ...)
                        'message' => 'Formato de correo electrónico no válido.'
      ),
      "unique" => array(
                      'rule' =>array("uniqueData",array("field_user"=>"cc_email" )),
                      'message' =>"Ingresa un correo electrónico distinto"
        ),
    ),
     'refcan_tel' => array(
        'required'=>  array(
         'rule' => 'notEmpty',
         'required' => true,
        'message'    => 'Ingresa un número telefónico.'
      ),
      'digits'=>  array(
                'rule' => 'numeric',
                'required' => true,
              'message'    => 'Verifica el número telefónico.'
             )
    ),
     'refrel_cve' => array(
        'required'=>  array(
         'rule' => 'notEmpty',
         'required' => true,
        'message'    => 'Selecciona tipo de relación.'
      )
    ),
      'reftiempo_cve' => array(
        'required'=>  array(
         'rule' => 'notEmpty',
         'required' => true,
        'message'    => 'Selecciona el tiempo de conocerlo.'
      )
    ),
      'reftipo_cve' => array(
        'required'=>  array(
         'rule' => 'notEmpty',
         'required' => true,
        'message'    => 'Selecciona el tipo de relación.'
      )
    ),
      'tipo_movil' => array(
        'required'=>  array(
         'rule' => 'notEmpty',
         'required' => true,
        'message'    => 'Seleciona tipo de teléfono'
      ))
    );

  public $belongsTo = array(
    'Candidato' => array(
      'className' => 'Candidato',
      'foreignKey' => 'candidato_cve'
    ),
    'CandidatoInfo' => array(
      'className' => 'CandidatoUsuario',
      'foreignKey' => 'candidato_cve'
    )
  );

  public $hasMany = array(
    'RefCanEnc' => array(
      'className' => 'RefCanEnc',
      'foreignKey' => "refcan_cve"
    ),
    'RespuestasRef' => array(
      'className' => 'RefCanEnc',
      'foreignKey' => 'refcan_cve',
      'finderQuery' => 'SELECT
        RespuestasRef.refcan_cve,
        RespuestasRef.encuestaref_cve RespuestasRef__id,
        Evaluacion.evaluacion_cve RespuestasRef__evaluacion_id,
        Evaluacion.evaluacion_nom RespuestasRef__evaluacion,
        Pregunta.pregunta_nom RespuestasRef__pregunta,
        Respuesta.opcpre_nom RespuestasRef__respuesta
        FROM tencuestaref RespuestasRef
        INNER JOIN tevaluacion Evaluacion ON (
          RespuestasRef.evaluacion_cve = Evaluacion.evaluacion_cve
        )
        INNER JOIN tevaluapreg Pregunta ON (
          RespuestasRef.pregunta_cve = Pregunta.pregunta_cve
        )
        INNER JOIN topcpreguntas Respuesta ON (
          RespuestasRef.respuesta_cve = Respuesta.opcpre_cve
        )
        WHERE RespuestasRef.refcan_cve IN ({$__cakeID__$})'
    )
  );


    public function existeEmail($candidato_cve=0,$refcan_cve=null,$email_user=null,$email=null ){
      $conditions = array(
          'candidato_cve' => $candidato_cve,
          'refcan_mail' => $email
      );

      if($refcan_cve){
        $conditions['refcan_cve !='] =$refcan_cve;

      }
      return  !$this->hasAny($conditions)  &&    $email_user !== $email  ;
    }

    public function existeNumero($candidato_cve,$refcan_cve=null,$numero=null){
            $conditions = array(
          'candidato_cve' => $candidato_cve,
          'refcan_tel' => $numero
      );
      if($refcan_cve){
        $conditions['refcan_cve !='] =$refcan_cve;

      }

      return  !$this->hasAny($conditions)  ;
    }


    public function beforeSaveData($id=null){
      $this->id=$id;
      $this->oldData=$this->read();

    }




    public function afterSave($created, $options = array()) {
        parent::afterSave($created, $options);
        $datan=$this->read();
         $this->change_mail=  $created  || (!empty($this->oldData) &&$datan[$this->alias]['refcan_mail'] != $this->oldData[$this->alias]['refcan_mail']);
  }



}
<?php

App::uses('AppModel', 'Model');
App::uses('CakeEvent', 'Event');
App::uses('MensajeListener', 'Event');

class Mensaje extends AppModel {
  public $actsAs = array('Containable');

  public $useTable = 'tmensajes';

  public $primaryKey = 'msj_cve';

  public $hasOne = array(
    'MensajeData' => array(
      'className' => 'MensajeUsuario',
      'foreignKey' => 'msj_cve',
      'type' => 'INNER'
    ),
    'MensajeOferta'=>array(
        'className' => "MensajeOferta",
        "foreignKey" => "msj_cve",
        "type" => 'LEFT'
      )
  );

  public $hasMany = array(
    'Receptores' => array(
      'className' => 'MensajeUsuario',
      'foreignKey' => 'msj_cve'
    ),
    'ReceptorEmpresa' => array(
      'className' => 'MensajeUsuario',
      'foreignKey' => 'msj_cve',
      'finderQuery' => 'SELECT
        ReceptorEmpresa.msj_cve,
        ReceptorEmpresa.receptor_cve,
        ReceptorEmpresa.receptor_tipo,
        ReceptorEmpresa.msj_leido,
        Cuenta.cu_sesion Cuenta__email,
        (Contacto.con_nombre || \' \' || Contacto.con_paterno || \' \' || Contacto.con_materno) Cuenta__nombre
          FROM treceptormsj ReceptorEmpresa INNER JOIN tcuentausuario Cuenta ON (
            Cuenta.cu_cve = ReceptorEmpresa.receptor_cve
          ) INNER JOIN tcontacto Contacto ON (
            Contacto.cu_cve = ReceptorEmpresa.receptor_cve
          )
          WHERE ReceptorEmpresa.receptor_tipo = 0 AND
            ReceptorEmpresa.msj_cve IN ({$__cakeID__$})'
    ),
    'ReceptorCandidato' => array(
      'className' => 'MensajeUsuario',
      'foreignKey' => 'msj_cve',
      'finderQuery' => 'SELECT
        ReceptorCandidato.msj_cve,
        ReceptorCandidato.receptor_cve,
        ReceptorCandidato.receptor_tipo,
        ReceptorCandidato.msj_leido,
        Cuenta.cc_email Cuenta__email,
        (Contacto.candidato_nom || \' \' || Contacto.candidato_pat || \' \' || Contacto.candidato_mat) Cuenta__nombre
          FROM treceptormsj ReceptorCandidato INNER JOIN tcuentacandidato Cuenta ON (
            Cuenta.candidato_cve = ReceptorCandidato.receptor_cve
          ) INNER JOIN tcandidato Contacto ON (
            Contacto.candidato_cve = ReceptorCandidato.receptor_cve
          )
          WHERE ReceptorCandidato.receptor_tipo = 1 AND
            ReceptorCandidato.msj_cve IN ({$__cakeID__$})'
    ),
  );

  public $validate = array(
    'msj_asunto' => array(
      'required' => array(
        'rule' => 'notEmpty',
        'required' => true,
        'message' => 'Asunto del mensaje es requerido'
      )
    ),
    'msj_texto' => array(
      'required' => array(
        'rule' => 'notEmpty',
        'required' => true,
        'message' => 'No puedes enviar un mensaje vacío.'
      )
    ),
  );
  public $type=array(
        "normal" => 0,
        "oferta" =>1
    );

  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);

    $this->virtualFields = array(
      'created_order' => " to_char($this->alias.created,'YYYY/MM/DD hh24:mi:ss')",
      'marcar' => "decode($this->alias.msj_importante,NULL,'','error')"
    );

    $listener = new MensajeListener();
    $this->getEventManager()->attach($listener);
  }

  public $findMethods = array('all_data' => true, 'recibidos' => true, 'enviados' => true);

  public $userType = array(
    'empresa' => 0,
    'candidato' => 1,
    'admin' => 100
  );

  private function formatUsuarios($data) {
    $users = [];

    if (!empty($data['usuarios']) && is_array($data['usuarios'])) {
      foreach ($data['usuarios'] as $user_id) {
        $users[] = array(
          'receptor_tipo' => 0,
          'receptor_cve' => $user_id,
          'msj_leido' => 0,
          'msj_status' => 0
        );
      }
    }

    if (!empty($data['candidatos']) && is_array($data['candidatos'])) {
      foreach ($data['candidatos'] as $candidato_id) {
        $users[] = array(
          'receptor_tipo' => 1,
          'receptor_cve' => $candidato_id,
          'msj_leido' => 0,
          'msj_status' => 0
        );
      }
    }

    return $users;

  }

  protected function _findEnviados($state, $query, $results = array()) {
    if ($state === 'before') {
      $status= empty($query['status']) ? 0 : $query['status'];
      $query['conditions'][] = array(
        'Mensaje.emisor_cve' => $query['fromUser'],
        'Mensaje.emisor_tipo' => $this->userType[$query['userType']],
        'Mensaje.msj_status' => $status
      );

      $query['contain'] = array(
        'ReceptorEmpresa',
        'ReceptorCandidato',        
        'MensajeOferta'
      );

      $query['recursive'] = -1;

      return $query;
    }

    return $results;
  }

  /**
   * Búsqueda de los mensajes recibidos del usuario.
   * @param  [type] $state   [description]
   * @param  [type] $query   [description]
   * @param  array  $results [description]
   * @return [type]          [description]
   */
  protected function _findRecibidos($state, $query, $results = array()) {
    if ($state === 'before') {
      $status= empty($query['status']) ? 0 : $query['status'];

      $conditions = array(
        'MensajeData.receptor_cve' => $query['toUser'],
        'MensajeData.receptor_tipo' => $this->userType[$query['userType']],
        'MensajeData.msj_status' => $status
      );

      if (!empty($query['mensaje'])) {
        $conditions['MensajeData.receptormsj_cve'] = $query['mensaje'];
      }

      $query['contain'] = array(
        'MensajeData' => array(
          'conditions' => $conditions,
        ),
        'MensajeOferta'
      );

      $query['order'] = array(
        'Mensaje.created' => 'DESC'
      );
      if(isset($query['is_importante'])  ){
        $query['conditions'] =array(
                                    'msj_importante' => $query['is_importante'] ? 1:0
          );

      }

      $query['recursive'] = -1;
      return $query;
    }

    $users = array(
      'empresas' => array(),
      'candidatos' => array(),
    );

    foreach ($results as $key => $value) {
      $userType = $value[$this->alias]['emisor_tipo'];
      $userId = $value[$this->alias]['emisor_cve'];

      if ((int)$userType === 0) { // Es empresa
        $users['empresas'][$userId] = true;
      } else {                    // Es candidato
        $users['candidatos'][$userId] = true;
      }
    }
    $usuariosEmpresa = !empty($users['empresas']) ? ClassRegistry::init('UsuarioEmpresa')->find('data', array(
      'fields' => array(
        'UsuarioEmpresa.cu_sesion Contacto__email',
        'UsuarioEmpresa.cu_cve    Contacto__cu_cve',
        "Contacto.con_nombre ||' ' ||Contacto.con_paterno||' '||Contacto.con_materno Contacto__nombre"
      ),
      'conditions' => array(
        'UsuarioEmpresa.cu_cve' => array_keys($users['empresas'])
      ),
      'recursive' => -1
    )) : array();



    $usuariosCandidato = !empty($users['candidatos']) ? ClassRegistry::init('CandidatoEmpresa')->find('basic_info', array(
      'fields' => array(
        '(CandidatoEmpresa.candidato_nom || \' \' || CandidatoEmpresa.candidato_pat || \' \' || CandidatoEmpresa.candidato_mat) Cuenta__nombre',
      ),
      'conditions' => array(
        'CandidatoEmpresa.candidato_cve' => array_keys($users['candidatos'])
      ),
      'recursive' => -1
    )) : array();

    foreach ($results as $key => $value) {
      $userType = $value[$this->alias]['emisor_tipo'];
      $userId = $value[$this->alias]['emisor_cve'];
      if ((int)$userType === 0) { // Es empresa
        $user = current(Hash::extract($usuariosEmpresa, "{n}.Contacto[cu_cve=$userId]"));
      } else {                    // Es candidato
        $user = current(Hash::extract($usuariosCandidato, "{n}.Cuenta[candidato_cve=$userId]"));
      }

      $results[$key]['Emisor'] = $user;
    }

    return $results;
  }

  protected function  _findAll_data($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['order'] = array(
        'Mensaje.created' => 'DESC'
      );
      $query['recursive'] = -1;
      return $query;
    }
    return $results;
  }

  public function is_importante($receptormsj_cve=null){
      $recibido=$this->Receptores;
      $recibido->id=$receptormsj_cve;
      $recibido->recursive=-1;
      $idMsj= $recibido->read()[$recibido->alias]['msj_cve'];
      $this->recursive=-1;
      $is_importante=$this->find("first",array("conditions"=>array('msj_cve' => $idMsj )))[$this->alias]['msj_importante'];
      return $is_importante == "1";

  }

  public function getStats($userId = null,$role='empresa') {
    $stats = $this->find('first', array(
      'fields' => array(
        'COUNT(CASE WHEN Mensaje.msj_importante = 1 AND R.msj_status = 0 AND R.msj_leido = 0 THEN 1 END) importantes',
        'COUNT(CASE WHEN R.msj_status = 0 AND R.msj_leido = 0 THEN 1 END) recibidos',
        'COUNT(CASE WHEN R.msj_status = -1 THEN 1 END) eliminados',
        'COUNT(CASE WHEN Mensaje.emisor_tipo = ' . $this->userType[$role] . ' AND Mensaje.emisor_cve = ' . $userId . ' THEN 1 END) enviados',
      ),
      'joins' => array(
        array(
          'table' => 'treceptormsj',
          'alias' => 'R',
          'type' => 'LEFT',
          'conditions' => array(
            'Mensaje.msj_cve = R.msj_cve',
            'R.receptor_cve' => $userId,
            'R.receptor_tipo' => $this->userType[$role]
          )
        )
      ),
      'recursive' => -1
    ));

    return reset($stats);
  }

  public function archivar($mensajeId, $status = 0) {
    $this->id = $mensajeId;
    return $this->saveField('msj_status', $status, false);
  }

  public function cambiaStatus($receptormsj_cve,$field="status",$status){

      $field= $field =="leido" ? "msj_leido" :"msj_status";

      return $this->MensajeData->cambiaStatus($receptormsj_cve,$field,$status);

  }

  /**
   * Guarda mensaje.
   * NOTA: Los mensajes ya no pueden ser enviados de reclutador a reclutador, pero se dejó la opción de guardar
   * a reclutadores para mantener compatibilidad con MensajeCanController.php
   * @param  [type] $data [description]
   * @return [type]       [description]
   */
  public function saveMensaje ($data) {

    $usuarios = isset($data[$this->alias]['receptores'])
      ? json_decode($data[$this->alias]['receptores'])
      : array();
    $candidatos = isset($data[$this->alias]['c_receptores'])
      ? json_decode($data[$this->alias]['c_receptores'])
      : array();
    $data['Receptores'] = $this->formatUsuarios(
      array(
        'usuarios' => $usuarios,
        'candidatos' => $candidatos
      )
    );
    $data[$this->alias]['msj_status'] = 0;
    $data[$this->alias]['tipomsj_cve']=  isset ($data[$this->alias]['tipo']) && !empty($data[$this->alias]['tipo']) ? (int)$data[$this->alias]['tipo']:0;         
    if ($success = $this->saveAll($data)) {     
      $this->guardarMensajeOferta($data);
      $id = $this->getLastInsertId();
      $data = $this->get($id, array(
        'contain' => array(
          'Receptores'
        )
      ));

      $event = new CakeEvent('Model.Mensaje.created', $this, array(
        'id' => $id,
        'data' => $data //[$this->alias]
      ));

      $this->getEventManager()->dispatch($event);
    }

    return $success;
  }
     /*
          verificamos que tipo de mensaje es: si es un mensaje de ofertas se agregara la realacion a la que pertenece dicha oferta
        */
  private function guardarMensajeOferta($data){ 
    if(  $data[$this->alias]['tipomsj_cve'] === $this->type['oferta']){
      $msj_cvesup=$data[$this->alias]['superior'];
      $ofertxmensaje=ClassRegistry::init("MensajeOferta");
      $oferta_cve=isset($data[$this->alias]['oferta_cve']) && !empty($data[$this->alias]['oferta_cve']) ? $data[$this->alias]['oferta_cve'] :  
      $ofertxmensaje->find("first",array(
        "conditions" => array(
          "MensajeOferta.msj_cve" => $msj_cvesup
          ),
        'recursive' =>-1,
        "fields" =>array(
          "MensajeOferta.oferta_cve"
          )
        ))['MensajeOferta']['oferta_cve'];

 
      $ofertxmensaje->create();
      $publico=isset($data[$this->alias]['publico'])? $data[$this->alias]['publico']: "N" ;
      $info=$ofertxmensaje->save(array(
        "MensajeOferta" => array(
          "msj_cve"=>$this->id,
          "oferta_cve"=>$oferta_cve,
          "msjxoferta_public" =>  $publico,
          "msj_cvesup" => $msj_cvesup
          )
        ),false);
      $ofertxmensaje->updateAll(array(
        "msjxoferta_public" => "'$publico'"
        ),array( 
        "msj_cve" => $msj_cvesup
        ));                    
        return $this->id;

    }
        return false;
  }
  public function afterFind($results, $primary = false) {

    foreach ($results as $key => $value) {
        if(isset($value['MensajeOferta']) &&  $value['MensajeOferta']['msj_cve'] ==null ){            
          $results[$key]['MensajeOferta']=array();
        }
    }

    return $results;
  }


  public function isOwnedBy($userId, $modelId = null, $userType = null) {
    return parent::isOwnedBy($userId, $modelId, array(
      'userKey' => 'emisor_cve',
      'conditions' => array(
        $this->alias . '.emisor_tipo' => $this->userType[$userType]
      )
    ));
  }
}
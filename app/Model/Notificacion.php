<?php

App::uses('AppModel', 'Model');
App::uses('CakeEvent', 'Event');

class Notificacion extends AppModel {

  /**
   * Utiliza el comportamiento: Containable
   * @var array
   */
  public $actsAs = array('Containable');

  /**
   * tabla
   * @var string
   */
  public $useTable = 'tnotificaciones';

  /**
   * Llave primaria
   * @var string
   */
  public $primaryKey = 'notificacion_cve';

  public $allSavedData = array();

  public $types = array(
    'mensaje' => 1,
    'evento' => 2,
    'evaluacion' => 3,
    'notificacion' => 4
  );

  public $typeUser=array(
    'empresa' => 0,
    'candidato' => 1,
    'admin' => -1
  );

  public $findMethods = array(
    'all_info' => true
  );

  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);

    $this->virtualFields = array(
      'tipo' => "decode($this->alias.notificacion_tipo,1,'mensaje',2,'evento',3,'evaluacion','notificacion')",
      'icon' => "decode($this->alias.notificacion_status,0,'warning-sign',1,'ok-circle',2,'minus-sign','')",
      'clazz' => "decode($this->alias.notificacion_status,0,'advertencia',1,'aceptada',2,'finalizada','')"
    );
  }

  public function leido($id = null, $leido = 1) {
    if ($id == null) {
      return false;
    }
    $this->id = $id;
    $result= $this->saveField('notificacion_leido', $leido);
    $this->recursive=-1;
    $this->read(null,$id);
    $info=$this->data["$this->alias"];
    if($this->types['mensaje'] == $info['notificacion_tipo']){
      $tipo=$info['receptor_tipo'];
      $receptor_id=$info['receptor_cve'];
      $_id=$info['notificacion_id'];
      $msj=ClassRegistry::init("MensajeUsuario");
         $rs=$msj->find("first",array(
        "recursive" =>-1,
        "conditions" => array(
                "receptor_tipo" => $tipo,
                "receptor_cve" =>  $receptor_id,
                "mensaje_cve" => $_id
          )
        ));
        if(!empty($rs)){
          $rs=$rs['MensajeUsuario'];
          $msj->id=$rs['receptormsj_cve'];
          $msj->saveField("msj_leido",(int)$leido);
        }
    }
    return $result;

  }
  public function syn_leido($id ,$tipo){
      $user=CakeSession::read("Auth.User");
      if(empty($user)){
        return;
      }
      $is= isset($user['cu_cve']) ? 'empresa' :'candidato';
      $idUser= $user[ $is=='empresa' ? 'cu_cve':'candidato_cve' ];
      $tipo_receptor=  $is =='empresa' ? 0:1;
      $type=$this->types[$tipo];
      $rs=$this->find("first",array("conditions" =>array(
          "receptor_cve"=>$idUser,
          "receptor_tipo" => $tipo_receptor,
          "notificacion_tipo" => $type,
          "notificacion_leido" => 0,
          "notificacion_id" => $id
        ), "fields" => "$this->primaryKey"));
      if(!empty( $rs )){
           $this->id=$rs[$this->alias][$this->primaryKey];
           $this->saveField("notificacion_leido",1);
      }
  }


  protected function _findAll_info($state, $query, $results = array()){
    $typeUser = isset($this->typeUser[$query['typeUser']]) ? $this->typeUser[$query['typeUser']] : $query['typeUser'];
    if ($state === 'before') {
      $query['conditions'] = array_merge(array(
        'AND' => array(
          "$this->alias.receptor_cve" =>$query['idUser'],
          "$this->alias.created <=" => date('Y-m-d H:i:s'),
          "$this->alias.receptor_tipo" => $typeUser
        ),
        $query['conditions']
      ));

      $query['order'] = array(
        // "$this->alias.notificacion_leido ASC",
        "$this->alias.created DESC"
      );

      $query['joins'] = array(
        array(
          'table' =>'tcuentausuario',
          'alias' => 'Usuario',
          'type' =>'LEFT',
          'fields' => array(
            'Usuario.cu_sesion From__email',
            'Usuario.cu_cve From__id',
          ),
          'conditions' => array(
            "$this->alias.emisor_cve = Usuario.cu_cve",
            "$this->alias.emisor_tipo" => $this->typeUser['empresa']
          )
        ),
        array(
          'table' =>'tcontacto',
          'alias' => 'Contacto',
          'type' =>'LEFT',
          'fields' => array(
            "Contacto.con_nombre ||' '|| Contacto.con_paterno From__nombre",
          ),
          'conditions' => array(
            'Contacto.cu_cve = Usuario.cu_cve'
          )
        ),
        array(
          'table' =>'tusuxcia',
          'alias' => 'USUXCIA',
          'type' =>'LEFT',
          'fields' => array(),
          'conditions' => array(
            'Usuario.cu_cve = USUXCIA.cu_cve'
          )
        ),
        array(
          'table' =>'tcompania',
          'alias' => 'Cia',
          'type' =>'LEFT',
          'fields' => array(
            'Cia.cia_cve  From__cia_cve',
            'Cia.cia_nombre From__cia_nombre'
          ),
          'conditions' => array(
            'USUXCIA.cia_cve = Cia.cia_cve'
          )
        ),
        array(
          'table' =>'tcandidato',
          'alias' => 'Candidato',
          'type' =>'LEFT',
          'fields' => array(
            "Candidato.candidato_nom ||' '||Candidato.candidato_pat||' '||Candidato.candidato_mat From__nombre"
          ),
          'conditions' => array(
            "$this->alias.emisor_cve = Candidato.candidato_cve",
            "$this->alias.emisor_tipo" => $this->typeUser['candidato']
          )
        ),
        array(
          'table' =>'tcuentacandidato',
          'alias' => 'UsuCan',
          'type' =>'LEFT',
          'fields' => array(
            'UsuCan.cc_email From__email',
            'UsuCan.candidato_cve From__id'
          ),
          'conditions' => array(
           'Candidato.candidato_cve = UsuCan.candidato_cve'
          )
        )
      );

      if (isset($query['type']) && !empty($query['type'])) {
        if ($query['typeUser'] === 'candidato' && $query['type'] === 'notificacion') {
          $query['conditions']['AND']["$this->alias.notificacion_tipo"] = array(
            $this->types['notificacion'],
            $this->types['evaluacion']
          );
        } else {
          $type = !empty($this->types[$query['type']]) ? $this->types[$query['type']] : null;
          $query['conditions']['AND']["$this->alias.notificacion_tipo"] = $type;
        }
      }

      return $query;
    }

    $totales = array();
    if(!empty($query['with_totales']) /*|| $query['with_totales'] === true*/) {
      $totales = $this->totales($query['typeUser'], $query['idUser']);
    }

    return compact('totales', 'results');
  }

  public function isOwner($id = null, $idUser = null, $type = 'empresa') {
    return $this->hasAny(array(
      "$this->alias.receptor_tipo" => $this->typeUser[$type],
      "$this->alias.receptor_cve" => $idUser,
      "$this->alias.notificacion_cve" => $id
    ));
  }

  public function totales($typeUser, $idUser) {
    $typeUser = $this->typeUser[$typeUser];
    // Empresas y admins.
    $fields = $typeUser < 1 ? array(
      "COUNT(CASE WHEN $this->alias.notificacion_leido=0 THEN 1 END) notificacion",
      "COUNT(1) notificacion_total"
    ) : array(
      "COUNT(CASE WHEN $this->alias.notificacion_tipo = 1 AND $this->alias.notificacion_leido = 0 THEN 1 END) mensaje",
      "COUNT(CASE WHEN $this->alias.notificacion_tipo = 2 AND $this->alias.notificacion_leido = 0 THEN 1 END) evento",
      "COUNT(CASE WHEN $this->alias.notificacion_tipo >= 3 AND $this->alias.notificacion_leido = 0 THEN 1 END) notificacion",
      "COUNT(CASE WHEN $this->alias.notificacion_tipo = 1 THEN 1 END) mensaje_total",
      "COUNT(CASE WHEN $this->alias.notificacion_tipo = 2 THEN 1 END) evento_total",
      "COUNT(CASE WHEN $this->alias.notificacion_tipo >= 3 THEN 1 END) notificacion_total"
    );

    $totales = $this->find('first', array(
      'fields' => $fields,
      'conditions' => array(
        "$this->alias.receptor_cve" => $idUser,
        "$this->alias.receptor_tipo" => $typeUser,
        "$this->alias.created <=" => date('Y-m-d H:i:s'),
      )
    ));

    return !empty($totales) ? $totales[0] : $totales;
  }

  public function notificaciones($userId, $role, $type = array(), $limit = 10) {
    $data = array();

    $conditions = array(
      $this->alias . '.notificacion_leido' => 0
    );

    if ($type === true) {
      return $this->get('all_info', array(
        'idUser' => $userId,
        'typeUser' => $role,
        'limit' => $limit,
        'with_totales' => true,
        'conditions' => $conditions
      ));
    }

    if (empty($type) || in_array('mensaje', $type)) {
      $rs = $this->get('all_info', array(
        'idUser' => $userId,
        'typeUser' => $role,
        'limit' => $limit,
        'type' => 'mensaje',
        'conditions' => $conditions
        // 'afterFind' => 'format',
      ));

      $data['mensaje'] = $rs['results'];
    }

    if (empty($type) || in_array('notificacion', $type)) {
      $rs = $this->get('all_info', array(
        'idUser' => $userId,
        'typeUser' => $role,
        'limit' => $limit,
        'type' => 'notificacion',
        'conditions' => $conditions
        // 'afterFind' => 'format',
      ));

      $data['notificacion'] = $rs['results'];
    }

    if (empty($type) || in_array('evento', $type)) {
      $rs = $this->get('all_info', array(
        'idUser' => $userId,
        'typeUser' => $role,
        'limit' => $limit,
        'type' => 'evento',
        'conditions' => $conditions
        // 'afterFind' => 'format',
      ));

      $data['evento'] = $rs['results'];
    }

    if (empty($type) || in_array('totales', $type)) {
      $data['totales'] = $this->totales($role, $userId);
    }

    return $data;
  }

  public function afterSave($created, $options = array()) {
    if ($created) {
      $this->allSavedData[] = array(
        'id' => $this->id,
        'data' => $this->data
      );
    }
  }
}
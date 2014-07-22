<?php

App::uses('AppModel', 'Model');
App::uses('CakeEvent', 'Event');
App::uses('PostulacionListener', 'Event');
App::uses('Email', 'Utility');

class Postulacion extends AppModel {
  public $useTable = 'tpostulacionxoferta';
  public $name = 'Postulacion';
  public $primaryKey = "postulacion_cve";
  public $actsAs = array('Containable');
  public $belongsTo = array(
    'Oferta' => array(
      'className' => 'Oferta',
      'foreignKey' => 'oferta_cve'
    )
  );

  /*
    postulacion_status
    0 abierta
    1 proceso de seleccion
    2 Finalizada
  */
  public $findMethods = array('all_info' => true);

  protected function _findAll_info($state, $query, $results = array()) {
    if ($state == 'before') {
      $query['joins'] =$this->joins['empresa'];
      $query['conditions']= array(
        "$this->alias.candidato_cve" => $query['idCandidato']
      );
      return $query;
    }
    return $results ;
  }


  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);

    $this->virtualFields= array(
      'fecha' => "to_char($this->alias.created,'DD/MM/YYYY')",
      'status' => "decode($this->alias.postulacion_status,0,'Abierta',1,'En procesos de selección',2,'Finalizada')"
    );

    $this->joins = array(
      'empresa' => array(
        array(
          'alias' => 'Empresa',
          'fields' => array(
            'Empresa.cia_nombre Postulacion__empresa'
          ),
          'conditions' => array(
            'Empresa.cia_cve = ' . $this->alias . '.cia_cve'
          ),
          'table' => 'tcompania',
          'type' => 'LEFT'
        )
      )
    );

    $listener = new PostulacionListener();
    $this->getEventManager()->attach($listener);
  }


  public function num_postulaciones($id=null){
    return $this->find('count', array(
      'conditions' => array(
        "$this->alias.postulacion_status" => 0,
        "$this->alias.candidato_cve" => $id
      )
    ));
  }

  public function postularse($id=null,$idCandidato=null ){

    if($id==null || $idCandidato==null ){
            return array("error","verifique la sesion");

    }

        $oferta=$this->Oferta->find("oferta",array( "idOferta" => $id));


        if(empty($oferta)){
            return array("error","Oferta no encontrada");
        }


      $datos['Postulacion'] = array(
                                            "oferta_cve" =>    $oferta['Oferta']["oferta_cve"],
                                            "cu_cve" =>    $oferta['Oferta']["cu_cve"],
                                            "cia_cve" =>    $oferta['Oferta']["cia_cve"],
                                            "candidato_cve" => $idCandidato,
                                            "postulacion_status" => $oferta['Oferta']['oferta_inactiva']

        );
    $this->create();
    $this->num_postulaciones=$oferta['Oferta']['oferta_postulaciones'];
      if( $rs=$this->save($datos)){

      return true;
    }

    return false;

  }

  public function quitar($idOferta=null,$idCandidato=null ){
    if ($idOferta == null || $idCandidato == null) {
      return false;
    }

    $rest = $this->find('first', array(
      'conditions' => array(
        "$this->alias.candidato_cve" => $idCandidato,
        "$this->alias.oferta_cve" => $idOferta
      )
    ));
    if (empty($rest)) {
      return false;
    }

    $id = $rest[$this->alias][$this->primaryKey];
    if ($this->delete($id)) {
      return  true;
    }
    return false ;
  }


  public function  checaPostulacion($idCia,$idUsuario,$idOFerta,$idCandidato){
    $conditions = array(
      "$this->alias.cia_cve" => $idCia,
      "$this->alias.cu_cve" => $idUsuario,
      "$this->alias.oferta_cve" => $idOFerta,
      "$this->alias.candidato_cve" => $idCandidato
    );
    return !$this->hasAny($conditions);
  }

  public function afterSave($created, $options = array()) {
    if ($created) {
      $event = new CakeEvent('Model.Postulacion.created', $this, array(
        'id' => $this->id,
        'data' => $this->data
      ));

      $this->getEventManager()->dispatch($event);
      $num_postulaciones=$this->find("count",
                    array("conditions"=> array(
                                  "$this->alias.postulacion_status"=>0,
                                  "$this->alias.oferta_cve" => $this->data[$this->alias]['oferta_cve']
                                  )
                    ));
      $num=$this->num_postulaciones;
      if($num_postulaciones % $num == 0  ){
       
        $oferta=$this->Oferta->find("oferta",array( "idOferta" => $this->data[$this->alias]['oferta_cve'], "postulaciones" => array("limit" =>$num ) ));              
        $event = new CakeEvent('Model.Postulacion.send-email', $this, array(
          'oferta' => $oferta,
          'num_postulaciones' =>$num_postulaciones
        ));
        $this->getEventManager()->dispatch($event);        
      } 



    }
  }
}
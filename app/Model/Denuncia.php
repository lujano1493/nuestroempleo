<?php
App::uses('CakeEvent', 'Event');
App::uses('CakeSession', 'Model/Datasource');
App::uses('DenunciaListener', 'Event');

class Denuncia extends AppModel {


  /*
    Status de una denuncia
   */
   const REPORTADA=0;
   const REVISION=1;
   const ACEPTADA=2;
   const DECLINADA=3;   


  /**
   * Nombre del modelo.
   * @var string
   */
  public $name = 'Denuncia';

  /**
   * Llave primaria.
   * @var string
   */
  public $primaryKey = 'denuncia_cve';

  /**
   * Se usará la siguiente tabla.
   * @var string
   */
  public $useTable = 'tdenunciascv';
  /**
   * campo status
   * @var string
   */
  public $statusKey= 'denuncia_status';
  /**
   * segundo campo
   * @var string
   */
  public $secondKey= 'candidato_cve';

  /**
   * campo de Usuario
   */

  public $userKey='cu_cve';

  public $actsAs = array(
    'Containable'
  );

  public $findMethods = array(
    'data' => true
  );

  protected $joins = array(
    'motivo' => array(
      'alias' => 'Catalogo',
      'conditions' => array(
        'Catalogo.ref_opcgpo' => 'MOTIVO_CVE',
        'Catalogo.opcion_valor = Denuncia.motivo_cve'
      ),
      'fields' => array('Catalogo.opcion_texto Denuncia__motivo_texto'),
      'table' => 'tcatalogo',
      'type' => 'LEFT',
    
)  );

  public $knows = array(
    'CandidatoUsuario'
  );

  public $belongsTo = array(
    'UsuarioEmpresa' => array(
      'className'    => 'UsuarioEmpresa',
      'foreignKey'   => 'cu_cve',
      'fields' => array(
        'cu_cve', 'cu_sesion', 'cu_status', 'per_cve', 'keycode', 'created'
      )
    ),
     'CandidatoUsuario' => array(
      'className'    => 'CandidatoUsuario',
      'foreignKey'   => 'candidato_cve',
      'fields' => array(
        'candidato_cve', 'cc_email', 'cc_status'
      )
    ),
      'Candidato'=>array(
          'className'=> 'Candidato',
          'foreignKey' => 'candidato_cve'
        )
  );



  public $validate = array(
    'detalles' => array(
      'required' => array(
        'rule' => 'notEmpty',
        'required' => true,
        'message' => 'Ingresa los detalles.'
      ),
      'maxlength' => array(
        'rule' => array('maxLength', 4000),
        'message' => 'El máximo de caracteres es 4000.'
      )
    ),
  );

  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);
    // Agrega InvitacionListener al manejador de eventos.
    $listener = new DenunciaListener();
    $this->getEventManager()->attach($listener);
  }

  public function guardar($candidatoId, $data, $userId, $ciaId) {
    $data[$this->alias]['cu_cve'] = $userId;
    $data[$this->alias]['cia_cve'] = $ciaId;
    $data[$this->alias]['candidato_cve'] = $candidatoId;
    $data[$this->alias]['denuncia_status'] = 0;

    $this->create();
    return $this->save($data);
  }

  protected function _findData($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['joins'] = array($this->joins['motivo']);
      $query['contain'] = array(
        'UsuarioEmpresa' => array(
          'Contacto'
        ),
        'CandidatoUsuario',
        'Candidato'
      );

      $query['recursive'] = -1;
      $query['order']= array("$this->alias.$this->primaryKey DESC");
      return $query;
    }

    return $results;
  }

  /**
   * Después de guardar cada denuncia dispara el evento.
   * @param  [type] $created [description]
   * @param  array  $options [description]
   * @return [type]          [description]
   */
  public function afterSave($created, $options = array()) {
    if ($created) {
      if (!empty($this->data[$this->alias]['candidato_cve'])) {
        $id = $this->data[$this->alias]['candidato_cve'];
        $candidato = $this->CandidatoUsuario->get($id, array(
          'recursive' => -1,
          'contain' => array(
            'Candidato'
          )
        ));

        $this->data[$this->alias]['motivo_texto'] = ClassRegistry::init('Catalogo')->getText('MOTIVO_CVE', $this->data[$this->alias]['motivo_cve']);

        $event = new CakeEvent('Model.Denuncia.created', $this, array(
          'id' => $this->id,
          'data' => $this->data[$this->alias],
          'candidato' => $candidato
        ));

        !empty($candidato) && $this->getEventManager()->dispatch($event);
        $this->actualiza_status();

        $idSecond=$this->data[$this->alias][$this->secondKey];
        $num= $this->numeroDenuncias($idSecond);
        if($num === 3 ){
          $this->CandidatoUsuario->save(array(
            "CandidatoUsuario"=>array(
                  $this->secondKey=>$idSecond,
                  "cc_status"=> -2
              )
            ),false);        


        }

      }


    }
  }

  public  function numeroDenuncias($idSecond){
    return $this->find("count",array(
          "conditions" => array(
              "$this->alias.$this->secondKey"=> $idSecond,
              "$this->alias.$this->statusKey !=3"
            )));
  }

   public function verifica_status($idDenunciado,$idUser){
    return $this->hasAny(array(
      "$this->alias.$this->secondKey"=> $idDenunciado,
      "$this->alias.$this->userKey"=> $idUser,
      "$this->alias.$this->statusKey !=3" 
      ));
  }
   private function actualiza_status(){
      $rs= $this->read()[$this->alias];
      $status=$rs[$this->statusKey];
      $second=$rs[$this->secondKey];
      $this->updateAll(array(
            $this->statusKey=> $status
          ),array(
            "$this->alias.$this->secondKey" =>$second
        )
      );    



    //   if( !empty($this->data[$this->alias][$this->secondKey])){
    //       $status=$this->find("all", array(
    //       "conditions" => array(
    //         "$this->alias.$this->secondKey" => $this->data[$this->alias][$this->secondKey],
    //         "$this->alias.$this->statusKey != 3" 
    //         ),
    //         "fields" => array(
    //           "$this->alias.$this->statusKey"
    //         ),
    //         "order" => array(              
    //               "$this->alias.$this->primaryKey desc"
    //           )
    //          ));        
    //       if(!empty($status) && count($status) > 1){
    //         $status_cve=$status[0][$this->alias][$this->statusKey];
    //         $this->updateAll(array(
    //               $this->statusKey=> $status_cve
    //             ),array(
    //               "$this->alias.$this->secondKey" => $this->data[$this->alias][$this->secondKey]
    //             ));        
    //     }

    // }
  }
  
/**
 * antes de guardar la denuncia se verifica si anteriormente se habia denunciado 
 * en el caso de que haya una denucnia previa se obtiene el status en el que esta.
 * @param  array  $options [description]
 * @return [type]          regresa un verdadero
 */
  public function beforeSave($options = array()) {


    return parent::beforeSave($options);
  }



  public function getReportedUsers($ciaId) {
    $users = $this->find('all', array(
      'fields' => array(
        'DISTINCT candidato_cve'
      ),
      'conditions' => array(
        'cia_cve' => $ciaId,
        'denuncia_status <' => 3
      )
    ));

    return Hash::extract($users, '{n}.Denuncia.candidato_cve');
  }
/**
 * cambiamos el status para todas las denuncias del mismo candidato
 * 
 */
 
/**
   * cambiamos el estatus de todas la denuncias realizadas a la misma oferta
   * @param  integer $status status 
   * @param  integer $id     id de la denuncia
   * @return [type]         [description]
   */
  public function change_status($status, $id = null) {  
      $user = CakeSession::read('Auth.User');
      $this->updateAll(array(
      "$this->alias.$this->statusKey" => $status,
      "$this->alias.cu_cve_rev" => $user['cu_cve'] 
      ), array(
            $this->secondKey=> $id
      ));   
    if($status== self::ACEPTADA || $status==self::DECLINADA ){
      $status_denunciado= $status==self::ACEPTADA  ? -2: 1 ;
      $this->CandidatoUsuario->id=$id;
      $this->CandidatoUsuario->saveField("cc_status",$status_denunciado);

      $data=$this->find("data",array(
          "conditions"=>array(
            "$this->alias.$this->secondKey"=>$id
          )
        ));

      foreach ($data as $index => $v) {
          $a=$v[$this->alias];
          $e=$v['UsuarioEmpresa'];
          $u=$v['UsuarioEmpresa']['Contacto'];
          $c=$v['Candidato'];
          $cc=$v['CandidatoUsuario'];
          $event = new CakeEvent('Model.Denuncia.status', $this, array(
          'tipo' =>"empresa",
          'resolucion' => $status== self::ACEPTADA ? 'aceptada':'declinada',
          'data' => array(
                        'correo' => $e['cu_sesion'],
                        'nombre' =>"$c[candidato_nom] $c[candidato_pat] $c[candidato_mat]",
                        'fecha' => $a['created'],
                        'motivo' =>$a['motivo_texto'],
                        'detalles' => $a['detalles']
            )
        ));

        $this->getEventManager()->dispatch($event);
        
      }
      
    }  else if($status== self::REVISION){

          $data= $this->Candidato->find('first',array(
                'conditions' => array(
                "candidato_cve" => $id                
                ),
                'recursive' => -1,
                'fields' => array(
                      "Candidato.candidato_perfil Candidato__nombre"
                  )
                ) )['Candidato'];
           $event = new CakeEvent('Model.Denuncia.revision',$this,array(
              'tipo' => 'candidato',
              'nombre' => $data['nombre'],
              'id' => $id
            ));
          $this->getEventManager()->dispatch($event);

    }

  }


}
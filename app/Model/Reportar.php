<?php
App::uses('CakeEvent', 'Event');
App::uses('DenunciaListener', 'Event');
App::uses('CakeSession', 'Model/Datasource');
class Reportar extends AppModel {

    /*
    Status de una denuncia
   */
   const REPORTADA=0;
   const REVISION=1;
   const ACEPTADA=2;
   const DECLINADA=3;   

/**
 * comportamiento
 * @var array
 */
    public $actsAs = array(
      'Containable'
      );


  /**
   * Nombre del modelo.
   * @var string
   */
  public $name = 'Reportar';

  /**
   * Llave primaria.
   * @var string
   */
  public $primaryKey = 'denuncia_cve';
  /**
   * llave de status
   * @var string
   */
  public $statusKey ="status_cve";
  /**
   * segundo campo
   * @var string
   */
  public $secondKey ="oferta_cve";

  /**
   * Se usará la siguiente tabla.
   * @var string tdenunciasoferta
   */
  public $useTable = 'tdenunciasoferta';

  /**
   * campo de Usuario
   */

  public $userKey='candidato_cve';

    public $belongsTo = array(
      'Candidato' => array(
        'className'    => 'Candidato',
        'foreignKey'   => 'candidato_cve'
        ),
      'Cuenta'=>array(
        'className' => 'CandidatoUsuario',
        'foreignKey' => 'candidato_cve'
        ),
      'Oferta' => array(
        'className'    => 'Oferta',
        'foreignKey'   => 'oferta_cve'
        )
    );
    public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);

    // Agrega InvitacionListener al manejador de eventos.
    $listener = new DenunciaListener();
    $this->getEventManager()->attach($listener);
  }

  public function guardar($info=array()) {
    $this->create();
    $info_m = $info[$this->alias];
    $data = array(
      $this->alias => array(
        "candidato_cve" => $info['idCandidato'],
        "oferta_cve" => $info['idOferta'],
        "causa_cve" => $info_m["causa"],
        "detalles" => $info_m['detalles'],
        "status_cve" => 0
      )
    );

    $data = $this->save($data);    
    return true;
  }
    /**
   * Después de guardar cada denuncia dispara el evento.
   * @param  [type] $created [description]
   * @param  array  $options [description]
   * @return [type]          [description]
   */
  public function afterSave($created, $options = array()) {
    if ($created) {    
        $data= $this->find("reporte");
        $id=$this->id;
        $event = new CakeEvent('Model.Reportar.created', $this,compact("data","id"));
        $this->getEventManager()->dispatch($event);      
        $this->actualiza_status();
        $idSecond=$this->data[$this->alias][$this->secondKey];
        $num= $this->numeroDenuncias($idSecond);
        if($num == 2 ){              
          $this->Oferta->save(
            array(
            "Oferta"=>array(
              $this->secondKey=>$idSecond,
              "oferta_inactiva"=>-2
            )
          ),false);        
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
    public function estaDenunciado($idOferta=null){
    return $this->hasAny(
      array(
            "$this->alias.$this->secondKey" => $idOferta,
            "$this->alias.$this->statusKey" => self::ACEPTADA
      ))  ||  !$idOferta;
  }


  public $findMethods = array(
    'reporte' => true,
    'data' => true
  );

  public function joins($joins = array()) {
    $_joins = array(
      'motivo' => array(
        "table" => "tcatalogo",
        "alias" => "Catalogo",
        "type" => "LEFT",
        "conditions" => array(
          "$this->alias.causa_cve = Catalogo.opcion_valor",
          "Catalogo.ref_opcgpo = 'CAUSA_CVE'"
        )
      ),
      'oferta' =>array(
         'table' => 'tofertas',
          'alias'=>'Oferta',
        'type' => 'LEFT',
        'conditions' =>array(
          "$this->alias.oferta_cve = Oferta.oferta_cve" 
        )       

        ),
      'cuentaempresa'=> array(
          'table' => 'tcuentausuario',
          'alias'=>'CuentaEmpresa',
          'type' => 'LEFT',
          'conditions' =>array(
          "Oferta.cu_cve = CuentaEmpresa.cu_cve" 
          )       
        ),
      'contacto' =>array(
        'table' => 'tcontacto',
        'alias'=>'Contacto',
        'type' => 'LEFT',
        'conditions' =>array(
          "Oferta.cu_cve = Contacto.cu_cve" 
        )       
      ),
      'candidato' => array(
           'table' => 'tcandidato',
            'alias'=>'Candidato',
            'type' => 'LEFT',
            'conditions' =>array(
              "$this->alias.candidato_cve = Candidato.candidato_cve" 
            )
          )
    );
    return empty($joins) ? array_values($_joins) : array_values(array_intersect_key($_joins, array_flip(
      (array)$joins
    )));
  }

  protected function _findReporte($state, $query, $results = array()) {
    if ($state == 'before') {
      $query['conditions'] = array(
        "$this->alias.$this->primaryKey" => $this->id
      );

      $query['joins'] = array_merge(
        $this->joins(),
        ClassRegistry::init('Candidato')->joins['direccion']
      );
      $query['recursive'] = -1;
      $query['contain']=array(
          'Cuenta'
        );
      $query['fields'] = array(
        "Catalogo.opcion_texto {$this->alias}__causa",
        "$this->alias.detalles",
        "to_char($this->alias.created,'DD-MM-YYYY') {$this->alias}__fecha",
        "$this->alias.created",
        "Candidato.candidato_nom ||' '||Candidato.candidato_pat||' '||Candidato.candidato_mat {$this->alias}__candidato_nombre",
        "Cuenta.cc_email {$this->alias}__candidato_correo",
        "Candidato.candidato_movil {$this->alias}__candidato_telmovil",
        "Candidato.candidato_tel  {$this->alias}__candidato_tel",
        "Estado.est_nom {$this->alias}__candidato_estado",
        "Ciudad.ciudad_nom {$this->alias}__candidato_ciudad",
        "Oferta.oferta_link {$this->alias}__oferta_link",
        "Oferta.oferta_cve   {$this->alias}__oferta_cve",
        "Oferta.puesto_nom {$this->alias}__puesto_nom",
        "CuentaEmpresa.cu_sesion {$this->alias}__contacto_correo",
        "Contacto.con_nombre || ' ' || Contacto.con_paterno || ' '|| Contacto.con_materno {$this->alias}__contacto_nombre"
      );

      return $query;
    }

    return (empty($results)) ? $results : $results[0][$this->alias];
  }

  protected function _findData($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['joins'] = $this->joins();
      $query['recursive'] = -1;
      $query['contain']=array(
          'Cuenta'
        );
      $query['fields'] = array(
        "$this->alias.denuncia_cve",
        "Catalogo.opcion_texto {$this->alias}__causa",
        "$this->alias.detalles",
        "$this->alias.created",
        "Candidato.candidato_nom||' '||Candidato.candidato_pat||' '||Candidato.candidato_mat {$this->alias}__candidato_nombre",
        "Cuenta.cc_email {$this->alias}__candidato_correo",
        "Candidato.candidato_movil {$this->alias}__candidato_telmovil",
        "Candidato.candidato_tel  {$this->alias}__candidato_tel",
        "Oferta.oferta_cve {$this->alias}__oferta_id",
        "Oferta.puesto_nom {$this->alias}__oferta_nombre",
        "$this->alias.status_cve {$this->alias}__status"
      );

      $query['recursive'] = -1;
      $query['order']= array("$this->alias.$this->primaryKey DESC");

      return $query;
    }

    return $results;
  }

  public function getReportedUsers($idUser){
   $result= $this->find("all",array(
      "fields"=> array(
        'DISTINCT oferta_cve'
      ),
      "conditions" =>array(
        "$this->alias.$this->userKey" =>$idUser,
        "$this->alias.$this->statusKey <" => 3
        )
      )
    );    
    return Hash::extract($result, '{n}.Reportar.oferta_cve');
  }
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
      $status_denunciado= $status==self::ACEPTADA  ? -2: 0 ;           
      $arr=array(
            "Oferta"=>array(
              "oferta_cve" => $id,             
              "oferta_inactiva"=>$status_denunciado
            )
          );
       if($status===self::DECLINADA ){
          $this->Oferta->contain();
          $this->recursive=-1;
          $nuevafecha=$this->Oferta->read(
            array(
              "to_char(Oferta.oferta_fecfin+(sysdate-Oferta.modified),'YYYY-MM-DD')  Oferta__fecha_nueva",          
              "Oferta.oferta_cve"
               ),$id)['Oferta']['fecha_nueva'];

          $arr["Oferta"]["oferta_fecfin"]=$nuevafecha;
       }
      $this->Oferta->save($arr,false);
      $data=$this->find("data",array(
          "conditions"=>array(
            "$this->alias.$this->secondKey"=>$id
          )
        ));

      foreach ($data as $index => $v) {
          $a=$v[$this->alias];
          $event = new CakeEvent('Model.Denuncia.status', $this, array(
          'tipo' =>"candidato",
          'resolucion' => $status== self::ACEPTADA ? 'aceptada':'declinada',
          'data' => array(
                        'correo' => $a['candidato_correo'],
                        'nombre' =>$a['candidato_nombre'],
                        'puesto_nombre' => $a['oferta_nombre'],
                        'fecha' => $a['created'],
                        'motivo' =>$a['causa'],
                        'detalles' => $a['detalles']
            )
        ));

        $this->getEventManager()->dispatch($event);
        
      }
    }  else if($status== self::REVISION){     
     
          $data= $this->Oferta->find('first',array(
            'conditions' => array(
                "oferta_cve" => $id,            
            ),
            'recursive' => -1,
            'fields' => array(
                  "Oferta.puesto_nom Oferta__nombre"
              )
          )
             )['Oferta'];
           $event = new CakeEvent('Model.Denuncia.revision',$this,array(
              'tipo' => 'oferta',
              'nombre' => $data['nombre'],
              'id' => $id
            ));
          $this->getEventManager()->dispatch($event);

    }

  }
}
<?php

App::uses('AppModel', 'Model');
App::uses('CakeEvent', 'Event');
App::uses('EventoListener', 'Event');

class Evento extends AppModel {

  public $primaryKey = 'evento_cve';

  public $name = 'Evento';

  public $actsAs = array('Containable');

  public $useTable = 'teventos';

  public $micrositio=array();

  public $validate = array(
    'evento_nombre' => array(
      'validateNombre' => array(
        'rule' => 'notEmpty',
        'required' => true,
        'message' => 'Ingresa el nombre del evento.'
      ),
      'maxlength' => array(
        'rule'=> array('maxLength', 250),
        'message' => 'El título debe ser hasta 250 caracteres.'
      ),
    ),
    'title' => array(
      'maxlength' => array(
        'rule'=> array('maxLength', 250),
        'message' => 'El título debe ser hasta 250 caracteres.'
      ),
    ),
    'dir' => array(
      'maxlength' => array(
        'rule'=> array('maxLength', 128),
        'message' => 'La dirección debe ser hasta 128 caracteres.'
      ),
    ),
    'calle' => array(
      'maxlength' => array(
        'rule'=> array('maxLength', 256),
        'message' => 'La calle debe ser hasta 256 caracteres.'
      ),
    ),
    'evento_dir' => array(
      'validateDir' => array(
        'rule' => 'notEmpty',
        'required' => true,
        'message' => 'Ingresa la dirección del evento.'
      ),
      'maxlength' => array(
        'rule'=> array('maxLength', 128),
        'message' => 'La dirección debe ser hasta 128 caracteres.'
      ),
    ),
    'evento_calle' => array(
      'maxlength' => array(
        'rule'=> array('maxLength', 256),
        'message' => 'La calle debe ser hasta 256 caracteres.'
      ),
    ),
    'evento_resena' => array(
      'validateDescrip' => array(
        'rule' => 'notEmpty',
        'required' => true,
        'message' => 'Ingresa la reseña del evento.'
      )
    ),
  );

  public $belongsTo = array(
    'Reclutador' => array(
      'className' => 'UsuarioEmpresa',
      'foreignKey' => 'cu_cve',
    ),
    'Contacto' => array(
      'className' => 'UsuarioEmpresaContacto',
      'foreignKey' => 'cu_cve',
    ),
    'Empresa' => array(
      'className' => 'Empresa',
      'foreignKey'=>'cia_cve'

      )
  );

  public $findMethods = array(
    'cercanos'  => true,
    'all_info' => true,
    'evento' => true,
    'sociales' => true
  );

  private $joins = array(
   'cerca'=> array(
      array(
        'alias' =>'Ciudad',
        'conditions' => array(
          'Ciudad.ciudad_cve = Evento.ciudad_cve'
        ),
        'fields'=> array(
          'Ciudad.ciudad_nom Evento__ciudad_nom'
        ),
        'table' => 'tciudad',
        'type' => 'LEFT'
      ),
      array(
        'alias' =>'Estado',
        'conditions' => array(
          'Estado.est_cve = Ciudad.est_cve'
        ),
        'fields'=> array(
          'Estado.est_cve Evento__est_cve',
          'Estado.est_nom Evento__est_nom'
        ),
        'table' => 'testado',
        'type' => 'LEFT'
      ),
      array(
        'alias' =>'TipoEvento',
        'conditions' => array(
          'TipoEvento.ref_opcgpo = \'TIPO_EVENTO\'',
          'TipoEvento.pais_cve = 1',
          'TipoEvento.opcion_valor = Evento.evento_tipo'
        ),
        'fields'=> array(
          'TipoEvento.opcion_texto Evento__tipo_nombre',
        ),
        'table' => 'tcatalogo',
        'type' => 'LEFT'
      )
    )
  );

  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);

    $this->virtualFields = array(
      'fecha_ini_' => " to_char($this->alias.evento_fecini,'DD/MM/YYYY')",
      'fecha_fin_' => " to_char($this->alias.evento_fecfin,'DD/MM/YYYY')"
    );

    $listener = new EventoListener();
    $this->getEventManager()->attach($listener);
  }

  private function updateDate($date, $days, $minutes) {
    $date = new DateTime($date);
    $dateInterval = new DateInterval('P' . abs($days) . 'DT' . abs($minutes) .'M');

    if ($days < 0 || $minutes < 0) {
      $dateInterval->invert = 1;
    }

    return $date->add($dateInterval)->format('Y-m-d H:i:s');
  }



  protected function _findAll_info($state, $query, $results = array()) {
    if ($state == 'before') {
      $this->virtualFields = array();
      $query['joins'] = $this->joins['cerca'];
      if(!empty($this->micrositio)){
          $query['conditions'][ "$this->alias.cia_cve"] = $this->micrositio['cia_cve'];
      }

      $query['contain'] = array(
        'Reclutador' => array(
          'fields' => array(
            'cu_sesion Reclutador__email'
          )
        ),
        'Contacto' => array(
          'fields' => array(
            '(con_nombre || \' \' || con_paterno || \' \' || con_materno) Reclutador__nombre'
          )
        )
      );

      return $query;
    }

    return $results;
  }

  public function eventosxEstado($idEstado=null,$limit=3){
      $rs=$this->find("cercanos",compact("idEstado","limit"));
      // $count=count($rs);
      // if(empty($rs) || $count < $limit ){
      //     $limit =$limit- $count;
      //     $distIdEstado=true;
      //     $rs_1=$this->find("cercanos",compact("idEstado","limit","distIdEstado"));
      //     $rs= array_merge($rs,$rs_1);
      // }
      return $rs;
  }


   protected function _findSociales($state, $query, $results = array()) {
    if ($state === 'before') {
        $conditions=array(
          'OR' => array( 'Evento.evento_fecfin >= CURRENT_DATE' , 'Evento.evento_fecini  >= CURRENT_DATE'),
          'Evento.evento_status' => 1
        );
        $conditions[] ="$this->alias.evento_redsocial = 1";

      if(isset($query['id'])){
        $conditions[ "$this->alias.$this->primaryKey"]= $query['id'];      
      }

      if(isset($query['idUser'])){
        $conditions["$this->alias.cu_cve"] = classRegistry::init('UsuarioEmpresa')->getIds('dependents', array(
          'parent' => $query['idUser']
        ));
      }
      $query['conditions']=$conditions;
      $query['joins'] = array(
              array(
                      'table' => '(select compartir_id,count (compartir_id) veces from tcompartir where compartir_tipo=2 and compartir_redsocial=1 group by compartir_id )',
                      'alias' => 'Facebook',
                      'conditions' => array(
                              "$this->alias.evento_cve= Facebook.compartir_id" 
                        ),
                      'fields' => array(
                          "nvl(Facebook.veces,0)   {$this->alias}__compartido_facebook"
                      ),
                      'type' =>'LEFT'
              ),

              array(
                      'table' => '(select compartir_id,count (compartir_id) veces from tcompartir where compartir_tipo=2 and compartir_redsocial=2 group by compartir_id )',
                      'alias' => 'Twitter',
                      'conditions' => array(
                              "$this->alias.evento_cve= Twitter.compartir_id" 
                        ),
                      'fields' => array(
                          "nvl(Twitter.veces,0)   {$this->alias}__compartido_twitter"
                      ),
                      'type' =>'LEFT'
              ),
                 array(
                      'table' => '(select compartir_id,count (compartir_id) veces from tcompartir where compartir_tipo=2 and compartir_redsocial=3 group by compartir_id )',
                      'alias' => 'Linkedin',
                      'conditions' => array(
                              "$this->alias.evento_cve= Linkedin.compartir_id" 
                        ),
                      'fields' => array(
                          "nvl(Linkedin.veces,0)   {$this->alias}__compartido_linkedin"
                      ),
                      'type' =>'LEFT'
              ),
                  array(
                      'table' => '(select compartir_id,count (compartir_id) veces from tcompartir where compartir_tipo=2 group by compartir_id )',
                      'alias' => 'VecesCompartido',
                      'conditions' => array(
                              "$this->alias.evento_cve= VecesCompartido.compartir_id" 
                        ),
                      'fields' => array(
                          " nvl(VecesCompartido.veces,0)   {$this->alias}__compartido"
                      ),
                      'type' =>'LEFT'
              )
        );
      $query['joins']= array_merge( $query['joins']  ,$this->joins['cerca']);
      $query['contain'] = array(
        'Reclutador' => array(
          'fields' => array('cu_cve', 'cu_sesion', 'keycode')
        ),
        'Empresa' => array(
                'fields' =>array('cia_nombre') 
          )
      );
      $query['recursive'] = -1;
      return $query;
    }
    return $results;
  }

  protected function _findCercanos($state, $query, $results = array()) {
    if ($state == 'before') {
      $query['conditions'] = array(
       'OR' => array(
          array("Evento.evento_fecini >=  current_date"),
          array("current_date  < Evento.evento_fecfin")
        )
      );

      if(!empty($this->micrositio)){
          $query['conditions'][ "$this->alias.cia_cve"] = $this->micrositio['cia_cve'];
      }

      if (isset($query['idEstado'])&& !empty($query['idEstado'] )) {
        $distint=  isset($query['distIdEstado']) ? '<>' :'';
        $query['conditions']['AND']= array(
          array("Ciudad.est_cve  $distint" => $query['idEstado']),
        );
      }

      if(isset($query['fecha_inicio'])&& isset($query['fecha_fin']) ){
          $query['conditions']['AND'][]=array(
              "$this->alias.evento_fecini >="=> $query['fecha_inicio'],
              "$this->alias.evento_fecfin <="=> $query['fecha_fin']
            );
      }
      if(isset($query['idEvento'])){
        $query['conditions']['AND'][]=array(
              "$this->alias.evento_cve"=> $query['idEvento']
          );
      }

      $query['conditions']['AND'][]= array("$this->alias.evento_status"=> "1") ;
      $contain=array();
      $join_info= array();

      $is_login=isset($query['is_login']) ? $query['is_login']:false;

      if($is_login){
        $contain=array(
                          'Reclutador' => array(
                                                "fields" => array(
                                                                      "Reclutador.cu_sesion {$this->alias}__email"
                                                  )

                            ),
                          'Contacto' =>array(
                                            "fields" => array(
                                                                "Contacto.con_nombre || ' ' || Contacto.con_paterno || ' ' || Contacto.con_materno  {$this->alias}__nombre",
                                                                "nvl(Contacto.con_tel,'')  {$this->alias}__telefono"
                                              )

                            )
      );
       $join_info= array(
                      array(
                                'table'=> 'tcompania',
                                'alias'=> 'Cia',
                                'type'=> 'LEFT',
                                'fields' => array(
                                                      "Cia.cia_nombre {$this->alias}__cia_nombre"
                                ),
                                'conditions' => array(
                                                        "{$this->alias}.cia_cve=Cia.cia_cve"
                                  )


                        )

        );


      }
      $query['contain']= $contain;
      $query['joins']=array_merge($this->joins['cerca'],$join_info);
      $query['order'] = array("$this->alias.evento_fecini ASC");
      return $query;
    }

    return  isset($query['idEvento']) && !empty($results) ? $results[0] :$results;
  }

  public function listaEstados(){
    return $this->find("list",array(
      'joins' => array(
        array(
          "alias" =>"Ciudad",
          "conditions" => array(
            "Ciudad.ciudad_cve=Evento.ciudad_cve"
          ),
          "table" => "tciudad",
          "type" => "LEFT"
        ),
        array(
          "alias" => "Estado",
          "conditions" => array(
            "Estado.est_cve=Ciudad.est_cve"
          ),
          "table" => "testado",
          "type" => "LEFT"
        )
      ),
      "conditions" => array(
        "OR" => array(
          array("Evento.evento_fecini >=  current_date" ),
          array("current_date  < Evento.evento_fecfin" )
        ),
        "AND" => array(
          array("Estado.est_cve !="=>null )
        )
      ),
      "fields" => array("Estado.est_cve","Estado.est_nom"),
      "group" => array("Estado.est_cve","Estado.est_nom")
      )
    );
  }

  public function candidatosCercanos($conditions = array()) {
    $CandidatoUsuario = ClassRegistry::init('CandidatoUsuario');
    $joins = $CandidatoUsuario->Candidato->joins['direccion'];
    array_unshift($joins, array(
      'alias' => 'Candidato',
      'conditions' => array(
        'CandidatoUsuario.candidato_cve = Candidato.candidato_cve',
        'CandidatoUsuario.cc_status =1'
      ),
      'table' => 'tcandidato',
      'type' => 'LEFT'
    ));

    foreach ($joins as $key => $value) {
      unset($joins[$key]['fields']);
    }

    $rs = $CandidatoUsuario->find('all', array(
      'joins' => $joins,
      'fields' => array(
        'Candidato.candidato_cve Receptor__id',
        'CandidatoUsuario.cc_email Receptor__email',
      ),
      'recursive' => -1,
      'conditions' => $conditions
    ));

    return !empty($rs) ? Hash::extract($rs, '{n}.Receptor') : array();
  }

  public function afterSave($created, $options = array()) {
    if ($created) {

      $receptores= $this->candidatosCercanos(array(
          'Ciudad.ciudad_cve' => $this->data['Evento']['ciudad_cve']
        ));
      if(!empty($receptores)){
          $data = $this->data + array(
          'Receptores' => $receptores
          );

          $event = new CakeEvent('Model.Evento.created', $this, array(
          'id' => $this->id,
          'data' => $data
          ));
          $this->getEventManager()->dispatch($event);
      }

    }
  }

  public function normalizar($ev, $id = null) {
    $evento = array(
      'evento_fecini' => date('Y-m-d H:i:s', strtotime($ev['start'])),
      'evento_fecfin' => date('Y-m-d H:i:s', strtotime($ev['end'])),
      'evento_status' => 1, //isset($ev['status']) ? $ev['status'] : 1,
      'evento_tipo' => isset($ev['type']) ? $ev['type'] : 1,
      'evento_nombre' => $ev['title'],
      'evento_resena' => $ev['desc'],
      'evento_dir' => $ev['dir'],
      'evento_calle' => $ev['calle'],
      'evento_cp' => $ev['cp'],
      'latitud' => $ev['lat'],
      'longitud' => $ev['lng'],
      'evento_redsocial'=> isset($ev['network']) ? $ev['network']: null
    );
    if ($id) {
      $evento[$this->primaryKey] = $id;
    }

    return $evento;
  }

  public function actualizar($eventoId, $data) {
    if (!$this->exists($eventoId)) {
      return false;
    } else {
      $evento = $this->read(null, $eventoId);
    }

    if ($data['type'] === 'data') {
      $data = $this->normalizar($data['Evento'], $eventoId);
      return $this->save($data);
    } else {
      $daysDelta = $data['dayDelta'];
      $minutesDelta = $data['minuteDelta'];

      $evento[$this->alias]['evento_fecfin'] = $this->updateDate(
        $evento[$this->alias]['evento_fecfin'], $daysDelta, $minutesDelta
      );
      if ($data['type'] == 'drop') {
        $evento[$this->alias]['evento_fecini'] = $this->updateDate(
          $evento[$this->alias]['evento_fecini'], $daysDelta, $minutesDelta
        );
      }

      return $this->save($evento, true, array('evento_fecini','evento_fecfin'));
    }
  }

  public function cancelar($eventoId) {
    $this->id = $eventoId;
    return $this->saveField('evento_status', 0);
  }


  public function eventosEstado($idEstado=null){
      $options=array(
            "joins" =>array(
            array(
              "alias" =>"Ciudad",
              "conditions" => array(
                                        "Ciudad.ciudad_cve=Evento.ciudad_cve"
                ),
              "fields"=> array(
                                  "Ciudad.ciudad_nom"
                ),
              "table" => "tciudad",
              "type" => "LEFT"
            ),
             array(
                  "alias" =>"Estado",
                  "conditions" => array(
                                            "Estado.est_cve=Ciudad.est_cve"
                    ),
                  "fields"=> array(
                                      "Estado.est_cve",
                                      "Estado.est_nom"
                    ),
                  "table" => "testado",
                  "type" => "LEFT"
                )
            ),
            "conditions" =>  array(
                                      "OR" => array(
                                                  array("Evento.evento_fecini >=  current_date" ),
                                                  array("current_date  < Evento.evento_fecfin" )
                                                  )
                                 ),
            'fields' => array(
                                "Evento.evento_cve",
                                "Evento.evento_nombre",
                                "Evento.fecha_ini_",
                                "Evento.fecha_fin_"
                              ),
            'limit' => 3,
            'order' =>  array(
                            "Evento.evento_fecini ASC"
              )


        );

      if($idEstado!=null){
            $options["conditions"]["AND"]= array(
                                                   array("Estado.est_cve "=>$idEstado )
                                        ) ;

      }
      $options['conditions']['AND'][] = array("$this->alias.evento_status"=> "1") ;
      if(!empty($this->micrositio) ){
          $options['conditions']["AND"][] = array("$this->alias.cia_cve" => $this->micrositio['cia_cve']);
      }


      $result=$this->find("all",$options);

      if( $idEstado!=null && empty($result) && empty($this->micrositio)){
          unset($options["conditions"]["AND"]);
          $result=$this->find("all",$options);
      }

      return $result;

  }

  public function format_to_share($network_s='facebook',$evento){
    $of= $evento[$this->alias];
    $imgPath= Usuario::getPhotoPath($of['cia_cve'],'empresa');
    if($network_s==='twitter'){
      $file_name= WWW_ROOT. substr($imgPath,1);
      $name=basename($file_name);     
    } 
    $info_share= "$of[tipo_nombre] $of[evento_nombre], $of[ciudad_nom], $of[est_nom], $of[evento_link] ";
    return    $network_s ==='facebook' ?array(
        'name' =>   "$of[evento_nombre]" ,
        'description' =>  $info_share,
        'picture' => "http://www.nuestroempleo.com.mx/$imgPath",
        'message' =>"$of[evento_nombre]-$of[tipo_nombre]",
        'link' => $of['evento_link']
        ): (  $network_s==='twitter' ?  array(
          'status' => $info_share,
          'media[]'=> "@{$file_name};type=image/jpeg;filename={$name}"
          )   :array() ) ; 

  }

  public function getEventos(){




  }
}
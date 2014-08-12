<?php

App::import('Model', 'ModelCan');
class Candidato extends ModelCan {
  public $name='Candidato';
  public $useTable = 'tcandidato';
  public $primaryKey="candidato_cve";
  public $msg_succes="Datos Personales";

  public $joins= array(
                        "direccion" => array(
                            'alias' => 'DirCandidato',
                            'fields' => array( "DirCandidato.cp_cve"),
                            'conditions' => array(
                              'DirCandidato.candidato_cve = Candidato.candidato_cve'
                            ),
                            'table' => 'tdircandidato',
                            'type' => 'LEFT'
                          )

    );
  public $hasMany = array(
    'AreaIntCan'=> array(
      'className'    => 'AreaIntCan',
      'foreignKey'   => 'candidato_cve',
      'finderQuery' =>  'SELECT
                            AreaIntCan.candidato_cve,
                            AreaIntCan.areaint_cve,
                            AreaInt.area_cve,
                            AreaInt.area_nom,
                            AreaInt.categoria_cve,
                            Categoria.categoria_nom AreaIntCan__categoria_nom
                              FROM tareaintcandidato AreaIntCan INNER JOIN tareas AreaInt ON (
                                AreaInt.area_cve = AreaIntCan.area_cve
                              ) INNER JOIN tcategorias Categoria  ON (  AreaInt.categoria_cve=Categoria.categoria_cve)
                              WHERE
                                AreaIntCan.candidato_cve IN ({$__cakeID__$})
                              ORDER BY
                                AreaIntCan.areaint_cve ASC'
      ),
      'ExpLabCan' => array(
        'className'=> 'ExpLabCan',
        'foreignKey'   => 'candidato_cve',


        'finderQuery' =>  'SELECT
                                  ExpLabCan.candidato_cve,
                                  ExpLabCan.explab_cve,
                                  ExpLabCan.explab_actual,
                                  ExpLabCan.explab_empresa,
                                  ExpLabCan.giro_cve,
                                  ExpLabCan.explab_puesto,
                                  ExpLabCan.explab_web,
                                  TO_CHAR(ExpLabCan.explab_fecini,\'DD/MM/YYYY\') ExpLabCan__explab_fecini,
                                  TO_CHAR(ExpLabCan.explab_fecfin,\'DD/MM/YYYY\') ExpLabCan__explab_fecfin,
                                  ExpLabCan.explab_funciones,
                                  Giro.giro_nom ExpLabCan__giro_nom
                              FROM texplabcandidato ExpLabCan INNER JOIN tgiros Giro ON (
                                Giro.giro_cve = ExpLabCan.giro_cve
                              )
                              WHERE
                                ExpLabCan.candidato_cve IN ({$__cakeID__$})
                              ORDER BY
                                ExpLabCan.explab_cve ASC'
      ),
      'AreaExpCan' => array(
        'className'=> 'AreaExpCan',
        'foreignKey'   => 'candidato_cve',
        'finderQuery' =>  'SELECT
                            AreaExpCan.candidato_cve,
                            AreaExpCan.areaexpcan_cve,
                            AreaExpCan.tiempo_cve,
                            AreaInt.area_cve,
                            AreaInt.area_nom,
                            AreaInt.categoria_cve,
                            Categoria.categoria_nom AreaExpCan__categoria_nom
                              FROM tareasexplab AreaExpCan INNER JOIN tareas AreaInt ON (
                                AreaInt.area_cve = AreaExpCan.area_cve
                              ) INNER JOIN tcategorias Categoria ON (
                                     Categoria.categoria_cve=AreaInt.categoria_cve
                              )
                              WHERE
                                AreaExpCan.candidato_cve IN ({$__cakeID__$})
                              ORDER BY
                                AreaExpCan.areaexpcan_cve ASC'
      ),
      'IdiomaCan' => array(
        'className'=> 'IdiomaCan',
        'foreignKey'   => 'candidato_cve',
        'finderQuery' =>  'SELECT
                            IdiomaCan.candidato_cve,
                            IdiomaCan.ic_cve,
                            IdiomaCan.ic_nivel,
                            Idioma.idioma_cve,
                            Idioma.Idioma_nom
                              FROM tidiomacandidato IdiomaCan INNER JOIN tidioma Idioma ON (
                                Idioma.idioma_cve = IdiomaCan.idioma_cve
                              )
                              WHERE
                                IdiomaCan.candidato_cve IN ({$__cakeID__$})
                              ORDER BY
                                IdiomaCan.ic_cve ASC'
      ),

      'EscCan' => array(
        'className'=> 'EscCan',
        'foreignKey'   => 'candidato_cve',
         'finderQuery' => 'SELECT
                                EscCan.candidato_cve,
                                EscCan.ec_cve,
                                EscCan.ec_nivel,
                                EscCan.ec_institucion,
                                EscCan.ec_especialidad,
                                EscCan.cespe_cve,
                                to_char(EscCan.ec_fecini,\'DD/MM/YYYY\') EscCan__ec_fecini,
                                to_char(EscCan.ec_fecfin,\'DD/MM/YYYY\') EscCan__ec_fecfin,
                                DECODE(EscCan.ec_fecfin,NULL,\'S\',\'N\')  EscCan__ec_actual,
                                Nivel.opcion_texto  EscCan__nivel,
                                EscCarArea.carea_cve,
                                EscCarArea.carea_nom,
                                EscCarGene.cgen_cve,
                                EscCarGene.cgen_nom,
                                EscCarEspe.cespe_cve,
                                EscCarEspe.cespe_nom
                            FROM tesccandidato EscCan LEFT JOIN tesccarespe EscCarEspe ON (
                                    EscCarEspe.cespe_cve = EscCan.cespe_cve
                                  ) LEFT JOIN tesccargene EscCarGene ON (
                                    EscCarGene.cgen_cve = EscCarEspe.cgen_cve
                                  ) LEFT JOIN tesccararea EscCarArea ON (
                                    EscCarArea.carea_cve = EscCarGene.carea_cve
                                  ) LEFT JOIN tcatalogo Nivel ON (
                                                  Nivel.opcion_valor = EscCan.ec_nivel and
                                                  Nivel.ref_opcgpo=\'NIVEL_ESCOLAR\'
                                  )

                             WHERE EscCan.candidato_cve IN ({$__cakeID__$})
                             ORDER BY  ec_cve ASC'
      ),
      'CursoCan' => array(
        'className'=> 'CursoCan',
        'foreignKey'   => 'candidato_cve',
        'order'  => array ("curso_cve ASC")
      ),
      'ConoaCan' => array(
        'className'=> 'ConoaCan',
        'foreignKey'   => 'candidato_cve',
        'order'  => array ("conoc_cve ASC")
        ),
      'ConfigCan' => array(
        'className'=> 'ConfigCan',
        'foreignKey'   => 'candidato_cve'),
      'RefCan' => array(
        'className'=> 'RefCan',
        'foreignKey'   => 'candidato_cve',
         'order'  => array ("refcan_cve ASC")
        ),
       'InteresCan' => array(
        'className'=> 'InteresCan',
        'foreignKey'   => 'candidato_cve',
         'order'  => array ("interescan_cve ASC")
        ),
       'HabiCan' => array(
        'className'=> 'HabiCan',
        'foreignKey'   => 'candidato_cve',
         'order'  => array ("habican_cve ASC")
        ),
       'IncapCan' => array(
        'className'=> 'IncapCan',
        'foreignKey'   => 'candidato_cve',
         'order'  => array ("incapcan_cve ASC")
        ),

       'GrafCan' => array(
        'className' => 'GrafCan',
        'foreignKey' => 'candidato_cve',
        'finderQuery' => 'SELECT
                            GrafCan.grafcandidato_cve,
                            GrafCan.candidato_cve,
                            GrafCan.tabla_cve,
                            TablaGrafCan.tabla_cve,
                            TablaGrafCan.tabla_nombre,
                            TablaGrafCan.tabla_porcentaje
                              FROM tgrafcandidato GrafCan INNER JOIN ttablasgrafcandidato TablaGrafCan ON (
                                TablaGrafCan.tabla_cve = GrafCan.tabla_cve
                              )
                              WHERE
                                GrafCan.candidato_cve IN ({$__cakeID__$})'
        ),
       'DocCanFoto' => array(
          'className'=>'DocCan',
          'foreignKey' =>'candidato_cve',
          'conditions' =>array('docscan_nom' => 'foto')
        )

    );
public $belongsTo = array(
    'DirCandidato'=> array(
      'className'    => 'DirCandidato',
      'foreignKey'   => "candidato_cve"
      ),
     'ExpEcoCan'=> array(
      'className'    => 'ExpEcoCan',
      'foreignKey'   => 'candidato_cve'
      )
    );

public $validate = array(
    'candidato_nom' => array(
        'required'=>  array(
         'rule' => 'notEmpty',
         'required' => true,
        'message'    => 'Ingresa nombre(s).'
      )
    ),

     'candidato_pat' => array(
        'required'=>  array(
        'rule' => 'notEmpty',
        'required' => true,
        'message'    => 'Ingresa apellido paterno.'
      )
    ),
    'candidato_fecnac' => array(
            'required'=>  array(
            'rule'       => 'notEmpty',
            'required'   => true,
            'message'    => 'Ingresa fecha de nacimiento.'
          ),
            'mydate' => array(
            'rule'       => array('date', 'dmy'),
            'message'   => "Formato de fecha no válido.",

            )
        ),
     'candidato_perfil' => array(
          'required'=>  array(
          'rule' => 'notEmpty',
          'required'   => false,
          'message'    => 'Ingresa un título a tu perfil.'
        )
      ),

      'edo_civil' => array(
                'required'=>  array(
                 'rule' => 'notEmpty',
                 'required' => true,
                'message'    => 'Selecciona estado civil.'
              )
            ),

      'candidato_sex' => array(
                'required'=>  array(
                 'rule' => 'notEmpty',
                 'required' => true,
                'message'    => 'Selecciona género.'
              )
            ),
      'candidato_movil' => array(
                'required'=>  array(
                 'rule' => 'notEmpty',
                 'required' => true,
                'message'    => 'Ingresa número teléfonico.'
              )
            )

  );

 public $findMethods = array(
    'all_info'    => true,
    'basic_info'  => true,
    'config'  => true,
    'grafcan' =>true,
    'search' => true,
    'direccion' =>true
  );


  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);


     $this->virtualFields = array(
      'candidato_fecnac' => "to_char($this->alias.candidato_fecnac,'DD/MM/YYYY')",
      'edad' => "trunc((sysdate - $this->alias.candidato_fecnac) / 365)",
      'nombre_' => "$this->alias.candidato_nom || ' ' || $this->alias.candidato_pat || ' ' || $this->alias.candidato_mat",
      'genero' => "decode($this->alias.candidato_sex,'M','Masculino','F','Femenino','Dato no Capturado')",
      "ultima_conexion" => "to_char($this->alias.modified,'DD/MM/YYYY')"
    );

     $this->joins['direccion'] = array_merge(  array($this->joins['direccion']) ,$this->DirCandidato->joins['direccion']  );

    if(getenv("NODE_ENV")=='pro'){
        $this->useDbConfig='production';
        foreach ($this->hasMany as $key=>$rel ){
          $this->$key->useDbConfig='production';
        }
      }

  }

 protected function _findDireccion($state, $query, $results = array()) {
    if ($state == 'before') {
      $query['contain'] = array( );
      $query['joins']= $this->joins['direccion'];
      $query['conditions']=array(
                                      "$this->alias.candidato_cve" => $query['idUser']
          );
      return $query;
    }
    return  (empty($results)) ? $results :$results[0]   ;
  }



  protected function _findBasic_info($state, $query, $results = array()) {
    if ($state == 'before') {
      $query['contain'] = array("GrafCan" );
      $query['joins']= $this->joins['direccion'];
      $query['conditions']=array(
                                      "$this->alias.candidato_cve" => $query['idUser']
          );
      return $query;
    }

    return $results;
  }

  // NOTA:
  // Sólo se agregó la variable $empty para la firma de esta función fuera compatible con
  // la de AppModel.
  public function format($results=array(), $empty = null){
    $rs=array();

    foreach ($results as $num_row => $row) {
        $rs[$num_row][$this->alias]=$row[$this->alias];

        foreach ($this->belongsTo as $alias_model => $v_) {
          if(array_key_exists($alias_model,$row)){

              $rs[$num_row][$alias_model]= $row[$alias_model];
              if($alias_model== "DirCandidato"){
                $rs[$num_row][$alias_model]['CodigoPostal']= $row['CodigoPostal'];
                $rs[$num_row][$alias_model]['CodigoPostal']['Pais']= $row['Pais'];
                $rs[$num_row][$alias_model]['CodigoPostal']['Estado']= $row['Estado'];
                $rs[$num_row][$alias_model]['CodigoPostal']['Ciudad']= $row['Ciudad'];


              }


          }

        }
        foreach ($this->hasMany as $alias_model => $v_) {

          if(array_key_exists($alias_model,$row)){
            $rs[$num_row][$alias_model]= $row[$alias_model];
          }

        }

    }





    return $rs;


  }



 protected function _findAll_info($state, $query, $results = array()) {
    if ($state == 'before') {
        $contain= array("ExpEcoCan");

        foreach ($this->hasMany as $alias_model => $va_) {
          $contain[]=$alias_model;
        }

      $query['contain']=$contain;
      $query['joins'] =$this->joins['direccion'];
      $query['conditions']=array(
                                      "$this->alias.candidato_cve" => $query['idUser']
          );
      return $query;
    }

    return $results;
  }

protected  function _findSearch($state,$query,$results=array()){
    if($state==='before'){
        $query['recursive']=-1;
        $query['joins'] =$this->joins['direccion'];
         $arrays_ =array(
                        array(
                          "table" => "tcatalogo",
                            "alias" => "EdoCivil",
                            "type" => "left",
                            "conditions"=>array(
                              "EdoCivil.opcion_valor = $this->alias.edo_civil",
                              "EdoCivil.ref_opcgpo" => 'ESTADO_CIVIL'
                              )
                        ),
                        array(
                              "table" => "texpecocandidato",
                              "alias" => "ExpEco",
                              "type" =>"inner",
                              "conditions" => array(
                                    "$this->alias.candidato_cve = ExpEco.candidato_cve"
                                )
                          ),
                        array(
                            "table" => "texplabsueldos",
                            "alias" => "Sueldo",
                            "type" => "inner",
                            "conditions"=>array(
                              "Sueldo.elsueldo_cve = ExpEco.explab_sueldod"
                              )
                          ),
                        array(
                              "table" => 'tcatalogo',
                              "alias" => "Tipo",
                              "type" => "inner",
                              "conditions" => array(
                                  "ExpEco.expeco_tipoe= Tipo.opcion_valor" ,
                                  "Tipo.ref_opcgpo" => "DISPONIBILIDAD_EMPLEO"
                                )
                          ),

          );
          $query['contain']= array(
                        'InteresCan' , 'CursoCan', 'EscCan', 'AreaIntCan','AreaExpCan'
            );
         $query['joins']= array_merge($query['joins'],$arrays_);
        foreach ($query['joins'] as $key => $join){
              $query['joins'][$key]['fields'] = array();

        }
        $query['fields'] =array(
          "$this->alias.candidato_perfil {$this->alias}__perfil",
          " (trunc((sysdate - $this->alias.candidato_fecnac) / 365) || ' Años') {$this->alias}__edad",
          " EdoCivil.opcion_texto   {$this->alias}__edocivil",
          "(decode($this->alias.candidato_sex,'M','Masculino','F','Femenino',null)) {$this->alias}__genero",
          "Tipo.opcion_texto {$this->alias}__empleo_tipo",
          " ExpEco.explab_viajar   {$this->alias}__viajar",
          " ExpEco.explab_reu   {$this->alias}__reubicarse",
          "Sueldo.elsueldo_ini {$this->alias}__sueldo",
          "CodigoPostal.cp_asentamiento {$this->alias}__colonia",
          "Ciudad.ciudad_nom {$this->alias}__ciudad",
          "Estado.est_nom  {$this->alias}__estado",
          "Pais.pais_nom   {$this->alias}__pais"
        );
        $query['conditions']=array(
                                      "$this->alias.candidato_cve" => $query['idUser']
        );
        return $query;
    }

      if(!empty($results)){
           $results=$results[0] ;
           if(!empty($results['AreaIntCan'])){
            $results["$this->alias"]["area_interes"]=$results['AreaIntCan'][0]['AreaInt']['area_nom'];
            $results["$this->alias"]["categoria_experiencia"]=$results['AreaIntCan'][0]['categoria_nom'];
            unset($results['AreaIntCan']);
           }
            if(!empty($results['AreaExpCan'])){
            $results["$this->alias"]["area_experiencia"]=$results['AreaExpCan'][0]['AreaInt']['area_nom'];
            $results["$this->alias"]["categoria_experiencia"]=$results['AreaExpCan'][0]['categoria_nom'];
            unset($results['AreaExpCan']);
           }

          if(!empty($results['CursoCan'])){
            $results["$this->alias"]["curso"]=$results['CursoCan'][0]['curso_nom'];
            unset($results['CursoCan']);
           }

          if(!empty($results['EscCan'])){
            $results["$this->alias"]["carrera"]=$results['EscCan'][0]['EscCarEspe']['cespe_nom'];
            $results["$this->alias"]["nivel_carrera"]=$results['EscCan'][0]['nivel'];
            unset($results['EscCan']);
           }


    }
    return $results ;
}

 protected function _findGrafcan($state, $query, $results = array()) {
    if ($state == 'before') {
       $query['contain'] = array('GrafCan' );
      $query['conditions']=array(
                                      "$this->alias.candidato_cve" => $query['idUser']
          );
      return $query;
    }

    return $results;
  }


protected function _findConfig($state, $query, $results = array()) {
    if ($state == 'before') {
      $query['contain'] =  array('ConfigCan','GrafCan');
      $query['joins'] =$this->joins['direccion'];
      $query['conditions']=array(
                                      "$this->alias.candidato_cve" => $query['idUser']
          );
      return $query;
    }


    return $results;
  }


function getCanInfoRef($id){


    return $this->find("first",array(
            "conditions" => array ( "$this->alias.candidato_cve " => $id ),
            "fields" => array(
                              "$this->alias.candidato_cve",
                              "$this->alias.nombre_",

              ),
              "recursive" => -1

      ));

}


function registrar($data){

      if($this->save($data['Candidato']) ){
          if($this->DirCandidato->save($data['DirCandidato'])){
                 $data_save=array(
                              "EvaCan" =>array(
                                            "candidato_cve"=>$this->id,
                                            "evaluacion_cve"=>2,
                                            "cu_cve" => 1,
                                            "evaluacion_status" =>0,
                                            "evaluacion_fec" =>  date("Y-m-d ")
                                            ));
                 if(ClassRegistry::init("EvaCan")->save($data_save)){
                       return array("ok","Datos de candidato y dirección guardados.");
                 }

                 else{
                  return array("error","Error al procesar petición candidato.");

                 }
          }
          else{
             return array("error","La dirección del candidato no se guardó.", $this->DirCandidato->validationErrors );
          }
      }
      return array("error","Los datos de candidato y dirección no fueron guardados.", $this->validationErrors );
}

function guardar_primera($data,$id){


    /*modelos que se guardaran*/
    $model_save=  array("Candidato","DirCandidato","ExpEcoCan","AreaIntCan","EscCan","IdiomaCan","ConfigCan");
    /*si tiene experiencia laboral se guardarn*/
    $model_exp= array("AreaExpCan","ExpLabCan");
    $candidato=array();
  foreach ($model_save as  $model){
    if(!empty($data[$model])){
      $candidato[$model]=$data[$model] ;
    }
  }

  /**/
  if($data['hiddenform']['s_hidden']==="S"){
    foreach ($model_exp as $model){
      if(!empty($data[$model])){
        $candidato[$model]=$data[$model] ;
      }
    }
  }


  if($res=$this->saveall($candidato)){

    return array("ok","Proceso completo.");
  }
  else{
   /*$db =& ConnectionManager::getDataSource('default');
    $db->showLog();*/
    return array("error","Error al guardar información.",$this->validationErrors);
  }


}


public function modificar_fechaConexion($idCan=null,$fecha=null ){

    $fecha= !$fecha ? date("Y-m-d"):$fecha;

      $this->id=$idCan;
      $this->saveField("modified",$fecha );



}


public function  datos_busqueda_oferta($id=null,$extra_info=array()){

    /*

      falta direccion y perfil

    */

  $info=array(
          // 'AreaIntCan',
          // "AreaExpCan",
          // "ExpLabCan",
          // "ConoaCan",
          // "CursoCan",
          // "EscCan",
          // "ExpEcoCan",
          // "IdiomaCan",
          // "HabiCan",
          // "InteresCan",
          // "IncapCan"

    );

  // $flag=false;

  // $fields_s=array();
  // foreach ($info as $model_name) {
  //   $arr=$this->$model_name->datos_busqueda_oferta($id);
  //   if (is_array($arr) ){
  //     if( array_key_exists("explab_viajar", $arr)){
  //       $flag= $arr['explab_viajar'] =='N' && $arr['explab_reu'] =='N' ;
  //       unset($arr['explab_viajar']);
  //       unset($arr['explab_reu']);
  //     }

  //     $fields_s[]= $arr;
  //   }

  // }



  $str="";
  // foreach ($fields_s as $iter) {
  //   foreach ($iter as $key => $value) {
  //     $str.= $value . ". ";
  //   }
  // }
  // if($flag){

  //   foreach ($extra_info as $key => $value) {
  //     $str.= $value . ". ";
  //   }

  // }
  // else{
  //     $str.=  $extra_info['candidato_perfil'].  ". ";

  // }
  //
  //


  foreach ($extra_info as $key => $value) {
    $str.= $value . ". ";
  }
  return   $str;

}

public function fechaConexion ($idCan){

  $rs= $this->find("first",array(
                                "conditions" => array(
                                                       "candidato_cve" => $idCan
                                                     ),
                                "fields"=> array(
                                                  "to_char($this->alias.modified,'DD/MM/YYYY') ".$this->alias."__ultima_conexion"
                                                ),
                                "recursive" => -1,

                            ));

    return empty($rs) ? null: $rs[$this->alias]['ultima_conexion'];

}



public function getCandidato($candidato_cve){
  return $this->find("all_info",array('idUser' => $candidato_cve))[0];
    //   return $this->find('first', array(
    // 'conditions' => array('Candidato.candidato_cve' => $candidato_cve) , 'recursive'=> $recursive));

}



public function eleminar_Explab($id){
      $conditions=array('candidato_cve'=>$id);

      if($this->ExpLabCan->deleteAll($conditions,false) &&
         $this->AreaExpCan->deleteAll($conditions,false) ){

          return array("ok","Proceso de eliminación de Experiencia Laboral completo.");

      }
      else{
             return array("error","Error al eliminar Experiencia Laboral.");
      }


  }



  public function getPhotoPath($id) {
    App::uses('Usuario', 'Utility');

    return Usuario::getPhotoPath($id);
  }

}


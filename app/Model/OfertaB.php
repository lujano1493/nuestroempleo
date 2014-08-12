<?php

App::import('Utility','Utilities');

class OfertaB extends AppModel {
  public $name = 'OfertaB';
  public $primaryKey="";
  public $useTable="tofertabusqueda";

  public $micrositio=array();

  private $template_query=

  array(
          "normal" =>  '
              <query>
                   <textquery lang="SPANISH" grammar="CONTEXT">  {  __expresion__ }
                     <progression>
                         <seq><rewrite>transform((TOKENS, "{", "}", " AND "))</rewrite> </seq>
                         <seq><rewrite>transform((TOKENS, "?{", "}", " AND "))</rewrite> </seq>
                     </progression>
                   </textquery>
                  <score datatype="FLOAT" algorithm="DEFAULT"/>
                </query>

  ',
    "perfil" => '
              <query>
                   <textquery lang="SPANISH" grammar="CONTEXT">  {  __expresion__ }
                     <progression>
                         <seq><rewrite>transform((TOKENS, "?{", "}", " ACCUM "))</rewrite> </seq>
                     </progression>
                   </textquery>
                  <score datatype="FLOAT" algorithm="DEFAULT"/>
                </query>

  '  );
  public function busqueda_perfil_candidato($idUser,$limit=10){
    $m_c=ClassRegistry::init("Candidato");
    $c=$m_c -> find("search",array("idUser" => $idUser));
    $data= $c['Candidato'];
    $ubicacion=array(
          "pais"=> $data['pais'],
          "estado" => $data['estado'],
          "ciudad" => $data['ciudad'],
          'colonia'=> $data['colonia']
      );
    $por_ubicacion= array(
              "$this->alias.pais_nom" => $ubicacion['pais'],
              "$this->alias.est_nom" => $ubicacion['estado'],             

    );
    $area = empty($data['area_experiencia']) ? $data['area_interes'] :$data['area_experiencia'];
    $categoria=  empty($data['categoria_experiencia']) ? $data['categoria_interes'] :$data['categoria_experiencia'];
    $data_search=" $data[perfil] $data[edad] $data[edocivil] $data[sueldo] $area ";
    $conditions=  $data['viajar']==='N' && $data['reubicarse']==='N' ? $por_ubicacion: array();
    $conditions["$this->alias.oferta_genero"]=$data['genero'];
    $conditions["$this->alias.oferta_edocivil"]=$data['edocivil'];
    $conditions["$this->alias.oferta_sueldo"]=$data['sueldo'];    
    $conditions["$this->alias.oferta_tipo"]=$data['empleo_tipo'];
    $conditions["OR"] =array(
      "$this->alias.oferta_area1" => $area,
      "$this->alias.oferta_area2" => $area,
      "$this->alias.oferta_area3" => $area, 
      "$this->alias.oferta_cat1" => $categoria,
      "$this->alias.oferta_cat2" => $categoria,
      "$this->alias.oferta_cat3" => $categoria              
      );
    $ofertas_rs=$this->_set_perfil_oferta($data_search,$conditions,$limit);
    $conditions=  $data['viajar']==='N' && $data['reubicarse']==='N' ? $por_ubicacion: array();
    $ofertas_rs= empty($ofertas_rs) ? $this->_set_perfil_oferta($data_search,$conditions,$limit) : $ofertas_rs ;
    $ofertas_rs= empty($ofertas_rs) ? $this->_set_perfil_oferta($data_search,array(),$limit) : $ofertas_rs ;
    return $ofertas_rs;
  }
  private function _set_perfil_oferta($info,$arr=array(),$limit=10){
       $_options=array(
          'params' => array("dato" =>$info, "iDisplayStart" =>0,"iDisplayLength"=>$limit),
          'is_group' => false,
          'search_acum' =>true,
          'conditions' =>$arr,
          'order' => array( )
        );
     return $this-> realizar($_options)['data'];

  }




  public function preparaConsulta($params=array()){
              $fields=array(
                              "dato"
      );

              $str_="";

              foreach ($params as $key => $value) {
                  if( in_array($key,$fields) && !empty($value)  ){
                    $str_.= " $value";
                  }

              }



      return !empty($str_) ? $str_: false ;

  }

  private $result_agroup=array();
  private $count=array();

private function agrupando_($data=null,$name_model,$field){

      if(!$data){
          return;

      }
      $keyisita="$name_model.$field:$data";

      if( ! array_key_exists($keyisita,$this->count )  ){
          $this->count[$keyisita]=1;

      }
      else{
        $this->count[$keyisita]++;
      }




      $this->result_agroup[$name_model][$field][$data]=$this->count[$keyisita] ;

}


private  function data_contar(&$set=arr,$path=null ){
  if(! Hash::check( $set, $path) ){
    $set=Hash::insert($set,$path,1);


  }
  else{
    $count= Hash::get($set,$path);
    $set=Hash::insert($set,$path, ++$count);
  }

}


 public static  function  cmpcategoria($a, $b)
{
    if ($a['count'] == $b['count']) {
        return 0;
    }
    return ($a['count'] > $b['count']) ? -1 : 1;
}


  public  function agrupar($params=array()){


            $field_descar=array(
                                  "oferta_cve",
                                  "oferta_resumen",
                                  "oferta_prestaciones",
                                  "puesto_nom" ,
                                  "oferta_fecini",
                                  "oferta_status",
                                  "oferta_privada",
                                  "cia_cve" ,
                                  "score"



          );
        $rs=$this->realizar(array("params" => $params,"is_group"=> true ))['data'];
        if(empty($rs)){
          return array();
        }


        $_campos=array();
        foreach ($this->campos as $fields_) {
            $_campos= array_merge($_campos, array( $fields_ => $fields_  )   );
        }

          $_campos= array_merge($_campos, array(
                                                    "oferta_area1" => "area_nom",
                                                    "oferta_area2" => "area_nom",
                                                    "oferta_area3" => "area_nom",
                                                    "oferta_cat1" => "categoria_nom",
                                                    "oferta_cat2" => "categoria_nom",
                                                    "oferta_cat3" => "categoria_nom",
                                                    'publicacion' => "publicacion"

            ));

          $gerarquias=array();
          $gerarquias['localidad']=array();
          $gerarquias['categoria']=array();

      foreach ($rs as  $data) {

                $info_=$data[$this->alias];



                $this->data_contar($gerarquias['localidad'],  str_replace(".","_" ,$info_['est_nom']).".". str_replace(".","_" ,$info_['ciudad_nom']));

                for($in_=1;$in_<=3;$in_++){

                    if(!$info_["oferta_cat$in_"] || !$info_["oferta_area$in_"]){
                      continue;
                    }
                  $this->data_contar($gerarquias['categoria'],  str_replace(".","_" ,$info_["oferta_cat$in_"]).".". str_replace(".","_" ,$info_["oferta_area$in_"]));

                }
          foreach ($data[$this->alias] as  $field=>$value  ) {
                if(!in_array($field,$field_descar) ){
                      $name_field= $_campos[$field];

                    $this->agrupando_($value,$this->alias,$name_field);

                }



          }


      }

       $agrupados=array();

       $agrupados_g=array();

          foreach ($gerarquias as $tipo => $arra_) {

              foreach ($arra_ as $sub_leve => $array_sub) {
                  $count_=0;
                  foreach ($array_sub as $sub_leve_2 => $coun_sub) {
                      $count_= $coun_sub+ $count_;
                  }

                  $agrupados_g[$tipo][$sub_leve]['count']=$count_;
                  arsort($array_sub);
                  $agrupados_g[$tipo][$sub_leve]['data']= $array_sub;
                  $agrupados_g[$tipo][$sub_leve]['name_parent']=$sub_leve;

              }
              if(!empty($agrupados_g[$tipo])){
                usort($agrupados_g[$tipo],array($this, "cmpcategoria"  ));

              }
              // $agrupados_g[$tipo]['count']=$count_;
              // $agrupados_g[$tipo]['data']=$arra_;

          }






           if(!empty($this->result_agroup)){
              foreach ($this->result_agroup[$this->alias] as  $field_key=>$data) {
              if($field_key!=='publicacion' ) arsort($data);
              $agrupados[$field_key]=$data;
             }

           }


        $agrupados=array_merge($agrupados,$agrupados_g);



      return $agrupados;

  }


private function formato_fecha($field){
    return "to_char( $this->alias.$field,'MM/DD/YYYY')";

}


  public function agregarCondiciones( $params){
        $conditions=array();

              $fields=array(

                        "tipo" => "$this->alias.oferta_tipo",
                        "escolaridad" => "$this->alias.oferta_escolaridad",
                        "genero" => "$this->alias.oferta_genero",
                        "estado_civil"=> "$this->alias.oferta_edocivil",
                        "disponibilidad"=> "$this->alias.oferta_disponibilidad",
                        "sueldo" => "$this->alias.oferta_sueldo",
                        "ciudad" => "$this->alias.ciudad_nom",
                        "publicacion" => $this->formato_fecha("oferta_fecini"),
                        "estado" => "$this->alias.est_nom",
                        "area" =>  array(
                                              "$this->alias.oferta_area1",
                                              "$this->alias.oferta_area2",
                                              "$this->alias.oferta_area3"

                          )  ,
                        "categoria" =>  array(
                                              "$this->alias.oferta_cat1",
                                              "$this->alias.oferta_cat2",
                                              "$this->alias.oferta_cat3"

                          )
                    );


    foreach ($params as $query => $data) {
      if(array_key_exists($query,$fields)  !== false &&  !empty($data) ){

        if(is_array($fields[$query])){
          foreach ($fields[$query] as  $fielts) {
          $conditions['OR'][$fielts]= $data;

          }
       }
        else{
          if($query=="publicacion"){
            /*falta decodificar*/

            $data=$this->formato_fecha_publicacion_decode($data);


          }
          if($data){
            $conditions['AND'][$fields[$query]]=$data;
          }
        }




      }
    }

      $conditions['AND'][]=" $this->alias.oferta_fecfin >= CURRENT_DATE ";
      return $conditions;



  }


   private function formato_fecha_publicacion_decode($str=null ){
      if(!$str){
          return null;
      }
      $dia=(1*24*60*60);
        $time=time();
        if($str=="Hoy" ){
            return date("m/d/Y");
        }
        else if ($str=="Ayer"){
            return date("m/d/Y",   $time -$dia  );
        }
        else if (preg_match("/(Hace [0-9]+)/", $str, $matches)  ) {
              $p= explode("Hace",$matches[0]);
              $dias_menos= $p[1];
              return date("m/d/Y",   $time - ($dia * $dias_menos) );
        }
        return null;
  }
/**
 * funcion para realizar busquedas en oracle
 * @param  array  $options  opciones utulizadas para realizar busqueda
 *
 *    
 * 
 * @return [type]         arreglo de oferta encontrdas
 */
  public function  realizar($_options=array()){
    $_options1=array(
      'params' => array(),
      'is_group' => false,
      'search_acum' =>false,
      'conditions' => array(),
      'order' => array()
    );
    $_options=array_merge($_options1,$_options);
    extract($_options, EXTR_OVERWRITE);
    $str_expresion=$this->preparaConsulta($params);
    $options=  array(
                      "conditions"=>  $this->agregarCondiciones($params)
      );
    if($str_expresion!== false ){
      $template_query=  str_replace("__expresion__",$str_expresion, $this->template_query[ !$search_acum ? 'normal': 'perfil'   ]);
      $options['conditions']['AND']["contains($this->alias.oferta_texto,?,1) > 0"] = array($template_query);
    }
    $fields=array();
    foreach ($this->campos  as $value) {
      $fields[]= "$this->alias.$value";
    }
    $options['fields']=$fields;

    if(!empty($order)){
          $options['order'] =$order;
    }
    else{
        $options['order'] =array();
    }
    if($str_expresion !==false){
        $options['fields'][]="score(1) {$this->alias}__score";
    }
    $options['fields'][]="to_char ($this->alias.oferta_fecini,'MM/DD/YYYY') ".$this->alias."__publicacion";
    // $options['order'][]=  "$this->alias.oferta_status DESC";
    if($str_expresion!==false){
          $options['order'][]="score(1) DESC";

    }
    $options['order'][]= "$this->alias.oferta_fecini DESC";
    if(!$is_group){
       if(isset($params["iDisplayStart"]) && !empty($params["iDisplayStart"])){
      $options['offset'] =$params["iDisplayStart"];

      }
      if(isset($params["iDisplayLength"])&&!empty($params["iDisplayLength"])){
        $options['limit'] =$params["iDisplayLength"];
      }
    }
    if(!empty($conditions)){
       $options['conditions']['AND'][]=$conditions;
    }
    if(!empty($this->micrositio)){
        $options['conditions']['AND']["$this->alias.cia_nom"]=$this->micrositio['name_full'];

    }
    $rs= $this->find("all",$options);
    $empty_rs=empty($rs)&& empty($this->micrositio) ;
    $ultimas=10;
    if($empty_rs && !$is_group && empty($conditions)){
        $rs=$this->find("all",array(
                                'order' =>array(
                                                "$this->alias.oferta_status DESC",
                                                "$this->alias.oferta_fecini DESC"
                                              ),
                                'limit' => $ultimas,
                                'fields' => array_merge($fields,
                                                array("to_char ($this->alias.oferta_fecini,'MM/DD/YYYY') ".$this->alias."__publicacion")) ,
                                'conditions' => array(
                                                          "$this->alias.oferta_fecfin >= CURRENT_DATE ",
                                                          "$this->alias.oferta_status >" => 1
                                  )
          ));
    }
    $iTotal=0;
    if(!$search_acum && !$is_group){
         $iTotal=$this->find("count",array("conditions" => $options['conditions']));
    }
    $iFilteredTotal=count($rs);
      $resultado=array(
        "is_empty"=>$empty_rs,
        "iTotalRecords" =>    $empty_rs ? $ultimas:$iFilteredTotal,
        "iTotalDisplayRecords" =>  $empty_rs ? $ultimas: $iTotal,
        "data" => $rs
    );
      if(isset($params["sEcho"])&&!empty($params["sEcho"])){
       $resultado["sEcho"] =intval($params['sEcho']);
      }

    return  $resultado;


  }

   public function beforeFind($queryData = array()) {
    $queryData = parent::beforeFind($queryData);
    App::uses("Acceso","Utility");
    if (Acceso::is()==='candidato') {
      $ofertasId = ClassRegistry::init("Reportar")->getReportedUsers( AuthComponent::user('candidato_cve') );
      !empty($ofertasId) && $queryData['conditions']['NOT'][$this->alias . '.oferta_cve'] = $ofertasId;
    }
    return $queryData;
  }

  private function getdatas_n($value=array()){
      $info=explode("&",$value);
      foreach ($info as $params) {
             $param =explode("=",$params);
              if(count($param) !=2 ){
                continue;
              }
              $this->agrupando_($param[1],$this->alias,$param[0]);

      }
  }

  public static function prestaciones_str($json = '[]') {
    $arrayPrestaciones = json_decode($json);
    $prestaciones = ClassRegistry::init('Catalogo')->lista('prestaciones');

    $rs = array();
    foreach ($arrayPrestaciones as $value) {
      $rs[] = $prestaciones[$value];
    }

    return $rs;
  }

  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);


      $this->campos=array(
      'oferta_cve',
//    'oferta_texto',
      'ciudad_nom',
      'est_nom',
      'puesto_nom',
      'cia_nom',
      'pais_nom',
      'oferta_prestaciones',
      'oferta_resumen',
      'oferta_sueldo',
      'oferta_tipo',
      'oferta_experiencia',
      'oferta_escolaridad',
      'oferta_genero',
      'oferta_edocivil',
      'oferta_disponibilidad',
      'oferta_fecini',
      'oferta_status',
      'oferta_privada',
      'cia_cve',
      'oferta_area1',
      'oferta_area2',
      'oferta_area3',
      'oferta_cat1',
      'oferta_cat2',
      'oferta_cat3'
        );


  }







}
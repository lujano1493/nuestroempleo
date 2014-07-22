<?php 
/*modelo protipo para modelos relacionados añ candidato */
App::import('Vendor','funciones');
class ModelCan extends AppModel {
  public $actsAs = array('Containable',"GraficaCan");
  public $name='ModelCan';
  public $useTable = ''; 
  public $primaryKey="";
  public $candidatoKey="candidato_cve";
  public $dataUser=array();
  public $field_extract_info=array();
  public $limit_extract_info=-1;  //por default traer toda la información
  public $hasMany = array(   

    );

  /* atributo para aplicar compartamiento en graficaCan*/

  public $create_update=false;

  public $belongsTo = array( );


  public $findMethods = array(
    'all_info'    => true,
    'basic_info'  => true,
    );


  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);    
    $this->virtualFields = array(

      );


  }
  protected function _findBasic_info($state, $query, $results = array()) {
    if ($state == 'before') {

      return $query;
    }

    return $results;
  }

  public function checkBeforeInsertGrafCan($options = array() ){
    return true;

  }


  public function uniqueData($field,$param=array()) {        
        $data=$this->data[$this->alias];
        $id=!empty($data[$this->primaryKey]) ? $data[$this->primaryKey] : $this->id  ;        
        $conditions=array(
            "$this->candidatoKey"=> $data[$this->candidatoKey]
          );

        $conditions=array_merge($field,$conditions );  
        if($id){
          $conditions["$this->primaryKey !="]=$id;
        }

        $existing_promo_count = $this->find('count', array(
            'conditions' => $conditions,
            'recursive' => -1
        ));

        $flag=true;        
        if(array_key_exists("field_user",$param)){          
          
          $field_u =$this->dataUser[$param['field_user']];
          $value=array_values($field)[0];
          $flag=$field_u != $value;  
         }
        return $existing_promo_count == 0  && $flag;
    }




    public function beforeSaveData($id=null){

    }

    protected function info_extract_dato($rs=array()){
        $str="";
        return "";
    }


    public function add_separator($is_empty=false,$index=0,$size=0){
        return ($index+1 <  $size && !$is_empty   ? ", ": " "   ) ;
    }



    public function datos_busqueda_oferta($id=null){

          if(empty($this->field_extract_info)){
              return;

          }


          $options= array(
                            "conditions" => array(
                                                  "candidato_cve" => $id
                                  ),
                            "fields" => $this->field_extract_info

            );

          if($this->limit_extract_info != -1 ){
                $options['limit']=$this->limit_extract_info;
          }

          $rs=$this->find("all",$options ); 
          if( empty($rs)){
              return"";
          }

          $arr=array();
          $size=count($rs);
          for ($index=0;$index< $size ; $index++) {
                $value=$rs[$index];
                foreach ($value as $name_model => $info) {   
                    foreach ($info as $field => $data) {
                     $arr[$field] =$data;         
                    }               
                }            

          }
          return $arr;

    }





  // public function afterSaveData(CandidatoController $controller = null){

  // }



}


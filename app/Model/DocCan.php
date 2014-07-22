<?php 

App::import('Model', 'ModelCan');
class DocCan extends ModelCan {
	public $name='DocCan';
	public $useTable = 'tdocscandidato'; 
	public $primaryKey="docscan_cve";


  public $tipo_doc="0";
  public $is_fotoperfil=false;
	public $belongsTo = array(    
    'Usuario'=> array(
      'className'    => 'Candidato',
      'foreignKey'   => "candidato_cve"
      )
    );


 public $findMethods = array(
    'documentos'  => true,
    'documento' => true 
  );
  

  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);    
     $this->virtualFields = array(

    );

  
  }

	/*verificamos que la foto no halla sido insertada anteriormente*/
	public function checkBeforeInsertGrafCan($options = array() ){
      /*si es una imagen */
      return $this->tipo_doc=="1" && $this->is_fotoperfil  ;
	}


  protected function _findDocumentos($state, $query, $results = array()) {
    if ($state == 'before') {
      $query['contain'] = array(
        'Usuario'
      );
      $query['conditions']=array(
        "$this->alias.candidato_cve" => $query['idUser'],
        "docscan_nom !=" => "foto"

      );
      return $query;
    }

    return $results;
  }

    protected function _findDocumento($state, $query, $results = array()) {
    if ($state == 'before') {
      $query['contain'] = array(
        'Usuario'
      );
      $query['conditions']=array(
        "$this->alias.candidato_cve" => $query['idUser'],
        "$this->alias.$this->primaryKey" => $query['id'],
        "docscan_nom !=" => "foto"

      );
      return $query;
    }

    return $results;
  }


  public function beforeSave($options = array()){

    if($this->data[$this->alias]["tipodoc_cve"]==10 ){
        $name=$this->data[$this->alias]["docscan_nom"];
        if (! preg_match("/(https?|s?ftp):\/\//", $name, $matches)) {      
          $name="http://$name";
        }
        $this->data[$this->alias]["docscan_nom"]=$name;
    }
    return parent::beforeSave();

  }







}


<?php 
class Compartir extends AppModel {
	public $name='Compartir';
	public $useTable = 'tcompartir'; 
	public $primaryKey="compartir_cve";

  	public $virtualFields = array();
  	public $type=array(
  		"oferta" => 1,
  		"evento" => 2
  	);
  	public $red_social=array(
  		"facebook" => 1,
  		"twitter" => 2,
  		"linkedin" => 3
  	);

  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);
  }
  public function compartir($id=null,$tipo=null,$red=null){
  	$this->create();
  	return $this->save(array(
  		$this->alias => array(
  			"compartir_id" => $id,
  			"compartir_tipo" => $this->type[$tipo],
  			"compartir_redsocial" => $this->red_social[$red]
  			)
  		)
  	);


  }  

  public function beforeSave($options = array()) {    
    return parent::beforeSave($options);
  }

}
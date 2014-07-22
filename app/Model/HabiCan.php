<?php
App::import('Model', 'ModelCan');
class HabiCan extends ModelCan {
	public $name='HabiCan';
	public $useTable = 'thabilidadcandidato'; 
	public $primaryKey="habican_cve";


	public $belongsTo = array(
  	
  	'Habi'=> array(
  		'className'    => 'Catalogo',
  		'foreignKey'   => false,
  		'conditions' => array(
  								'Habi.opcion_valor = HabiCan.habilidad_cve' ,
  								'Habi.ref_opcgpo' => 'HABILIDAD_CVE'
  							)
  		)
  	);
	


 public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id,$table,$ds);		
    	 

	}
	


		
}
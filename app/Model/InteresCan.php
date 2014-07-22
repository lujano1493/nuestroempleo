<?php
App::import('Model', 'ModelCan');
class InteresCan extends ModelCan {
	public $name='InteresCan';
	public $useTable = 'tinterescandidato'; 
	public $primaryKey="interescan_cve";	


	public $belongsTo = array(
  	
			  	'Interes'=> array(
			  		'className'    => 'Catalogo',
			  		'foreignKey'   => false,
			  		'conditions' => array(
			  								'Interes.opcion_valor=InteresCan.interes_cve',
			  								'Interes.ref_opcgpo' => 'INTERES_CVE'
			  							),
			  		)
  	);



 public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id,$table,$ds);		

    

	}
	



		
}

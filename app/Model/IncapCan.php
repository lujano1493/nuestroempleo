<?php

App::import('Model', 'ModelCan');

class IncapCan extends ModelCan {
	public $name='IncapCan';
	public $useTable = 'tincapcandidato'; 
	public $primaryKey="incapcan_cve";		
	public $actsAs = array('Containable');



	public $belongsTo = array(
  	
			  	'Inca'=> array(
			  		'className'    => 'Catalogo',
			  		'foreignKey'   => false,
			  		'conditions' => array(
			  								'Inca.opcion_valor=IncapCan.incapacidad_cve' ,
			  								'Inca.ref_opcgpo' => 'INCAPACIDAD_CVE'
			  							),
			  		)
  	);



 public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id,$table,$ds);		

    	 $this->field_extract_info= array(
                                        // "Inca.opcion_texto"                                        

      );

	}
	


}
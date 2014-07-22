<?php

App::import('Model', 'ModelCan');
class IdiomaCan extends ModelCan {
	public $name='IdiomaCan';
	public $actsAs = array('Containable');
	public $useTable = 'tidiomacandidato'; 
	public $primaryKey="ic_cve";	

	public $msg_succes="Idiomas";
	
	public $belongsTo = array(
        	'Idioma' => array(
            'className'    => 'Idioma',
            'foreignKey'   => 'idioma_cve'
        )
		
    );
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id,$table,$ds);		

    	 $this->field_extract_info= array(
                                        // "Idioma.idioma_nom"                                        

      );

	}
	


		
}
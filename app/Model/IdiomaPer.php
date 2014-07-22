<?php

class IdiomaPer extends AppModel {
	var $name='IdiomaPer';
	var $useTable = 'tidiomapersona'; 
	var $primaryKey="idiper_cve";	

		 
		 
	public $belongsTo = array(
        	'Idioma' => array(
            'className'    => 'Idioma',
            'foreignKey'   => false,
			 'conditions' => array('Idioma.idioma_cve = IdiomaPer.idioma_cve')

        )
		
    );
	
	 function all($candidato_cve){		 
		return 	 $this->find("all",array(
											"conditions"=>array (
																	"IdiomaPer.candidato_cve"=>$candidato_cve
																)

											));
		 
	}
	 
		

		
		
}
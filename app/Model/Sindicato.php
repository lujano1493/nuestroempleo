<?php
 class Sindicato extends AppModel{
 	public $name="Sindicato";
 	public $useTable = 'tsindicato';
 	 public $primaryKey = 'sindi_cve';
 	 
	var $encode_utf= array (array('model'=>'Sindicato', //para mostrar
					'fields'=>array("sindi_nom"))   );
	
	var $decode_utf= array (array('model'=>'Sindicato',
					'fields'=>array("sindi_nom"))   );//para guardar
 	 function all(){		 
			return 	 $this->find("list",array ("fields"=>array ("Sindicato.sindi_cve","Sindicato.sindi_nom")));
		 
	}
	 
 
 
 }
 
 
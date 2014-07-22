<?php

class Idioma extends AppModel {
	public $name='Idioma';
	public $useTable = 'tidioma'; 
	public $primaryKey="idioma_cve";	
	public $displayField ="idioma_nom";
	
	
	
	public $encode_utf= array (array('model'=>'Idioma', //para mostrar
					'fields'=>array("idioma_nom"))   );
	
	public $decode_utf= array (array('model'=>'Idioma',
					'fields'=>array("idioma_nom"))   );//para guardar
	
	 function lista(){
		 
		return 	 $this->find("list",array ("order"=>"idioma_nom asc" ));
		 
	}
	 
		

		
		
}
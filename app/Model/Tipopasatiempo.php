<?php


class TipoPasatiempo extends AppModel {
	var $name='TipoPasatiempo';
	var $useTable = 'ttipopasatiempo'; 
	var $primaryKey="pasa_cve";	
	var $virtualFields= array(

	);
	
		var $encode_utf= array (array('model'=>'TipoPasatiempo', //para mostrar
					'fields'=>array("pasa_nom"))   );
	
	var $decode_utf= array (array('model'=>'TipoPasatiempo',
					'fields'=>array("pasa_nom"))   );//para guardar
	

	
	 
	 function all(){
		return 	 $this->find("all", array ('order'=>'TipoPasatiempo.pasa_cve ASC' ));
		 
	}
	 
	 
	
		

		
		
}
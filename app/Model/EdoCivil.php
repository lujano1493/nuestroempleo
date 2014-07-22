<?php 

	class EdoCivil extends AppModel {
    	var $name='EdoCivil';
		var $useTable = 'tedocivil'; 
		var $displayField = "edocivil_nom";


		
		var $encode_utf= array (array('model'=>'EdoCivil', //para mostrar
					'fields'=>array("edocivil_nom"))   );
	
	var $decode_utf= array (array('model'=>'EdoCivil',
					'fields'=>array("edocivil_nom"))   );//para guardar
	

	
		

		function getEdoCivilList(){
			return $this->find('list', array( 'fields' => array('EdoCivil.edocivil_cve', 'EdoCivil.edocivil_nom')));
		}
		
		
		

}



?>
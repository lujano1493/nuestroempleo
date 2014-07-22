<?php


class RefCom extends AppModel {
	var $name='RefCom';
	var $useTable = 'treferenciascom'; 
	var $primaryKey="refcom_cve";	
	var $virtualFields= array(
		"clave"=>"refcom_cve",
		"nombre"=>"refcom_contac",
		"correo"=>"refcom_correo",
		"telefono"=>"refcom_tel",
		"tipo"=>"0",
		"anio"=>"refcom_aniocon"
	
	);

	
	var $encode_utf= array (array('model'=>'RefCom', //para mostrar
					'fields'=>array("refcom_rs",'refcom_contac'))
		
		);
	var $decode_utf= array (array('model'=>'RefCom',//para guardar
					'fields'=>array("refcom_rs",'refcom_contac'))
		
		);

	 
	function all ($candidato_cve){
		return $this->find ('all', array( 'conditions'=>array( 'RefCom.candidato_cve'=>$candidato_cve  )));
	
	}	
	
	 
	
		

		
		
}
<?php


class RefPer extends AppModel {
	var $name='RefPer';
	var $useTable = 'treferenciasper'; 
	var $primaryKey="refper_cve";	
	var $virtualFields= array(
		"clave"=>"refper_cve",
		"nombre"=>"refper_nom",
		"correo"=>"refper_correo",
		"telefono"=>"refper_tel",
		"tipo"=>"tiporefper_cve",
		"anio"=>"refper_aniocon"
	
	);
	var $encode_utf= array (array('model'=>'RefCom', //para mostrar
					'fields'=>array("refcom_rs",'refcom_contac'))
		
		);
	var $decode_utf= array (array('model'=>'RefCom',//para guardar
					'fields'=>array("refcom_rs",'refcom_contac'))
		
		);
	

	 
	function all ($candidato_cve){
		return $this->find ('all', array( 'conditions'=>array( 'RefPer.candidato_cve'=>$candidato_cve  )));
	
	}	

	 
	
		

		
		
}
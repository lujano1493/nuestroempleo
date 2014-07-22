<?php


class TipoRef extends AppModel {
	var $name='TipoRef';
	var $useTable = 'ttiporefpersonales'; 
	var $primaryKey="tiporefper_cve";	
	var $virtualFields= array();
	var $encode_utf= array (array('model'=>'TipoRef', //para mostrar
					'fields'=>array("tiporefper_nom"))
		
		);
	var $decode_utf= array (array('model'=>'TipoRef',//para guardar
					'fields'=>array("tiporefper_nom"))
		
		);
	function all(){
		return $this->find('list', array(
			'fields' => array('TipoRef.tiporefper_cve', 'TipoRef.tiporefper_nom'),
			'order' => array ('tiporefper_cve'=> 'ASC' )
		
			));
	
	}
		
}
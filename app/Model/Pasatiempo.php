<?php


class Pasatiempo extends AppModel {
	var $name='Pasatiempo';
	var $useTable = 'tpasatiempo'; 
	var $primaryKey="pas_cve";	
	var $virtualFields= array(

	);

	
		var $encode_utf= array (array('model'=>'Pasatiempo', //para mostrar
					'fields'=>array("pas_nom")),
					
					array('model'=>'Tipopasatiempo',
					'fields'=>array("pasa_nom")) ,
		
		);
	
	var $decode_utf= array (array('model'=>'Pasatiempo',
					'fields'=>array("pas_nom")) ,
					array('model'=>'Tipopasatiempo',
					'fields'=>array("pasa_nom")) ,
	
					);//para guardar
	
	 
	 public $belongsTo = array(
        	'Tipopasatiempo' => array(
            'className'    => 'Tipopasatiempo',
            'foreignKey'   => false,
			 'conditions' => array('Pasatiempo.pasa_cve = Tipopasatiempo.pasa_cve')

        ));
	
	
	 function all(){
		return 	 $this->find("all", array ('order'=> array('Pasatiempo.pasa_cve asc' ,'Pasatiempo.pas_cve asc')));
		 
	}
	 
	 
	
		

		
		
}
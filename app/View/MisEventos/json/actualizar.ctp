<?php


	if($id){
		$data = array(
	    	'id' => (int)$id
  			);

	  	if (!empty($evento['Evento'])) {
	    	$data['inicio'] = $this->Time->dt($evento['Evento']['start']);
	    	$data['fin'] = $this->Time->dt($evento['Evento']['end']);
	  	}

	  $this->_results = $data;

	}
	
?>
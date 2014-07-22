<?php 

  $this->set('noValidationErrors', true);
  $results = $datos['data']; 
  unset($datos['data']);
  $results= array_merge(array( "data" =>$results ),   array("paginate"=>$datos) );
  $this->_results = $results;

?>
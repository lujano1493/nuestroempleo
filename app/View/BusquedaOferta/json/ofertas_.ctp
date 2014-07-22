<?php 

  $this->set('noValidationErrors', true);
  $results = $this->OfertasB->formatToJson($datos ,array()); 
  unset($datos['data']);
  $results= array_merge(array( "data" =>$results ),   array("paginate"=>$datos) );
  $this->_results = $results;

?>
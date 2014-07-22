


<?php

  $this->set('noValidationErrors', true);
  $results = $this->OfertasB->formatToJson($data ,array());
  unset($data['data']);
  $results= array_merge(array( "data" =>$results ),   array("paginate"=>$data) );
  $this->_results = $results;
?>


<?php 
  echo json_encode(array(
    'statusCode' => $this->response->statusCode(),
    'message' => $this->Session->flash(),
    'validationErrors' => $this->validationErrors
  ));
?>
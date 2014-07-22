<?php 
   echo json_encode(array(
    'statusCode' => $this->response->statusCode(),
    'message' => $this->Session->flash(),
    'validationErrors' => array_intersect_key(
      $this->validationErrors, 
      array_flip(
        array('CandidatoUsuario','DirCandidato')
      )
    )
    //'validationErrors' => Hash::flatten($this->validationErrors)
  ));

?>
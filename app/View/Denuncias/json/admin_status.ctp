<?php  

	 if (!empty($callback) && !empty($denuncias)) {
    $callback['args'] = array(
      $this->Denuncia->formatToJson($denuncias)
    );
    $this->set(compact('callback'));
  }


?>
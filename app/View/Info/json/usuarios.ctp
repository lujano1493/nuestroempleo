<?php 
  $formattedUsers = [];


  foreach ($usuarios as $key => $value) {
    if ($authUser['cu_cve'] != $value['UsuarioEmpresa']['cu_cve']) {
      $formattedUsers[] = array(
        'id' => $value['UsuarioEmpresa']['cu_cve'],
        'name' => $value['UsuarioEmpresa']['cu_sesion'],
      );
    }
  }

  $this->_results = $formattedUsers;

  //echo json_encode(array(
  //  'results' => $formattedUsers
  //));  
?>
<?php

  foreach ($usuarios as $k => $v) {
    $usuarios[$k] = $v['Contacto'];
    $usuarios[$k]['cu_cve'] = $v['EmpresaUsuario']['cu_cve']; 
    $usuarios[$k]['html_link'] = $this->Html->link($v['Contacto']['con_email'], '#');
  }

  echo json_encode(
    array(
      'usuarios' => $usuarios
    )
  );
?>
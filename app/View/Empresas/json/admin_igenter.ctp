<?php

  foreach ($empresas as $key => $value) {
    // Elimina el nombre del modelo.
    $empresas[$key] = $value['Empresa'];
    
    $empresas[$key]['html_link'] = $this->Html->link($value['Empresa']['cia_nom'], '#');
    
    $empresas[$key]['url'] = $this->Html->url(array(
      'admin' => 1,
      $value['Empresa']['cia_cve'],
      'ext' => 'json'
    ));
    
    $empresas[$key]['users_url'] = $this->Html->url(array(
      'admin' => 1,
      'controller' => 'cuentas',
      'action' => 'igenter',
      $value['Empresa']['cia_cve'],
      'ext' => 'json'
    ));

    if (isset($value['DirCompania']) && isset($value['DirCompania']['dircia_cve'])) {
      $empresas[$key]['dir'] = $value['DirCompania'];
    } else {
      $empresas[$key]['dir'] = 'La compañia no cuenta con domicilio fiscal.';
    }
  }
  
  echo json_encode(array(
    'empresas' => $empresas
  ));
?>
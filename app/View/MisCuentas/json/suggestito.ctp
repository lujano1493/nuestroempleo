<?php
  $results = array();

  foreach ($cuentas as $k => $v) {
    $cuenta = array(
      'id' => (int)$v['UsuarioEmpresa']['cu_cve'],
      'name' => $v['UsuarioEmpresa']['cu_sesion']
    );

    $results[] = $cuenta;
  }


  $this->_results = $results;
?>
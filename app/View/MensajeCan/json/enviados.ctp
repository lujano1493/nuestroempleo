<?php
  $results = array();

  foreach ($mensajes as $k => $v) {
    $msj = array(
      'id' => (int)$v['Mensaje']['msj_cve'],
      'asunto' => $v['Mensaje']['msj_asunto'],
      'contenido' => $v['Mensaje']['msj_texto'],
      'importante' => (int)$v['Mensaje']['msj_importante'],
      'enviado' => array(
        'val' => $v['Mensaje']['created'],
        'str' => $this->Time->dt($v['Mensaje']['created']),
        'order' => $v['Mensaje']['created_order']
      ),
      'para' => array(
      )
    );

    if (!empty($v['ReceptorEmpresa'])) {
      $reclutadores = array();
      foreach ($v['ReceptorEmpresa'] as $k_r => $v_r) {
        $r = array(
          'id' => (int)$v_r['receptor_cve'],
          'email' => $v_r['Cuenta']['email'],
          'nombre' => $v_r['Cuenta']['nombre']
        );

        $reclutadores[] = $r;
      }
      $msj['para']['reclutadores'] = $reclutadores;
    }

    if (!empty($v['ReceptorCandidato'])) {
      $candidatos = array();
      foreach ($v['ReceptorCandidato'] as $k_c => $v_c) {
        $c = array(
          'id' => (int)$v_c['receptor_cve'],
          'email' => $v_c['Cuenta']['email'],
          'nombre' => $v_c['Cuenta']['nombre']
        );

        $candidatos[] = $c;
      }
      $msj['para']['candidatos'] = $candidatos;
    }

    $results[] = $msj;
  }

  $this->_results = $results;
?>
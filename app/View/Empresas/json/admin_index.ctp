<?php
  $empresas = array();
  // debug($lista_empresas);die;
  foreach ($lista_empresas as $k => $v) {
    $e = $v['Empresa'];
    $c = $v['AdminContacto'];
    $a = $v['Admin'];
    $ec = $v['EjecutivoContacto'];
    // $d = $v['DatosEmpresa'];

    $emp = array(
      'id' => (int)$e['cia_cve'],
      'nombre' => $e['cia_nombre'],
      'rfc' => $e['cia_rfc'],
      'slug' => Inflector::slug($e['cia_nombre'] . ' ' . $e['cia_cve'], '-'),
      'tipo' => array(
        'text' => (int)$e['cia_tipo'] === 0 ? __('Comercial') : __('Convenio'),
        'val' => (int)$e['cia_tipo'] === 0 ? 'comercial' : 'convenio',
      ),
      'admin' => array(
        'id' => (int)$c['cu_cve'],
        'nombre' => implode(' ', array(
          $c['con_nombre'], $c['con_paterno'], $c['con_materno']
        )),
        'email' => $a['cu_sesion'],
        'tel' => !empty($c['con_tel']) ? $c['con_tel'] : __('N/D')
      ),
      'ejecutivo' => array(
        'nombre' => implode(' ', array(
          $ec['con_nombre'],
          $ec['con_paterno'],
          $ec['con_materno'],
        ))
      ),
      'fecha_alta' => array(
        'val' => $e['created'],
        'str' => $this->Time->dt($e['created'])
      ),
      'datos' => array(

      )
    );

    if ((int)$e['cia_tipo'] === 1) {
      $emp['status'] = array(
        'value' => (int)$v['Empresa']['convenio_status'],
        'text' => $v['Empresa']['convenio_status_text'],
      );
    }


    $empresas[] = $emp;
  }

  $this->_results = $empresas;

?>
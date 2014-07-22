<?php
  $this->set('noValidationErrors', true);

  $e = $empresa['Empresa'];
  $c = $empresa['AdminContacto'];
  $a = $empresa['Admin'];
  $d = $empresa['Datos'];
  $ec = $empresa['EjecutivoContacto'];
  $ej = $empresa['Ejecutivo'];

  $emp = array(
    'id' => (int)$e['cia_cve'],
    'nombre' => $e['cia_nombre'],
    'web' => $d['web'],
    'telefono' => $d['telefono'],
    'rfc' => $e['cia_rfc'],
    'slug' => Inflector::slug($e['cia_nombre'] . ' ' . $e['cia_cve'], '-'),
    'admin' => array(
      'id' => (int)$c['cu_cve'],
      'nombre' => implode(' ', array(
        $c['con_nombre'], $c['con_paterno'], $c['con_materno']
      )),
      'email' => $a['cu_sesion'],
      'tel' => !empty($c['con_tel']) ? $c['con_tel'] : __('N/D')
    ),
    'fecha_alta' => array(
      'val' => $e['created'],
      'str' => $this->Time->dt($e['created'])
    ),
    'datos' => array(),
    'ejecutivo' => array(
      'nombre' => implode(' ', array(
        $ec['con_nombre'], $ec['con_paterno'], $ec['con_materno']
      ))
    ),
    'status' => array(
      'value' => (int)$e['convenio_status'],
      'text' => $e['convenio_status_text']
    )
  );

  if (!empty($callback)) {
    $callback['args'] = array(
      $emp
    );

    $this->set(compact('callback'));
  }

?>
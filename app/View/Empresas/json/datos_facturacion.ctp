<?php
  $results = array(
    'datos_id' => $datos['DatosFacturacionEmpresa']['datos_cve'],
    'empresa_nombre' => $datos['FacturacionEmpresa']['cia_nombre'],
    'razon_social' => $datos['FacturacionEmpresa']['cia_razonsoc'],
    'rfc' => $datos['FacturacionEmpresa']['cia_rfc'],
    'giro' => $datos['FacturacionEmpresa']['giro_cve'],
    'calle' => $datos['DatosFacturacionEmpresa']['calle'] ?: '',
    'num_interior' => $datos['DatosFacturacionEmpresa']['num_int'] ?: '',
    'num_exterior' => $datos['DatosFacturacionEmpresa']['num_ext'] ?: '',
    'telefono' => $datos['DatosFacturacionEmpresa']['cia_tel'],
    'web' => $datos['DatosFacturacionEmpresa']['cia_web'],
    'codigo_postal' => $datos['Direccion']['cp'],
    '_defaults' => array(
      'colonias' => $datos['DatosFacturacionEmpresa']['cp_cve']
    ),
    // '___datos' => $datos
  );

  $this->_results = $results;
?>
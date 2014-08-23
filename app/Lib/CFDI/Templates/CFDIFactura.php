<?php

App::uses('CFDIBase', 'Lib/CFDI/Templates');

class CFDIFactura extends CFDIBase {
  public function generate($data = null, $emisor = null) {
    if (!$data) {
      $data = $this->_data;
    }

    if (empty($emisor)) {
      return false;
    }

    $dir = $data['compania']['domicilio'];

    $this->root(array(
      '@folio' => $data['folio'],
      '@tipoDeComprobante' => 'ingreso',
      '@noCertificado' => '',
      '@certificado' => '',
      '@sello' => '',
      '@formaDePago' => 'Pago en una sola exhibicion',
      '@metodoDePago' => 'No identificado', //'Transferencia Electrónica',
      '@NumCtaPago' => 'No identificado',
      '@LugarExpedicion' => 'DISTRITO FEDERAL, MEXICO',
      '@subTotal' => number_format($data['subtotal'], 2, '.', ''),
      '@total' => number_format($data['total'], 2, '.', ''),
    ))
    ->emisor($emisor)
    ->receptor(array(
      '@nombre' => $this->_e($data['compania']['razon_social']),
      '@rfc' => $data['compania']['rfc'],
      'cfdi:Domicilio' => array(
        '@calle' => $this->_e($dir['calle']),
        '@colonia' => $this->_e($dir['colonia']),
        '@municipio' => $this->_e($dir['ciudad']),
        '@estado' => $this->_e($dir['estado']),
        '@pais' => $this->_e($dir['pais']),
        '@codigoPostal' => $this->_e($dir['cp']),
      )
    ));

    $conceptos = array();
    foreach ($data['conceptos'] as $k => $v) {
      $conceptos[] = array(
        '@cantidad' => $v['cantidad'],
        '@descripcion' => $this->_e($v['descripcion']),
        '@importe' => number_format($v['importe'], 2, '.', ''),
        '@noIdentificacion' => $v['noIdentificacion'],
        '@unidad' => 'Servicio',
        '@valorUnitario' => number_format($v['valorUnitario'], 2, '.', ''),
        '@' => ''
      );
    }

    $impuestos = array();
    foreach ($data['impuestos'] as $k => $v) {
      $impuestos[] = array(
        '@impuesto' => $v['impuesto'],
        '@tasa' => $v['tasa'],
        '@importe' => number_format($v['importe'], 2, '.', ''),
        '@' => ''
      );
    }

    $this->conceptos($conceptos)->impuestos($impuestos);

    return $this;
  }

  public function validate() {
    if (!$this->validateRFC($this->get('cfdi:Receptor.@rfc'))) {
      $this->_errors[] = 'El RFC del receptor no tiene el formato correcto';
    }

    if ($this->exists('cfdi:Receptor.cfdi:Domicilio.@calle', '')) {
      $this->_errors[] = 'La calle del receptor es necesaria';
    }

    return empty($this->_errors);
  }
}
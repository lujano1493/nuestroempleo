<?php
/**
 * Clase Base para generar los CFDI
 */
abstract class CFDIBase {
  protected $_data = array();

  protected $_xmlArray = array();

  protected $_schemaBase = 'cfdi:Comprobante';

  protected $_errors = array();

  protected function paths() {

  }

  public function __construct($data = array()) {
    $this->_data = $data;
  }

  public function init() {
    $this->_xmlArray[$this->_schemaBase] = $this->schema();

    return $this;
  }

  abstract protected function generate($data = null);

  public function insert($path, $value, $add = false, $namespace = 'cfdi') {
    $_root = $this->_xmlArray[$this->_schemaBase];

    $paths = array_map(function ($value) use ($namespace) {
      return $namespace . ':' . $value;
    }, explode('.', $path));

    $mappedPath = implode('.', $paths);

    if (Hash::check($_root, $mappedPath)) {

    } else {
      $this->_xmlArray[$this->_schemaBase] = Hash::insert($_root, $mappedPath, $value);
    }

    return $this;
  }

  public function schema() {
    $schema = array(
      'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
      'xmlns:xs' => 'http://www.w3.org/2001/XMLSchema',
      'xmlns:cfdi' => 'http://www.sat.gob.mx/cfd/3',
      '@xsi:schemaLocation' => 'http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv32.xsd',
      '@version' => '3.2',
      '@fecha' => substr(date('c', strtotime('-1 hour')), 0, 19),
      // '@fecha' => substr(date('c'), 0, 19),
    );

    return $schema;
  }

  public function root($data) {
    $this->_xmlArray[$this->_schemaBase] = array_merge($this->_xmlArray[$this->_schemaBase], $data);

    return $this;
  }

  public function emisor($data) {
    return $this->insert('Emisor', $data);
  }

  public function receptor($data) {
    return $this->insert('Receptor', $data);
  }

  public function conceptos($data) {
    return $this->insert('Conceptos.Concepto', $data);
  }

  public function impuestos($data, $rootData = array()) {
    if (!empty($rootData)) {
      $this->insert('Impuestos', $rootData);
    } else {
      $totalImpuestos = array_sum(Hash::extract($data, '{n}.@importe'));

      $this->insert('Impuestos', array(
        '@totalImpuestosTrasladados' => number_format($totalImpuestos, 2, '.', ''),
      ));
    }

    return $this->insert('Impuestos.Traslados.Traslado', $data);
  }

  public function exists($path, $value = null) {
    $_root = $this->_xmlArray[$this->_schemaBase];

    if (is_null($value)) {
      return Hash::check($_root, $path);
    } else {
      $data = Hash::get($_root, $path);
      return $data === $value;
    }
  }

  public function get($path = null) {
    if (is_null($path)) {
      return $this->_xmlArray;
    }

    $_root = $this->_xmlArray[$this->_schemaBase];
    return Hash::get($_root, $path);
  }

  public function validate() {
    return true;
  }

  public function errors() {
    return $this->_errors;
  }

  /**
   * Escapa el texto.
   * @param  [type] $str [description]
   * @return [type]      [description]
   */
  public function _e($str) {
    $str = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $str);
    $str = preg_replace('!\s+!', ' ', $str);
    $str = strtoupper($str);
    return $str;
  }

  /**
   * Aquí validamos el RFC, si se validaron los RFC al registrarlos, esto no es necesario.
   */
  public function validateRFC($rfc) {
    $validateRFC = "/^(([A-ZÑ&]{3,4})([0-9]{2})([0][13578]|[1][02])(([0][1-9]|[12][\d])|[3][01])([A-Z0-9]{3}))"
    . "|(([A-ZÑ&]{3,4})([0-9]{2})([0][13456789]|[1][012])(([0][1-9]|[12][\d])|[3][0])([A-Z0-9]{3}))"
    . "|(([A-ZÑ&]{3,4})([02468][048]|[13579][26])[0][2]([0][1-9]|[12][\d])([A-Z0-9]{3}))"
    . "|(([A-ZÑ&]{3,4})([0-9]{2})[0][2]([01][1-9]|[2][0-8])([A-Z0-9]{3}))$/";

    return (bool)preg_match($validateRFC, $rfc);
  }
}
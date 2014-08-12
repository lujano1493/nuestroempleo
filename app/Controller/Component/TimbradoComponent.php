<?php

require_once(APP . 'Config' . DS . 'timbrado.php');

App::uses('X509Cert', 'Lib/CFDI');
App::uses('CFDI', 'Lib/CFDI');
App::uses('Xml', 'Utility');

class TimbradoComponent extends Component {

  public $config = array();

  protected $_configName = null;

  /**
   * Constructor del Componente.
   * @param ComponentCollection $collection [description]
   * @param array               $settings   [description]
   */
  public function __construct(ComponentCollection $collection, $settings = array()) {
    parent::__construct($collection, $settings);
  }

  /**
   * Inicializacion del componente.
   * @param  Controller $controller [description]
   * @return [type]                 [description]
   */
  public function initialize(Controller $controller) {
    $this->controller = $controller;
    $this->params = $this->controller->params;
  }

  public function init($config = 'default') {
    $this->config = TimbradoConfig::get($config);

    $this->engine = new X509Cert(
      $this->config['public_key'],
      $this->config['private_key'],
      $this->config['passphrase']
    );

    $this->xdoc = new DomDocument();
    $_xsl = new DOMDocument();
    $_xsl->load($this->config['xlst']);

    $this->proc = new XSLTProcessor;
    $this->proc->importStyleSheet($_xsl);

    $this->soapClient = new SoapClient($this->config['wsdl'], array(
      'encoding' => 'utf-8',
      'trace' => true,
      'cache_wsdl' => WSDL_CACHE_NONE
    ));

    $this->_configName = $config;
  }

  public function timbrar($data, $config = 'default') {
    /**
     * Inicializa la configuración, la comparación se hace para no cargar la configuración cada vez que
     * se intente timbrar.
     */
    if ($this->_configName !== $config || empty($this->config)) {
      $this->init($config);
    }

    $numero_certificado = $this->config['no_cert'];

    $data = $this->testData();

    //generar y sellar un XML con los CSD de pruebas
    if (empty($data)) {
      return false;
    } elseif (is_array($data)) {
      $cfdi = $this->generarXML($data);
    } elseif (is_string($data)) {
      $cfdi = $data;
    } else {
      return false;
    }

    $cfdi = $this->sellarXML($cfdi, $numero_certificado);
    $result = $this->enviar($cfdi);

    debug($result);
    debug($cfdi);
    die;
  }

  public function generarXML($data) {
    $factura = CFDI::create('Factura', $data, $this->config['emisorData']);

    $xml = Xml::build($factura->get(), array(
      'return' => 'domdocument',
      'pretty' => true
    ));

    return $xml->saveXML();
  }

  public function enviar($xml) {
    $opts = new stdClass;
    $opts->usuario = $this->config['usuario'];
    $opts->password = $this->config['password'];
    $opts->xmlFirmado = trim(preg_replace(array("/\n/", '/>\s+</'), array('', '><'), $xml));

    $response = $this->soapClient->getCFDI($opts);

    return $response;
  }

  public function sellarXML($xml, $numero_certificado) {
    $originalString = $this->cadenaOriginal($xml);

    $c = $this->xdoc->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', 'Comprobante')->item(0);
    $c->setAttribute('sello', $this->engine->sello($originalString));
    $c->setAttribute('certificado', $this->engine->certificado());
    $c->setAttribute('noCertificado', $numero_certificado);

    return $this->xdoc->saveXML();
  }

  public function cadenaOriginal($xml) {
    if (!$this->xdoc->loadXML($xml)) {
      return false;
    }

    $cadena_original = $this->proc->transformToXML($this->xdoc);
    return $cadena_original;
  }

  public function testData() {
    return array(
      'total' => 1.16,
      'subtotal' => 1.00,
      'folio' => '00001014',
      'creada' => '2014-07-18 12:32:07',
      'modificada' => '2014-07-18 12:33:09',
      'compania' => array(
        'nombre' => 'Power Engineering de Mexico',
        'razon_social' => 'Power Engineering de Mexico S.A. de C.V.',
        'rfc' => 'PEM001027NS3',
        'giro' => 'Servicios',
        'domicilio' => array(
          'calle' => 'Calle Ejemplo',
          'num_int' => '',
          'num_ext' => '',
          'colonia' => 'Apodaca Centro',
          'ciudad' => 'Apodaca',
          'estado' => 'Nuevo Leon',
          'pais' => 'Mexico',
          'cp' => '66600'
        )
      ),
      'conceptos' => array(
        array(
          'cantidad' => 1,
          'descripcion' => '3 Ofertas',
          'importe' => 1.00,
          'noIdentificacion' => '13',
          'unidad' => 'Servicio',
          'valorUnitario' => 1.00
        )
      ),
      'impuestos' => array(
        array(
          'impuesto' => 'IVA',
          'tasa' => 16.00,
          'importe' => 0.16
        )
      )
    );
  }
}
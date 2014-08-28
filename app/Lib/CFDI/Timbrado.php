<?php

require_once(APP . 'Config' . DS . 'timbrado.php');

App::uses('X509Cert', 'Lib/CFDI');
App::uses('CFDI', 'Lib/CFDI');
App::uses('PeDeEfe', 'Utility');
App::uses('File', 'Utility');
App::uses('CakeEvent', 'Event');

class Timbrado {

  public $config = array();

  protected $_proveedor = null;

  protected $_errors = array();

  protected $_configName = null;

  /**
   * Constructor del Componente.
   * @param ComponentCollection $collection [description]
   * @param array               $settings   [description]
   */
  public function __construct() {
    $this->Factura = ClassRegistry::init('Factura');
  }

  public function initConfig($config = 'default') {
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

    if ($this->testService()) {
      $this->soapClient = new SoapClient($this->config['wsdl'], array(
        'encoding' => 'utf-8',
        'trace' => true,
        'cache_wsdl' => WSDL_CACHE_NONE
      ));
    } else {
      $this->soapClient = false;
    }

    $this->_configName = $config;
  }

  public function testService() {
    $handle = curl_init($this->config['wsdl']);
    curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($handle);
    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);

    if($httpCode == 404) {
      /* You don't have a WSDL Service is down. exit the function */
    }

    curl_close($handle);

    return (int)$httpCode === 200;
  }

  public function procesar($data, $config = 'default') {
    /**
     * Inicializa la configuración, la comparación se hace para no cargar la configuración cada vez que
     * se intente timbrar.
     */
    if ($this->_configName !== $config || empty($this->config)) {
      $this->initConfig($config);
    }

    $numero_certificado = $this->config['no_cert'];

    // $data = $this->testData();

    //generar y sellar un XML con los CSD de pruebas
    if (empty($data)) {
      return false;
    } elseif (is_array($data) && (bool)($cfdi = $this->generarXML($data))) {
      // Aquí se genera el XML, si falla o no es válido retorna false al entrar al else.
    } elseif (is_string($data)) {
      $cfdi = $data;
    } else {
      return false;
    }

    $cfdi = $this->sellarXML($cfdi, $numero_certificado);
    return $this->enviar($cfdi);
  }

  public function timbrar($folio, $config = 'default') {
    $factura = $this->Factura->get('datos_timbrado', array(
      'conditions' => array(
        'factura_folio' => $folio,
        // 'Factura.cia_cve' => $this->Auth->user('Empresa.cia_cve')
      ),
      'first' => true
    ));

    if ((bool)($r = $this->procesar($factura, $config))) {
      $facturaId = $factura['id'];
      $data = array(
        'factura_cve' => $facturaId,
        'uuid' => $r->folioUDDI,
        'cadorig_sat' => $r->cadenaOriginal,
        'sello_sat' => $r->selloDigitalTimbreSAT,
        'url_pdf' => $r->rutaDescargaPDF,
        'url_xml' => $r->rutaDescargaXML,
        'xml' => $r->XML,
        'created' => date('Y-m-d H:i:s', strtotime($r->fechaHoraTimbrado)),
      );

      $this->Factura->begin();
      $this->Factura->Timbrado->begin();
      if ($this->Factura->Timbrado->save($data) && $this->Factura->changeStatus($facturaId, 3)) { //Status 3 = timbrado
        $this->Factura->commit();
        $this->Factura->Timbrado->commit();

        /**
         * Lanza el evento para enviar los archivos por correo.
         */
        $this->dispatchEvent($factura, $r->XML, $r->cadenaOriginal);

        return true;
      } else {
        $this->Factura->rollback();
        $this->_errors[] = __('Error al guardar en la base de datos. Folio: %s, UUID: %s', $folio, $r->folioUDDI);
        return false;
      }
    } else {
      return false;
    }
  }

  public function generarXML($data) {
    $factura = CFDI::create('Factura', $data, $this->config['emisorData']);

    if (!$factura->validate()) {
      $this->_errors = $factura->errors();
      return false;
    }

    $xml = Xml::build($factura->get(), array(
      'return' => 'domdocument',
      'pretty' => true
    ));

    return $xml->saveXML();
  }

  public function dispatchEvent($factura, $xml = null, $cadenaOriginal = null) {
    $ciaId = $factura['compania']['id'];
    $admin = $this->Factura->Empresa->get('admin', $ciaId);
    $email = $admin['Administrador']['cu_sesion'];

    if (!empty($email)) {
      $event = new CakeEvent('Timbrado.factura_timbrada', $this, array(
        'folio' => $factura['folio'],
        'email' => $email,
        'files' => $this->getTMPFiles($factura['folio'], $xml, $cadenaOriginal)
      ));

      $this->Factura->getEventManager()->dispatch($event);
    }
  }

  public function getTMPFiles($folio, $xml = null, $cadenaOriginal = null) {
    $fileName = '/tmp/ne_files/timbrado_' . $folio;
    $files = array();

    if ((bool)$xml) {
      $f = new File($fileName . '.xml', true);

      if ($f->write($xml)) {
        $files[__('Timbrado_%s.%s', $folio, 'xml')] = $f->path;
      }
    }

    if (true) {
      $files[__('Timbrado_%s.%s', $folio, 'pdf')] = PeDeEfe::fromView($fileName, '/Facturas/pdf/factura', array(
        'factura' => Xml::toArray(Xml::build($xml)),
        'cadenaOriginal' => $cadenaOriginal
      ))->save();
    }

    return $files;
  }

  public function enviar($xml) {
    $opts = new stdClass;
    $opts->usuario = $this->config['usuario'];
    $opts->contrasenia = $this->config['password'];
    $opts->idServicio = 5906390; //5652422; //5652500;
    $opts->xml = trim(preg_replace(array("/\n/", '/>\s+</'), array('', '><'), $xml));

    if (!(bool)$this->soapClient) {
      $this->_errors[] = __('El servidor SOAP no está disponible.');
    } else {
      $response = $this->soapClient->EmitirTimbrar($opts);
      if (isset($response->return->isError) && (bool)$response->return->isError) {
        // debug($opts->xml);die;
        /**
         * Ocurrió un error
         */
        $this->_errors[] = $response->return->message;
      } elseif(isset($response->return->XML) && !empty($response->return->XML)) {
        // $r = new stdClass;
        // $r->uuid = $response->return->folioUDDI;
        // $r->cadenaOriginalSAT = $response->return->cadenaOriginal;
        // // $r->sello = $response->return->selloDigitalEmisor;
        // $r->selloSAT = $response->return->selloDigitalTimbreSAT;
        // $r->urlPDF = $response->return->rutaDescargaPDF;
        // $r->urlXML = $response->return->rutaDescargaXML;
        // $r->XML = $response->return->XML;
        // $r->fechaTimbrado = $response->return->fechaHoraTimbrado;

        $response->return->XML = trim(preg_replace(array("/\n/", '/>\s+</'), array('', '><'), $response->return->XML));
        /**
         * Respuesta exitosa
         */
        return $response->return;
      }
    }

    return false;
  }

  public function cancelar($folio, $config = 'default') {
    if ($this->_configName !== $config || empty($this->config)) {
      $this->initConfig($config);
    }

    $factura = $this->Factura->find('first', array(
      'conditions' => array(
        'factura_folio' => $folio
      ),
      'contain' => array(
        'Timbrado' => array(
          'fields' => array('uuid', 'created')
        )
      ),
      'recursive' => -1
    ));

    $opts = new stdClass;
    $opts->usuario = $this->config['usuario'];;
    $opts->contrasenia = $this->config['password'];
    $opts->UUID = $factura['Timbrado']['uuid'];
    $opts->keyEncode = $this->engine->getPrivateKey();

    if (!(bool)$this->soapClient) {
      $this->_errors[] = __('El servidor SOAP no está disponible.');
    } else {
      $response = $this->soapClient->Cancelar($opts);
      if (isset($response->return->isError) && (bool)$response->return->isError) {
        /**
         * Ocurrió un error
         */
        $this->_errors[] = $response->return->message;
      } elseif(isset($response->return->arrayFolios->arreglo) && !empty($response->return->arrayFolios->arreglo)) {
        $obj = $response->return->arrayFolios->arreglo;

        return $factura;
      }
    }

    return false;
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

  public function errors() {
    return $this->_errors;
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

  public static function init() {
    $className = Configure::read('p_timbrado') . 'Timbrado';

    App::uses($className, 'Lib/CFDI');
    if (!class_exists($className)) {
      throw new CakeException(__d('cake_dev', 'CFDI class "%s" was not found.', $className));
    }

    return (new $className());
  }
}

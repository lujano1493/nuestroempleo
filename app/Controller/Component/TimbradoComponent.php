<?php

require_once(APP . 'Config' . DS . 'timbrado.php');

App::uses('X509Cert', 'Lib/Cert');
App::uses('Xml', 'Utility');

class TimbradoComponent extends Component {

  /**
   * Constructor del Componente.
   * @param ComponentCollection $collection [description]
   * @param array               $settings   [description]
   */
  public function __construct(ComponentCollection $collection, $settings = array()) {
    parent::__construct($collection, $settings);

    $this->config = TimbradoConfig::get('igenter');
  }


  /**
   * Inicialización del componente.
   * @param  Controller $controller [description]
   * @return [type]                 [description]
   */
  public function initialize(Controller $controller) {
    $this->controller = $controller;
    $this->params = $this->controller->params;

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
  }

  public function generarXML($rfc_emisor){
    $fecha_actual = substr(date('c'), 0, 19);

    // $data = array(
    //   'cfdi:Comprobante' => array(
    //     'xmlns:xsi' => "http://www.w3.org/2001/XMLSchema-instance",
    //     'xmlns:xs' => "http://www.w3.org/2001/XMLSchema",
    //     'xmlns:cfdi' => "http://www.sat.gob.mx/cfd/3",
    //     '@xsi:schemaLocation' => 'http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv32.xsd',
    //     '@version' => "3.2",
    //     '@fecha' => $fecha_actual,
    //     '@tipoDeComprobante' => "ingreso",
    //     '@noCertificado' => "",
    //     '@certificado' => "",
    //     '@sello' => "",
    //     '@formaDePago' => "Pago en una sola exhibición",
    //     '@metodoDePago' => "Transferencia Electrónica",
    //     '@NumCtaPago' => "No identificado",
    //     '@LugarExpedicion' => "San Pedro Garza García, Mty.",
    //     '@subTotal' => "10.00",
    //     '@total' => "11.60",
    //     'cfdi:Emisor' => array(
    //       '@nombre'=> "EMPRESA DEMO",
    //       '@rfc' => $rfc_emisor,
    //       'cfdi:RegimenFiscal' => array(
    //         '@Regimen' => "No aplica"
    //       )
    //     ),
    //     'cfdi:Receptor' => array(
    //       '@nombre' => "PUBLICO EN GENERAL",
    //       '@rfc' => "XAXX010101000",
    //       '@' => ''
    //     ),
    //     'cfdi:Conceptos' => array(
    //       'cfdi:Concepto' => array(
    //         '@cantidad' => '10',
    //         '@unidad' => 'No aplica',
    //         '@noIdentificacion' => '00001',
    //         '@descripcion' => 'Servicio de Timbrado',
    //         '@valorUnitario' => '1.00',
    //         '@importe' => '10.00',
    //         '@' => ''
    //       )
    //     ),
    //     'cfdi:Impuestos' => array(
    //       '@totalImpuestosTrasladados' => '1.60',
    //       'cfdi:Traslados' => array(
    //         'cfdi:Traslado' => array(
    //           '@impuesto' => 'IVA',
    //           '@tasa' => '16.00',
    //           '@importe' => '1.6',
    //           '@' => ''
    //         )
    //       )
    //     ),
    //   )
    // );

    //* //
    $data = array(
      'cfdi:Comprobante' => array(
        'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
        'xmlns:xs' => 'http://www.w3.org/2001/XMLSchema',
        'xmlns:n2' => 'http://www.sat.gob.mx/TimbreFiscalDigital',
        'xmlns:nomina' => 'http://www.sat.gob.mx/nomina',
        'xmlns:cfdi' => 'http://www.sat.gob.mx/cfd/3',
        '@xsi:schemaLocation' => 'http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv32.xsd',
        '@LugarExpedicion' => "CUAUHTEMOC",
        '@metodoDePago'=> "DEPOSITO DE CUENTA",
        '@tipoDeComprobante'=> "egreso",
        '@total'=> "-786.93",
        '@Moneda'=> "MXN",
        '@TipoCambio'=> "1.0",
        '@subTotal'=> "2003.77",
        '@certificado'=> "",
        '@noCertificado'=> "00001000000202605969",
        '@formaDePago'=> "UNA SOLA EXHIBICION",
        '@sello'=> "",
        '@fecha'=> "2014-07-24T10:50:17",
        '@folio'=> "1",
        '@version'=> "3.2",
        'cfdi:Emisor' => array(
          '@nombre' => 'SERVICIOS DE PROMOCION Y COMERCIALIZACION DE MEXICALI, S.A. DE C.V.',
          '@rfc' => 'IPB050810VC3',
          'cfdi:DomicilioFiscal' => array(
            '@codigoPostal' => '06170',
            '@pais' => 'MEXICO',
            '@estado' => 'DISTRITO FEDERAL',
            '@municipio' => 'CUAUHTEMOC',
            '@colonia' => 'HIPODROMO DE LA CONDESA',
            '@calle' => "AV NUEVO LEON 202"
          ),
          'cfdi:RegimenFiscal' => array(
            '@Regimen' => 'Regimen 01'
          )
        ),
        'cfdi:Receptor' => array(
          '@nombre' => 'YESSICA JULIANA BURROLA RODRIGUEZ',
          '@rfc' => 'BURY870109638',
          'cfdi:Domicilio' => array(
            '@pais' => 'MEXICO'
          )
        ),
        'cfdi:Conceptos' => array(
          'cfdi:Concepto' => array(
            '@importe' => '-786.93',
            '@valorUnitario' => '-786.93',
            '@descripcion' => 'PAGO DE NOMINA',
            '@unidad' => 'SERVICIO',
            '@cantidad' => '1',
          )
        ),
        'cfdi:Impuestos' => array(
          '@totalImpuestosRetenidos' => '0.00'
        ),
        'cfdi:Complemento' => array(
          'nomina:Nomina' => array(
            '@SalarioDiarioIntegrado' => '150.82',
            '@SalarioBaseCotApor' => '150.82',
            '@PeriodicidadPago' => 'NOMINA QUINCENAL',
            '@Puesto' => 'MOZO DE AREAS PUBLICAS',
            '@Antiguedad' => '3',
            '@FechaInicioRelLaboral' => '2011-01-13',
            '@Departamento' => 'CONTABILIDAD NOGALES',
            '@NumDiasPagados' => '15',
            '@FechaFinalPago' => '2013-03-15',
            '@FechaInicialPago' => '2013-03-01',
            '@FechaPago' => '2013-03-15',
            '@NumSeguridadSocial' => '24058729336',
            '@TipoRegimen' => '2',
            '@CURP' => 'BURY870109MSRRDS01',
            '@NumEmpleado' => 'N:357, E:9',
            '@Version' => '1.1',
            'nomina:Percepciones' => array(
              '@TotalExento' => '78.77',
              '@TotalGravado' => '1925.00',
              'nomina:Percepcion' => array(
                array(
                  '@ImporteExento' => '0.00',
                  '@ImporteGravado' => '1925.00',
                  '@Concepto' => '1 - SUELDOS',
                  '@Clave' => '001',
                  '@TipoPercepcion' => '001',
                ),
                array(
                  '@ImporteExento' => '-0.37',
                  '@ImporteGravado' => '0.00',
                  '@Concepto' => '43 - REDONDEO A PESOS',
                  '@Clave' => '043',
                  '@TipoPercepcion' => '016',
                ),
                array(
                  '@ImporteExento' => '79.14',
                  '@ImporteGravado' => '0.00',
                  '@Concepto' => '212 - SUBSIDIO PARA EL EMPLEO',
                  '@Clave' => '212',
                  '@TipoPercepcion' => '017',
                )
              )
            ),
            'nomina:Deducciones' => array(
              '@TotalExento' => '2790.70',
              '@TotalGravado' => '0.00',
              'nomina:Deduccion' => array(
                array(
                  '@ImporteExento' => '-0.48',
                  '@ImporteGravado' => '0.00',
                  '@Concepto' => '118 - AJUSTE REDONDEO A PESOS',
                  '@Clave' => '118',
                  '@TipoDeduccion' => '004'
                ),
                array(
                  '@ImporteExento' => '2594.93',
                  '@ImporteGravado' => '0.00',
                  '@Concepto' => '350 - CREDITO INFONAVIT',
                  '@Clave' => '350',
                  '@TipoDeduccion' => '005'
                ),
                array(
                  '@ImporteExento' => '3.75',
                  '@ImporteGravado' => '0.00',
                  '@Concepto' => '352 - 1% MANTENIMIENTO  INFONAVIT',
                  '@Clave' => '352',
                  '@TipoDeduccion' => '010'
                ),
                array(
                  '@ImporteExento' => '192.50',
                  '@ImporteGravado' => '0.00',
                  '@Concepto' => '402 - APORT. FONDO DE AHORRO EMPLEAD',
                  '@Clave' => '402',
                  '@TipoDeduccion' => '004'
                ),
              ),
            ),
          ),
        ),
      ),
    );
    /* */

    $xml = Xml::build($data, array(
      'return' => 'domdocument',
      'pretty' => true
    ));

    return $xml->saveXML();
  }

  public function cadenaOriginal($xml) {
    $this->xdoc->loadXML($xml) or die("XML invalido");
    $cadena_original = $this->proc->transformToXML($this->xdoc);
    return $cadena_original;
  }

  public function timbrar() {
    //RFC utilizado para el ambiente de pruebas
    $rfc = $this->config['rfc']; // 'ESI920427886';
    $numero_certificado = $this->config['no_cert'];

    //generar y sellar un XML con los CSD de pruebas
    $cfdi = $this->generarXML($rfc);
    $cfdi = $this->sellarXML($cfdi, $numero_certificado);
    debug($cfdi); die;
  }

  public function sellarXML($xml, $numero_certificado) {
    $originalString = $this->cadenaOriginal($xml);

    $c = $this->xdoc->getElementsByTagNameNS('http://www.sat.gob.mx/cfd/3', 'Comprobante')->item(0);
    $c->setAttribute('sello', $this->engine->sello($originalString));
    $c->setAttribute('certificado', $this->engine->certificado());
    $c->setAttribute('noCertificado', $numero_certificado);

    return $this->xdoc->saveXML();
  }
}
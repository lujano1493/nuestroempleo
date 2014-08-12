<?php
/**
 *
 * Configuración para el timbrado
 *
 */

/**
 * La llave pública se obtiene:
 * ----   openssl x509 -inform der -in public.cer -out public.pem
 *
 * La llave privada se obtiene:
 * ----   openssl pkcs8 -inform der -in private.key -out private.key.pem
 *
 * http://www.lacorona.com.mx/fortiz/sat/firma.htm
 */

class TimbradoConfig {
  private $defaults = array();

  public function __construct() {
    $this->defaults = array(
      /**
       * XLST para el tipo de Timbrado
       */
      'xlst' => ROOT . DS . 'certificados' . DS . 'xlst32' . DS . 'cadenaoriginal_3_2.xslt',
      /**
       * URL del servicio Web.
       */
      'wsdl' => 'http://65.50.243.178:8080/CFDI/WsEmisionTimbrado?wsdl', // Proveedor actual
      /**
       * Usuario del servicio.
       */
      'usuario' => 'AAA010101AAA.Test.User',
      /**
       * Password del servicio.
       */
      'password' => 'Prueba$1',
    );

    $this->igenter = array(
      /**
       * URL del servicio Web.
       */
      'wsdl' => 'http://200.34.168.109/WSCFDBuilderTurbo/WSCFDBuilderPlus.asmx?WSDL', // Proveedor anterior
      /**
       * Usuario del servicio.
       */
      'usuario' => 'CFDIHIT1213',
      /**
       * Password del servicio.
       */
      'password' => '@CFDIHIT1213',
      /**
       * Datos del emisor.
       */
      'emisorData' => array(
        '@nombre'         => 'I-GENTER MEXICO, S. DE R.L. DE C.V.',
        '@rfc'            => 'IME080505LY5',
        'cfdi:DomicilioFiscal' => array(
          '@codigoPostal' => '06170',
          '@pais'         => 'MEXICO',
          '@estado'       => 'DISTRITO FEDERAL',
          '@municipio'    => 'CUAUHTEMOC',
          '@colonia'      => 'HIPODROMO DE LA CONDESA',
          '@calle'        => 'AV. NUEVO LEON No. 238 - 302 B'
        ),
        'cfdi:RegimenFiscal' => array(
          '@Regimen'      => 'REGIMEN GENERAL DE LEY PERSONAS MORALES'
        )
      ),
      /**
       * Número de certificado.
       */
      'no_cert' => '00001000000203280901',
      /**
       * Ruta para la llave pública (CER)
       */
      'public_key' => ROOT . DS . 'certificados' . DS . 'timbrado' . DS . 'igenter' . DS . '00001000000203280901.cer',
      /**
       * Ruta para la llave privada en formato PEM (ASCII).
       */
      'private_key' => ROOT . DS . 'certificados' . DS . 'timbrado' . DS . 'igenter' . DS . 'private.key.pem',
      /**
       * Password de la llave privada.
       */
      'passphrase' => 'IME080505LY5',
    );

    $this->test = array(
      /**
       * Datos del emisor.
       */
      'emisorData' => array(
        '@nombre'         => 'EMPRESA DE PRUEBA',
        '@rfc'            => 'AAAA010101AAA',
        'cfdi:DomicilioFiscal' => array(
          '@codigoPostal' => '37OO0',
          '@pais'         => 'MEXICO',
          '@estado'       => 'GUANAJUATO',
          '@municipio'    => 'LEON',
          '@colonia'      => 'JARDINES DE PRUEBA',
          '@calle'        => 'BLVD. MARIANO ESCOBEDO',
          '@noInterior'    => 337,
          '@noExterior'    => 519
        ),
        'cfdi:RegimenFiscal' => array(
          '@Regimen'      => 'REGIMEN GENERAL DE LEY PERSONAS MORALES'
        )
      ),
      /**
       * Número de certificado.
       */
      'no_cert' => '30001000000100000800',
      /**
       * Ruta para la llave pública (CER)
       */
      'public_key' => ROOT . DS . 'certificados' . DS . 'timbrado' . DS . 'test' . DS . 'aaa010101aaa__csd_01.cer',
      /**
       * Ruta para la llave privada en formato PEM (ASCII).
       */
      'private_key' => ROOT . DS . 'certificados' . DS . 'timbrado' . DS . 'test' . DS . 'private.key.pem',
      /**
       * Password de la llave privada.
       */
      'passphrase' => '12345678a',
    );
  }

  /**
   * Obtiene la configuración seleccionada.
   * @param  [type] $configName [description]
   * @return [type]             [description]
   */
  public static function get($configName) {
    $self = new self;
    return array_merge($self->defaults, $self->{$configName});
  }
}
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
      'xlst' => ROOT . DS . 'certificados' . DS . 'xlst32' . DS . 'cadenaoriginal_3_2.xslt'
    );

    $this->igenter = array(
      /**
       * RFC
       */
      'rfc' => 'ESI920427886',
      /**
       * Número de certificado.
       */
      'no_cert' => '20001000000200000192',
      /**
       * Ruta para la llave pública (CER)
       */
      'public_key' => ROOT . DS . 'certificados' . DS . 'timbrado' . DS . 'public.cer',
      /**
       * Ruta para la llave privada en formato PEM (ASCII).
       */
      'private_key' => ROOT . DS . 'certificados' . DS . 'timbrado' . DS . 'private.key.pem',
      /**
       * Password de la llave privada.
       */
      'passphrase' => 'SPC0510259A5001',
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
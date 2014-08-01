<?php
/************
 * Use these settings to set defaults for the Paypal Helper class.
 * The PaypalHelper class will help you create paynow, subscribe, donate, or addtocart buttons for you.
 *
 * All these options can be set on the fly as well within the helper
 */
class PaypalIpnConfig {

  public function __construct() {

    /**
     * Configuración para PRODUCCIÓN en Paypal
     * @var array
     */
    $this->default = array(
      // Cuenta de Paypal
      'business'      => 'pp.ne@nuestroempleo.com.mx',
      // Servidor de pruebas de Paypal
      'server'        => 'https://www.paypal.com',
      // 'http://test.yoursite.com/paypal_ipn/process',
      // Notify_url... set this to the process path of your
      // paypal_ipn::instant_payment_notification::process action
      'notify_url'    => 'http://www.nuestroempleo.com.mx/paypal/verify?' . Configure::read('paypal_allow_id'),
      // Moneda
      'currency_code' => 'MXN',
      // País
      'lc'            => 'MX',
      // 'item_name'     => 'Paypal_IPN',                    // Default item name.
      // 'amount'        => '15.00',                         // Default item amount.
      // Establece el cifrado de los items
      'encrypt'       => true,
      // 'tax'          => 16
    );

    /**
     * Configuración para pruebas en el sandbox de Paypal
     * @var array
     */
    $this->test = array(
      // Cuenta de Paypal
      'business'      => 'pp.ne-facilitator@nuestroempleo.com.mx',
      // Servidor de pruebas de Paypal
      'server'        => 'https://www.sandbox.paypal.com',
      // 'http://test.yoursite.com/paypal_ipn/process',
      // Notify_url... set this to the process path of your
      // paypal_ipn::instant_payment_notification::process action
      'notify_url'    => 'http://www.nuestroempleo.com.mx/paypal/verify?' . Configure::read('paypal_allow_id'),
      // Moneda
      'currency_code' => 'MXN',
      // País
      'lc'            => 'MX',
      // 'item_name'     => 'Paypal_IPN',                    // Default item name.
      // 'amount'        => '15.00',                         // Default item amount.
      // Establece el cifrado de los items
      // 'encrypt'       => true,
      // 'tax'          => 16
    );

    /**
     * Configuración para ---PRUDUCCIÓN---.
     * @var array
     */
    $this->encryption_default = array(
      // https://developer.paypal.com/docs/classic/paypal-payments-standard/integration-guide/encryptedwebpayments/
      // ID del certificado (se obtiene al subir el certificado a Paypal)
      'cert_id'       => '9FNZRQ65WV34Y',
      // Ruta absoluta a la llave privada.
      // ----> openssl genrsa -out my-prvkey.pem 1024
      'key_file'      => ROOT . DS . 'certificados' . DS . 'paypal' . DS . 'prod' . DS . 'my-prvkey.pem',
      // Ruta absoluta a la llave pública
      // ----> openssl req -new -key my-prvkey.pem -x509 -days 365 -out my-pubcert.pem
      'cert_file'     => ROOT . DS . 'certificados' . DS . 'paypal' . DS . 'prod' . DS .'my-pubcert.pem',
      // Ruta absoluta al certificado de Paypal
      'paypal_cert_file' => ROOT . DS . 'certificados' . DS . 'paypal' . DS . 'prod' . DS .'paypal_cert_pem.txt',
      // OpenSSL
      'openssl'       => '/usr/bin/openssl',
      // Anotación de compilación
      'bn'            => 'cakephp_paypal-ipn-plugin',
    );


    /**
     * Configuración para ---PRUEBAS---.
     * @var array
     */
    $this->encryption_test = array(
      // https://developer.paypal.com/docs/classic/paypal-payments-standard/integration-guide/encryptedwebpayments/
      // ID del certificado (se obtiene al subir el certificado a Paypal)
      'cert_id'       => '7DEGYJWGJ8MDE',
      // Ruta absoluta a la llave privada.
      // ----> openssl genrsa -out my-prvkey.pem 1024
      'key_file'      => ROOT . DS . 'certificados' . DS . 'paypal' . DS . 'test' . DS . 'my-prvkey.pem',
      // Ruta absoluta a la llave pública
      // ----> openssl req -new -key my-prvkey.pem -x509 -days 365 -out my-pubcert.pem
      'cert_file'     => ROOT . DS . 'certificados' . DS . 'paypal' . DS . 'test' . DS .'my-pubcert.pem',
      // Ruta absoluta al certificado de Paypal
      'paypal_cert_file' => ROOT . DS . 'certificados' . DS . 'paypal' . DS . 'test' . DS .'paypal_cert_pem.txt',
      // OpenSSL
      'openssl'       => '/usr/bin/openssl',
      // Anotación de compilación
      'bn'            => 'cakephp_paypal-ipn-plugin',
    );
  }
}
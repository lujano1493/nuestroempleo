<?php
/**
  *
  */
App::uses('AppController', 'Controller');

class PaypalController extends AppController {

  /**
    * Nombre del controlador.
    *
    * @var string
    */
  public $name = 'Paypal';

  public $components = array(
    'Paypal', 'Emailer'
  );

  public function beforeFilter() {
    parent::beforeFilter();

    $paypalAllowId = Configure::read('paypal_allow_id');
    if (isset($this->request->query[$paypalAllowId])) {
      $this->Auth->allow(array('verify'));
    }
  }

  public function verify() {
    Configure::write('debug', 2);

    $this->autoRender = false;
    $data = $this->request->data;

    $this->log('Process accessed', 'paypal');
    if ($this->request->is('post')) {
      $this->log('POST ' . print_r($data, true), 'paypal');
    }

    $folio = $data['invoice'];
    if ($this->Paypal->isValid($data) && $folio) {
      $this->loadModel('Factura');

      $this->log(__('Transacción desde Paypal válida: %s', $folio), 'paypal');

      $ciaId = $this->Factura->field('cia_cve', array(
        'factura_folio' => $folio
      ));

      $empresa = $this->Factura->Empresa->get($ciaId, 'basic_info');

      if (!empty($empresa)) {
        $this->Emailer->sendEmail(array(
          'to' => 'ventas.ne@nuestroempleo.com.mx',
          'bcc' => array(
            'jmreynoso@igenter.com',
            'flujano@igenter.com'
          )
        ), __('Paypal ha confirmado el pago de la factura %s.', $folio),
          'admin/factura_pagada', array(
            'factura' => $folio,
            'empresa' => $empresa
        ), 'admin');
      }

      /**
       * Una vez que Paypal notifica el pago, automáticamente confirmamos la
       * activación de servicios, una vez que se activan los servicios se timbrará
       * la factura.
       */
      if ($this->Factura->confirm($folio, $ciaId)) {

      }

      $this->log('QUERY ' . print_r($this->Factura->getLog('return'), true), 'paypal');
    }
  }
}

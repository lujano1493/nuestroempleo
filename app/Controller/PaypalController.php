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

    $invoice = $data['invoice'];
    if ($this->Paypal->isValid($data) && $invoice) {
      $this->loadModel('Factura');

      $this->log(__('Transacción desde Paypal válida: %s', $invoice), 'paypal');

      if ($this->Factura->markAsPaid($invoice)) {
        $this->loadModel('Empresa');
        $ciaId = $this->Factura->field('cia_cve', array(
          'Factura.factura_folio' => $invoice
        ));

        $empresa = $this->Empresa->get($ciaId, 'basic_info');
        if (!empty($empresa)) {
          $this->Emailer->sendEmail(array(
            'to' => 'ventas.ne@nuestroempleo.com.mx',
            'bbc' => array(
              'jmreynoso@igenter.com',
              'flujano@igenter.com'
            )
          ), __('Factura %s pagada', $invoice),
            'admin/factura_pagada', array(
              'factura' => $invoice,
              'empresa' => $empresa
          ), 'admin');
        }
      }

      $this->log('QUERY ' . print_r($this->Factura->getLog('return'), true), 'paypal');
    }
  }
}

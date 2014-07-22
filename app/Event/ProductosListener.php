<?php

App::uses('BaseEventListener', 'Event');

class ProductosListener extends BaseEventListener {

  public function implementedEvents() {
    return array(
      'Model.Productos.solicitud_promocion' => 'sendEmailPromocion',
      'Model.Productos.servicios_activados' => 'sendServiciosActivados'
    );
  }

  public function sendEmailPromocion(CakeEvent $event) {
    $folio = $event->data['folio'];
    $empresa = $event->data['empresa'];

    $subject = __('Promoción de %s', $empresa['Empresa']['cia_nombre']);
    $vars = array(
      'factura_folio' => $folio,
      'empresa' => $empresa
    );

    try {
      $this->sendEmail(array(
        'to' => 'ventas.ne@nuestroempleo.com.mx',
        'bcc' => array(
          'jmreynoso@igenter.com',
          'flujano@igenter.com'
        )
      ), $subject, 'admin/promocion', $vars, 'admin');
    } catch (Exception $e) {

    }
  }

  public function sendServiciosActivados(CakeEvent $event) {
    $empresa = $event->data['empresa'];
    $folio = !empty($event->data['factura_folio']) ? $event->data['factura_folio'] : false;
    $email = $empresa['Admin']['cu_sesion'];

    $subject = $folio
      ? __('Los servicios de la factura %s han sido activados.', $folio)
      : __('Los servicios del convenio %s han sido activados.', $empresa['Empresa']['cia_nombre']);

    $vars = array(
      'empresa' => $empresa,
      'folio' => $folio
    );

    try {
      $this->sendEmail(array(
        'to' => $email,
        'bcc' => array(
          'ventas.ne@nuestroempleo.com.mx',
          'jmreynoso@igenter.com',
          'flujano@igenter.com'
        )
      ), $subject, 'empresas/servicios_activados', $vars, 'aviso');
    } catch (Exception $e) {

    }
  }

}
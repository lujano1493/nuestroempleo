<?php

App::uses('BaseEventListener', 'Event');
App::uses('Timbrado', 'Lib/CFDI');

class ProductosListener extends BaseEventListener {

  public function implementedEvents() {
    return array(
      'Model.Productos.servicios_activados' => 'serviciosActivados',
      'Model.Productos.solicitud_promocion' => 'sendEmailPromocion',
      'Timbrado.factura_timbrada' => array(
        'callable' => 'sendFacturaTimbrada',
        'priority' => 20
      ),
    );
  }

  public function serviciosActivados(CakeEvent $event) {
    $empresa = $event->data['empresa'];
    $folio = !empty($event->data['factura_folio']) ? $event->data['factura_folio'] : false;
    $email = $empresa['Admin']['cu_sesion'];

    $this->send('users.update-session-admin', array(
      'email' => $email,
      'session' => $event->data['session_data']
    ), 'empresas');

    $this->sendServiciosActivados($empresa, $folio, $email);
  }

  public function sendServiciosActivados($empresa, $folio, $email) {
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

    /**
     * Si existe folio, lo timbra.
     */
    $folio && $this->timbrar($folio);
  }

  public function sendFacturaTimbrada(CakeEvent $event) {
    try {
      $folio = $event->data['folio'];
      $email = $event->data['email'];

      $vars = array(
        'email' => $email,
        'folio' => $folio,
      );

      $this->sendEmail(array(
        'to' => $email,
        'bcc' => array(
          'ventas.ne@nuestroempleo.com.mx',
          'jmreynoso@igenter.com',
          'flujano@igenter.com'
        ),
        'attachments' => $event->data['files']
      ), __('Timbrado de la factura %s exitoso.', $folio), 'empresas/timbrado', $vars, 'aviso');
    } catch (Exception $e) {

    }
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

  protected function timbrar($folio) {
    $_timbrado = Timbrado::init();

    if ($_timbrado->timbrar($folio, 'igenter')) {
      // Éxito
    } else {
      $subject = __('Ocurrió un error al timbrar la factura: %s', $folio);
      $vars = array(
        'folio' => $folio,
        'errors' => $_timbrado->errors()
      );

      $this->sendEmail(array(
        'to' => 'ventas.ne@nuestroempleo.com.mx',
        'bcc' => array(
          'jmreynoso@igenter.com',
          'flujano@igenter.com'
        )
      ), $subject, 'admin/timbrado_error', $vars, 'admin');
    }
  }

}

<?php

class SoporteController extends AppController {

  public $name = 'Soporte';

  public $components = array(
    'Emailer'
  );

  public function admin_index() {
    $title_for_layout = __('Soporte Técnico');

    if ($this->request->is('post')) {
      $asunto = $this->request->data('Soporte.asunto');
      $desc = $this->request->data('Soporte.descripcion');

      $this->Emailer->sendEmail(array(
        'flujano@igenter.com',
        'jmreynoso@igenter.com',
      ), __('Soporte: %s', $asunto), 'admin/soporte', array(
        'asunto' => $asunto,
        'desc' => $desc,
        'user' => $this->Auth->user()
      ), 'admin');

      $this
        ->success(__('Se ha enviado tu solicitud correctamente. Pronto nos pondremos en contacto contigo.'))
        ->redirect(array(
          'admin' => true,
          'controller' => 'mi_espacio',
          'action' => 'index',
        ));
    }

    $this->set(compact('title_for_layout'));
  }

}

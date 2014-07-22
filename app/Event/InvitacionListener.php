<?php
App::uses('BaseEventListener', 'Event');

class InvitacionListener extends BaseEventListener {

  public function implementedEvents() {
    return array(
      'Model.Invitacion.created' => 'sendInvitationEmail'
    );
  }

  public function sendInvitationEmail(CakeEvent $event) {
    $savedData = $event->data['data'];
    $userEmail = $savedData['candidato_mail'];
    $subject = __('Invitación de Nuestro Empleo');
    $vars = array(
      'candidato' => array(
        'email' => $userEmail,
        'nombre' => $savedData['candidato_nom'],
        'ref_code' => $savedData['invitacion_ref']
      ),
      'reclutador' => CakeSession::read('Auth.User'),
      'correo_automatico' => false,
    );

    $this->sendEmail($userEmail, $subject, array(
      'template' => 'empresas/invitacion_candidato',
      'layout' => 'candidato'
    ), $vars, 'invita');
  }
}
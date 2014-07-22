<?php

App::uses('Component', 'Controller');

/**
 * Componente para verificar los permisos, accesos y créditos del Usuario.
 */
class CandidatosComponent extends Component {

  /**
   * [$components description]
   * @var array
   */
  public $components = array('Session', 'Auth', 'Emailer');

  public function sendEmails($data, $type = array()) {
    $subject = __('Invitación de Nuestro Empleo');
    $reclutador = $this->Auth->user();

    foreach ($type as $key) {
      foreach ($data[$key] as $_k => $candidato) {
        $vars = array(
          'candidato' => $candidato,
          'reclutador' => $reclutador,
          'correo_automatico' => false,
        );

        $this->Emailer->sendEmail($candidato['email'], $subject, array(
          'template' => 'empresas/actualiza_perfil',
          'layout' => 'candidato'
        ), $vars);
      }
    }
  }
}
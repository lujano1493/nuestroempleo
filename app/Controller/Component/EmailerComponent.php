<?php

App::uses('Component', 'Controller');
App::uses('Email', 'Utility');
class EmailerComponent extends Component {

  /**
    * Envia un email a $mail, con el asunto $subject, utilizando la plantilla $template.
    * @param String $mail Correo electrónico del destinatario.
    * @param String $subject Asunto del correo electrónico.
    * @param String $template Plantilla que se usará al enviar.
    * @param Array $vars Array asociativo de variables que utiliza la plantilla.
    * @param String $type String para saber si la planilla a ocupar es para candidatos o clientes.
    */
  public function sendEmail($mail = null, $subject = null, $template = null, $vars = array(), $mailFrom = 'default') {
    Email::sendEmail($mail, $subject, $template, $vars, $mailFrom);
  }

}
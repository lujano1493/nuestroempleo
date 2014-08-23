<?php
App::uses('CakeEmail', 'Network/Email');

class  Email {

  private static $mailsFrom = array(
    'default' => array(
      'emailSender' => 'nuestroempleo',
      'labelSender' => 'registrate@nuestroempleo.com'
    ),
    'activar_cuenta' => array(
      'emailSender' => 'nuestroempleo',
      'labelSender' => 'activar_cuenta@nuestroempleo.com'
    ),
    'boletin' => array(
      'emailSender' => 'nuestroempleo',
      'labelSender' => 'boletin@nuestroempleo.com'
    ),
    'promociones' => array(
      'emailSender' => 'nuestroempleo',
      'labelSender' => 'promociones@nuestroempleo.com'
    ),
    'recuperar_pass' => array(
      'emailSender' => 'nuestroempleo',
      'labelSender' => 'recuperar_contrasena@nuestroempleo.com'
    ),
    'evento' => array(
      'emailSender' => 'nuestroempleo',
      'labelSender' => 'eventos@nuestroempleo.com'
    ),
    'encuesta' => array(
      'emailSender' => 'nuestroempleo',
      'labelSender' => 'encuesta@nuestroempleo.com'
    ),
    'aviso' => array(
      'emailSender' => 'nuestroempleo',
      'labelSender' => 'aviso@nuestroempleo.com'
    ),
    'postulacion' => array(
      'emailSender' => 'nuestroempleo',
      'labelSender' => 'postulacion@nuestroempleo.com'
    ),
    'invita' => array(
      'emailSender' => 'nuestroempleo',
      'labelSender' => 'invita@nuestroempleo.com'
    ),
    'admin' => array(
      'emailSender' => 'nuestroempleo',
      'labelSender' => 'admin@nuestroempleo.com'
    )
  );

  /**
   * Envia un email a $mail, con el asunto $subject, utilizando la plantilla $template.
   * @param String $mail Correo electrónico del destinatario.
   * @param String $subject Asunto del correo electrónico.
   * @param String $template Plantilla que se usará al enviar.
   * @param Array $vars Array asociativo de variables que utiliza la plantilla.
   * @param String $type String para saber si la planilla a ocupar es para candidatos o clientes.
   */
  public static function sendEmail($to = null, $subject = null, $template = null, $vars = array(), $mailFrom = 'default') {
    $selectMail = self::$mailsFrom[$mailFrom];
    $emailSender =  $selectMail['emailSender'];
    $labelSender = $selectMail['labelSender'];

    /**
     * Busca en el nombre de la plantilla la palabra 'empresas', para usar el layout 'empresas',
     * en caso contrario usará el layout 'candidato'.
     *
     **/
    if (is_array($template) && !empty($template['layout'])) {
      extract($template);
    } elseif (strpos($template, 'empresas') === 0) {
      $layout = 'empresas';
    } elseif (strpos($template, 'admin') === 0) {
      $layout = 'admin';
    } else {
      $layout = 'candidato';
    }

    /**
     * Si la variable $to contiene bcc, entonces la extrae como variable.
     * @var array
     */
    $bcc = $attachments = array();
    if (is_array($to) && !empty($to['bcc']) && !empty($to['to'])) {
      extract($to);
    }

    $email = new CakeEmail($emailSender);
    $email->helpers(array(
      'Html',
      'Time' => array('className' => 'Tiempito', 'engine' => 'Tiempito'),
      'Text'
    ));

    /**
     * Esto quiere decir que está el debug, por lo tanto envíamos a correo de
     * desarrolladores.
     */
    if ((bool)Configure::read('debug_email') === true) {
      $subject .= ' (DEBUG ON)';
      $to = array(
        'flujano@igenter.com',
        'jmreynoso@igenter.com',
      );
      $bcc = array();
    }

    // Título en caso  de necesitarse.
    $vars['title_for_layout'] = $subject;
    $email->template($template, $layout)
      ->viewVars($vars)
      ->subject($subject)
      ->emailFormat('html')
      ->attachments($attachments)
      ->to($to)
      ->bcc($bcc)
      ->from(array(
        $labelSender => 'Nuestro Empleo'
      ))
      ->send();
  }
}
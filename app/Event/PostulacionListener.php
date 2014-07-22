<?php

App::uses('Router', 'Routing');
App::uses('BaseEventListener', 'Event');

class PostulacionListener extends BaseEventListener {

  public function implementedEvents() {
    return array(
      'Model.Postulacion.created' => 'sendNtfy',
      'Model.Postulacion.send-email' => 'send_Email'
    );
  }

  public function send_Email(CakeEvent $event){
    $oferta = $event->data['oferta'];
    $num_postulaciones = $event->data['num_postulaciones'];
    $email = $oferta['UsuarioEmpresa']['cu_sesion'];
    $subject = 'Postulaciones';
    $template = 'empresas/postulacion';
    $vars = array(
      'postulantes' =>  $oferta['Postulacion'],
      'nombre' => $oferta['Oferta']['puesto_nom'],
      'publicado' => $this->date($oferta['Oferta']['oferta_fecini']),
      'num' => $num_postulaciones
    );

    $mailFrom = 'postulacion';

    $this->sendEmail($email, $subject, $template, $vars, $mailFrom);
  }

  public function sendNtfy(CakeEvent $event) {
    $savedData = $event->data['data'];

    if ($this->save($savedData['Postulacion'])) {
      $this->send('send-ntfy', $this->format($savedData), 'empresas');
    }
  }

  public function format($data = array()) {
    $p = $data['Postulacion'];
    $pId = (int)$p['postulacion_cve'];

    //$emails = ClassRegistry::init('UsuarioEmpresa')->getEmails($p['cu_cve'], true);
    $customData = $this->getEmailsAndNtfyID($p['cu_cve'], 'UsuarioEmpresa');

    return array(
      'data' => array(
        //'id' => $pId,
        'title' => __('Se han postulado a una oferta.'),
        'body' => __('%s se ha pustulado a la oferta %s', $this->user('Candidato.nombre_'), $p['oferta_cve']),
      ),
      'meta' => array(
        'type' => 'notificacion',
        'route' => $this->route($p['oferta_cve']),
        'tmpl' => 'notificacion',
        'created' => $this->date(),
        'isNew' => true
      ),
      'from' => array(
        'email' => $this->user('cc_email'),
        'name' => $this->user('Candidato.nombre_'),
        'logo' => $this->user('Candidato.logo'),
      ),
      'to' => $customData,
    );
  }

  public function route($id) {
    return Router::url(array(
      'controller' => 'mis_ofertas',
      'action' => 'postulaciones',
      'id' => $id
    ));
  }

  public function save($postulacion) {
    $pData = array(             // Datos desde el mensaje
      'emisor_tipo' => 1,
      'emisor_cve' => $postulacion['candidato_cve'],
      'notificacion_tipo' => 4,
      'notificacion_controlador' => $this->route($postulacion['oferta_cve']),
      'notificacion_id' => $postulacion['postulacion_cve'],
      'notificacion_titulo' => __('Se han postulado a una oferta.'),
      'notificacion_texto' => __('%s se ha pustulado a la oferta %s', $this->user('Candidato.nombre_'), $postulacion['oferta_cve']),
      'notificacion_status' => 0,
      'notificacion_leido' => 0,
      'receptor_tipo' => 0,
      'receptor_cve' => $postulacion['cu_cve'],
    );

    return $this->Notificacion->save($pData);
  }
}
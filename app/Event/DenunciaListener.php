<?php
App::uses('BaseEventListener', 'Event');

class DenunciaListener extends BaseEventListener {

  public function implementedEvents() {
    return array(
      'Model.Denuncia.created' => 'sendDenunciaEmail',
      'Model.Reportar.created' => "sendReportarEmail",
      'Model.Denuncia.status' => "sendResolucionEmail" 
    );
  }
   public function sendReportarEmail(CakeEvent $event) {  
    $userEmail = array( 'contacto.ne@nuestroempleo.com.mx');    
    $data=$event->data['data'];
    $this->sendEmail($userEmail,  __('Se ha Reportado una Oferta'), 'admin/denuncia_oferta', array( "info" => $data  ));
    $this->sendEmail($data['contacto_correo'],__('Denuncia de Oferta'),'empresas/denuncia_oferta',compact("data"));
  }
  public function sendDenunciaEmail(CakeEvent $event) {
    $savedData = $event->data['data'];
    $candidato = $event->data['candidato'];
    $userEmail = array('contacto.ne@nuestroempleo.com.mx');

    $vars = array(
      'data' => $savedData,
      'candidato' => $candidato,
      'reclutador' => CakeSession::read('Auth.User'),
      // 'correo_automatico' => false,
    );
    $this->sendEmail($userEmail, __('Se ha reportado el perfil de un Candidato'), 'admin/denuncia_candidato', $vars, 'admin');
    $this->sendEmail($candidato['CandidatoUsuario']['cc_email'],__('Denuncia de curriculum'),'denuncia_candidato',compact("candidato") );

  }

  public function sendResolucionEmail(CakeEvent $event){
    $data=$event->data['data'];
    $tipo=$event->data['tipo'];
    $resolucion=$event->data['resolucion'];
    $plantilla= $tipo==='empresa' ? 'empresas/denuncia_resolucion': 'denuncia_resolucion';
    $vars=compact("data","resolucion");
    $userEmail=$data['correo'];
    $titulo = 'Resolución de Reporte';
    $this->sendEmail($userEmail, $titulo, $plantilla, $vars);



  }

}
<?php
App::uses('BaseEventListener', 'Event');

class DenunciaListener extends BaseEventListener {

  public function implementedEvents() {
    return array(
      'Model.Denuncia.created' => 'sendDenunciaEmail',
      'Model.Reportar.created' => "sendReportarEmail",
      'Model.Denuncia.status' => "sendResolucionEmail" ,
      'Model.Denuncia.revision' => "revisionDenuncia"       
    );
  }
   public function sendReportarEmail(CakeEvent $event) {  
    $userEmail = array( 'contacto.ne@nuestroempleo.com.mx');    
    $data=$event->data['data'];
    $id= $event->data['id'];
    $this->sendEmail($userEmail,  __('Se ha Reportado una Oferta'), 'admin/denuncia_oferta', array( "info" => $data  ));
    $this->sendEmail($data['contacto_correo'],__('Denuncia de Oferta'),'empresas/denuncia_oferta',compact("data"));
    if( $this->save($data,'oferta' ,$data['oferta_cve']) ){

    }
  }
  public function sendDenunciaEmail(CakeEvent $event) {
    $savedData = $event->data['data'];
    $candidato = $event->data['candidato'];
    $id=$event->data['id'];
    $userEmail = array('contacto.ne@nuestroempleo.com.mx');
    $vars = array(
      'data' => $savedData,
      'candidato' => $candidato,
      'reclutador' => CakeSession::read('Auth.User'),
      // 'correo_automatico' => false,
    );
    $this->sendEmail($userEmail, __('Se ha reportado el perfil de un Candidato'), 'admin/denuncia_candidato', $vars, 'admin');
    $this->sendEmail($candidato['CandidatoUsuario']['cc_email'],__('Denuncia de curriculum'),'denuncia_candidato',compact("candidato") );
        if( $this->save($candidato,'candidato' , $savedData['candidato_cve'] ) ){

    }

  }

  public function revisionDenuncia(CakeEvent $event) {  
      $date = date('Y-m-d H:i:s', strtotime('+5 days'));
      $id = $event->data['id'];
      $tipo = $event->data['tipo']; 
      $nombre= $event->data['nombre'] ;
      $label_=$tipo ==='oferta' ? 'La oferta ':'El candidato';
      $slug = Inflector::slug(($nombre."-".$id), '-');
      $data = array(  // Datos desde el evento
      'emisor_cve' =>  CakeSession::read("Auth.User.cu_cve")  ,
      'emisor_tipo' => -1,
      'notificacion_tipo' => 5,
      'notificacion_controlador' => "/admin/denuncias/$id/$tipo/$slug/",
      'notificacion_titulo' => "Denuncia a Revisar",
      'notificacion_texto' => __("$label_ de %s debe ser revisada.",  $nombre  ),
      'notificacion_status' => 0,
      'notificacion_leido' => 0,
      'notificacion_id' => $id,
      'receptor_tipo' => -1,
      'receptor_cve' =>1,
      'created' => $date,
      'modified' => $date
    );

      $this->Notificacion->save($data);
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
  public function route($tipo='oferta',$id ) {
      $slug = Inflector::slug(($tipo."-".$id), '-');
    return  "/admin/denuncias/$id/$tipo/$slug/" ;
  }

  public function save($denuncia,$tipo='oferta' ,$id) {
    $label= $tipo ==='oferta' ? 'Una oferta' : 'Un CV';
    $label_=$tipo ==='oferta' ? 'La oferta ':'El candidato';
    $key= $tipo=== 'oferta' ? 'candidato_cve' :'cu_cve';
    $date = date('Y-m-d H:i:s');
    $entidad= $tipo==='oferta' ? $denuncia[ 'puesto_nom'  ] :$denuncia['Candidato']['nombre_'];
    $data = array(  // Datos desde el evento
      'emisor_cve' =>  CakeSession::read("Auth.User.$key")  ,
      'emisor_tipo' =>   $tipo ==='oferta' ? 0:1   ,
      'notificacion_tipo' => 4,
      'notificacion_controlador' => $this->route($tipo,$id),
      'notificacion_titulo' => "$label fue denunciado",
      'notificacion_texto' => __("$label_ de %s debe ser revisada.",  $entidad  ),
      'notificacion_status' => 0,
      'notificacion_leido' => 0,
      'notificacion_id' => $id,
      'receptor_tipo' => -1,
      'receptor_cve' =>1,
      'created' => $date,
      'modified' => $date
    );

    return $this->Notificacion->save($data);
  }




}
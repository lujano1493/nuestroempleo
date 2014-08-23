<?php
App::import('Utility','Security');
App::import('controller', 'BaseCandidato');

class CandidatoController extends BaseCandidatoController {
    public $name = 'Candidato';

    public $uses = array("CandidatoUsuario");

    public $helpers = array(  'VisualCaptcha' );
    public $components = array('Emailer','VisualCaptcha');
    public $pais_cve="1";
    public $gpo_cve="1";


public function index (){
      $is_nuevo=false;
      $show_msg_status_cv=false;
      $porcentaje=ClassRegistry::init('GrafCan')->porcentaje($this->user['candidato_cve']) ;     
      if($porcentaje < 100 ){
           $show_msg_status_cv=true;
      }
      $idUser=$this->user['candidato_cve'];
      $is_nuevo=array_key_exists("is_nuevo",$this->request->query)  ?   ($this->request->query['is_nuevo'] ==="true") :false    ;
      $datoc= $this->CandidatoUsuario->Candidato->find("basic_info",array("idUser"=>$idUser  ))[0];
      $this->request->data =$datoc;     
      $OfertaB= ClassRegistry::init("OfertaB");
      $OfertaB->micrositio=$this->micrositio;
      $ofertas_perfil= $OfertaB->busqueda_perfil_candidato($idUser);
      $this->set(compact("is_nuevo","show_msg_status_cv","ofertas_perfil"));
    }

private function get_lista($model=null,$id=null){

  $json_names=array(
      "EscCarGene" =>"carreras_genericas",
      "EscCarEspe" =>"carreras_especificas"
    );

  if($model==null || $id==null ){
   $this->error("modelo no existe o idenfificandor nulo.");
  }
  $id= $id=='index' ? 0:$id;
  $results=array();
  if($this->isAjax){
    $json_name=isset($json_names[$model] ) ? $json_names[$model]:"json";
    $results=  array( $json_name=> ClassRegistry::init($model)->get_lista($id,1));
  }
  $this->set(compact('results'));
}

public function carreras_genericas($id=null){
  $this->get_lista("EscCarGene",$id);
}


public function carreras_especificas($id=null){
  $this->get_lista("EscCarEspe",$id);

}


public function reenviar_correo(){
  $sts=array("error","verifique parametros");

  if($this->request->is("post") ){

      if(!$this->VisualCaptcha->isValid()){
        $sts=array("error","El objeto Arrastrado es distinto.",array('codigo'=>"verifique el código de seguridad" ));
        $this->responsejson($sts);
        return ;

      }

    $data=$this->request->data;


    $result=$this->CandidatoUsuario->findByCcEmail($data['Usuario']['correo']);

    if(empty($result)){
      $sts=array("error",'El correo que has proporcionado no está registrado. Verifícalo.');
    }
    else if($result['CandidatoUsuario']['cc_status']!=="-1"){

        $sts=array("warning",'El correo que has proporcionado ya está activado.');
    }
    else{
      $sts=array("ok","verificando ...");
    }

    if($sts[0]==="ok"){
      if(!$this->CandidatoUsuario->changePassword(null,$result['CandidatoUsuario']['candidato_cve']) ){
          $sts=array("error",'Error al cambiar contraseña.');

      }
    }

    if($sts[0]==="ok"){
      $email=$result['CandidatoUsuario']['cc_email'];
      $name_full=$result['Candidato']['nombre_'];



          $info= array (
          'correo'=>$email,
          'nombre'=>$name_full,
          'contrasena'=>$this->CandidatoUsuario->password,
          'keycode'=>$this->CandidatoUsuario->keycode
          );



        $this->Emailer->sendEmail($info['correo'],
                      'Activación de Cuenta',
                      'activar_candidato',
                      array("data"=>$info));// enviamos correo



        $sts=array("ok","El correo se ha enviado correctamente.");
        $this->request->data=array();


    }

  }

  if($sts[0]!=="ok"){
  }

  $this->responsejson($sts);


}

public function recuperar_password(){
  if(!empty($this->request->data) && $this->request->is('Post') ){
    $this->autoRender=false;
    $data=  $this->request->data;
    $email=$data['CandidatoUsuario']['cc_email'];

    $this->autoRender=false;
    try{
      $data=$this->CandidatoUsuario->cambiar_contrasena($email);
      if(!empty($data)){
        $data['correo']=$email;
        $this->Emailer->correoRecuperacion( $data );// enviamos correo
        $sts='ok';
        $msg='Correo de recuperación de cuenta enviado.';
      }
      else{
        $sts='error';
        $msg='El correo no esta registrado.';
      }
    } catch (Exception $e){
      $sts='error';
      $msg='Error al enviar Correo.';
    }
    echo json_encode (array (0=> array ('sts'=>$sts,'msg'=>$msg,)  ));
  }



}


public function loadFoto(){
     $this->autoRender=false;
       $id=$this->user['candidato_cve'];
       $webroot=$this->webroot;
       echo  json_encode(array ( Funciones::check_picture($id,$webroot)));
}

public function grafica(){
  if (!$this->isAjax){
    return false;
  }
    $id=$this->user['candidato_cve'];
    $porcentaje=ClassRegistry::init('GrafCan')->porcentaje($this->user['candidato_cve']) ;       
    $grafcan=$this->CandidatoUsuario->Candidato->find("grafcan",array("idUser"=>$id ))[0]['GrafCan'];
    $usuario=$this->CandidatoUsuario;
    $usuario->id=$this->user['candidato_cve'];
    $usuario->saveField("cc_completo","S");
    $tablas_r=ClassRegistry::init("TablaGrafCan")->getTablasFaltantes($id);
    $this->set(compact("porcentaje","tablas_r"));
}





/*activacion de cuenta*/

public function activar($keycode = null) {
    if (is_null($keycode)) {
      throw new NotFoundException("La página que buscas acceder no existe.");
    }

    /**
      * Busca al usuario por medio de su keycode.
      */
    $this->CandidatoUsuario->recursive = -1;
    $usuario = $this->CandidatoUsuario->findByKeycode($keycode);

    if (!empty($usuario)) {
      if ($usuario['CandidatoUsuario']['cc_status'] == -1) {
        if (! $this->CandidatoUsuario->activar($usuario['CandidatoUsuario']['candidato_cve'])) {
          $this->error('Ocurrió un error al actualizar tu cuenta. Intenta más tarde.');
        }
      }
      $this->success('Tu cuenta ya ha sido activada. Ya puedes iniciar sesión.');
      if(  $this->request->query('email')  && $this->request->query('pass') ){            
          $this->request->data['CandidatoUsuario']=array(
                "cc_email" =>$this->request->query('email'),
                "cc_password" => $this->request->query('pass')
            );
          $this->Auth->login();
      }
      $this->redirect(array('controller' => 'candidato','action' => 'index'));
    } else {
      $this->error('El enlace no existe.');
      $this->redirect('/');
    }
  }



/*cambio*/

/*registro de nuevo Candidato*/

public function registrar(){
  $sts=array();
  if(!empty($this->request->data)){
    $data=$this->request->data;



    /*verificar codigo de seguridad*/

      if(!$this->VisualCaptcha->isValid()){
        $sts=array("error","El objeto arrastrado es distinto",array('codigo'=>"Verifica el código de seguridad" ));
        $this->responsejson($sts);
        return ;

      }

    $this->CandidatoUsuario->begin();
    try{
      $sts=$this->CandidatoUsuario->registrar($data);
      if($sts[0]=='ok'){

        $info= array (
          'correo'=>$this->CandidatoUsuario->email,
          'nombre'=>$this->CandidatoUsuario->name_full,
          'contrasena'=>$this->CandidatoUsuario->password,
          'keycode'=>$this->CandidatoUsuario->keycode
          );



        $this->Emailer->sendEmail($info['correo'],
                      'Activación de Cuenta',
                      'activar_candidato',
                      array("data"=>$info),'activar_cuenta');// enviamos correo

      }


    } catch (Exception $e){
      $sts=array("error","verifique su correo electronico o intentelo mas tarde","$e");
    }


  }
  else{
    $sts=array("error","formulario vacío");
  }

  if ($sts[0]!='ok') {
    $this->CandidatoUsuario->rollback();
  } else {
    $ref_code = $this->Session->read('App.reference');
    if (!empty($ref_code)) {
      $email = $this->CandidatoUsuario->email;
      $nombre = $this->CandidatoUsuario->name_full;
      ClassRegistry::init('Invitacion')->updateAll(array(
        'invitacion_status' => 1,
        'candidato_mail' => "'$email'",
        'candidato_nom' => "'$nombre'"
      ), array(
        'invitacion_ref' => $ref_code
      ));
    }
    $this->CandidatoUsuario->commit();
  }

  $this->responsejson($sts);
}

public function registro_rapido(){
   /*verificar codigo de seguridad*/
      if(!$this->VisualCaptcha->isValid()){
        $this->error('El objeto arrastrado es distinto');
        $this->response->statusCode(300);
        return ;
      }
      $data=$this->request->data;
      if(empty($data)){
        $this->error("Formulario vacio.");
        $this->response->statusCode(300);
        return;
      }
      Configure::write('debug',2);
       $log_data=Debugger::exportVar( $this->request->data ,10);
      $this->CandidatoUsuario->logDataBase("Resgistrando nuevo usuario \n $log_data \n\n");
      if( $this->CandidatoUsuario->registro_rapido($data) ===false){
        $this->error("Los datos de candidato no fueron guardados, intente más tarde.");
        $this->response->statusCode(300);
        return;
      }

      $info= array (
        'correo'=>$this->CandidatoUsuario->email,
        'nombre'=>$this->CandidatoUsuario->name_full,
        'contrasena'=>$this->CandidatoUsuario->password,
        'keycode'=>$this->CandidatoUsuario->keycode
        );

      try{
         $this->Emailer->sendEmail($info['correo'],
                      'Activación de Cuenta',
                      'activar_candidato',
                      array("data"=>$info),'activar_cuenta');// enviamos correo

       } catch (Exception $e){
        $this->error("verifique su correo electronico o intentelo mas tarde");
        $this->response->statusCode(300);
        return ;
    }
}


 public function iniciar_sesion($keycode=null) {
  $usuario=array();
  if($keycode){
    $usuario = $this->CandidatoUsuario->findByKeycode($keycode);   
    if(empty($usuario)){
        $this->error("La página que buscas acceder no existe.");
        $this->redirect("/");
        return;
    }
    $can=$usuario['Candidato'] ;  
    $usuario= $usuario['CandidatoUsuario'];
    $usuario['Candidato'] = $can;
    if($usuario['cc_status'] == -1){
        $this->CandidatoUsuario->activar($usuario['candidato_cve']);
        $usuario['cc_status'] =1;       
    }

  }
  $redirectUrl = array('controller' => 'Candidato', 'action' => 'index');
  $data=$this->request->data;
  $status= $keycode ? array("ok","pasa") :$this->CandidatoUsuario->login($data) ;
  $url_error=array('controller'=>'informacion','action'=>'index');
  if('error'==$status[0]){
     $this->error($status[1]);
  }
  else if ('warning'==$status[0]){
     $this->warning($status[1]);
  }
  else {
    if($this->Auth->login($usuario)){          
      $user=  $this->Auth->user();     
      $candidato_cve= $user['Candidato']['candidato_cve'];
      /*consultamos la fecha aneterior para posteriormente guardarla en session */
      $fecha= $this->CandidatoUsuario->Candidato->fechaConexion($candidato_cve);
      $this->Session->write("Auth.User.Candidato.ultima_conexion",$fecha);
      $ubicacion= $this->CandidatoUsuario->Candidato->DirCandidato->find("direccion",array(
                                                                                "idUser" =>$candidato_cve
                                                                              ));
      $this->Session->write("Auth.User.ubicacion",$ubicacion);
      /*ahora agreagamos la fecha actual a nuestro candidato logeado*/
      $this->CandidatoUsuario->Candidato->modificar_fechaConexion($candidato_cve);

      if($user['cc_completo']!=='S'  ){        
         $this->redirect(array("controller" => "candidato" ,"action" =>"primera"));
         return;
      }

      $status=array("ok","login completo");
        if(!$this->isAjax ){
            $this->redirect($redirectUrl);

        }
    }
    else{
      $status[0]="error";
      $this->error("Contraseña no válida");
    }


  }

  if($status[0]!='ok'){


    if(!$this->isAjax ){
        $this->redirect($url_error,$data);
      }
      else{
            $this->response->statusCode(300);

      }

  }
    $this->set(compact("status"));

  }




  public function logout() {
       $redirect=$this->Auth->logout();
      if(!empty($this->micrositio)){
        $redirect="/{$this->micrositio[name]}/informacion/index";
      }
     $this->redirect($redirect);
    }

private function cargarParamCandidato(){
    $user=$this->user;
    $candidato=$this->CandidatoUsuario->Candidato->getCandidato($user['candidato_cve']);
    $this->request->data=$candidato;
    $asentamientos_list=array();
    if(isset($candidato['CodigoPostal'])){
      $asentamientos_list=$this->CandidatoUsuario->Candidato->DirCandidato->CodigoPostal->getListAsentamientos($candidato['CodigoPostal']['cp_cp']);
    }

    $this->set("candidato_cve",$user['candidato_cve']);
    $this->set("asentamientos_list",$asentamientos_list);
    $this->set("list",ClassRegistry::init('Catalogo')->get_list_candidato());
}


public function primera(){
    $this->cargarParamCandidato();
    $idUser=$this->user['candidato_cve'];
    $hasPsw= $this->CandidatoUsuario->checarPsw($idUser);
    $this->set(compact("hasPsw"));
}

public function agregarPsw(){

    if(!$this->request->is("post") ){
        $this->error("error no se puedo agregar contraseña");
        $this->statusCode(300);
        return;
    }

    $idUser=$this->user['candidato_cve'];
    $psw=$this->request->data['Usuario']['contrasena'];
    $this->CandidatoUsuario->changePassword($psw,$idUser);
    $this->info("se agrego contraseña a tu cuenta de nuestro empleo");
}


public function actualizar(){
  $this->cargarParamCandidato();

}


/*funcion para guardar informacion la primera vez que ingresa el usuario al sistema*/
function guardar_primera(){
  $result=array("ok", "iniciando." );$redirect=null ;
  $data=$this->request->data;
  if(empty($data)){
    $this->responsejson(array("error","formulario vacío"));
    return;
  }
  $cc_completo= $this->Session->read("Auth.User.cc_completo");
  if($cc_completo=="S"){
      $this->responsejson(array("ok","La información del Perfil General ya habia sido guardada anteriormente"));
      return;
  }
  $this->CandidatoUsuario->begin();


  $id=$this->user['candidato_cve'];

  $result=$this->CandidatoUsuario->guardar_primera($data,$id);
  if($result[0]=="ok"){
    $this->Session->write("Auth.User.cc_completo","S");
    $this->CandidatoUsuario->commit();
    $redirect="/Candidato/index?is_nuevo=true";
    if(!empty($this->micrositio)){
        $redirect= "/{$this->micrositio[name]}{$redirect}";
    }
  }
  else{
      $this->CandidatoUsuario->rollback();
  }
  $this->responsejson($result,$redirect);
}


/**
 * [guardar_actualizar description]
 * @param  [type] $name_model
 * @return [type]
 */
function guardar_actualizar($name_model =null){
  $data=$this->request->data;
  if(empty($data)){
      $this->responsejson(array("error","formulario vacío"));
      return;
  }
  /*verificamos que modelo vamos a guardar*/
  if(!$name_model){
    $this->responsejson(array("error","error no se envio nombre del modelo"));
      return;

  }
  /*cargamos el modelo que vamos a guardar*/
  $this->loadModel($name_model);
    $is_save=false;
  if($name_model=="Candidato"){
    $is_save=$this->$name_model->saveAll($data);
  }
  else{
    $is_save=$this->$name_model->save($data ) ;
  }


  if($is_save){
    $sts=array("ok","Los datos han sido guardados",array(  "name_id"=>$this->$name_model->primaryKey ,"id"=> $this->$name_model->id    ) );
  }
  else{
    $sts=array("error","No fue posible guardar los datos del candidato",$this->$name_model->validationErrors);

  }
  $this->responsejson($sts);

}

/**
 * [guardar_actualizar description]
 * @param  [type] $name_model
 * @return [type]
 */
function guardar_actualizar_hasmany($name_model =null){
  $data=$this->request->data;
  $msg_com="";
  if(empty($data)){
      $this->responsejson(array("error","formulario vacío"));
      return;
  }
  /*verificamos que modelo vamos a guardar*/
  if(!$name_model){
    $this->responsejson(array("error","error no se envio nombre del modelo"));
      return;

  }



  /*cargamos el modelo que vamos a guardar*/
   $model=$this->CandidatoUsuario->Candidato->$name_model;



   $data_save=$data[$name_model];
   $result=array();
   $flag=true;
   $msg_error="No fue posible guardar los datos del candidato";
   $model->dataUser=$this->user;//pasamos datos del usuario
   $model->begin();
   foreach ($data_save as $key => $value) {

    /*en caso de que se guarde una referencia */

    $value['candidato_cve']=$this->user['candidato_cve'];
    /*

        guardamos los datos anteriores en caso de que exista y no sean datos nuevos
    */

    if(!empty($value[$model->primaryKey])){
      $model->beforeSaveData( $value[$model->primaryKey]);
    }


    if(  $is_save=$model->save($value)   ){
      $result[]=  array(  "name_id"=>$model->primaryKey ,"id"=> $model->id    );


      /*verificamos que sea una nueva referencia */
      if($model->alias=="RefCan" ){

        if($model->change_mail){
               /*si es una nueva referencia le enviaremos un correo con la direccion de la encuesta*/
           $status=$this->enviarEvaluacionRef($is_save);
           $flag= $status[0] =="ok";
           $msg_error=$status[1];
           $msg_com=" , se ha enviado un correo a la siguiente dirección: ".$value['refcan_mail'];
        }



      }

    }
    else{
      $flag=false;
      $result=$model->validationErrors;
      break;
    }


   }

   if($flag){
    $model->commit();
    $sts=array("ok","Los datos  fueron guardados con éxito$msg_com.",$result );
   }
  else{
    $model->rollback();
    $sts=array("error",$msg_error,$model->validationErrors);

  }
  $this->responsejson($sts);

}

public function enviarEvaluacionRef($data=array()){
        $refcan_encuesta=ClassRegistry::init("RefCanEnc");

        try{
          $refcan_encuesta->crearEncuesta($this->user['candidato_cve'],$data['RefCan']);

          //juntamos la informacion de la referencia  con la de candidato
          $data['Candidato']=$this->user['Candidato'];
          $this->loadModel("Ticket");
          //generamos ticket para que nuestra referencia pueda acceder al sitio
          $info = $data['RefCan']['refcan_cve']."info_encuesta";
          $hash = Security::generateAuthKey();

          $existsTicket = $this->Ticket->findByInfo($info);

          if (!empty($existsTicket)) {
            $this->Ticket->id = $existsTicket['Ticket']['ticket_cve'];
          }

          $ticket['Ticket']['hash'] = $hash;
          $ticket['Ticket']['info'] = $info;
          $ticket['Ticket']['fec_exp'] = $this->Ticket->getExpirationDate(365);

          if($this->Ticket->save($ticket )){

            $this->Emailer->sendEmail($data['RefCan']['refcan_mail'],
                'Encuesta de Referencia',
                'encuesta_referencia',
                array("data"=>array("nombre_referencia"=>$data['RefCan']['refcan_nom'] ,
                                    'nombre_' =>$this->user['Candidato']['nombre_'] ,
                                    'keycode' => $hash,
                                    "refcan_cve"=>$data['RefCan']['refcan_cve'] )),'encuesta');// enviamos correo
            }

          else{
                 return array("error","No se pudo generar enlace de encuesta");
          }

        $refcan_encuesta->commit();
        return array("ok","envio");
        }catch (Exception $e){
          $refcan_encuesta->rollback();
        }



          return array("error","Verifica que el correo exista o intentelo más tarde");

}


function eliminar($name_model=null){


    /*verificamos el modelo que vamos a guardar*/
  if(!$name_model  ||  empty($name_model) ){
    $this->responsejson(array("error","error no se envio nombre del modelo"));
      return;

  }

  /*verificamos que la acción sea la de borrar*/
  if(!$this->request->is("post")){
      $this->responsejson(array("error","La acción que desea realizar no es soportada."));
      return;
  }
  $data=$this->request->data;
  /*verfifivamos que el formulario no este vacío*/
  if(empty($data)){
      $this->responsejson(array("error","Formulario vacío."));
      return;
  }
  /*verificamos que modelo vamos a guardar*/
  $id=$data['id'];

  try{
    $model=ClassRegistry::init( $name_model);
    if($model->delete($id)){
    $sts=array("ok","El registro fue eliminado " );

  }
  else{
    $sts=array("error","El registro  no fue eliminado ");
  }

  }catch (Exception $e){
    $sts=array("error","La información no se guardo");

  }

  $this->responsejson($sts);




}



function guardar_lista($name_model=null){
    /*verificamos el modelo que vamos a guardar*/
  if(!$name_model  ||  empty($name_model) ){
    $this->responsejson(array("error","error no se envio nombre del modelo"));
      return;

  }

  /*verificamos que la acción sea la de borrar*/
  if(!$this->request->is("post")){
      $this->responsejson(array("error","la acción que desea realizar no es soportada"));
      return;
  }
  $data=$this->request->data;

  try{
    /*cargamos el modelo que vamos a guardar*/
    $model=$this->CandidatoUsuario->Candidato->$name_model;

    $model->begin();

    if( $model->deleteAll( array( "candidato_cve"=>$this->user['candidato_cve']),false,true  ) ){
        $flag=true;
      $result=array();
      if(array_key_exists($name_model,$data) ){
        $data_save=$data[$name_model];
        foreach ($data_save as $key => $value) {
          $value['candidato_cve']=$this->user['candidato_cve'];
            $model->create();
          if(  $model->save($value)   ){
            $result[]=  array(  "name_id"=>$model->primaryKey ,"id"=> $model->id    );

          }
          else{
            $flag=false;
            $result=$model->validationErrors;
            break;
          }


        }

      }
       if($flag){
        $model->commit();
        $sts=array("ok","Los datos fueron guardados",$result );
       }

    }
    else{
      $sts=array("error","error en el proceso de guardar datos");
    }

  }catch (Exception $e){
    $sts=array("error","la información no se guardo");

  }


  if($sts[0]!="ok"){
     $model->rollback();
  }
  else{
    $model->commit();
  }


  /*$db =& ConnectionManager::getDataSource('default');
    $db->showLog();*/
  $this->responsejson($sts);

}



public function view_pdf(){
    $this->set("info",$this->CandidatoUsuario->Candidato->getCandidato($this->user['candidato_cve']));
     $this->render("view_pdf2");
  }


public function view_header(){



}

public  function semblazas(){
     $datos=array();
      if($this->request->is("Get") ){    
          $params=$this->request->query;
          $datos=ClassRegistry::init("WPPost")->articulos_liga($params,'Semblanzas');
       }

        $this->set(compact("datos"));

}



  /**
    * MÃ©todo que se ejecuta antes de cualquier acciÓn.
    */
  public function beforeFilter() {
    parent::beforeFilter();
    /**
      * Acciones que no necesitan autenticaciÓn.
      */
    $allowActions = array('registrar','login','registro_rapido',
      'iniciar_sesion','activar','loadFoto','reenviar_correo');
    $this->Auth->allow($allowActions);




  }

}
<?php
	App::import('Vendor','funciones');
	App::import('Utility','Security');
	App::uses('ConnectionManager', 'Model');
	App::import('controller', 'BaseCandidato');
class ConfigCanController extends BaseCandidatoController {
	public $name="ConfigCan";
	public $uses = array("CandidatoUsuario");

	public $helpers = array('Js');
	public $components=array('Emailer');
	public function index() {




		$this->loadModel("Catalogo");
		$config_cve=$this->Catalogo->get_list("CONFIG_CVE");
		$contac_cve=$this->Catalogo->get_list("CONTAC_CVE");
		$list=compact("config_cve","contac_cve");
		$this->set("list",$list);
		$this->request->data=$this->CandidatoUsuario->Candidato->find("config",array("idUser" => $this->user['candidato_cve'] ))[0];
	}

	public function cambiar_contrasena(){
		$data=$this->request->data;
		if(empty($data)){
			$this->responsejson(array("error","formulario vacío"));
			return;
		}

		$id=$this->user['candidato_cve'];

		$data=$this->request->data['CandidatoUsuario'];
		$password_old=$data["contrasena_vieja"];
		$password=$data["contrasena"];
		$result=$this->CandidatoUsuario->cambiar_contrasena($id,$password_old,$password);
		
		$this->responsejson($result);
	}

	public function guardar_configuracion(){
		$data=$this->request->data;
		if(empty($data)){
			$this->responsejson(array("error","formulario vacío"));
			return;
		}
		$this->CandidatoUsuario->Candidato->id=$data['Candidato']['candidato_cve'];
		$result=$this->CandidatoUsuario->Candidato->save($data['Candidato'],false,array("candidato_nom","candidato_pat","candidato_mat"));
		if($result){
			$result=$this->CandidatoUsuario->Candidato->ConfigCan->guardar_configuracion( $this->user['candidato_cve'],$this->request->data);	

		}
		else{
			$result = array("error","no se puedo guardar datos personales",$this->CandidatoUsuario->Candidato->validationErros);
		}


	
		$this->responsejson($result);

	}


	public function desactivar_facebook(){
			App::uses('FB', 'Facebook.Lib');
			$user=$this->user;
			$facebook_id= $this->Session->read("Auth.User.facebook_id");	
			if(!empty($facebook_id)){
				$facebook = new FB();
				$res= $facebook->api("/$facebook_id/permissions","delete");		
				$this->CandidatoUsuario->id=$user['candidato_cve'];
				$this->CandidatoUsuario->saveField("facebook_id",null);
				$this->Session->write("Auth.User.facebook_id",null);	
			}					
			$this->info("Cuenta de facebook desenlazada.");
			$this->redirect("index");
	}
	public function activar_facebook(){
			App::uses('FB', 'Facebook.Lib');
			$facebook = new FB();
			$res= $facebook->api("/me");		
			$user_id=$res['id'];
			$idUser=$this->user['candidato_cve'];
			$this->CandidatoUsuario->activar_facebook($user_id,$idUser);
			$this->Session->write("Auth.User.facebook_id",$user_id);
			$this->info("Cuenta de facebook enlazada.");
			$this->redirect("index");
	}

	public function desactivar_cuenta(){

  		$user=$this->Session->read("Auth.User");
		$cc_status=$this->Session->read("Auth.User.cc_status") == 1 ? 0: 1;

		$results=array("target" =>"");
		$this->CandidatoUsuario->begin();
		$this->CandidatoUsuario->id=$user['candidato_cve'];
		if( $this->CandidatoUsuario->savefield ("cc_status",$cc_status ) ){
			$this->Session->write("Auth.User.cc_status",$cc_status);		
			$results['target'] = $cc_status== 0 ?'#tmpl-activar':"#tmpl-desactivar";

			if($cc_status==0){
				classRegistry::init("Postulacion")->deleteAll(array("candidato_cve" => $user['candidato_cve']));
				try{
					$this->Emailer->sendEmail(
						$this->user['cc_email'], 
						'Desactivación de cuenta', 
						'cuenta_desactivada_candidato', 
						
						array(
								"usuario" => $this->user['Candidato']['nombre_']
							)	,
						'aviso'
						);

				} catch (Exception $e){
					$this->error("No se pudo enviar correo.");
					$this->CandidatoUsuario->rollback();

				}


					

			}

			$this->success("El estatus de la cuenta a sido cambiado con exíto");
			$this->CandidatoUsuario->commit();
		}
		else{
			 	$this->response->statusCode(400);
				$this->error("no se pudo cambiar el estatus de la cuenta");
		}
		$this->set(compact("results"));

  }


 	public function beforeFilter() {
 		   parent::beforeFilter();
 		

 	}


}

<?php

App::uses('FB', 'Facebook.Lib');

class VerificaCuentaController extends AppController {
	public $name="VerificaCuenta";
	public function index(){    	
                    
  
        $param=$this->request->query;
        if(!isset($param['autentificar'])){
        	$this->error("error en los parametros");
        	$this->redirect("/");
        	return;
        }
        $autentificar=  $param['autentificar'];

        $response=array();
		$this->loadModel("CandidatoUsuario");
		$authUser = $this->Auth->user(); 
		$isAuthUser = isset($authUser) && !empty($authUser);
		$id_api=null;
        if($autentificar=='facebook'){
        	    $Facebook = new FB();
				$response['facebook'] = $Facebook->api(
												    "/me"
												);			
				if(!isset($response['facebook']) ){
					$this->error('error redireccionamiento.');
           			$this->redirect("/");
           			return ;
				}			
				$email=$response['facebook']['email'];	
				$id_api=$response['facebook']['id'];
				if(!$isAuthUser){
						/*buscamos el usuario de facebook en nuestro empleo*/
						 $user=$this->CandidatoUsuario->findByCcEmail($email);


						 /*si no lo encuentra  lo creamos con los datos disponibles de su cuenta de facebook*/
						 if(empty($user)){
						 	$idUser=$this->crearCuenta('facebook',$response['facebook']);						 
						 	$user=$this->CandidatoUsuario->read(null,$idUser);						 
						 }
						 /* realizamos loggeo del usuario de facebook*/
						 if(!empty($user)){
						 	$status=$user['CandidatoUsuario']['cc_status'] ;
						 	$idUser=$user['CandidatoUsuario']['candidato_cve'];

						 	if($status == -2){
						 			$this->error("Favor de verficar terminos y condiciones de Nuestro Empleo, si tienes dudas favor de contactarnos.");
						 			$this->redirect("/");
						 			return;
						 	}
						 	if($status== -1){
						 		$this->CandidatoUsuario->activar($idUser);
						 		$user=$this->CandidatoUsuario->read(null,$idUser);
						 	}
						 	$isAuthUser= $this->Auth->login( $user['CandidatoUsuario']);
						 	if($isAuthUser)
						 		$authUser = $this->Auth->user(); 
						 }
				}
        }     
		/*
			Si se encontro el correo de facebook en nuestro empleo se realiza la ligadura

		 */
		if($isAuthUser){

			$idUser=$authUser['candidato_cve'];
			if(empty($authUser['facebook_id'])){
					$this->CandidatoUsuario->id=$idUser;
					$this->CandidatoUsuario->saveField("facebook_id",$id_api);					
			}
			$ubicacion= $this->CandidatoUsuario->Candidato->find("direccion",array(
			    "idUser" =>$idUser
			  ));
			$this->Session->write("Auth.User.Candidato",$ubicacion['Candidato']);
			unset($ubicacion['Candidato']);
			$fecha= $this->CandidatoUsuario->Candidato->fechaConexion($idUser);
      		$this->Session->write("Auth.User.Candidato.ultima_conexion",$fecha);
   			$this->Session->write("Auth.User.ubicacion",$ubicacion);	
   			$this->Session->write("Auth.User.facebook_id",$id_api);	
   			$this->info("Ingresando con cuenta de facebook");
			$this->redirect("/candidato");
			return;
		}	 	
		$this->set(compact("response"));

	}
	public function login($autentificar=null){
		if($autentificar==null ){
			$this->response->statusCode(300);
			$this->error("Erro en redireccionamiento.");
			return;
		}	


		$this->request->data;
		
		if(!$this->Auth->login()){
			$this->response->statusCode(300);
			$this->error("Error usuario o contraseña no valida.");
			return;
		}		
		$response=array();

		if($autentificar=='facebook'){
			$Facebook = new FB();
			$response['facebook']= $Facebook->api("/me");		
			if(empty($response['facebook'])){
				$this->error('error redireccionamiento.');
	           	$this->redirect("/");
			}
		}
		$user=  $this->Auth->user();
		$this->loadModel("CandidatoUsuario");
		$this->CandidatoUsuario->id=$user['candidato_cve'];
		$this->CandidatoUsuario->saveField("facebook_id",$response['facebook']['id']);	
		$this->info("Iniciando sesión con Facebook");
		$this->redirect("/verificaCuenta?autentificar=".$autentificar);

	}
	private function crearCuenta($autentificar=null ,$data=array()){

			if($autentificar==null){
				return;
			}		
			$idUser=null;
			if($autentificar=='facebook'){
					$save=array(
						'CandidatoUsuario' => array(
							"cc_password" =>null,
							"cc_email"=> $data['email'],
							"per_cve" =>"10",
							"cc_status"=>"1",
							'facebook_id' => $data['id']
						),
						'Candidato' => array(
													'candidato_nom' => $data['first_name'],
													'candidato_pat' =>$data['last_name'],
													'candidato_sex' =>( $data['gender'] == 'male' ?'M':'F' ) ,
													'edo_civil' => 1

							),
						"EvaCan" =>array(
                                            "candidato_cve"=>null, 
                                            "evaluacion_cve"=>2,  
                                            "cu_cve" => 1,
                                            "evaluacion_status" =>0,
                                            "evaluacion_fec" =>  date("Y-m-d ")
                                            )
						);
			$this->CandidatoUsuario->save($save,false);
			$idUser= $this->CandidatoUsuario->id;
			$save['Candidato']['candidato_cve']=$save['EvaCan']['candidato_cve'] = $idUser;
			$this->CandidatoUsuario->Candidato->save($save,false );
			ClassRegistry::init("EvaCan")->save($save,false) ;	

			}
			return $idUser;
	}




	 public function beforeFilter() {
	 	parent::beforeFilter();
 		$a = array('index','login');
    	$this->Auth->allow($a);

    	


	 }


}	
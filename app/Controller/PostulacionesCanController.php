<?php

App::import('Utility','Security');
App::import('Vendor',array('funciones'));
App::import('controller', 'BaseCandidato');

class PostulacionesCanController extends BaseCandidatoController {
    public $name = 'PostulacionesCan';
    public $uses=array("Oferta","Postulacion","Reportar");

    public $components= array( "Notificaciones");
    public $helpers = array(
                            'Form' => array(
                                    'className' => 'Formito'
                                    ),
                            'Html' => array(
                                    'className' =>"Htmlito"
                                    ) ,
                            "Js",
                            "Time"=> array(
                                    'className' =>  'Tiempito'
                                ),
                            "OfertaMensaje" );


    public function index(){



        $this->request->data =ClassRegistry::init("Candidato")->find("basic_info",array("idUser"=>$this->user['candidato_cve']  ))[0];

    }

    public function postulaciones(){


            $postulaciones=$this->Postulacion->find("all_info",array(
                                                    "idCandidato" => $this->user['candidato_cve']
            ));
          $this->set(compact("postulaciones"));

    }


    public function postularse($id=null){

        if($id== null){
           $this->error("No existe oferta");
           $this->response->statusCode(300);
            return;
        }
        $user=$this->user;
        $idUser=$user['candidato_cve'];
        $this->loadModel("CandidatoUsuario");
        if(!$this->CandidatoUsuario->status($idUser)){
            $this->error("No es posible postularse, verifica que tu cuenta este activa. ");
            $this->redirect("/candidato/configCan");
            $this->response->statusCode(300);
            return;
        }        
        $rs=$this->Postulacion->postularse($id,$idUser);
        if ( $rs ===false){
            $this->error("No fue posible guardar la postulación.");
            $this->response->statusCode(300);
        }

         $this->set(compact("id"));

    }



    public function quitar($id=null){

        if($id== null){
            $this->error("No existe oferta");
           $this->response->statusCode(300);
            return;
        }

        $rs=$this->Postulacion->quitar($id,$this->user['candidato_cve']);
        $this->callback('deleteRow');
        if($rs===false){
            $this->error("No se pudo eliminar postulación");
            $this->response->statusCode(300);
        }
        $this->set(compact("id"));

    }

    public function denunciar($idOferta=null){
        if($idOferta==null){
                $this->error(__("No existe oferta"));
                return;
        }
        if(empty($this->request->data)){
           $this->error(__("Formulario vacío"));           
           return;
        }
        if($this->Reportar->verifica_status($idOferta,$this->Auth->user('candidato_cve'))   ){
            $this->warning(__("Existe una denuncia previa."));            
            return;            
        }
        $info=$this->request->data;
        $info['idOferta']=$idOferta;
        $info['idCandidato'] =$this->user['candidato_cve'];
        if($this->Reportar->guardar($info)){
            $this->success(__("La oferta fue reportada"));        
        }
        else{
            $this->error(__("La  oferta no pudo ser reportada"));      
            $this->statusCode(400);        
        }
        // $this->redirect(array("controller"=> "BusquedaOferta","action"=>"index"));
    }

    public function eliminar($id=null){
            if($id==null){
                $this->responsejson(array("error","no existe postulación"));
                return;
            }

           if($this->Postulacion->delete($id,false)){
               $this->callback('deleteRow');
           }
           else{
               $this->error("No fue posible eliminar postulación");
           }

    }
    public function ver($id=null){
        if($id==null){
            $this->error("No es posible realizar acción.");
            $this->redirect("/PostulacionesCan/index");
            return;
        }
        $oferta=$this->Oferta->find("oferta",array(
            "idOferta"=>$id
        ));
        $param_query=array();
        $conditions=array();
        $this->set(compact("oferta","param_query","conditions"));
    }
    public  function oferta_detalles($id=null){
        if($id==null){
            $this->error(__("No es posible realizar acción."));
            $this->redirect( "index" );
            return;
        }

        $tipo=$this->Acceso->is();
        $denuncia_=ClassRegistry::init("Reportar");
        $denuncia_previa=true;
        if($tipo!=='guest'){
             $denuncia_previa = $denuncia_->verifica_status($id,$this->Auth->user('candidato_cve'));        
             $num=$denuncia_->numeroDenuncias($id);
             if($num > 0){
                    $this->warning(__("Esta oferta fue denunciada."));
             }
        }
        else{
            
        }       

        $oferta=$this->Oferta->find("oferta",array(
            "idOferta"=>$id
        ));       
        if(!empty($oferta)){
            $title_layout=$oferta['Oferta']['puesto_nom'];
            $description_layout=$oferta['Oferta']['oferta_resumen'];
        }
        $this->set(compact("oferta","title_layout","description_layout","denuncia_previa"));

    }


    public function comentarios(){
            $idUser=$this->user['candidato_cve'];
            $data=$this->request->query;
            $comentarios=array();
            if(!empty($data)&&$this->isAjax){
                $idOferta=$data['idOferta'];

                if($this->Oferta->hasAny(array(
                    "Oferta.oferta_cve" => $idOferta,
                    "Oferta.oferta_preguntas" => 1
                    )) ){
                    $this->loadModel("MensajeOferta");
                    $comentarios=$this->MensajeOferta->find("comentarios",
                                                            compact("idOferta","idUser" )
                                                      );
                }
                else{
                    $comentarios=array();
                }              
            }
            $this->set(compact("comentarios"));

    }

    public function  guarda_comentario(){
        $data=$this->request->query;
        if(!$this->request->is("get") ||!$this->isAjax|| empty($data)){
            return;

        }
        $this->loadModel("MensajeOferta");
        $idUser=$this->user['candidato_cve'];
        $typeUser=1;
        $mensaje=$data['mensaje'];
        $idOferta=$data['idOferta'];
        $is_public=false;
        $rs= $this->MensajeOferta->guardar(compact("idUser","typeUser","mensaje","idOferta","is_public"));
        if($rs===false ){
            $this->response->statusCode(300);
            $this->error("No fue posible guardar comentario");
        }

        $comentario=array($rs);

        $this->set(compact("comentario"));

    }






  public function beforeFilter(){
    parent::beforeFilter();
    $allowActions=array("ver","oferta_detalles");

    $this->Auth->allow($allowActions);

  }

}
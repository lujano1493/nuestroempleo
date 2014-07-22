<?php
  
App::import('Utility','Security');
App::import('Vendor',array('funciones'));
class EncuestaRefController extends AppController {
    public $name = 'EncuestaRef';

    public $uses = array("Candidato","RefCanEnc");

    public $helpers = array(  'Form' => array('className' => 'Formito'), 'Html',"Js" );




    public function check($ticket=null ,$id=null){

      $this->user = $authUser = $this->Auth->user();
      $isAuthUser = isset($authUser) && !empty($authUser);
      if($isAuthUser){
          $this->Auth->logout();
     
      }
      $this->redirect(array(
                            "controller" => "EncuestaRef" ,
                            "action" =>"index" ,
                            $ticket,
                            $id
                            )
                      );

    }

    public function index ($ticket=null ,$id=null){   
     


        if($ticket==null || $id==null){
           $this->error('Enlace no encontrado.');
           $this->redirect("/");
           return;
        }

        $this->loadModel("Ticket");
        $results = $this->Ticket->checkTicket($ticket);
        /*si encontramos ticket y no expirado*/
         if (!empty($results)) {
            $refcan= ClassRegistry::init('RefCan')->find("first",array('conditions' => array("refcan_cve"=>$id), 'recursive'=> -1   ) );

            if(!empty($refcan)){        

                $candidato=$this->Candidato->getCanInfoRef($refcan['RefCan']['candidato_cve']);       
                $encuesta=$this->RefCanEnc->cargarEncuesta($refcan['RefCan']['refrel_cve'] );     
                $this->request->data=$this->RefCanEnc->find("RefEnc",array( 
                                                                            "idRef"=>$refcan['RefCan']['refcan_cve'] ,
                                                                            "refrel"=>$refcan['RefCan']['refrel_cve']
                                                                          ) );
                $this->set("param",compact("refcan" ,"candidato","encuesta" , "ticket"));                

            }
            else{
                $this->error('Referencia no encontrada.');
              $this->redirect("/");
            }

       

         }
         else {
          $this->error('Enlace no encontrado.');
          $this->redirect('/');
        }


    
    
     

    }

/* accion guardar para los datos de encuesta*/
    public function  guardar(){

      $data=$this->request->data;
      if(empty($data)){
          $this->responsejson(array("error","formulario vacío"));
          return;
      }
    
       $this->responsejson( $this->RefCanEnc->guardar($data) );

    }


    public function beforeFilter(){
      parent::beforeFilter();



      $this->Auth->allow();  
      $this->layout='default';

    }

}
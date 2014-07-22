<?php
  
App::import('Utility','Security');

App::import('Vendor',array('funciones'));
App::import('controller', 'BaseCandidato');

class PortafolioController extends BaseCandidatoController {
    public $name = 'Portafolio';
    public $uses=array("DocCan"); 
    public $components = array('Upload'); 

    public function index(){
      $param=array("idUser"=>$this->user['candidato_cve']  );
      $documentos=$this->DocCan->find("documentos",$param);
    $this->request->data=classRegistry::init("Candidato")->find("basic_info",$param)[0];
     $this->set(compact('documentos'));
   
     //$this->set(compact(''));

    }


    public function guardar(){
      $data=$this->request->data;
        if(empty($data)){
          $this->responsejson(array("error","Formulario vacío"));
          return;
        }
        $file_res=array();        
        $this->DocCan->begin();
        $data[$this->DocCan->alias]['candidato_cve'] =$this->user['candidato_cve']; 
        if($res_save=$this->DocCan->save($data)){
            $res_save=$res_save['DocCan'];

            if($data[$this->DocCan->alias]["tipodoc_cve"]!=10 ){
              $file_res= $this->guardar_archivo($res_save);
              if(!empty($file_res)){
                $this->DocCan->commit();
              }  
              else{
                $this->DocCan->rollback();
                 $res=array("error","Error al guardar error al guardar archivo.");
                $this->responsejson($res);
                return;
              }

            }
            else{

              $this->DocCan->commit();
            }
                      
            $this->set("result",compact("res_save","file_res"));    

            if(!$this->isAjax){
              $this->render("json/result","json/default" );
            }
            else{
                  $this->render("result");
            }
             

        }
        else{
            $this->DocCan->rollback();
            $res=array("error","Error al guardar información.");
            $this->responsejson($res);
            return;
        }
      
    }

    private  function  guardar_archivo($data=array()){
     $result= $this->Upload->post(false);
     $name=$result['files'][0]->name;
      $sal= funciones::agregadocumento($this->user['candidato_cve'],$data['docscan_nom'],"temporales/$name");
     if (!$sal){
        return $sal;
     }
     return $result;
    }


    public function  elemento($id=null){
          if($id==null){
              $this->responsejson(array("error","error id nulo"));
              return;
          }

         $respuesta= $this->DocCan->find("documento",array(
                                              "idUser" =>$this->user['candidato_cve'],
                                              "id" => $id ));



        if(empty($respuesta)){
              $this->responsejson(array("error","no existe archivo con ese id"));
              return;          
        }

       $this->set("result",$respuesta[0]['DocCan']);


    }


    function eliminar($id=null,$tipo=null,$name=null){

      if($id==null||$tipo==null||$name==null){
        $this->responsejson(array("error","Error id de elemento no válido."));
        return;

      }
      if($tipo!= 10){
          Funciones::eliminardocumento($this->user['candidato_cve'],$name);
      }
      if($this->DocCan->delete($id,false )){
        $this->responsejson(array("ok","Eliminación completa."));
      }
      else{
          $this->responsejson(array("error","Error al eliminar elemento."));
      }


    }


  

  public function beforeFilter(){
    parent::beforeFilter();
    	//$this->Auth->allow();  

  }

}
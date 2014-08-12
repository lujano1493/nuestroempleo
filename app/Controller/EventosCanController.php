<?php 

	App::import("Controller","MisEventos");
	App::import('Utility','Security');
	App::import('Utility','Usuario');
	App::import('controller', 'BaseCandidato');
class EventosCanController extends BaseCandidatoController {
	public $name="EventosCan";	
	public $uses=array("Candidato","Evento");
	public function index(){
		$this->_init_render();
	}
	private function _init_render(){
	  	$list=array();
	  	$data=$this->request->data;
	  	$param=array();
	    $list['estados']=$this->Evento->listaEstados();
	    $list['TIPO_EVENTO']=classRegistry::init("Catalogo")->get_list("TIPO_EVENTO");
	    $cerca_est=null;
	    if($this->user){
	    	$idUser=$this->user['candidato_cve'];
	    	$candidato= $this->Candidato->find("basic_info",array("idUser"=> $idUser  ))[0];
	   		$this->request->data= $candidato;
	   		$cerca_est=$candidato['CodigoPostal']['est_cve'];
	   		$param['is_login']=true;
	    }		    
	  	$param['idEstado']=$this->request->query("estadito") ;

	  	if($this->request->query("start") && $this->request->query("end")){
	  		$param['fecha_inicio'] = date("Y-m-d",(int)$this->request->query("start") );
	  		$param['fecha_fin'] = date("Y-m-d",(int)$this->request->query("end") );
	  	}
	  	$idEvento=$this->request->query("idEvento");
	  	if($idEvento){
	  		$param['idEvento']=$idEvento;
	  		ClassRegistry::init("Notificacion")->syn_leido($idEvento,"evento");		  
	  	}
	    $eventos = ($this->isAjax ) ?   $this->Evento->find('cercanos', $param) :array()  ;
	    $this->set(compact('eventos',"list","cerca_est","idEvento"));
	    return $eventos;
	}
  	public function ver($id=null){
	    if ($id == null) {
	      $this->error('No es posible realizar acción.');
	      $this->redirect("index");
	      return;
	    }
	    $idEvento=$id;
	    $eventos=$this->Evento->find('cercanos',compact("idEvento"));
	    if(empty($eventos)){
	      $this->error('No existe el evento indicado.');
	      $this->redirect("index");
	      return;
	    } 
	    $this->_init_render();
		$title_layout=$eventos['Evento']['evento_nombre'];
		$description_layout=$eventos['Evento']['evento_resena'];
		$this->set(compact('title_layout','description_layout','eventos','idEvento'));   
		$this->render('index');
 	}
	public function beforeFilter() {
		parent::beforeFilter();
	    $allowActions = array('index','ver');
	    $this->Auth->allow($allowActions);  
	    if (!empty($this->micrositio)){
	    		$this->Evento->micrositio=$this->micrositio;
	    		
	    }
	}
	

}
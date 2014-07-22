<?php
	App::import('Vendor','funciones');
	App::import('Utility','Security');
	App::uses('ConnectionManager', 'Model');
class EscolaresController extends AppController {
		var $name = 'Escolares';
		var $uses = array('Escolar','EscCarArea','EscCarGene','EscCarEspe','Curso','IdiomaPer','ExpLabPer','Pasatiempo',
						'TipoPasatiempo','PasatiempoPer','RefPer','RefCom');		
		var $helpers = array('Form', 'Html');
		var $pais_cve="1";
		var $gpo_cve="1";
		var $user;
		public function consultar($opcion){
				$this->autoRender=false;
				$user =$this->user;
			if($opcion=="form_escolar_b"){
				echo json_encode($this->Escolar->basicos($user['persona_cve']));				
			}
			else if($opcion=="form_escolar_s"){
				echo json_encode($this->Escolar->superior($user['persona_cve']));
			}
			else if($opcion=="form_escolar_p"){
				echo json_encode($this->Escolar->posgrado($user['persona_cve']));
			}
			else if($opcion=="form_escolar_c"){
				echo json_encode($this->Curso->all($user['persona_cve']));
			}
			else if($opcion=="form_escolar_i"){
				echo json_encode($this->IdiomaPer->all($user['persona_cve']));
			}
			else if($opcion=="form_exp_laboral"){
				echo json_encode($this->ExpLabPer->all($user['persona_cve']));
			}
			else if($opcion=="form_referencias"){
				
				echo $this->consultar_referencias();  
			}
					
			else{
				echo json_encode(array("Opcion no valida :P"));
			}
			
		}
		
		
		
		function consultar_referencias(){
				$ref=array_merge($this->RefPer->all($this->user['persona_cve']),$this->RefCom->all($this->user['persona_cve']));	
				return json_encode($ref);
		}
		
		
		
		function eliminar($target){
				$this->autoRender=false;
				if(empty($this->request->data)){
						echo json_encode(array ("0"=>array ( "sts"=>"empty","mensaje"=>"No hay parametros"  )  ) );
				}				
				 $opcion=$target;
				 if($opcion=="form_escolar_b" ||$opcion=="form_escolar_s" ||$opcion=="form_escolar_p" ){
					 
					echo $this->eliminar_($this->Escolar,$this->request->data["Escolar"]["escper_cve"]);
				 }
				 else if($opcion=="form_escolar_c" ){
					echo $this->eliminar_($this->Curso,$this->request->data["Curso"]["curper_cve"]);
				 }	
 				else if($opcion=="form_escolar_i" ){
					echo $this->eliminar_($this->IdiomaPer,$this->request->data["IdiomaPer"]["idiper_cve"]);
				 }	
				 else if($opcion=="form_exp_laboral" ){
					echo $this->eliminar_($this->ExpLabPer,$this->request->data["ExpLabPer"]["explab_cve"]);
				 }	
				 else if($opcion=="form_referencias" ){				 	
				 	if(isset($this->request->data['RefPer'])){
				 		$id=$this->request->data["RefPer"]["refper_cve"];
				 		$model=$this->RefPer;
				 	}
				 	else if(isset($this->request->data['RefCom'])){
				 		$id=$this->request->data["RefCom"]["refcom_cve"];
				 		$model=$this->RefCom;
				 	}
					echo $this->eliminar_($model,$id);
				 }	
				 else {
					 	echo json_encode(array ("0"=>array ( "sts"=>"error","mensaje"=>"opcion no valida"  )  ) );
					}			
		}
		
	
	function eliminar_($model,$clave){
		$resultado="";
		if($model->delete($clave)){
			$resultado= json_encode(array ("0"=>array ( "sts"=>"ok","mensaje"=>"El elemento fue eliminado"  )  ) );
		}
		else{
			$resultado= json_encode(array ("0"=>array ( "sts"=>"error","mensaje"=>"El elemento no fue eliminado"  )  ) );
		}
		
		return $resultado;
		
		
	}
		
	
	
	
	function guardar(){
		$this->autoRender=false;
		if(empty($this->request->data)){
			echo json_encode(array ("0"=>array ( "sts"=>"empty","mensaje"=>"No hay parametros"  )  ) );
		}
		else{	
					$opcion=$this->data['Options']['target'];
		
				if($opcion=="lista_form_escolar_b"){
					echo $this->guardar_esc_($this->request->data['Escolar']['Escolar'],$this->Escolar);
				}
				else if($opcion=="lista_form_escolar_s"){
					echo $this->guardar_esc_($this->request->data['Escolar']['Escolar_S'],$this->Escolar);
				}
				else if($opcion=="lista_form_escolar_p"){
					echo $this->guardar_esc_($this->request->data['Escolar']['Escolar_P'],$this->Escolar);
				}
				else if($opcion=="lista_form_escolar_c"){
					echo $this->guardar_esc_($this->request->data['Escolar']['Curso'],$this->Curso);
				}
				else if($opcion=="lista_form_escolar_i"){
					echo $this->guardar_esc_($this->request->data['Escolar']['IdiomaPer'],$this->IdiomaPer);
				}
				else if($opcion=="lista_exp_laboral"){
					echo $this->guardar_esc_($this->request->data['Laboral']['ExpLabPer'],$this->ExpLabPer);
				}
				
				else if($opcion=="lista_referencias"){
					echo $this->guardar_referencias($this->request->data);
				}
				
				
				
				else{
					echo json_encode(array ("0"=>array ( "sts"=>"error","mensaje"=>"Opcion No Valida Escolaridad"  )  ) );
				}			
			}

	}

function guardar_esc_($data,$model){
		$user =$this->user;
		$id=$model->primaryKey;
		$name=$model->name;
		$empty=  (isset( $data[$id]))?$data[$id]:null;				
		if($empty!=NULL && $empty!==""){
					$model->id=$data[$id];					
				}
				else {					
					$data['persona_cve']=$user['persona_cve'];
					$data['gpo_cve']=$this->gpo_cve;
					$data[$id]= $model->get_Id();			
				}	
				if($model->save($data)){
						  $result= $model->find('all', array (
						  		'conditions'=> array  ( $name.'.'.$id => $data[$id]  )						  	
						  	));
						return json_encode(array ("0"=>array ( "sts"=>"ok","mensaje"=>"Los Datos fueron Guardados Exitosamente","data"=>$result )  ) );
				}
				else{
					return json_encode(array ("0"=>array ( "sts"=>"error","mensaje"=>"Los Datos no Fueron Guardados !!!"  )  ) );
				}	
				
				
	//	return $this->guardar_(array('Escolar'=>$data),$this->Escolar);
}



function guardar_pasatiempo(){
		$this->autoRender=false;
		$persona_cve=$this->user['persona_cve'];
		echo json_encode( $this->PasatiempoPer->insertar_pasatiempos($this->gpo_cve,$persona_cve,$this->request->data) );
	
	
	}
	
	
	function guardar_referencias($data){
		$tipo=$data['Referencia']['tipo'];
		$model=($tipo=='0')?$this->RefCom:$this->RefPer;
		$data['Referencia'][$model->primaryKey]=$data['Referencia']['clave'];		
		$this->change_fields($model,$data,'Referencia');		
		return $this->guardar_esc_($data['Referencia'],$model);	
	
	}
	
	function change_fields($model,&$data,$name_model){
		$virtual=$model->virtualFields;		
			foreach ($virtual as $key => $value){
					if(isset($data[$name_model][$key]) ){
						$data[$name_model][$value]=$data[$name_model][$key];
						unset($data[$name_model][$key]);						
					}
			}
		
	
	
	}
	function change_name_model(&$data,$name_model,$new_name){
		foreach ($data as $key =>$value ){
			if(isset($value[$name_model])){
				$data[$key][$new_name]=$value[$name_model];
				unset($data[$key][$name_model]);
			}
		}
	}
	
	

	
function  change_select($id,$data){
			$result=NULL;
			$this->autoRender=false;
			if($id=="carea_cve"){
				$result=$this->EscCarGene->getgenerica($data);				
			}
			else if ($id=="cgen_cve"){
				$result=$this->EscCarEspe->getEspecifica($data);
			}
			echo json_encode($result);
		
	}		
		
		
function prueba(){
	$p =$this->RefCom->all($this->user['persona_cve']);
	$a=$this->RefPer->all($this->user['persona_cve']);
	$this->change_name_model($p,'RefCom','Referencia');
	$this->change_name_model($a,'RefPer','Referencia');
	$res=array_merge($p,$a);
	
	var_dump($res);
	
		
}		
		
		
		
	public function beforeFilter() {
    parent::beforeFilter();

    /**
      * Acciones que no necesitan autenticación.
      */
    $allowActions = array('prueba');
    $this->Auth->allow($allowActions);	
    $this->user=$this->Auth->user();
	
  }
	

}
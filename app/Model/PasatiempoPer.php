<?php


class PasatiempoPer extends AppModel {
	var $name='PasatiempoPer';
	var $useTable = 'tpasatiempopersona'; 
	var $primaryKey="pasa_cve";	
	var $virtualFields= array(

	);

	 public $belongsTo = array(
        	'Pasatiempo' => array(
            'className'    => 'Pasatiempo',
            'foreignKey'   => false,
			 'conditions' => array('PasatiempoPer.pas_cve = Pasatiempo.pas_cve')

        ),
        'Tipopasatiempo' => array(
            'className'    => 'Tipopasatiempo',
            'foreignKey'   => false,
			 'conditions' => array('Pasatiempo.pasa_cve = Tipopasatiempo.pasa_cve')

        )
        
        );
	
	
	 function all($candidato_cve){
		return 	 $this->find("all", array ('conditions'=> array('PasatiempoPer.candidato_cve'=>$candidato_cve)));
		 
	}
	
	function insertar_pasatiempos($gpo_cve,$candidato_cve,$request){
		$dataSource = $this->getDataSource();
		$result=array ("0"=>array ( "sts"=>"","mensaje"=>""  )  );
		
		$dataSource->begin();
		if($this->eliminar_todo($candidato_cve)){
			foreach ($request as $data_ ){
					$data=$data_['PasatiempoPer'];
					$data['candidato_cve']=$candidato_cve;
					$data['gpo_cve']=$gpo_cve;
					$data['pasa_cve']=$this->get_Id();		
					$data['aud_cve']="0";										
					if(!$this->save($data)){
						$result[0]=array("sts"=>"error","mensaje"=>"Error al insertar pasatiempos");
						 $dataSource->rollback();
						 break;
					}
					
					
			}	
			 $result[0]=array("sts"=>"ok","mensaje"=>"  Pasatiempos guardardos");
			  $dataSource->commit();
		}
		else{
			$result[0]=array("sts"=>"error","mensaje"=>"Error al guardar Pasatiempos");
			$dataSource->rollback();
		}
	
		return $result;
	
	}
	
	
	
	 
	 function eliminar_todo($candidato_cve){
	 	 return $this->deleteAll(array('PasatiempoPer.candidato_cve'=>$candidato_cve),false);
	 
	 }
	
		

		
		
}
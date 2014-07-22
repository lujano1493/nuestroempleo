<?php

class Escolar extends AppModel {
	var $name='Escolar';
	var $useTable = 'tescpersona'; 
	var $primaryKey="escper_cve";	
	public $virtualFields = array(
  		"gmc"=>"DECODE(Escolar.escper_gmc,1,'PRIMER AÑO',2,'SEGUNDO AÑO',3,'TERCER AÑO',4,'CUARTO AÑO',5,'QUINTO AÑO',6,'SEXTO AÑO',7,'SEPTIMO AÑO',8,'OCTAVO AÑO',9,'NOVENO AÑO','DATO NO CAPTURADO' ) ",
		"titulado"=>"DECODE(Escolar.escper_titulado,'S','SÍ','N','NO','DATO NO CAPTURADO')",
		"nivel_"=>"DECODE(Escolar.escper_nivel,1,'PRIMARIA',2,'SECUNDARIA',3,'PREPARATORIA',4,'VOCACIONAL',5,'TECNICA',6,'SUPERIOR',7,'MAESTRIA',8,'DOCTORADO','DATO NO CAPTURADO')",
		
		
	);		
	var $encode_utf= array (array('model'=>'Escolar', //para mostrar
					'fields'=>array ("escper_institucion","escper_lugar","escper_especialidad"))   );
	
	var $decode_utf= array (array('model'=>'Escolar',
					'fields'=>array ("escper_institucion","escper_lugar","escper_especialidad"))   );//para guardar
	
	
	 public $belongsTo = array(
        	'EscCarEspe' => array(
            'className'    => 'EscCarEspe',
            'foreignKey'   => false,
			 'conditions' => array('Escolar.cespe_cve = EscCarEspe.cespe_cve')

        ),
		'EscCarGene' => array(
            'className'    => 'EscCarGene',
            'foreignKey'   => false,
			 'conditions' => array('EscCarEspe.cgen_cve = EscCarGene.cgen_cve and  EscCarEspe.carea_cve=EscCarGene.carea_cve')

        ),				
	 	'EscCarArea' => array(
            'className'    => 'EscCarArea',
            'foreignKey'   => false,
			 'conditions' => array('EscCarGene.carea_cve = EscCarArea.carea_cve')

        ) 
		
    );
		
		
	function basicos($candidato_cve){
		return	$this->find("all",array (
											"conditions"=> array(
																	"Escolar.candidato_cve"=>$candidato_cve,
																	"Escolar.escper_nivel <=" => "5"
																	 )
									));	

	}
	function superior($candidato_cve){
		return	$this->find("all",array (
											"conditions"=> array(
																	"Escolar.candidato_cve"=>$candidato_cve,
																	"Escolar.escper_nivel =" => "6"
																	 )
									));	

	}
	
	function posgrado($candidato_cve){
		return	$this->find("all",array (
											"conditions"=> array(
																	"Escolar.candidato_cve"=>$candidato_cve,
																	"Escolar.escper_nivel >" => "6"
																	 )
									));	

	}
			
	function getNivelesBasicos(){
		
		return array (
					""=>"Selecciona nivel",
					"1"=>"PRIMARIA",
					"2"=>"SECUNDARIA",
					"3"=>"PREPARATORIA",		
					"4"=>"VOCACIONAL",
					"5"=>"TÉCNICA"
			);
		
		
	}
	function getGMCBasicos(){
			return array (
					 ""=>"Selecciona opción",
					"1"=>"PRIMER AÑO",
					"2"=>"SEGUNDO AÑO",
					"3"=>"TERCER AÑO"
			);
		
		
	}
	function getGMCSuperior(){
			return array (
					 ""=>"Selecciona Opción",
					"1"=>"PRIMER AÑO",
					"2"=>"SEGUNDO AÑO",
					"3"=>"TERCER AÑO",
					"4"=>"CUARTO AÑO",
					"5"=>"QUINTO AÑO",
					"6"=>"SEXTO AÑO",
					"7"=>"SEPTIMO AÑO",
					"8"=>"OCTAVO AÑO",
					"9"=>"NOVENO AÑO",
					
			);
		
		
	}
	function getNivelesPosgrado(){
		
		return array (
					""=>"Selecciona ...",		
					"7"=>"MAESTRIA",
					"8"=>"DOCTORADO"
			);
		
		
	}
	
	function get_Id(){
				$rs=$this->find('all',array ( 'fields'=>  'nvl(max( '.$this->name.'.'.$this->primaryKey.'),0)+1 as clave '));		
				$rs=$rs[0][0]['clave'];
			return $rs;
		
		}
		
		
}
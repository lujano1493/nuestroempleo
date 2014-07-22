<?php

class Curso extends AppModel {
	var $name='Curso';
	var $useTable = 'tcursospersona'; 
	var $primaryKey="curper_cve";	
	var $virtualFields= array(
		"tipo_"=>"DECODE(Curso.curper_tipo,1,'CURSO',2,'DIPLOMADO',3,'SEMINARIO',4,'CERTIFICACIÓN',5,'OTRO','DATO NO CAPTURADO') ",
		'intext_'=>"DECODE(Curso.curper_intext,1,'INTERNO',2,'EXTERNO (LO PAGUE YO)','DATO NO CAPTURADO')",
		'result_'=>"DECODE(Curso.curper_result,1,'APROBADO',2,'NO APROBADO','DATO NO CAPTURADO')",
		'curper_fecini'=>"TO_CHAR(curper_fecini,'DD/MM/YYYY')",
		'curper_fecfin'=>"TO_CHAR(curper_fecfin,'DD/MM/YYYY')",
	);
	var $encode_utf= array (array('model'=>'Curso',
					'fields'=>array("curper_descrip","curper_obj","curper_instructor"))   );
	
	var $decode_utf= array (array('model'=>'Curso',
					'fields'=>array("curper_descrip","curper_obj","curper_instructor"))   );
	

	 
	 function all($candidato_cve){
		 
		return 	 $this->find("all",array(
											"conditions"=>array (
																	"Curso.candidato_cve"=>$candidato_cve
																)

											));
		 
	}
	 
	 
	 function getTipo_select(){
			return array(
				""=>"Selecciona ...",
				"1"=>"CURSO",
				"2"=>"DIPLOMADO",
				"3"=>"SEMINARIO",
				"4"=>"CERTIFICACIÓN",
				"5"=>"OTRO"			
			); 
		
		}
	function getIntExt_select(){
			return array(
				""=>"Selecciona ..",
				"1"=>"INTERNO",
				"2"=>"EXTERNO (LO PAGUE YO)"							
			);
		
		
		}
	function getResultado(){
			return array(
				""=>"Selecciona ..",
				"1"=>"APROBADO",
				"2"=>"NO APROBADO"							
			);
	}
		

		
		
}
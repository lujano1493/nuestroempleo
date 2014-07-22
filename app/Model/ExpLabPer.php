<?php
 class ExpLabPer extends AppModel{
 	public $name="ExpLabPer";
 	public $useTable = 'texplabpersona';
 	 public $primaryKey = 'explab_cve';
 	 
 	 
 	 public $virtualFields= array (
 	 	"explab_sueldo_"=> "DECODE(ExpLabPer.explab_sueldo,0,0,1,1,null)", 	 	
 	 	"explab_sueldo"=> "CASE WHEN ExpLabPer.explab_sueldo > 1 THEN ExpLabPer.explab_sueldo ELSE null END",
 	 	"pais_cve"=> "CASE WHEN ExpLabPer.explab_sueldo > 1 THEN ExpLabPer.pais_cve ELSE null END",
 	 	"explab_sindi_"=>"DECODE(ExpLabPer.sindi_cve,null,'N','S')",
 	 	"explab_fecini"=>"TO_CHAR(explab_fecini,'DD/MM/YYYY')",
 	 	"explab_fecter"=>"TO_CHAR(explab_fecter,'DD/MM/YYYY')"
 	 	
 	 );	
	var $encode_utf= array (array('model'=>'ExpLabPer', //para mostrar
					'fields'=>array ("explab_empresa","explab_jefe",'explab_mds'))   );
	
	var $decode_utf= array (array('model'=>'ExpLabPer',
					'fields'=>array("explab_empresa","explab_jefe",'explab_mds'))   );//para guardar
 	 
 	 
 	 function all($candidato_cve){		 
		return 	 $this->find("all",array(
											"conditions"=>array (
																	"ExpLabPer.candidato_cve"=>$candidato_cve
																)

											));
		 
	}
	 
 
 
 }
 
 
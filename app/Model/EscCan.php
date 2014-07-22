<?php

App::import('Model', 'ModelCan');
class EscCan extends ModelCan {
	public $name='EscCan';
	public $useTable = 'tesccandidato'; 
	public $primaryKey="ec_cve";	
	public $msg_succes="Referencias Escolares";

	 public $belongsTo = array(
        	'EscCarEspe' => array(
					            'className'    => 'EscCarEspe',
					            'foreignKey'   => 'cespe_cve'
								),
        	'EscCarGene' =>  array(
					            'className'    => 'EscCarGene',
					            'foreignKey'   => false,
					            'conditions' => array(
					            						"EscCarGene.cgen_cve=EscCarEspe.cgen_cve"		

					            	)
								),
    	 	'EscCarArea' =>  array(
				            'className'    => 'EscCarArea',
				            'foreignKey'   => false,
				            'conditions' => array(
				            						"EscCarArea.carea_cve=EscCarGene.carea_cve"		

				            	)
							),
    	 	'Nivel'=> array(
					  		'className'    => 'Catalogo',
					  		'foreignKey'   => false,
					  		'conditions' => array(
					  								'Nivel.opcion_valor = EscCan.ec_nivel' ,
					  								'Nivel.ref_opcgpo' => 'NIVEL_ESCOLAR'
					  							)
					  		)

    );

	 public $validate = array(
	    'ec_actual' => array(
	        'required'=>  array(
	         'rule' => 'notEmpty',
	         'required' => true,
	        'message'    => '¿Estudias actualmente?'
	      	)),

		    'ec_nivel' => array(
		        'required'=>  array(
		         'rule' => 'notEmpty',
		         'required' => true,
		        'message'    => 'Selecciona máximo nivel de estudios.'
		      	)),
		    'ec_institucion' => array(
		        'required'=>  array(
		         'rule' => 'notEmpty',
		         'allowEmpt' => false,
		        'message'    => 'Ingresa el nombre de la institución.'
		      	))
		   
	    );



	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id,$table,$ds);
		$this->virtualFields = array(
	     	"ec_fecini"=> "to_char(ec_fecini,'DD/MM/YYYY')",  
	 	 	"ec_fecfin"=> "to_char(ec_fecfin,'DD/MM/YYYY')", 	 	
	  		"ec_actual"=>"DECODE(ec_fecfin,NULL,'S','N')"  
    	);

    	 $this->field_extract_info= array(
    	 								// "$this->alias.ec_especialidad",
    	 								// "EscCarArea.carea_nom",
    	 								// "EscCarGene.cgen_nom",
              //                           "EscCarEspe.cespe_nom",
              //                           "Nivel.opcion_texto"

      );

    	$this->limit_extract_info=1;

	}

	public function beforeSave($options = array()){

		if(empty($this->data[$this->alias]["ec_fecfin"])){
			$this->data[$this->alias]["ec_fecfin"]=NULL;
		}		
			
		if (!empty($this->data[$this->alias]["cespe_cve"])){
			$cespe_cve=  json_decode( $this->data[$this->alias]["cespe_cve"]) ;			
			    
			if(!empty($cespe_cve) && !empty($cespe_cve[0])){			
				$this->data[$this->alias]["cespe_cve"]= ($this->data[$this->alias]['ec_nivel']<=3)? "" :$cespe_cve[0];
			}		
		}

		$this->data[$this->alias]["ec_especialidad"]= ($this->data[$this->alias]['ec_nivel']<=8)? "":$this->data[$this->alias]["ec_especialidad"];
		return parent::beforeSave();

	}



}
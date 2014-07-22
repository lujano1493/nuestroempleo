<?php 
App::import('Model', 'ModelCan');
	class ExpEcoCan extends ModelCan {
	public $name='ExpEcoCan';
	public $useTable = 'texpecocandidato'; 
	public $primaryKey="candidato_cve";	
	public $msg_succes="Expectativas Económicas";
	public $virtualFields = array();


	public $belongsTo = array(
  	
  	'SueldoD'=> array(
  		'className'    => 'ExpLabSue',
  		'foreignKey'   => false,
  		'conditions' => array(
  								"ExpEcoCan.explab_sueldod = SueldoD.elsueldo_cve"
  		)
  		),
  	'SueldoA'=> array(
  		'className'    => 'ExpLabSue',
  		'foreignKey'   => false,
  		'conditions' => array(
  								"ExpEcoCan.explab_sueldoa = SueldoA.elsueldo_cve"
  		)
  		)
  	);




	public $validate = array(
	    'expeco_tipoe' => array(
	        'required'=>  array(
	         'rule' => 'notEmpty',
	         'required' => true,
	        'message'    => 'selecciona disponibilidad'
	      )      
    	),
    	'explab_sueldoa' => array(
	        'required'=>  array(
	         'rule' => 'notEmpty',
	         'required' => true,
	        'message'    => 'selecciona sueldo actual'
	      )      
    	),
    	'explab_sueldod' => array(
	        'required'=>  array(
	         'rule' => 'notEmpty',
	         'required' => true,
	        'message'    => 'selecciona sueldo deseado'
	      ),
	      'compare'=>  array(
	         'rule' => 'notEmpty',
	         'required' => true,
	         'arguments' => array("type"=>"number","element"=>".explab_sueldoa","compare"=>">=" ) ,
	        'message'    => 'el sueldo deseado debe ser mayor que el actual'
	      ) 
    	),
    	'explab_viajar' => array(
	        'required'=>  array(
	         'rule' => 'notEmpty',
	         'required' => true,
	        'message'    => 'selecciona si esta dispuesto a viajar o no'
	      )      
    	),
    	'explab_reu' => array(
	        'required'=>  array(
	         'rule' => 'notEmpty',
	         'required' => true,
	        'message'    => 'selecciona si esta dispuesto a reubicarse'
	      )      
    	)

	    );

	function all($candidato_cve){
		return $this->find('all', array(
        		'conditions' => array('ExpEcoCan.candidato_cve' => $candidato_cve),
        		"order" => array("explab_cve ASC")
        		));
		}


	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id,$table,$ds);		

    	 $this->field_extract_info= array(
                                        // "SueldoD.elsueldo_ini Sueldo__sueldo_d",
                                        // "SueldoA.elsueldo_ini Sueldo__sueldo_a",
                                        // "$this->alias.explab_viajar",
                                        // "$this->alias.explab_reu"

      );

	}


}
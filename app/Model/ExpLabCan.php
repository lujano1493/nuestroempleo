<?php


App::import('Model', 'ModelCan');

 class ExpLabCan extends ModelCan{
 	public $name="ExpLabCan";
 	public $useTable = 'texplabcandidato';
 	public $primaryKey = 'explab_cve';
 	public $msg_succes="Experiencia Laboral";
 	 
 	
  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);
    $this->virtualFields = array (  
      "explab_fecini" =>  "to_char($this->alias.explab_fecini,'DD/MM/YYYY')",  
      "explab_fecfin" =>  "to_char($this->alias.explab_fecfin,'DD/MM/YYYY')"  
    );  



    $this->field_extract_info= array(
                                        // "$this->alias.explab_puesto",
                                        // "Giros.giro_nom"

      );
        




  }



  public $belongsTo = array(
    
    'Giros'=> array(
      'className'    => 'Giros',
      'foreignKey'   => "giro_cve"
      )
    );
 	 
	public $validate = array(
		'explab_actual' => array(
        'required'=>  array(
         'rule' => 'notEmpty',
         'required' => true,
        'message'    => 'selecciona sí actualmente trabaja'
      )      
    ),
    'explab_empresa' => array(
        'required'=>  array(
         'rule' => 'notEmpty',
         'required' => true,
        'message'    => 'ingresa nombre de la empresa'
      )      
    ),
    'giro_cve' => array(
        'required'=>  array(
         'rule' => 'notEmpty',
         'required' => true,
        'message'    => 'selecciona un giro de la empresa'
      )   
    ),
    'explab_puesto' => array(
        'required'=>  array(
         'rule' => 'notEmpty',
         'required' => true,
        'message'    => 'ingresa un puesto'
      )   
    ),
	  'explab_funciones' => array(
	        'required'=>  array(
	         'rule' => 'notEmpty',
	         'required' => true,
	        'message'    => 'ingresa una descripción de funciones'
	      )  , 
            'maxlength' => array(
             'rule' => array("maxLength",1024),
             'required' => true,
            'message'    => 'longitud del campo excedido '
          )

	    )
    );

 	 function all($candidato_cve){		 
		return 	 $this->find("all",array(
											"conditions"=>array (
																	"ExpLabCan.candidato_cve"=>$candidato_cve
																),
											"order" => array ("ExpLabCan.explab_cve"=>"asc")

											));
		 
	}





	
	 function beforeSave($options = array()){
	 	if(empty($this->data[$this->alias]["explab_fecfin"])){	 		
	 		$this->data[$this->alias]["explab_fecfin"]=NULL;
	 	}
		return parent::beforeSave();

	}
 
 }
 
 
<?php

App::import('Model', 'ModelCan');
class CursoCan extends ModelCan {
	public $name='CursoCan';

  public $actsAs = array('Containable');
	public $useTable = 'tcursocandidato'; 
	public $primaryKey="curso_cve";	
  public $msg_succes="Curso";

  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);
    $this->virtualFields = array(  
      "curso_fecini"=> "to_char($this->alias.curso_fecini,'DD/MM/YYYY')",  
      "curso_fecfin"=> "to_char($this->alias.curso_fecfin,'DD/MM/YYYY')" 
    );  


      $this->field_extract_info= array(
                                        // "$this->alias.curso_nom"

      );
        



  }

public $validate = array(
		'cursotipo_cve' => array(
        'required'=>  array(
         'rule' => 'notEmpty',
         'required' => true,
        'message'    => 'selecciona tipo de curso'
      )      
    ),
    'curso_institucion' => array(
        'required'=>  array(
         'rule' => 'notEmpty',
         'required' => true,
        'message'    => 'ingresa nombre de la institución'
      )      
    ),
    'curso_nom' => array(
        'required'=>  array(
         'rule' => 'notEmpty',
         'required' => true,
        'message'    => 'ingresa el nombre del curso'
      )   
    ));


	

	

	public function beforeSave($options = array()){
	
		return parent::beforeSave();

	}

		
		
}
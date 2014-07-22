<?php 

App::import('Model', 'ModelCan');
class ConoaCan extends ModelCan {
	public $name='ConoaCan';
	public $useTable = 'tconoccan'; 
	public $primaryKey="conoc_cve";
    public $actsAs = array('Containable');
    public $msg_succes="Conocimientos adicionales";

public $validate = array(
		'conoc_descrip' => array(
        'required'=>  array(
         'rule' => 'notEmpty',
         'required' => true,
        'message'    => 'Ingresa una descripción'
      )      
    ));



  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);

    
    $this->field_extract_info= array(
                                        // "$this->alias.conoc_descrip"

      );
        

                
  }




}
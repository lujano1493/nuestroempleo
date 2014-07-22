<?php 
App::import('Model', 'ModelCan');
class AreaIntCan extends ModelCan {
	public $name='AreaIntCan';
	public $useTable = 'tareaintcandidato'; 
	public $primaryKey="areaint_cve";
	

  /**
    * Métodos de búsqueda personalizados.
    */
  public $virtualFields = array();


	public $belongsTo = array(
  	
  	'AreaInt'=> array(
  		'className'    => 'AreaInt',
  		'foreignKey'   => "area_cve"
  		)
  	);




  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);

    
    $this->field_extract_info= array(
                                        // "AreaInt.area_nom"

      );
        

                
  }


  

}
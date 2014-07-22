<?php 

App::import('Model', 'ModelCan');
class AreaExpCan extends ModelCan {
	public $name='AreaExpCan';
	public $useTable = 'tareasexplab'; 
	public $primaryKey="areaexpcan_cve";
	

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
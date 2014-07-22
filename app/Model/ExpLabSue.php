<?php

class ExpLabSue extends AppModel {
	public $name='ExpLabSue';
	public $useTable = 'texplabsueldos'; 
	public $primaryKey="elsueldo_cve";	
	public $displayField ="elsueldo_ini";
		
	public function lista(){
			return $this->find("list",array( "conditions" => array(
					"$this->alias.elsueldo_cve <>"=> 0 
				) ,"order"=>"elsueldo_cve"));
	}

}
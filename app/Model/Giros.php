<?php
 class Giros extends AppModel{
 	public $name="Giros";
 	public $useTable = 'tgiros';
 	 public $primaryKey = 'giro_cve';
 	 
	public $displayField ="giro_nom";

 	 function lista(){		 
			return 	 $this->find("list",array ("order"=>"giro_nom asc"));
		 
	}
	 
 
 
 }
 
 
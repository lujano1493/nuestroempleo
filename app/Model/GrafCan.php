<?php 
class GrafCan extends AppModel {
	public $actsAs = array('Containable');
	public $name='GrafCan';
	public $useTable = 'tgrafcandidato'; 
	public $primaryKey="grafcandidato_cve";
  

 public $belongsTo = array(    
    'TablaGrafCan'=> array(
      'className'    => 'TablaGrafCan',
      'foreignKey'   => "tabla_cve"
      ));
 	public function porcentaje($idUser){
 			$rs=$this->find("first",array(
						"fields"=> array(
									" sum(TablaGrafCan.tabla_porcentaje) {$this->alias}__porcentaje"
						),
						"conditions"=>array("$this->alias.candidato_cve" => $idUser)
				));
			return  !empty($rs) ? (int) $rs[$this->alias]['porcentaje'] :0;
	}




}


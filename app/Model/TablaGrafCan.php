<?php 

class TablaGrafCan extends AppModel {
public $actsAs = array('Containable');
	public $name='TablaGrafCan';
	public $useTable = 'ttablasgrafcandidato'; 
	public $primaryKey="tabla_cve";
  

	public function getTabla($name_table="" ){

			return $this->find("all");

	}


	public function getTablasFaltantes($candidato_cve=-1){
			$conditionsSubQuery = array('TablaGrafCan.tabla_cve =GrafCan.tabla_cve', 'GrafCan.candidato_cve' =>$candidato_cve ) ;
		$db = $this->getDataSource();
		$subQuery = $db->buildStatement(
		    array(
		        'fields'     => array('GrafCan.tabla_cve'),
		        'table'      => 'tgrafcandidato',
		        'alias'      => 'GrafCan',
		        'limit'      => null,
		        'offset'     => null,
		        'joins'      => array(),
		        'conditions' => $conditionsSubQuery,
		        'order'      => null,
		        'group'      => null
		    ),
		    $this
		);
		$subQuery = '  not exists (' . $subQuery . ') ';
		$subQueryExpression = $db->expression($subQuery);

		$conditions[] = $subQueryExpression;		


		return $this->find('all', compact('conditions'));



}





}


<?php

class EscCarEspe extends AppModel {
	public $name='EscCarEspe';
	public $useTable = 'tesccarespe'; 
	public $primaryKey="cespe_cve";
	public $displayField="cespe_nom";
	public $foreignKey="cgen_cve";

	public $belongsTo = array(
		'EscCarGene' => array(
				            'className'    => 'EscCarGene',
				            'foreignKey'   => 'cgen_cve'
							)
	);			


	

}
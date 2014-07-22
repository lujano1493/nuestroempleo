<?php

class EscCarGene extends AppModel {
	public $name='EscCarGene';
	public $useTable = 'tesccargene'; 
	public $primaryKey="cgen_cve";
	public $displayField="cgen_nom";
	public $foreignKey="carea_cve";

	public $belongsTo = array(
        	'EscCarArea' => array(
					            'className'    => 'EscCarArea',
					            'foreignKey'   => 'carea_cve'
								)
		);


}
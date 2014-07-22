<?php 


App::import('Model', 'ModelCan');
	class DirCandidato extends ModelCan {
    	public $name='DirCandidato';
		public $useTable = 'tdircandidato'; 
		public $primaryKey='candidato_cve';
		public $msg_succes="Dirección ";


   public $joins=array(
     'direccion' => array(     
      array(
        'alias' => 'CodigoPostal',
        'conditions' => array(
          'DirCandidato.cp_cve = CodigoPostal.cp_cve'
        ),
        'fields' => array(
                          'CodigoPostal.cp_cp', 
                          'CodigoPostal.est_cve',
                          'CodigoPostal.pais_cve',
                          'CodigoPostal.ciudad_cve',
                          'CodigoPostal.cp_asentamiento'

                          ),
        'table' => 'tcodigopostal',
        'type' => 'LEFT'
      ),
      array(
        'alias' => 'Ciudad',
        'conditions' => array(
          'Ciudad.ciudad_cve = CodigoPostal.ciudad_cve'
        ),
        'fields' => array('Ciudad.ciudad_nom'),
        'table' => 'tciudad',
        'type' => 'LEFT'
      ),
      array(
        'alias' => 'Estado',
        'conditions' => array(
          'Estado.est_cve = CodigoPostal.est_cve'
        ),
        'fields' => array('Estado.est_nom'),
        'table' => 'testado',
        'type' => 'LEFT'
      ),
      array(
        'alias' => 'Pais',
        'conditions' => array(
          'Pais.pais_cve = CodigoPostal.pais_cve'
        ),
        'fields' => array('Pais.pais_nom'),
        'table' => 'tpais',
        'type' => 'LEFT'
      )
    )

    );

		 public $findMethods = array(
			'direccion' => true
		);

		protected function _findDireccion($state, $query, $results = array()) {
		    if ($state == 'before') {
		      $query['contain'] = array( );
		      $query['joins']= $this->joins['direccion'];
		      $query['conditions']=array(
		                                      "$this->alias.candidato_cve" => $query['idUser']
		          );
		      return $query;
		    }
		    return  (empty($results)) ? $results :$results[0]   ;
		  }

		public $belongsTo = array(
		'CodigoPostal' => array(
            'className'    => 'CodigoPostal',
            'foreignKey'   => "cp_cve"
        ));
	
		function getDireccion_actual($candidato_cve){
			 return $this->find('first', array ('conditions'=> array ($this->name.'.candidato_cve'=>$candidato_cve)));
		}
		
		public $validate = array(
		    'cp_cve' => array(
		        'required'=>  array(
		         'rule' => 'notEmpty',
		         'required' => true,
		        'message'    => 'Ingresa un Código Postal'
		      )      
		         

		    ));



		
}


?>
<?php 

	class Estado extends AppModel {
    	public $name='Estado';
		public $useTable = 'testado'; 
		public $primaryKey= 'est_cve';
		public $displayField = "est_nom";

		 public $belongsTo = array(
        	'Pais' => array(
	            'className'    => 'Pais',
	            'foreignKey'   => 'pais_cve')
        	);
	

		   public function getlistaEstado($pais_cve=null, $est_cve=null){

		    $options=array(
		      'conditions' => array(   
		      ),
		      'order' => array(
		        'Estado.est_nom' => 'ASC'
		      )
		    );
		    if($pais_cve){
		        $options['conditions'][ 'Estado.pais_cve'] =$pais_cve;

		    }
		    if($est_cve){
		       $options['conditions']['Estado.est_cve']=$est_cve;

		    }

		    $estado = $this->find('list', $options );

    		return $estado;
		}




		
		function getEstadosList($pais_cve){
			return $this->find('list', array( 'conditions' => array('Estado.pais_cve' => $pais_cve),'fields' => array('Estado.est_cve', 'Estado.est_nom')));
		}

}

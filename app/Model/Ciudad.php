<?php 

class Ciudad extends AppModel {
 	public $name='Ciudad';
	public $useTable = 'tciudad'; 
	public $displayField = "ciudad_nom";
	public $primaryKey="ciudad_cve";

	public $belongsTo = array(
		'Estado' => array(
      'className'    => 'Estado',
      'foreignKey'   => 'est_cve'
  ));



  public function getlistaCiudad($pais_cve=null, $est_cve=null){

    $options=array(
      'conditions' => array(   
      ),
      'order' => array(
        'Ciudad.ciudad_nom' => 'ASC'
      )
    );
    if($pais_cve){
        $options['conditions'][ 'Ciudad.pais_cve'] =$pais_cve;

    }
    if($est_cve){
       $options['conditions']['Ciudad.est_cve']=$est_cve;

    }

    $ciudades = $this->find('list', $options );

    return $ciudades;


  }


  public	function getCiudadesList($pais_cve=null, $est_cve=null){

    $options=array(
      'conditions' => array(   
      ),
      'fields' => array(
        'Ciudad.ciudad_cve as id', 'Ciudad.ciudad_nom as name'
      ),
      'order' => array(
        'Ciudad.ciudad_nom' => 'ASC'
      )
    );
    if($pais_cve){
        $options['conditions'][ 'Ciudad.pais_cve'] =$pais_cve;

    }
    if($est_cve){
       $options['conditions']['Ciudad.est_cve']=$est_cve;

    }

		$ciudades = $this->find('all', $options );

    return Hash::extract($ciudades, '{n}.Ciudad');
	}

  public function getEstado($ciudadId) {
    return $this->find('first', array(
      'conditions' => array(
        'ciudad_cve' => $ciudadId
      ),
      'recursive' => 0
    ));
  }
}

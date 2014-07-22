<?php

class CodigoPostal extends AppModel {
  public $name = 'CodigoPostal';
  public $useTable = 'tcodigopostal';
  public $primaryKey = 'cp_cve';

 public $belongsTo = array(
        	'Ciudad' => array(
	            'className'    => 'Ciudad',
	            'foreignKey'   => 'ciudad_cve'),
        	'Estado' => array(
	            'className'    => 'Estado',
	            'foreignKey'   => 'est_cve'),
        	'Pais' => array(
	            'className'    => 'Pais',
	            'foreignKey'   => 'pais_cve')
        	);

public $validate = array(
    'cp_asentamiento' => array(
        'required'=>  array(
         'rule' => 'notEmpty',
         'required' => true,
        'message'    => 'Selecciona tu colonia, si no se encuentra elige la más cercana a tu domicilio.'
      )
    ));



	function getCodigoPostal_($cp_cp){

		$options=array ();

		$options['conditions']=array('CodigoPostal.cp_cp' => $cp_cp);
		$codigoPostal = $this->find('all',$options);
		return $codigoPostal;

	}

	function getListAsentamientos($cp_cp){

		$options=array ();
		$options['conditions']=array('CodigoPostal.cp_cp' => $cp_cp);
		$options['fields']=array ("CodigoPostal.cp_cve","CodigoPostal.cp_asentamiento");
		$codigoPostal = $this->find('list',$options);


		return $codigoPostal;

	}

  /**
    * Obtiene la información acerca del codigo postal.
    * @param $cp_cp Integer
    * @param $isKey Boolean
    * @return Mixed
    */
  public function getCP($cp_cp, $isKey = false) {
    $conditions = $isKey ?
      array($this->alias . '.cp_cve = ' . $cp_cp) :  // Obtiene la colonia en base a la clave del CP.
      array($this->alias . '.cp_cp = ' . $cp_cp);    // Obtiene las colonias en base al CP.

    $options = array(
      'fields' => array(
        'Pais.pais_nom pais',
        'Estado.est_nom estado',
        'Ciudad.ciudad_nom ciudad',
        $this->alias . '.cp_cve id',
        $this->alias . '.cp_cp cp',
        $this->alias . '.cp_asentamiento colonia'
      ),
      'conditions' => $conditions,
      'order' => array(
        $this->alias . '.cp_asentamiento ASC'
      )
    );

    $codigoPostal = $this->find('all', $options);
    $results = array();

    if (!empty($codigoPostal)) {
      $results = array(
        'cp' => '',
        'pais' => '',
        'estado' => '',
        'municipio' => '',
        'colonias' => array()
      );

      foreach ($codigoPostal as $key => $value) {
        $results['cp'] = $value[$this->alias]['cp'];
        $results['pais'] = $value['Pais']['pais'];
        $results['estado'] = $value['Estado']['estado'];
        $results['municipio'] = $value['Ciudad']['ciudad'];

        $colonia = array(
          'id' => $value[$this->alias]['id'],
          'nombre' => $value[$this->alias]['colonia']
        );

        array_push($results['colonias'], $colonia);
      }
    }
    return $results;
  }


}

?>
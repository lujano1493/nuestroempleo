<?php

class UsuarioEmpresaContacto extends AppModel {
	public $name='UsuarioEmpresaContacto';
	
	/**
    * Nombre de la llave primaria, en este caso es cia_cve, tabla tcompania.
    */
  public $primaryKey = 'cu_cve';

  /**
  	* Nombre de la tabla.
  	*/
	public $useTable = 'tcontacto';

	public $belongsTo = array(
		'UsuarioEmpresa' => array(
			'className' => 'UsuarioEmpresa',
			'foreignKey' => 'cu_cve'
		)
	);

	/**
   * Condiciones que validarán la información de contacto.
   * @var array 
   */
  public function getDatos($id, $onlyData) {
    $results = $this->find('first', array(
      'recursive' => -1,
      'conditions' => array(
        $this->alias . '.cu_cve =' . $id
      )
    ));

    return $onlyData ? $results[$this->alias] : $results;
  }
}
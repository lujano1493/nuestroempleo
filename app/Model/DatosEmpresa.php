<?php
class DatosEmpresa extends AppModel {

  public $actsAs = array('Containable');

  public $name ='DatosEmpresa';

	public $useTable = 'tdatoscompania';

	public $primaryKey ='datos_cve';

	public $belongsTo = array(
		'Empresa' => array(
			'className' => 'Empresa',
			'foreignKey' => 'cia_cve'
		),
    'Direccion' => array(
      'className' => 'CodigoPostal',
      'foreignKey' => 'cp_cve'
    )
	);

	/**
   * Condiciones que validarán la información de contacto.
   * @var array
   */
  /*public $validate = array(
    'cp_cve' => array(
      'uniqueRFC' => array(
        'rule' => 'numeric',
        'required' => true,
        'message' => 'Por favor, ingresa la clave CP númerica.'
      )
    ),
    'dircia_callenum' => array(
      'validateCalleNum' => array(
        'rule' => 'notEmpty',
        'required' => true,
        'message' => 'Este campo es requerido.'
      ),
      'maxLength' => array(
        'rule' => array('maxLength', 80),
        'message' => 'Este campo debe tener máximo 80 caracters.'
      )
    )
  );*/

  public function getDir($ciaId, $tipoDir = 0) {
    $datosEmpresa = $this->find('first', array(
      'conditions' => array(
        $this->alias . '.cia_cve' => $ciaId,
        $this->alias . '.tipodom_cve' => $tipoDir
      ),
      'recursive' => -1
    ));
    $direccion = $this->Direccion->getCP($datosEmpresa['DatosEmpresa']['cp_cve'], true);
    $datosEmpresa['Direccion'] = $direccion;

    return $datosEmpresa;
  }

  public function getStrDir($ciaId, $tipoDir = 0) {
    $dir = $this->getDir($ciaId, $tipoDir);

    $calle = $dir['DatosEmpresa']['calle'] . ' ' . $dir['DatosEmpresa']['num_ext'];
    $colonia = $dir['Direccion']['colonias'][0]['nombre'];
    $municipio = $dir['Direccion']['municipio'];
    $estado = $dir['Direccion']['estado'];
    $pais = $dir['Direccion']['pais'];
    $cp = $dir['Direccion']['cp'];

    return implode(', ', array(
      $calle, $colonia, $municipio, $estado, $pais, $cp
    ));
  }

  public function beforeSave($options = array()) {
    return parent::beforeSave($options);
  }

}
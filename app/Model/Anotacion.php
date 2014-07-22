<?php

App::uses('AppModel', 'Model');

class Anotacion extends AppModel {
  
  /**
   * Utiliza el comportamiento: Containable
   * @var array
   */
  public $actsAs = array('Containable');

  /**
   * tabla
   * @var string
   */
  public $useTable = 'tanotaciones';

  /**
   * Llave primaria
   * @var string
   */
  public $primaryKey = 'anotacion_cve';

  public $belongsTo = array(
    'UsuarioEmpresa' => array(
      'foreignKey' => 'cu_cve'
    )
  );

  /**
   * Validaciones.
   * @var array
   */
  public $validate = array(
    'anotacion_detalles' => array(
      'required' => array(
        'rule' => 'notEmpty',
        'required' => true,
        'message' => 'Ingresa los detalles.'
      ),
      'maxlength' => array(
        'rule' => array('maxLength', 4000),
        'message' => 'El máximo de caracteres es 4000.'
      )
    ),
  );
}
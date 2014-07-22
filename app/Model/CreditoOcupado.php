<?php 

App::uses('AppModel', 'Model');

/**
 * Modelo para llevar un historial de los créditos gastados.
 */
class CreditoOcupado extends AppModel {

  public $actsAs = array('Containable');
  /**
   * Nombre del modelo.
   * @var string
   */
  public $name = 'CreditoOcupado';

  /**
   * Llave primaria.
   * @var string
   */
  public $primaryKey = 'credxusu_cve';
  
  /**
   * Se usará la siguiente tabla.
   * @var string
   */
  public $useTable = 'tcreditos_ocupados';

  /**
   * Relación pertenece a.
   * @var array
   */
  public $belongsTo = array(
    'UsuarioEmpresa' => array(
      'className' => 'UsuarioEmpresa',
      'foreignKey' => 'cu_cve',
    ),
    'Servicio' => array(
      'className' => 'Servicio',
      'foreignKey' => 'servicio_cve'
    )
  );

  public function logCredit($user, $type, $productId) {
    $this->create();

    $credito = array(
      'servicio_cve' => $type,
      'credito_cve' => $productId,
      'cia_cve' => $user['Empresa']['cia_cve'],
      'cu_cve' => $user['cu_cve']
    );

    return $this->save($credito);
  }
}
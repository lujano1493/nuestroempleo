<?php

App::uses('AppModel', 'Model');

class Reporte extends AppModel {
  /**
   * tabla
   * @var string
   */
  public $useTable = false;

  public $knows = array(
    'UsuarioEmpresa'
  );

  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);

    $this->ds = $this->getDataSource();
    $this->UserAlias=$this->alias;
  }

  /**
   * Genera un subquery para encontrar a los usuarios dependientes.
   * @param  [type] $userId [description]
   * @return [type]         [description]
   */
  protected function users($userId) {
    $ds = $this->ds;
    $subQuery = $ds->buildStatement(
      array(
        'fields'     => array('UsuarioEmpresa.cu_cve'),
        'table'      => $ds->fullTableName($this->UsuarioEmpresa),
        'alias'      => 'UsuarioEmpresa',
        'limit'      => null,
        'offset'     => null,
        'joins'      => array(),
        'conditions' => null,
        'order'      => null,
        'group'      => null,
        'connect'    => array(
          'by' => 'PRIOR UsuarioEmpresa.cu_cve = UsuarioEmpresa.cu_cvesup',
          'start with' => 'UsuarioEmpresa.cu_cve = ' . $userId
        )
      ),
      $this->UsuarioEmpresa
    );

    $subQuery = $this->UserAlias . '.cu_cve IN (' . $subQuery . ') ';
    return $ds->expression($subQuery);
  }

  protected function conditions ($query, $anotherConditions = array()) {
    $conditions = array();

    /**
     * Si se pasa el parámetro cia_cve, agregará a las condiciones
     */
    if (!empty($query['cia_cve'])) {
      $conditions[$this->alias . '.cia_cve'] = $query['cia_cve'];
    }

    /**
     * Si se pasa el parámetro cu_cve, agregarán los dependientes a las condiciones.
     */
    if (!empty($query['cu_cve'])) {
      $conditions[] = $this->users($query['cu_cve']);
    }

    /**
     * Agregará a las condiciones las fechas de inicio y fin.
     */
    if (!empty($query['dates'])) {
      $conditions += $this->settingDates($query['dates']);
    }

    return $conditions + $anotherConditions;
  }
}
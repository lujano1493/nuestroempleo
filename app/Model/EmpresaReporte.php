<?php

App::uses('Reporte', 'Model');

class EmpresaReporte extends Reporte {
  /**
   *
   */
  public $actsAs = array('Containable');

  /**
   * [$name description]
   * @var string
   */
  public $name = 'EmpresaReporte';

  /**
   * [$primaryKey description]
   * @var string
   */
  public $primaryKey = 'cia_cve';

  /**
   * [$useTable description]
   * @var string
   */
  public $useTable = 'tcompania';

  public $type = array(
    'comercial' => 0,
    'convenio' => 1
  );

  /**
    * Métodos de búsqueda personalizados.
    */
  public $findMethods = array(
    'tipo' => true,
    'zona' => true,
    'giro' => true,
    'por_cuenta' => true

  );
    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->UserAlias="Cuenta";
    }


    protected function settingDates($dates) {
    $conditions = array();

    if (!empty($dates)) {
      $conditions[$this->alias.'.created >='] = date('Y-m-d H:i:s', $dates['ini']);
      $conditions[$this->alias.'.created <='] = date('Y-m-d H:i:s', $dates['end']);
    }

    return $conditions;
  }



    protected function _findZona($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['fields'] = array(
        "Ciudad.ciudad_nom {$this->alias}__ciudad",
        "Estado.est_nom {$this->alias}__estado",
        "COUNT(*) {$this->alias}__empresas"
      );
      $query['conditions'] = $this->conditions($query,array());
      $query['joins'] = array(
        array(
            'alias' => 'DirCia',
            'table' =>'tdatoscompania',
            'conditions' => array(
              "$this->alias.cia_cve=DirCia.cia_cve",
              "DirCia.tipodom_cve=0"
            ),
            'type' => 'INNER'
          ),
        array(
              'alias' => "Cp",
              'table'=> 'tcodigopostal',
              'conditions'=> array(
                "DirCia.cp_cve=Cp.cp_cve"
              ),
              'type' => 'INNER'
          ),
        array(
          'alias' => 'Ciudad',
          'conditions' => array(
            'Cp.ciudad_cve = Ciudad.ciudad_cve',
          ),
          'fields' => array(            
          ),
          'table' => 'tciudad',
          'type' => 'INNER',
        ),
        array(
          'alias' => 'Estado',
          'conditions' => array(
            'Ciudad.est_cve = Estado.est_cve'
          ),
          'fields' => array(       
          ),
          'table' => 'testado',
          'type' => 'INNER',
        )
      );
      $query['group'] = array(
        'Ciudad.ciudad_nom',
        'Estado.est_nom'
      );
       $query['order'] = array(
        'Estado.est_nom' => 'ASC',
        'Ciudad.ciudad_nom' => 'ASC'
      );

      $query['recursive'] = -1;
      return $query;
    }

    return $results;
  }

    protected function _findGiro($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['fields'] = array(
        "Giro.giro_nom {$this->alias}__giro",
        "COUNT(*) {$this->alias}__empresas"
      );
      $query['conditions'] = $this->conditions($query,array());
      $query['joins'] = array(
        array(
            'alias' => 'Giro',
            'table' =>'tgiros',
            'conditions' => array(
              "$this->alias.giro_cve=Giro.giro_cve"
            ),
            'type' => 'INNER'
          )
      );
      $query['group'] = array(
        'Giro.giro_nom'
      );
       $query['order'] = array(
        'Giro.giro_nom' => 'ASC'
      );

      $query['recursive'] = -1;
      return $query;
    }
    return $results;
  }

  protected function _findTipo($state, $query, $results = array()) { 
    if ($state === 'before') {
      $query['fields'] = array(
        "DECODE({$this->alias}.cia_tipo,0,'Comercial','Convenio') {$this->alias}__tipo",
        "COUNT(*) {$this->alias}__empresas"
      );
      $query['group'] = array(
        "DECODE({$this->alias}.cia_tipo,0,'Comercial','Convenio')"
      );
      $query['order'] = array(
        "{$this->alias}__tipo" => 'ASC'
      );
      $query['conditions'] = $this->conditions($query,array());
      return $query;
    } 
    return $results;
  }

  protected function _findPor_cuenta($state, $query, $results = array()) { 
    if ($state === 'before') {    
      $query['fields'] =array(
            "CuentaSup.cu_sesion {$this->alias}__correo",
            " COUNT(CASE WHEN {$this->alias}.cia_tipo = 1 THEN 1 END) {$this->alias}__comercial",
            " COUNT(CASE WHEN {$this->alias}.cia_tipo = 0 THEN 1 END) {$this->alias}__convenio",
            " COUNT ({$this->alias}.cia_cve)  {$this->alias}__total"
          );
      $query['joins']=array(
      array(
          'alias' => 'Cuenta',
          'table'=> 'tcuentausuario',
          'type' => 'INNER',
          'fields' => array(),
          'conditions' => array(
              "$this->alias.cu_cve=Cuenta.cu_cve"
            )              
        ),
      array(
        'alias' => 'CuentaSup',
        'table' => 'tcuentausuario',
        'type' => 'INNER',
        'fields' =>array(),
        'conditions' => array(
            'Cuenta.cu_cvesup=CuentaSup.cu_cve',
            'CuentaSup.per_cve' => array(1,2,3)
        )
      )
      );
      $query['group']=array(
        "CuentaSup.cu_sesion "
      );
      $query['conditions'] = $this->conditions($query,array());
      return $query;

    }
    return $results;
  }

}
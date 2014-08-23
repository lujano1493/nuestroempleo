<?php

App::uses('Reporte', 'Model');

class ProductoReporte extends Reporte {
  /**
   * tabla
   * @var string
   */
    public $useTable = 'tperfilxmembresia';

    public $actsAs = array('Containable');

    public $primaryKey = 'perfilxmembresia_cve';

   public $findMethods = array(
    'productos_adquiridos' => true,
    'productos_adquiridos_cuenta'=>true,
    'productos_usuario'=>true
    );
  public $type=null;
  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);
    $this->UserAlias="Cuenta";

    $this->joins=array(
        'membresia'=>  array(
            'alias' => 'Membresia',
            'conditions' => array(
              'Membresia.membresia_cve = ProductoReporte.membresia_cve',
              'Membresia.membresia_status' => 1
            ),
            'fields' => array(
            ),
            'table' => 'tmembresias',
            'type' => 'INNER',
          ),
        'cia' =>  array(
            'table' => 'tcompania',
            'type'=> 'INNER',
            'alias' => 'Cia',
            'conditions'=> array(
              "$this->alias.cia_cve=Cia.cia_cve"
            ),
            'fields'=> array()
        ),
        'cuenta' => array(
            'table' => 'tcuentausuario',
            'alias' => 'Cuenta',
            'conditions' => array(
                "Cuenta.cu_cve=Cia.cu_cve"
              ),
            'fields' =>array(),
            'type' => 'INNER'
          )

      );

    $this->joins_cuenta=array(
        'superior'=> array(
                'table'=> 'tcuentausuario',
                'alias' => 'CuentaSup',
                'conditions' => array(
                'CuentaSup.cu_cve=Cuenta.cu_cvesup'
                 ),
                'fields' =>array()
              ),
        'pefil' =>  array(
                'table'=> 'tperfil',
                'alias' => 'Perfil',
                'conditions' => array(
                  'Perfil.per_cve=CuentaSup.per_cve',
                  'Perfil.per_cve' => array(1,2,3)
                ),
              'fields' =>array()
            ),
          'contacto'=> array(
                'table' => 'tcontacto',
                'alias' => 'Contacto',
                'type' => 'INNER',
                'conditions' => array(
                    'Contacto.cu_cve=CuentaSup.cu_cve'
                  ),
                'fields' => array()
                )

      );


    $this->fields=array(
      "total" =>array(        
        'Membresia.membresia_cve ProductoReporte__id',
        'Membresia.membresia_nom ProductoReporte__membresia',
        'DECODE(Membresia.membresia_tipo,\'P\',\'Promoción\',\'\') ProductoReporte__tipo',
        'COUNT(Membresia.membresia_cve) ProductoReporte__total',
        'SUM(Membresia.costo) ProductoReporte__precio'
        ),
      "cuenta" =>  array(
          "CuentaSup.cu_cve  {$this->alias}__id",       
          "CuentaSup.cu_sesion  {$this->alias}__cuenta",
          "Contacto.con_nombre || ' '|| Contacto.con_paterno || ' '|| Contacto.con_materno {$this->alias}__nombre",
          'SUM(Membresia.costo) ProductoReporte__precio',
          "count( Membresia.membresia_cve ) {$this->alias}__total"
        )
      );

    $this->groups=array(
      "total" => array(
        'Membresia.membresia_cve',
        'Membresia.membresia_nom',
        'DECODE(Membresia.membresia_tipo,\'P\',\'Promoción\',\'\')'
      ),
      'cuenta' =>array(
          "CuentaSup.cu_cve ",
          "CuentaSup.cu_sesion",
          "Contacto.con_nombre || ' '|| Contacto.con_paterno || ' '|| Contacto.con_materno"   
        )
    );
  }

  protected function settingDates($dates) {
    $conditions = array();
    if (!empty($dates)) {
      $conditions[$this->alias.'.fec_ini >='] =  date('Y-m-d H:i:s', $dates['ini']);
      $conditions[$this->alias.'.fec_ini <='] = date('Y-m-d H:i:s', $dates['end']);
    }
    return $conditions;
  }

  private function conditions_($query=array()){

    $otherconditions=array();
       if(isset($query['tipo']) ){
          if($query['tipo'] ==='c'  || $query['tipo']==='n'  ){
            $otherconditions["Cia.cia_tipo"]= $query['tipo']==='c' ? 1 :0 ;  
          }
        } 
        if(isset($query['usuario'])){
        $otherconditions["CuentaSup.cu_cve"]= $query['usuario'];
        }     
      return $otherconditions;
  }

  public $joins=array();
  public $joins_cuenta=array();
  protected function _findProductos_adquiridos($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['fields'] = $this->fields['total'];
      $query['joins'] = array_values($this->joins);    
      $query['conditions']=$this->conditions($query,$this->conditions_($query)); 
      $query['group'] = $this->groups['total'];
      $query['order'] = array(
        'ProductoReporte__id' => 'ASC',
      );
      $query['recursive'] = -1;
      return $query;
    }

    return $results;
  }
    protected function _findProductos_adquiridos_cuenta($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['fields'] =  $this->fields['cuenta'];
      $query['joins'] =  array_merge(array_values($this->joins),array_values($this->joins_cuenta)) ;    
      $query['conditions']=$this->conditions($query,$this->conditions_($query)); 
      $query['group'] = $this->groups['cuenta'];
      $query['order'] = array(
        'CuentaSup.cu_sesion' => 'ASC',
      );
      $query['recursive'] = -1;
      return $query;
    }
    return $results;
  }
    protected function _findProductos_usuario($state, $query, $results = array()) {
      if ($state === 'before') {
        $query['fields'] =  $this->fields['total'];
        $query['joins'] = array_merge(array_values($this->joins),array_values($this->joins_cuenta)) ;    
        $query['conditions']=$this->conditions($query,$this->conditions_($query)); 
        $query['group'] = $this->groups['total'];
        $query['order'] = array(
          'Membresia.membresia_nom' => 'ASC',
        );
        $query['recursive'] = -1;
        return $query;
      }
    return $results;
  }

  public function getDataUser($usuario){
    return ClassRegistry::init("UsuarioAdmin")->find("data",array(
      "conditions" =>array(
        "UsuarioAdmin.cu_cve" => $usuario,    
        ),
      "contain" =>false,
      "recursive" =>-1,
      "fields" => array("cu_sesion")
      )
    )[0]['UsuarioAdmin']['cu_sesion'];
  }


}
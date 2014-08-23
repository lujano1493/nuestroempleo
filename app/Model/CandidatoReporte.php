<?php

App::uses('Reporte', 'Model');

class CandidatoReporte extends Reporte {

	  /**
   * tabla
   * @var string
   */
  public $useTable = 'tcuentacandidato';

  /**
   * utiliza comportamiento Containable
   * @var array
   */
  public $actsAs = array('Containable');

    public $belongsTo= array(
      'Candidato'=> array(
      'className'    => 'Candidato',
     'foreignKey'   => "candidato_cve"
      )
     );




    public $findMethods = array(
    'candidatos' => true,
    'genero'=> true,
    'edad' => true,
    'estado' => true
    );


    public $joins=array();

  protected function settingDates($dates) {
    $conditions = array();

    if (!empty($dates)) {
      $conditions[$this->alias.'.created >='] = date('Y-m-d H:i:s', $dates['ini']);
      $conditions[$this->alias.'.created <='] = date('Y-m-d H:i:s', $dates['end']);
    }

    return $conditions;
  }



    private function completo(){
	    $ds = $this->ds;
	    $grafcan=ClassRegistry::init('GrafCan');
	    $subQuery = $ds->buildStatement(
	      array(
	        'fields'     => array('GrafCan.candidato_cve'),
	        'table'      => $ds->fullTableName($grafcan),
	        'alias'      => 'GrafCan',
	        'limit'      => null,
	        'offset'     => null,
	        'joins'      => array(
	        	array(
	        		'table' => 'ttablasgrafcandidato',
	        		'type' => 'INNER',
	        		'alias' => 'Tabla',
	        		'conditions' => array(
	        			'Tabla.tabla_cve=GrafCan.tabla_cve'
	        		)
	        		)
	        ),
	        'conditions' => null,
	        'order'      => null,
	        'group'      => array(
	        	'GrafCan.candidato_cve having sum(Tabla.tabla_porcentaje) >=100'
	        ),
	        
	      ),
	      $this->GrafCan
	    );

	    $subQuery = $this->alias . '.candidato_cve IN (' . $subQuery . ') ';
    	return $ds->expression($subQuery);
 
    }


    protected function conditions ($query, $anotherConditions = array()){
    	$anotherConditions=array();
    	if(!empty($query['activos']) ){
    		$anotherConditions["$this->alias.cc_status"]= 1;

    	}

    	if(!empty($query['sin_activar']) ){
    		$anotherConditions["$this->alias.cc_status"]= -1;

    	}

    	if(!empty($query['inactivos']) ){
    		$anotherConditions["$this->alias.cc_status"]= 0;

    	}

    	if(!empty($query['perfil']) || !empty($query['completo'])  ){
    		$anotherConditions["$this->alias.cc_status"]= 1;
    		$anotherConditions["$this->alias.cc_completo"]= "S";
    	}

    	if(!empty($query['completo'])){
    		$anotherConditions[]=$this->completo();
    	}

    	return parent::conditions($query,$anotherConditions);

    }


      protected function _findCandidatos($state, $query, $results = array()) {
    if ($state === 'before') {    
      $query['fields'] = array(      
        'COUNT(*) CandidatoReporte__candidatos',
        "to_char(trunc($this->alias.created),'MM') CandidatoReporte__mes",
        "to_char(trunc($this->alias.created),'YYYY') CandidatoReporte__anio",
      );

      $query['conditions'] = $this->conditions($query);    



      $query['group'] = array(
        "to_char(trunc($this->alias.created),'MM')",
        "to_char(trunc($this->alias.created),'YYYY')"
      );

      $query['order'] = array(
        'CandidatoReporte__mes' => 'ASC',
        'CandidatoReporte__anio' => 'DESC'
      );

      $query['recursive'] = -1;
      return $query;
    }

    return $results;
  }

   protected function _findGenero($state, $query, $results = array()) {
    if ($state === 'before') {    
      $query['fields'] = array(
        "Catalogo.opcion_texto {$this->alias}__genero",
        "COUNT(*) {$this->alias}__totales"
      );
      $query['conditions'] = $this->conditions($query);
      $query['conditions']['CandidatoReporte.cc_status'] = 1;
      $query['conditions']['CandidatoReporte.cc_completo'] = 'S';  
      $query['joins'] = array(       
        $this->joins['candidato'],
        array(
          'alias' => 'Catalogo',
          'conditions' => array(
            'Candidato.candidato_sex = Catalogo.opcion_valor',
            'Catalogo.ref_opcgpo' => 'GENERO'
          ),
          'table' => 'tcatalogo',
          'type' => 'INNER',
        )        
      );

      $query['group'] = array(
        'Catalogo.opcion_texto'
      );
      $query['recursive'] = -1;
      return $query;
    }

    return $results;
  }

  protected function _findEstado($state,$query,$results=array()){
     if ($state === 'before') {    
      $query['conditions'] = $this->conditions($query);
      $query['conditions']['CandidatoReporte.cc_status'] = 1;
      $query['conditions']['CandidatoReporte.cc_completo'] = 'S';  
      $joins=array();
      $joins=ClassRegistry::init("Candidato")->joins['direccion'];      
      $joins=array_merge(array($this->joins['candidato'] ),$joins);            
      foreach ($joins as $key => $value) {
        $joins[$key]['fields']=array();
      }
      $query['joins'] =$joins;
      $query['group'] = array(
        'Ciudad.ciudad_nom',
        'Estado.est_nom'
      );

       $query['order'] = array(
        'Estado.est_nom' => 'ASC',
        'Ciudad.ciudad_nom' => 'ASC'
      );
      $query['fields'] = array(
        "Estado.est_nom {$this->alias}__estado",
        "Ciudad.ciudad_nom {$this->alias}__ciudad",
        "COUNT(*) {$this->alias}__candidatos",
      );
      $query['recursive'] = -1;

      return $query;
     }
     return $results;
  }

    protected function _findEdad($state, $query, $results = array()) {
    if ($state === 'before') {
      $__caseQuery = 'CASE
        WHEN trunc((SYSDATE-Candidato.candidato_fecnac)/365) <= 17 THEN \'Menos de 18 años\'
        WHEN trunc((SYSDATE-Candidato.candidato_fecnac)/365) <= 25 THEN \'De 18 a 25 años\'
        WHEN trunc((SYSDATE-Candidato.candidato_fecnac)/365) <= 30 THEN \'De 26 a 30 años\'
        WHEN trunc((SYSDATE-Candidato.candidato_fecnac)/365) <= 40 THEN \'De 31 a 40 años\'
        ELSE \'Más de 41 años\'
      END';

      $query['fields'] = array(
        $__caseQuery. ' CandidatoReporte__edades',
        'COUNT(*) CandidatoReporte__total'
      );

      $query['conditions'] = $this->conditions($query);
      $query['conditions']['CandidatoReporte.cc_status'] = 1;
      $query['conditions']['CandidatoReporte.cc_completo'] = 'S';  
      $query['joins'] = array(
        array(
          'alias' => 'Candidato',
          'conditions' => array(
            $this->alias.'.candidato_cve = Candidato.candidato_cve',
          ),
          'table' => 'tcandidato',
          'type' => 'INNER',
        ),
      );

      $query['group'] = array(
        $__caseQuery,
      );
      $query['order'] = array(
        'CandidatoReporte__edades' => 'ASC'
      );
      $query['recursive'] = -1;
      return $query;
    }

    return $results;
  }

    public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);
    $this->joins=array(
      'candidato' =>array(
          'alias' => 'Candidato',
          'conditions' => array(
            $this->alias.'.candidato_cve = Candidato.candidato_cve',
          ),
          'table' => 'tcandidato',
          'type' => 'INNER',
        )
    );

  }





}
<?php

App::uses('Reporte', 'Model');

class PostulacionReporte extends Reporte {
  /**
   * tabla
   * @var string
   */
  public $useTable = 'tpostulacionxoferta';

  public $findMethods = array(
    'total' => true,
    'por_genero' => true,
    'por_edad' => true,
    'por_escolaridad' => true,
    'por_cia' =>true
  );

  protected function settingDates($dates) {
    $conditions = array();

    if (!empty($dates)) {
      $conditions['PostulacionReporte.created >='] = date('Y-m-d H:i:s', $dates['ini']);
      $conditions['PostulacionReporte.created <='] = date('Y-m-d H:i:s', $dates['end']);
    }

    return $conditions;
  }

  protected function _findTotal($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['fields'] = array(
        'COUNT(*) PostulacionReporte__total',
        'to_char(trunc(created),\'MM\') PostulacionReporte__mes',
        'to_char(trunc(created),\'YYYY\') PostulacionReporte__anio'
      );

      $query['conditions'] = $this->conditions($query);

      $query['group'] = array(
        'to_char(trunc(created),\'MM\')',
        'to_char(trunc(created),\'YYYY\')'
      );
      if(!empty($query['cia_cve']) ){
        $query['fields'][]='cia_cve PostulacionReporte__ciaId';
        $query['group'][]= 'cia_cve';
      }
      $query['order'] = array(
        'PostulacionReporte__mes' => 'ASC',
        'PostulacionReporte__anio' => 'DESC'
      );

      $query['recursive'] = -1;
      return $query;
    }

    return $results;
  }


  protected function _findPor_cia($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['fields'] = array(      
        'COUNT(*) PostulacionReporte__total',
        'Cia.cia_nombre   PostulacionReporte__compania', 
        'Cia.cia_cve      PostulacionReporte__cia_cve'     
      );
      $query['conditions'] = $this->conditions($query);
      $query['joins']=array(
         array(
           'table' => 'tcompania',
          'alias' => 'Cia',
          'type' => 'INNER',
          'fields' =>array(),
          'conditions'=>array(
              "$this->alias.cia_cve=Cia.cia_cve"
            )
        )
        );
      $query['group'] = array(
        "Cia.cia_cve",
        "Cia.cia_nombre"
      );

      $query['order'] = array(
        'PostulacionReporte__compania' =>  "ASC"
      );

      $query['recursive'] = -1;
      return $query;
    }

    return $results;
  }


  protected function _findPor_genero($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['fields'] = array(       
        'COUNT(*) PostulacionReporte__total'
      );

      $query['conditions'] = $this->conditions($query);

      $query['joins'] = array(
        array(
          'alias' => 'Candidato',
          'conditions' => array(
            'PostulacionReporte.candidato_cve = Candidato.candidato_cve',
          ),
          'table' => 'tcandidato',
          'type' => 'INNER',
        ),
        array(
          'alias' => 'Catalogo',
          'conditions' => array(
            'Candidato.candidato_sex = Catalogo.opcion_valor',
            'Catalogo.ref_opcgpo' => 'GENERO'
          ),
          'fields' => array(
            'Catalogo.opcion_texto PostulacionReporte__genero'
          ),
          'table' => 'tcatalogo',
          'type' => 'INNER',
        ),
      );

      $query['group'] = array(        
        'Catalogo.opcion_texto'
      );

      if(!empty($query['cia_cve'])){
         $query['fields'][]='PostulacionReporte.cia_cve PostulacionReporte__ciaId';
         $query['group'][]="PostulacionReporte.cia_cve";
      }

      $query['recursive'] = -1;
      return $query;
    }

    return $results;
  }

  protected function _findPor_edad($state, $query, $results = array()) {
    if ($state === 'before') {
      $__caseQuery = 'CASE
        WHEN trunc((SYSDATE-Candidato.candidato_fecnac)/365) <= 17 THEN \'Menos de 18 años\'
        WHEN trunc((SYSDATE-Candidato.candidato_fecnac)/365) <= 25 THEN \'De 18 a 25 años\'
        WHEN trunc((SYSDATE-Candidato.candidato_fecnac)/365) <= 30 THEN \'De 26 a 30 años\'
        WHEN trunc((SYSDATE-Candidato.candidato_fecnac)/365) <= 40 THEN \'De 31 a 40 años\'
        ELSE \'Más de 41 años\'
      END';

      $query['fields'] = array(      
        $__caseQuery. ' PostulacionReporte__edades',
        'COUNT(*) PostulacionReporte__total'
      );

      $query['conditions'] = $this->conditions($query);

      $query['joins'] = array(
        array(
          'alias' => 'Candidato',
          'conditions' => array(
            'PostulacionReporte.candidato_cve = Candidato.candidato_cve',
          ),
          'table' => 'tcandidato',
          'type' => 'INNER',
        ),
      );

      $query['group'] = array(
        $__caseQuery,
      );
      if(!empty($query['cia_cve'])){
        $query['fields'][]='PostulacionReporte.cia_cve PostulacionReporte__ciaId';
        $query['group'][]='PostulacionReporte.cia_cve';
      }

      $query['order'] = array(
        'PostulacionReporte__edades' => 'ASC'
      );

      $query['recursive'] = -1;
      return $query;
    }

    return $results;
  }

  protected function _findPor_escolaridad($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['fields'] = array(  
        'COUNT(*) PostulacionReporte__total'
      );

      $query['conditions'] = $this->conditions($query);

      $query['joins'] = array(
        array(
          'alias' => 'Candidato',
          'conditions' => array(
            'PostulacionReporte.candidato_cve = Candidato.candidato_cve',
          ),
          'table' => 'tcandidato',
          'type' => 'INNER',
        ),
        array(
          'alias' => 'Nivel',
          'conditions' => array(
            'Nivel.candidato_cve = Candidato.candidato_cve',
          ),
          'table' => 'tesccandidato',
          'type' => 'INNER',
        ),
        array(
          'alias' => 'Catalogo',
          'conditions' => array(
            'Nivel.ec_nivel = Catalogo.opcion_valor',
            'Catalogo.ref_opcgpo' => 'NIVEL_ESCOLAR'
          ),
          'fields' => array(
            'Catalogo.opcion_texto PostulacionReporte__genero'
          ),
          'table' => 'tcatalogo',
          'type' => 'INNER',
        ),
      );

      $query['group'] = array(
        'Catalogo.opcion_texto'
      );

      if(!empty($query['cia_cve'])){
            $query['fields'][]='PostulacionReporte.cia_cve PostulacionReporte__ciaId';
            $query['group'][]='PostulacionReporte.cia_cve';
      }

      $query['recursive'] = -1;
      return $query;
    }

    return $results;
  }
}
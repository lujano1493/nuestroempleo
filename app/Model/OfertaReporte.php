<?php

App::uses('Reporte', 'Model');

class OfertaReporte extends Reporte {
  /**
   * tabla
   * @var string
   */
  public $useTable = 'tofertas';

  public $findMethods = array(
    'ofertas_publicadas' => true,
    'ofertas_categorias' => true,
    'ofertas_usuarios' => true,
    'ofertas_tipo' => true,
    'ofertas_zona' => true,
    'ofertas_postulaciones' => true,
    'ofertas_publicadas_xcia'=>true
  );

  protected function settingDates($dates) {
    $conditions = array();

    if (!empty($dates)) {
      $conditions['oferta_fecini >='] = date('Y-m-d H:i:s', $dates['ini']);
      $conditions['oferta_fecini <='] = date('Y-m-d H:i:s', $dates['end']);
    }

    return $conditions;
  }

  protected function _findOfertas_publicadas($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['fields'] = array(      
        'COUNT(*) OfertaReporte__ofertas',
        'to_char(trunc(oferta_fecini),\'MM\') OfertaReporte__mes',
        'to_char(trunc(oferta_fecini),\'YYYY\') OfertaReporte__anio'
      );  
      $query['conditions'] = $this->conditions($query, array(
        'oferta_status >' => 0
      ));

      $query['group'] = array(
        'to_char(trunc(oferta_fecini),\'MM\')',
        'to_char(trunc(oferta_fecini),\'YYYY\')'
      );
      if(!empty($query['cia_cve'])){
        $query['fields'][]='cia_cve OfertaReporte__ciaId';
        $query['group'][]='cia_cve';
      }

      $query['order'] = array(
        'OfertaReporte__mes' => 'ASC',
        'OfertaReporte__anio' => 'DESC'
      );
      $query['recursive'] = -1;
      return $query;
    }

    return $results;
  }



  protected function _findOfertas_publicadas_xcia($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['fields'] = array(      
        'COUNT(*) OfertaReporte__ofertas',
        'Cia.cia_nombre   OfertaReporte__compania', 
        'Cia.cia_cve      OfertaReporte__cia_cve'     
      );
      $query['conditions'] = $this->conditions($query, array(
        'oferta_status >' => 0
      ));

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
        'OfertaReporte__compania' =>  "ASC"
      );

      $query['recursive'] = -1;
      return $query;
    }

    return $results;
  }

  protected function _findOfertas_categorias($state, $query, $results = array()) {
    if ($state === 'before') {
      $areas = !empty($query['areas']);

      $query['fields'] = array(       
        'COUNT(*) OfertaReporte__ofertas',
      );

      if(!empty($query['cia_cve'])){
        $query['fields'][]= 'OfertaReporte.cia_cve OfertaReporte__ciaId';
      }
      $query['conditions'] = $this->conditions($query, array(
        'oferta_status >' => 0
      ));

      $query['joins'] = array(
        array(
          'alias' => 'OfertaArea',
          'conditions' => array(
            'OfertaReporte.oferta_cve = OfertaArea.oferta_cve',
          ),
          'table' => 'tofertaxarea',
          'type' => 'RIGHT',
        ),
        array(
          'alias' => 'Area',
          'conditions' => array(
            'Area.area_cve = OfertaArea.area_cve'
          ),
          'fields' => $areas ? array('Area.area_nom OfertaReporte__area') : array(),
          'table' => 'tareas',
          'type' => 'INNER',
        ),
        array(
          'alias' => 'Categoria',
          'conditions' => array(
            'Area.categoria_cve = Categoria.categoria_cve'
          ),
          'fields' => array('Categoria.categoria_nom OfertaReporte__categoria'),
          'table' => 'tcategorias',
          'type' => 'INNER',
        )
      );

      $query['group'] = array(
        'Categoria.categoria_nom'    
      );
      if(!empty($query['cia_cve']) ){
        $query['group'][]='OfertaReporte.cia_cve';
      }

      $areas && $query['group'][] = 'Area.area_nom';

      $query['order'] = array(
        'Categoria.categoria_nom' => 'ASC'
      );

      $query['recursive'] = -1;

      return $query;
    }
    return $results;
  }

  protected function _findOfertas_tipo($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['fields'] = array(       
        'COUNT(CASE WHEN
          oferta_status > 0 AND
          oferta_inactiva = 0 ' . // 'AND oferta_fecfin > CURRENT_DATE' .
        'THEN 1 END) OfertaReporte__activas',
        'COUNT(CASE WHEN
          oferta_status = 3 AND
          oferta_inactiva = 0 ' . // 'AND oferta_fecfin > CURRENT_DATE' .
        'THEN 1 END) OfertaReporte__distinguidas',
        'COUNT(CASE WHEN
          oferta_status = 2 AND
          oferta_inactiva = 0 ' . // 'AND oferta_fecfin > CURRENT_DATE' .
        'THEN 1 END) OfertaReporte__recomendadas',
        'COUNT(CASE WHEN
          oferta_status = 1 AND
          oferta_inactiva = 0 ' . // 'AND oferta_fecfin > CURRENT_DATE' .
        'THEN 1 END) OfertaReporte__publicadas'
      );
      if(!empty($query['cia_cve'])){
        $query['fields'][]='OfertaReporte.cia_cve';
        $query['group'] = array(
          'OfertaReporte.cia_cve'
        );
      }
      $query['conditions'] = $this->conditions($query);



      $query['recursive'] = -1;
      return $query;
    }

    return $results;
  }

  protected function _findOfertas_zona($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['fields'] = array(
        'COUNT(*) OfertaReporte__ofertas',
      );
      $query['conditions'] = $this->conditions($query, array(
        'oferta_status >' => 0
      ));
      $query['joins'] = array(
        array(
          'alias' => 'Ciudad',
          'conditions' => array(
            'OfertaReporte.ciudad_cve = Ciudad.ciudad_cve',
          ),
          'fields' => array(
            'Ciudad.ciudad_nom OfertaReporte__ciudad'
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
            'Estado.est_nom OfertaReporte__estado'
          ),
          'table' => 'testado',
          'type' => 'INNER',
        )
      );

      $query['group'] = array(
        'Ciudad.ciudad_nom',
        'Estado.est_nom'
      );
      if(!empty($query['cia_cve'])){
        $query['fields'][]= 'OfertaReporte.cia_cve';
        $query['group'][]= 'OfertaReporte.cia_cve';
      }
       $query['order'] = array(
        'Estado.est_nom' => 'ASC',
        'Ciudad.ciudad_nom' => 'ASC'
      );

      $query['recursive'] = -1;
      return $query;
    }

    return $results;
  }

}
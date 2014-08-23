<?php

App::uses('Reporte', 'Model');

class CorreoReporte extends Reporte {
	 /**
   * tabla
   * @var string
   */
  public $useTable = 'tcorreoscandidato';

  public $findMethods = array(
    'estado_completo' => true
  );

  protected function settingDates($dates) {
    $conditions = array();

    if (!empty($dates)) {
      $conditions['created >='] = date('Y-m-d H:i:s', $dates['ini']);
      $conditions['created <='] = date('Y-m-d H:i:s', $dates['end']);
    }

    return $conditions;
  }

protected function _findEstado_completo($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['fields'] = array(
      	"$this->alias.correo",
      	"(Candidato.candidato_nom ||' '|| Candidato.candidato_pat || ' '|| Candidato.candidato_mat)	{$this->alias}__nombre",
      	"Cuenta.created {$this->alias}__registrado",
      	"DECODE(Cuenta.cc_status,-1,'Sin Activar',0,'Inactivo',1,'Activo',-2,'Bloqueado') {$this->alias}__estado",
      	"DECODE(Cuenta.cc_completo,'S' ,'Sí','N','No','No registrado') {$this->alias}__rapido",
      	"DECODE(Completo.candidato_cve,NULL,'Sín Completar','Completo') {$this->alias}__completo",
      	"Postulacion.created {$this->alias}__fecha_p",
      	"Oferta.oferta_cve {$this->alias}__oferta_id",      	
      	"Oferta.puesto_nom {$this->alias}__oferta",
      	"Cia.cia_nombre {$this->alias}__cia"

      );
      $query['conditions']["$this->alias.proceso_cve"]=$query['idProceso']; 
      $query['joins']=array(
         array(
           'table' => 'tcuentacandidato',
          'alias' => 'Cuenta',
          'type' => 'LEFT',
          'fields' =>array(),
          'conditions'=>array(
              "$this->alias.correo=Cuenta.cc_email"
            )
        ),
         array(
	          'table' => 'tcandidato',
	          'alias' => 'Candidato',
	          'type' => 'LEFT',
	          'fields' =>array(),
	          'conditions'=>array(
	              "Cuenta.candidato_cve=Candidato.candidato_cve"
	            )
        ),
        array(
	      	'table' => 'tpostulacionxoferta',
	      	'alias' => 'Postulacion',
	      	'type' => 'LEFT',
	      	'fields' => array(),
	      	'conditions' => array(
	      		'Postulacion.candidato_cve=Cuenta.candidato_cve'
	      	)
	     ),
        array(
        	'table' => 'tofertas',
        	'alias' => 'Oferta',
        	'type' => 'LEFT',
        	'fields' => array(),
        	'conditions' => array(
        		'Oferta.oferta_cve=Postulacion.oferta_cve'
        	)
        ),
        array(
        	'table' => 'tcompania',
        	'alias' => 'Cia',
        	'type' =>'LEFT',
        	'fields' =>array(),
        	'conditions' => array(
        		'Cia.cia_cve=Oferta.cia_cve'
        	)        	
        	),
        array(
        	'table' => '(SELECT graf.candidato_cve
							FROM tgrafcandidato graf
							INNER JOIN ttablasgrafcandidato tabla
							ON ( tabla.tabla_cve  = graf.tabla_cve)
							GROUP BY graf.candidato_cve
							HAVING SUM(tabla.tabla_porcentaje) >=100)',
        	'alias' => 'Completo',
        	'type' => 'LEFT',
        	'fields' => array(),
        	'conditions' => array(
        			'Completo.candidato_cve=Cuenta.candidato_cve'
        	)
        )
        );
      $query['order'] = array(
        "$this->alias.correo" =>  "ASC"
      );

      $query['recursive'] = -1;
      return $query;
    }    
    return $results;
  }


}

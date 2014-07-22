<?php

App::uses('Reporte', 'Model');

class UsuarioReporte extends Reporte {
  /**
   * tabla
   * @var string
   */
  public $useTable = false;

  private $__sqlOfertas = 'SELECT
    id UsuarioReporte__id,
    email UsuarioReporte__email,
    nombre UsuarioReporte__nombre,
    perfil_id UsuarioReporte__perfil_id,
    perfil UsuarioReporte__perfil,
    parent_id UsuarioReporte__parent_id,
    total UsuarioReporte__total_ofertas,
    SUM(CONNECT_BY_ROOT total) UsuarioReporte__total_sub
    FROM (SELECT
      U.cu_cve id,
      U.cu_sesion email,
      C.con_nombre || \' \' || C.con_paterno nombre,
      U.cu_cvesup parent_id,
      U.per_cve perfil_id,
      P.per_nom perfil,
      NVL(O.total,0) total
      FROM
        tcuentausuario U
      LEFT JOIN (
        SELECT cu_cve, COUNT(*) total
        FROM tofertas
        WHERE
           {__dateConditions__}   {__ciaId__} 
          AND oferta_status > 0
        GROUP BY cu_cve
      ) O ON (
        O.cu_cve = U.cu_cve
      )
      LEFT JOIN tcontacto C ON (
        C.cu_cve = U.cu_cve
      )
      LEFT JOIN tperfil P ON (
        P.per_cve = U.per_cve
      )
      START WITH U.cu_cve = {__userId__} CONNECT BY PRIOR U.cu_cve = U.cu_cvesup)
    {__conditions__}
    CONNECT BY id = PRIOR parent_id
    GROUP BY
      id, email, nombre, perfil_id, perfil, parent_id, total
    ORDER BY
      parent_id, id';

  public $findMethods = array(
    'ofertas_publicadas' => true,
  );

  private function setConditions($conditions) {
    $sql = str_replace(array(
      '{__ciaId__}',
      '{__userId__}',
      '{__dateConditions__}',
      '{__conditions__}'
    ), array(
        !empty($conditions['cia_cve'] ) ? " AND cia_cve = $conditions[cia_cve]" : "",
      $conditions['cu_cve'],
      !empty($conditions['dates'])
        ? sprintf(' oferta_fecini >= TO_DATE(\'%s\', \'YYYY-MM-DD HH24:MI:SS\') AND oferta_fecini <= TO_DATE(\'%s\', \'YYYY-MM-DD HH24:MI:SS\') ',
          date('Y-m-d H:i:s', $conditions['dates']['ini']),
          date('Y-m-d H:i:s', $conditions['dates']['end'])
        )
        : '',
      !empty($conditions['conditions'])
        ? $this->ds->conditions($conditions['conditions'])
        : ''
    ), $this->__sqlOfertas);

    return $sql;
  }

  public function ofertas_publicadas($conditions) {

    $sql = $this->setConditions($conditions);
    $results = $this->ds->fetchAll($sql);

    return $results;
  }

  public function ofertas_cordinacion($conditions) {

    $conditions['conditions'] = array(
      'MOD(perfil_id,100) = 1'
    );

    $sql = $this->setConditions($conditions);
    $results = $this->ds->fetchAll($sql);

    return $results;
  }

  public function creditos($conditions) {
    $ciaId = $conditions['cia_cve'];
    $userId = $conditions['cu_cve'];
    $dates = $conditions['dates'];

    $creditos = ClassRegistry::init('Credito')->getByEmpresa(
      $ciaId, $userId, null, array(
        'disponibles' => array(
          sprintf('fec_fin >= TO_DATE(\'%s\', \'YYYY-MM-DD HH24:MI:SS\')', date('Y-m-d H:i:s', $dates['ini'])),
          sprintf('created <= TO_DATE(\'%s\', \'YYYY-MM-DD HH24:MI:SS\')', date('Y-m-d H:i:s', $dates['end'])),
        ),
        'ocupados' => array(
          sprintf('created >= TO_DATE(\'%s\', \'YYYY-MM-DD HH24:MI:SS\')', date('Y-m-d H:i:s', $dates['ini'])),
          sprintf('created <= TO_DATE(\'%s\', \'YYYY-MM-DD HH24:MI:SS\')', date('Y-m-d H:i:s', $dates['end'])),
        )
      )
    );

    $combine = false;
    $results = array();
    foreach ($creditos as $user => $credits) {
      $disponibles = array();
      $ocupados = array();
      foreach ($credits as $type => $credit) {
        if ($combine) {
          $disponibles[] = $credit['disponibles'];
          $ocupados[] = $credit['ocupados'];
        } else {
          $disponibles[$type] = array(
            'disponibles' => $credit['disponibles'],
            'ocupados' => $credit['ocupados']
          );
        }
      }

      $results[$user] = $combine ? array(
        'disponibles' => array_sum($disponibles),
        'ocupados' => array_sum($ocupados),
      ) : $disponibles;
    }

    return $results;
  }
}
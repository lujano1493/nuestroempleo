<?php

App::uses('AppModel', 'Model');

class Credito extends AppModel {

  public $actsAs = array('Containable');
  /**
   * Nombre del modelo.
   * @var string
   */
  public $name = 'Credito';

  /**
   * Llave primaria.
   * @var string
   */
  public $primaryKey = 'creditosxcu_cve';

  /**
   * Se usará la siguiente tabla.
   * @var string
   */
  public $useTable = 'tcreditosxcu_cve';

  /**
   * Modelos que se utilizan pero no se relaciona.
   * @var array
   */
  public $knows = array(
    'CreditoOcupado',
    'Membresia'
  );

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

  public $creditsType = array(
    'oferta_publicada' => 1,
    'oferta_recomendada' => 2,
    'oferta_distinguida' => 3,
    'consulta_cv' => 4
  );

  public $joins = array(
    'usuarios' => array(
      'alias' => 'Usuarios',
      'conditions' => array('1 = 1'),
      'fields' => array('Usuarios.cu_cve', 'Usuarios.cu_sesion'),
      'table' => '(SELECT
          UsuarioEmpresa.cu_cve
        , UsuarioEmpresa.cu_sesion
        FROM tcuentausuario UsuarioEmpresa
        WHERE
          UsuarioEmpresa.per_cve >= 100 {$__conditions__$}
        START WITH
          UsuarioEmpresa.cu_cve = {$__userId__$}
        CONNECT BY PRIOR
          UsuarioEmpresa.cu_cve = UsuarioEmpresa.cu_cvesup
        ORDER BY UsuarioEmpresa.cu_cve ASC)',
      'type' => 'LEFT'
    ),
    'creditos_disponibles' => array(
      'alias' => 'Disponibles',
      'fields' => array(
        'nvl(Disponibles.total,0) Servicio__disponibles',
        'nvl(Disponibles.infinitos,0) Servicio__creditos_infinitos'
      ),

      /**
       * Obtiene los créditos del usuario, si existe algún tipo de crédito con la cantidad < 0,
       * significa que los créditos son infinitos, por lo tanto establece como créditos disponibles
       * a -1.
       */
      'table' => '(SELECT
        total, servicio_cve, cu_cve, (CASE WHEN total = -9999 THEN 1 ELSE 0 END) infinitos
        FROM (SELECT
          CASE WHEN COUNT(CASE WHEN (cred_disponibles < 0) THEN cred_disponibles END) > 0 THEN -9999 ELSE SUM(cred_disponibles) END total,
          servicio_cve, cu_cve
          FROM tcreditosxcu_cve
          WHERE
            1 = 1 {$__conditions__$}
            GROUP BY servicio_cve, cu_cve
      ))',
      'type' => 'LEFT',
      'conditions' => array(
        'Disponibles.servicio_cve = Servicio.servicio_cve',
      )
    ),
    'creditos_ocupados' => array(
      'alias' => 'Ocupados',
      'fields' => array(
        'nvl(Ocupados.total,0) Servicio__ocupados'
      ),
      'table' => '(SELECT
          count(cu_cve) total
        , cu_cve
        , servicio_cve
        FROM tcreditos_ocupados
        WHERE
          1 = 1 {$__conditions__$}
        GROUP BY servicio_cve, cu_cve)',
      'type' => 'LEFT',
      'conditions' => array(
        'Ocupados.servicio_cve = Servicio.servicio_cve',
      )
    )
  );

  private function getJoins($joins = array()) {
    $processedJoins = array();
    $joins = (array)$joins;

    foreach ($joins as $key => $value) {
      $_key = is_numeric($key) ? $value : $key;

      if (empty($this->joins[$_key])) {
        continue;
      }
      $join = $this->joins[$_key];

      if (isset($value['tableConditions']) && is_array($value['tableConditions'])) {
        $tableConditions = $this->getDataSource()->conditions($value['tableConditions'], true, false);
      }

      if (isset($value['conditions']) && is_array($value['conditions'])) {
        $join['conditions'] = array_merge($join['conditions'], $value['conditions']);
      }

      $join['table'] = str_replace(array(
        '{$__conditions__$}',
        '{$__userId__$}'
      ), array(
        !empty($tableConditions) ? ' AND (' . $tableConditions . ')' : '',
        !empty($value['userId']) ? $value['userId'] : ''
      ), $join['table']);

      $processedJoins[] = $join;
    }

    return $processedJoins;
  }

  /**
   * Verifica los créditos que tiene el usuario.
   * @param  int      $userId     Id del usuario.
   * @param  int      $creditType Tipo de crédito.
   * @return mxied                [description]
   */
  public function getByUser($userId, $empresaId = null, $type = null, $dates = array()) {

    // Si $type es nulo, obtiene todos los creditos y los agrupará por tipo.
    $combine = $type == null; // && !is_numeric($type);

    if (!$empresaId) {
      $empresa = $this->UsuarioEmpresa->getEmpresaByUserId($userId, true);
      $empresaId = $empresa['cia_cve'];
    }

    if ($combine) {
      $options['fields'] = array(
        'Servicio.identificador',
        'Servicio.servicio_cve',
        'Servicio.servicio_nom Servicio__nombre',
        'Servicio.servicio_tipo Servicio__visible',
      );

      $options['joins'] = $this->getJoins(
        array(
          'creditos_disponibles' => array(
            'tableConditions' => array(
              !empty($dates['disponibles']) ? $dates['disponibles'] : 'fec_fin > CURRENT_DATE',
              'cu_cve' => $userId,
              'cia_cve' => $empresaId,
            )
          ),
          'creditos_ocupados' => array(
            'tableConditions' => array(
              !empty($dates['ocupados']) ? $dates['ocupados'] : '1 = 1',
              'cu_cve' => $userId,
              'cia_cve' => $empresaId
            )
          )
        )
      );

      $options['order'] = array('Servicio.servicio_cve' => 'ASC');
    } else {
      $type = is_numeric($type) ? $type : $this->creditsType[$type];
      $options['conditions']['Servicio.servicio_cve'] = $type;
    }

    $options['recursive'] = -1;

    $creditos = $this->Servicio->find('all', $options);

    if ($combine) {
      $creditos = Hash::combine($creditos, '{n}.Servicio.identificador', '{n}.Servicio');
    }

    return $creditos;
  }

  /**
   * Verifica los créditos que tiene la compañia.
   * @param  int    $empresaId  Id. de la empresa
   * @param  int    $type Tipo de Crédito
   * @return mixed              [description]
   */
  public function getByEmpresa($empresaId, $userId, $type = null, $dates = array()) {

    if (is_array($userId)) {
      $users = $userId['users'];
      $userId = $userId['userId'];
    }

    // Si $type es nulo, obtiene todos los creditos y los agrupará por tipo.
    $combine = $type == null; // && !is_numeric($type);

    if ($combine) {
      $options['fields'] = array(
        'Servicio.identificador',
        'Servicio.servicio_cve',
        'Servicio.servicio_nom Servicio__nombre',
        'Servicio.servicio_tipo Servicio__visible',
      );

      /* Agrupar por (para la suma de los cŕeditos) */
      $options['group'] = array(
        'Servicio.identificador',
        'Servicio.servicio_cve',
        'Servicio.servicio_nom',
        'Servicio.servicio_tipo',
        'Usuarios.cu_sesion',
        'Usuarios.cu_cve',
        'Ocupados.total',
        'Disponibles.infinitos',
        'Disponibles.total'
      );

      $options['joins'] = $this->getJoins(
        array(
          'usuarios' => array(
            'userId' => $userId,
            'tableConditions' => !empty($users) ? array(
              'cu_cve' => $users
            ) : '1 = 1'
          ),
          'creditos_disponibles' => array(
            'tableConditions' => array(
              !empty($dates['disponibles']) ? $dates['disponibles'] : 'fec_fin > CURRENT_DATE',
              'cia_cve' => $empresaId
            ),
            'conditions' => array(
              'Usuarios.cu_cve = Disponibles.cu_cve'
            )
          ),
          'creditos_ocupados' => array(
            'tableConditions' => array(
              !empty($dates['ocupados']) ? $dates['ocupados'] : '1 = 1',
              'cia_cve' => $empresaId
            ),
            'conditions' => array(
              'Usuarios.cu_cve = Ocupados.cu_cve'
            )
          )
        )
      );

      $options['order'] = array(
        'Usuarios.cu_cve' => 'ASC',
        'Servicio.servicio_cve' => 'ASC'
      );
    } else {
      $type = is_numeric($type) ? $type : $this->creditsType[$type];
      $options['conditions']['Servicio.servicio_cve'] = $type;
    }

    $options['recursive'] = -1;

    $creditos = $this->Servicio->find('all', $options);

    if ($combine) {
      $creditos = Hash::combine($creditos, '{n}.Servicio.identificador', '{n}.Servicio', '{n}.Usuarios.cu_sesion');
    }

    return $creditos;
  }

  public function asignarSimple($toUser, $options) {
    $creditType = $this->creditsType[$options['servicio']];
    $assignedCredits = $options['creditos'];
    $endDate = $this->Membresia->getEndDate($options['duracion']);

    $credits = array(
      'cia_cve' => !empty($toUser['Empresa']['cia_cve']) ? $toUser['Empresa']['cia_cve'] : $toUser['cia_cve'],
      'cu_cve' => $toUser['cu_cve'],
      'servicio_cve' => $creditType,
      'cred_disponibles' => $assignedCredits,
      'fec_fin' => $endDate
    );

    return $this->save($credits);
  }

  public function asignar($fromUser, $toUser, $data) {
    $name = key($data);
    $totalCredits = $data[$name];

    if ($totalCredits <= 0) {
      return true;
    }

    $credits = $this->find('all', array(
      'conditions' => array(
        'Credito.cu_cve' =>  $fromUser,
        'Credito.servicio_cve' => $this->creditsType[$name],
        'OR' => array(
          'Credito.cred_disponibles > 0',
          'Credito.cred_disponibles = -1'
        ),
        'Credito.fec_fin > CURRENT_DATE'
      ),
      'order' => array(
        'Credito.fec_fin' => 'ASC'
      ),
      'recursive' => -1
    ));

    $creditsToCreate = array();
    $creditsToDelete = array();
    $creditsToUpdate = array();
    $assignedCredits = 0;

    foreach ($credits as $key => $value) {
      $c = $value[$this->alias];

      // Si ya no hay créditos para asignar, se rompe la iteración.
      if ($totalCredits <= 0) {
        break;
      }

      $creditosInfinitos = $c['cred_disponibles'] < 0;
      if ($c['cred_disponibles'] > $totalCredits) {
        // Actualiza. Como los creditos disponibles en ese registro son mayores a los que se quieren asignar,
        // se actulizarán con la cantidad apropiada, restando los créditos asignados.
        $assignedCredits = $totalCredits;
        $c['cred_disponibles'] = $c['cred_disponibles'] - $assignedCredits;
        //$creditsToUpdate[] = $c;
        //
      } elseif ($creditosInfinitos) {
        $assignedCredits = $totalCredits;
      } else { // $totalCredits > CreditosDisponibles
        // Borra. Si los créditos que se buscan asignar son mayores, entonces se borrará el registro.
        $assignedCredits = $c['cred_disponibles'];
        $c['cred_disponibles'] = 0;
        //$creditsToDelete[] = $c[$this->primaryKey];
      }

      !$creditosInfinitos && $creditsToUpdate[] = $c;

      $totalCredits -= $assignedCredits;

      $creditsToCreate[] = array(
        'cia_cve' => isset($fromUser['cia_cve']) ? $fromUser['cia_cve'] : $c['cia_cve'],
        'cu_cve' => is_numeric($toUser) ? $toUser : $toUser['cu_cve'],
        'servicio_cve' => $c['servicio_cve'],
        'cred_disponibles' => $assignedCredits,
        'fec_fin' => $c['fec_fin']
      );
    }

    $data = array_merge($creditsToCreate, $creditsToUpdate);
    return $this->saveMany($data);
  }

  public function spend($user, $creditType, $productId, $numCredits = 1) {
    $success = false;

    if (is_string($numCredits) && $numCredits === 'infinity') {
      return $this->CreditoOcupado->logCredit($user, $creditType, $productId);
    }

    /**
     * Obtiene el crédito del usuario más antiguo y sobre ése disminuye.
     * @var [type]
     */
    $credit = $this->get(null, 'first', array(
      'conditions' => array(
        'Credito.cia_cve' => $user['Empresa']['cia_cve'],
        'Credito.cu_cve' => $user['cu_cve'],
        'Credito.servicio_cve' => $creditType,
        'Credito.cred_disponibles >=' => $numCredits
      ),
      'order' => array(
        'Credito.fec_fin' => 'ASC' //Obtiene el más antiguo.
      )
    ));

    if (!empty($credit) && ($availableCredits = (int)$credit['cred_disponibles']) >= $numCredits) {
      $this->id = $credit[$this->primaryKey];
      $this->begin();
      $success = $this->saveField('cred_disponibles', $availableCredits - $numCredits);
      if ($success) {
        if ($this->CreditoOcupado->logCredit($user, $creditType, $productId)) {
          $this->commit();
        } else {
          $success = false;
          $this->rollback();
        }
      }
    }

    return $success;
  }

  public function afterFind($results = array(), $primary = false) {

    return parent::afterFind($results, $primary);
  }
}
<?php

App::uses('UsuarioBase', 'Model');

/**
 * Clase Base para los administradores y usuario de las empresas.
 */

class UsuarioAdminEmpresa extends UsuarioBase {

  /**
   * Métodos de Búsqueda.
   * @var array
   */
  public $findMethods = array('dependents' => true, 'data' => true, 'parents' => true);

  /**
   * Pertenece a un PERFIl (tperfil) y a un SUPERIOR
   * @var array
   */
  public $belongsTo = array(
    'Perfil' => array(
      'className' => 'Perfil',
      'foreignKey' => 'per_cve'
    ),
    'Superior' => array(
      'className' => 'UsuarioAdmin',
      'foreignKey' => 'cu_cvesup',
    )
  );

  /**
   * [$hasOne description]
   * @var array
   */
  public $hasOne = array(
    'Contacto' => array(
      'className' => 'UsuarioEmpresaContacto',
      'foreignKey' => 'cu_cve'
    ),
  );

  /**
   * Búsqueda personalizada para encontrar los datos del usuario. Datos de Contacto y el Perfil.
   * @param  [type] $state   [description]
   * @param  [type] $query   [description]
   * @param  array  $results [description]
   * @return [type]          [description]
   */
  public function _findData($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['contain'] = array(
        'Contacto'/* => array(
          'fields' => array('Contacto.cu_cve', 'Contacto.con_nombre || \' \' || Contacto.con_paterno as nombre')
        )*/,
        'Perfil' => array(
          'fields' => array('Perfil.per_cve', 'Perfil.per_nom', 'Perfil.per_descrip')
        )
      );

      $query['recursive'] = -1;
      return $query;
    }
    return $results;
  }

  /**
   * Búsqueda personalizada para encontrar los dependientes de un usuario.
   * @param  [type] $state   [description]
   * @param  [type] $query   [description]
   * @param  array  $results [description]
   * @return [type]          [description]
   */
  public function _findDependents($state, $query, $results = array()) {
    if ($state === 'before') {
      if (empty($query['fields'])) {
        $query['fields'] = array(
          $this->alias . '.cu_cve', $this->alias . '.cu_sesion', $this->alias . '.cu_status', $this->alias . '.per_cve',
          $this->alias . '.keycode', $this->alias . '.cu_cvesup', $this->alias . '.created', $this->alias . '.modified'
        );
      }

      $query['conditions'][$this->alias . '.cu_status >= '] = -1;
      if (isset($query['includeParent']) && $query['includeParent'] === false) {
        $query['conditions'][] = $this->alias . '.cu_cve != ' . $query['parent'];
        unset($query['includeParent']);
      }

      $query['connect'] = array(
        'by' => 'PRIOR ' . $this->alias . '.cu_cve = ' . $this->alias . '.cu_cvesup',
        'start with' => $this->alias . '.cu_cve = ' . $query['parent']
      );

      //if (!isset($query['recursive']) || $query['recursive'] > 0) {
        $query['contain'] = array(
          'Superior' => array(
            'fields' => array('Superior.cu_sesion', 'Superior.keycode')
          ),
          'Contacto' => array(
            'fields' => array('Contacto.cu_cve', 'Contacto.con_nombre || \' \' || Contacto.con_paterno as nombre')
          ),
          'Perfil' => array(
            'fields' => array('Perfil.per_cve', 'Perfil.per_nom', 'Perfil.per_descrip')
          )
        );
      //}
      return $query;
    }

    return isset($query['format']) ? $this->format($query['format'], $results) : $results;
  }

  /**
   * Búsqueda personalizada para encontrar los superiores de un usuario.
   * @param  [type] $state   [description]
   * @param  [type] $query   [description]
   * @param  array  $results [description]
   * @return [type]          [description]
   */
  public function _findParents($state, $query, $results = array()) {
    if ($state === 'before') {
      if (empty($query['fields'])) {
        $query['fields'] = array(
          $this->alias . '.cu_cve', $this->alias . '.cu_sesion', $this->alias . '.cu_status', $this->alias . '.per_cve',
          $this->alias . '.keycode', $this->alias . '.cu_cvesup', $this->alias . '.created', $this->alias . '.modified'
        );
      }

      $query['connect'] = array(
        'by' => 'PRIOR ' . $this->alias . '.cu_cvesup = ' . $this->alias . '.cu_cve',
        'start with' => $this->alias . '.cu_cve = ' . $query['child']
      );

      if (!isset($query['recursive']) || $query['recursive'] > 0) {
        $query['contain'] = array(
          'Superior' => array(
            'fields' => array('Superior.cu_sesion', 'Superior.keycode')
          ),
          'Contacto' => array(
            'fields' => array('Contacto.cu_cve', 'Contacto.con_nombre || \' \' || Contacto.con_paterno Contacto__nombre')
          ),
          'Perfil' => array(
            'fields' => array('Perfil.per_cve', 'Perfil.per_nom', 'Perfil.per_descrip')
          )
        );
      }
      return $query;
    }
    return $results;
  }

  /**
   * Obtiene los id devueltos por la búsqueda.
   * @param  string $type       [description]
   * @param  array  $conditions [description]
   * @return [type]             [description]
   */
  public function getIds($type = 'all', $conditions = array()) {
    $options = array(
      'fields' => array($this->alias . '.' .$this->primaryKey),
      'recursive' => -1
    );

    $ids = $this->find($type, array_merge($options, $conditions));

    return Hash::extract($ids, "{n}.$this->alias.$this->primaryKey");
  }

  public function isAdminBy($adminId, $userId = null) {
    $ids = $this->getIds('parents', array(
      'child' => $userId
    ));

    return in_array($adminId, $ids);
  }

  public function getLast($limit = 5) {
    return $this->find('all', array(
      'limit' => $limit,
      'order' => array(
        $this->alias . '.created' => 'DESC'
      )
    ));
  }

  public function dependents($userId, $format = 'complete') {
    $users = $this->get(null, 'dependents', array(
      'fields' => array('UsuarioEmpresa.cu_cve', 'UsuarioEmpresa.cu_sesion', 'Contacto.con_tel'),
      'parent' => $userId,
      'recursive' => 1
    ));

    if ($format != 'complete') {
      return $this->format($format, $users);
    } else {
      return $users;
    }
  }

  public function registrar($data, $perfil = null, $usuarioSuperior = array()) {
    /**
      * Reinica los valores por default del Usuario y limpia el id.
      */
    $this->create();

    $this->email = $data[$this->alias]['cu_sesion'];
    $this->password = Funciones::generar_clave(8);

    $formatedData = array(
      'UsuarioAdmin' => array(
        'cu_sesion' =>  $this->email,
        'cu_sesion_confirm' =>  $data[$this->alias]['cu_sesion_confirm'],
        'cu_password' => $this->password,
        // Si no se específica un usuario superior, será el administrador.
        'cu_cvesup' => isset($usuarioSuperior['cu_cve']) ? $usuarioSuperior['cu_cve'] : 1,
        // Por default, el usuario está desactivado.
        'cu_status' => -1,
        // Por default, el perfil del usuario es 20099, Ejecutivo de ventas
        'per_cve' => is_null($perfil) ? 99 : $perfil,
      ),
      'Contacto' => $data['Contacto']
    );

    return $this->saveAll($formatedData, array('validate' => 'first'));
  }

  /**
   * Actualiza el usuario superior de los subordinados al superior del usuario actual
   * si $superId es null.
   * @param  [type] $userId  [description]
   * @param  [type] $superId [description]
   * @return [type]          [description]
   */
  public function updateSubsToSuper($userId, $superId = null) {

    /**
     * Si $superId es vacío o no es númerico busca el superior.
     */
    if (empty($superId) && !is_numeric($superId)) {
      $user = $this->get($userId, 'first');
      $superId = $user['cu_cvesup'];
    }

    return $this->updateAll(array(
      $this->alias . '.cu_cvesup' => $superId
    ), array(
      $this->alias . '.cu_cvesup' => $userId
    ));
  }

  public function beforeFind($queryData = array()) {
    return parent::beforeFind($queryData);
  }

  public function afterFind($results, $primary = false) {
    foreach ($results as $key => $value) {
      if (isset($value[$this->alias][$this->statusKey])) {
        $status = $value[$this->alias][$this->statusKey];

        switch ((int)$status) {
          case 0:
            $status = __('Bloqueada');
            break;
          case 1:
            $status = __('Activa');
            break;
          default:
            $status = __('Inactiva');
            break;
        }

        $results[$key][$this->alias]['status'] = $status;
      }
    }


    return parent::afterFind($results, $primary);
  }

  public function format($type, $data) {
    return $this->{'_format' . ucfirst($type)}($data);
  }

  private function _formatContact($data) {
    $items = array();

    foreach ($data as $key => $value) {
      $c = $value['Contacto'];
      $u = $value[$this->alias];

      $items[] = array(
        'name' => $c['nombre'],
        'value' => $u['cu_cve'],
        'data-tel' => empty($c['con_tel'])
          ? __('Sin dato')
          : __('%s Ext: %s', $c['con_tel'], !empty($c['con_ext']) ? $c['con_ext'] : ''),
        'data-email' => $u['cu_sesion'],
      );
    }

    return $items;
  }

  private function _formatList($data) {
    return Hash::combine($data, '{n}.' . $this->alias . '.cu_cve', '{n}.' . $this->alias . '.cu_sesion');
  }

  private function _formatCuenta($data) {
    return Hash::combine($data, '{n}.' . $this->alias . '.cu_cve', array(
      '%s (%s) - %s', '{n}.Contacto.nombre', '{n}.' . $this->alias . '.cu_sesion', '{n}.Perfil.per_nom'
    ));
  }

}
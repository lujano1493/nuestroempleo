<?php

App::uses('AppModel', 'Model');

class Carpeta extends AppModel {
  public $actsAs = array('Containable');

  // Nombre del Modelo
  public $name = 'Carpeta';

  // Nombre de la llave primaria, en este caso es cia_cve, tabla tcompania.
  public $primaryKey = 'carpeta_cve';

  public $findMethods = array('dependents' => true, 'ofertas' => true, 'candidatos' => true, 'mensajes' => true);

  // Tabla.
  public $useTable = 'tcarpetas';

  public $belongsTo = array(
    'Usuario' => array(
      'className' => 'UsuarioEmpresa',
      'fields' => array(
        'Usuario.cu_cve', 'Usuario.cu_sesion', 'Usuario.keycode',
      ),
      'foreignKey' => 'cu_cve',
    ),
    'Contacto' => array(
      'className' => 'UsuarioEmpresaContacto',
      'fields' => array(
        'Contacto.con_nombre', 'Contacto.con_paterno', 'Contacto.con_materno'
      ),
      'foreignKey' => 'cu_cve',
    )
  );

  public $hasAndBelongsToMany = array(
    'Candidatos' => array(
      'className' => 'CandidatoEmpresa',
      'with' => 'CarpetasCandidatos',
      'foreignKey' => 'carpeta_cve',
      'associationForeignKey' => 'candidato_cve',
      'unique' => false
    )
  );

  public static $tipo = array(
    'oferta' => 0, 'candidato' => 1, 'mensajes' => 2
  );

  /**
   * Condiciones que validarán los datos del Modelo.
   * @var array
   */
  public $validate = array(
    'carpeta_nombre' => array(
      'required' => array(
        'rule' => 'notEmpty',
        'required' => true,
        'message' => 'Nombre de carpeta requerida'
      ),
      'validateUnique' => array(
        'rule' => array('uniqueName'),
        'required' => true,
        'allowEmpty' => false,
        'message' => 'El nombre de la carpeta ya existe.'
      )
    )
  );

  /**
   * Busca las carpetas dependientes.
   * @param  [type] $state   [description]
   * @param  [type] $query   [description]
   * @param  array  $results [description]
   * @return [type]          [description]
   */
  protected function _findDependents($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['fields'] = array(
        'Carpeta.carpeta_cve',
        'Carpeta.carpeta_nombre',
        'Carpeta.tipo_cve',
        'Carpeta.cu_cve',
        'Carpeta.created'
      );

      $parent = isset($query['parent']) ? $query['parent'] : null;

      $query['connect'] = array(
        'by' => 'PRIOR Carpeta.carpeta_cve = Carpeta.carpeta_cvesup',
        'start with' => !is_null($parent) ?
          'Carpeta.carpeta_cve = ' . $parent :
          'Carpeta.carpeta_cvesup is null'
      );

      if (!isset($query['order'])) {
        $query['order'] = array(
          'Carpeta.carpeta_nombre' => 'ASC'
        );
      }

      $query['recursive'] = -1;
      return $query;
    } elseif ($state === 'after') {
      if (isset($query['nest']) && is_bool($query['nest']) && $query['nest']) {
        $query['nest'] = array(
          'idPath' => '{n}.Carpeta.carpeta_cve',
          'parentPath' => '{n}.Carpeta.carpeta_cvesup',
        );
      }

      if (!empty($query['nest']) && is_array($query['nest'])) {
        $results = Hash::nest($results, $query['nest']);
      }
    }

    return $results;
  }

  /**
   * Encuentra las carpetas de ofertas con el total de items en ella.
   * @param  [type] $state   [description]
   * @param  [type] $query   [description]
   * @param  array  $results [description]
   * @return [type]          [description]
   */
  protected function _findOfertas($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['joins'] = array(
        array(
          'table' => '(SELECT Oferta.carpeta_cve, NVL(count(Oferta.oferta_cve),0) count
            FROM tofertas Oferta
            WHERE Oferta.oferta_fecfin > CURRENT_DATE AND
              Oferta.oferta_inactiva = 0
            GROUP BY Oferta.carpeta_cve)',
          'alias' => 'Oferta',
          'fields' => array(
            'nvl(Oferta.count,0) Carpeta__total'
          ),
          'type' => 'LEFT',
          'conditions' => array(
            'Carpeta.carpeta_cve = Oferta.carpeta_cve'
          )
        )
      );

      $query['conditions'][$this->alias . '.tipo_cve'] = self::$tipo['oferta'];
    }

    return $this->_findDependents($state, $query, $results);
  }

  /**
   * Encuentra las carpetas de candidatos con el total de items en ella.
   * @param  [type] $state   [description]
   * @param  [type] $query   [description]
   * @param  array  $results [description]
   * @return [type]          [description]
   */
  protected function _findCandidatos($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['joins'] = array(
        array(
          'table' => '(SELECT Candidato.carpeta_cve, count(Candidato.candidato_cve) count
            FROM tcarpetaxcandidato Candidato
            INNER JOIN tcuentacandidato C on (
              C.candidato_cve = Candidato.candidato_cve AND C.cc_status = 1
            )
            WHERE Candidato.candidato_cve NOT IN (SELECT
              DISTINCT (candidato_cve) FROM tdenunciascv WHERE denuncia_status < 3 AND cia_cve = (SELECT cia_cve FROM tusuxcia U
                WHERE Candidato.cu_cve = U.cu_cve
              )
            )
            GROUP BY Candidato.carpeta_cve)',
          'alias' => 'Candidato',
          'fields' => array(
            'nvl(Candidato.count,0) Carpeta__total'
          ),
          'type' => 'LEFT',
          'conditions' => array(
            'Carpeta.carpeta_cve = Candidato.carpeta_cve'
          )
        )
      );

      $query['conditions'][$this->alias . '.tipo_cve'] = self::$tipo['candidato'];
    }

    return $this->_findDependents($state, $query, $results);
  }

  /**
   * Encuentra las carpetas de mensajes.
   * @param  [type] $state   [description]
   * @param  [type] $query   [description]
   * @param  array  $results [description]
   * @return [type]          [description]
   */
  protected function _findMensajes($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['joins'] = array(
        array(
          'table' => '(SELECT MensajeData.carpeta_cve, NVL(count(MensajeData.receptormsj_cve),0) count
            FROM treceptormsj MensajeData WHERE MensajeData.msj_status >= 0 GROUP BY MensajeData.carpeta_cve)',
          'alias' => 'MensajeData',
          'fields' => array(
            'nvl(MensajeData.count,0) Carpeta__total'
          ),
          'type' => 'LEFT',
          'conditions' => array(
            'Carpeta.carpeta_cve = MensajeData.carpeta_cve'
          )
        )
      );

      $query['conditions'][$this->alias . '.tipo_cve'] = self::$tipo['mensajes'];
    }

    return $this->_findDependents($state, $query, $results);
  }

  /**
   * Obtiene los folders del usuario, sí se específica un tipo, retornará esos folders.
   * @param  [type] $userId [description]
   * @param  [type] $type   [description]
   * @return [type]         [description]
   */
  public function getFolders($userId, $type = null) {
    $foldersKeys = array('candidatos', 'mensajes', 'ofertas');
    $folders = array();

    if (!is_null($type)) {
      $foldersKeys = array($type);
    }

    foreach ($foldersKeys as $value) {
      $folders[$value] = $this->get($value, array(
        'conditions' => array(
          $this->alias . '.cu_cve' => $userId,
        ),
        //'nest' => true, // Esta opción hace que las carpetas se obtengan en forma de árbol.
        'order' => array(
          'Carpeta.carpeta_nombre' => 'ASC'
        )
      ));
    }

    return is_null($type) ? $folders : $folders[$type];
  }

  public function getTipos() {
    return self::$tipo;
  }

  public function getParents($userId, $findType = 'dependents') {
    $results = parent::get(null, $findType, array(
      'conditions' => array(
        $this->alias . '.cu_cve' => $userId,
        $this->alias . '.nivel_max <=' => 2
      ),
      'fields' => array(
        'Carpeta.carpeta_cve',
        'Carpeta.carpeta_nombre',
      )
    ));

    return Hash::combine($results, '{n}.Carpeta.carpeta_cve', '{n}.Carpeta.carpeta_nombre');
  }

  public function getByUser($userId, $findType = 'dependents') {
    $results = parent::get(null, $findType, array(
      'conditions' => array(
        $this->alias . '.cu_cve' => $userId
      ),
      'fields' => array(
        'Carpeta.carpeta_cve',
        'Carpeta.carpeta_nombre',
      )
    ));

    return Hash::combine($results, '{n}.Carpeta.carpeta_cve', '{n}.Carpeta.carpeta_nombre');
  }

  public function getLevel($id) {
    $level = $this->field('nivel_max',array(
      'Carpeta.carpeta_cve' => $id
    ));

    return $level ?: 1;
  }

  /**
   * Obtiene los identificadores de las carpetas del usuario.
   * @param  [type]  $parent [description]
   * @param  [type]  $userId [description]
   * @param  integer $type   [description]
   * @return [type]          [description]
   */
  public function getIDs($parent = null, $userId = null, $type = 0) {
    $results = $this->find('dependents', array(
      'fields' => array('Carpeta.carpeta_cve'),
      'parent' => $parent,
      'conditions' => array(
        'Carpeta.cu_cve' => $userId,
        'Carpeta.tipo_cve' => $type
      )
    ));

    $ids = Hash::extract($results, '{n}.Carpeta.carpeta_cve');

    return $ids;
  }

  /**
   * Borra todas las carpetas dependientes.
   * @param  [type] $id [description]
   * @return [type]     [description]
   */
  public function deleteDependents($id) {
    $results = $this->find('dependents', array(
      'fields' => array('Carpeta.carpeta_cve'),
      'parent' => $id
    ));
    $ids = Hash::extract($results, '{n}.Carpeta.carpeta_cve');

    return $this->deleteAll(array(
      'Carpeta.carpeta_cve' => $ids
    ));
  }

  public function beforeSave($options = array()) {
    $level = 1;
    if (!empty($this->data[$this->alias]['carpeta_cvesup'])) {
      $parentId = $this->data[$this->alias]['carpeta_cvesup'];
      $level += (int)$this->getLevel($parentId);
    }
    $this->data[$this->alias]['nivel_max'] = $level;

    return parent::beforeSave($options);
  }

  public function afterFind($results, $primary = false) {
    foreach ($results as $key => $c) {
      if (isset($c[$this->alias]['tipo_cve'])) {
        $tipo = array_search((int)$c[$this->alias]['tipo_cve'], self::$tipo);

        $results[$key][$this->alias]['tipo_text'] = $tipo;
      }
    }

    return $results;
  }

  public function uniqueName($check) {
    $nameKey = 'carpeta_nombre';
    $name = $check[$nameKey];
    return !$this->hasAny(array(
      $this->alias . '.' . $nameKey => $name,
      $this->alias . '.' . 'cu_cve' => $this->data[$this->alias]['cu_cve'],
      $this->alias . '.' . 'tipo_cve' => $this->data[$this->alias]['tipo_cve'],
    ));
  }
}
<?php

App::uses('UsuarioAdminEmpresa', 'Model');
App::uses('Acceso', 'Utility');

/**
 *
 */
class UsuarioEmpresa extends UsuarioAdminEmpresa {
  /**
   * [$actsAs description]
   * @var array
   */
  public $actsAs = array('Containable');

  public $findMethods = array(
    'dependents' => true,
    'dependents_with_credits' => true,
    'by_empresa' => true,
    'data' => true
  );

  public $belongsTo = array(
    // 'Membresia' => array(
    //   'className' => 'Membresia',
    //   'foreignKey' => false,
    //   'conditions' => array(
    //     'Membresia.per_cve = trunc(UsuarioEmpresa.per_cve/100)*100',
    //   ),
    //   'fields' => array(
    //     'Membresia.per_cve Perfil__base_perfil',
    //     'Membresia.membresia_tipo Perfil__membresia_tipo',
    //     'Membresia.membresia_clase Perfil__membresia_cls',
    //     '(CASE WHEN Membresia.per_cve = 100 THEN \'Básica\' ELSE Membresia.membresia_nom END) Perfil__membresia'
    //   )
    // ),
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
   * [$hasMany description]
   * @var array
   */
  public $hasMany = array(
    'Oferta' => array(
      'className' => 'Oferta',
      'foreignKey' => 'cu_cve'
    ),
    'Credito' => array(
      'className' => 'Credito',
      'foreignKey' => 'cu_cve'
    ),
    'Carpeta' => array(
      'className' => 'Carpeta',
      'foreignKey' => 'cu_cve'
    )
  );

  public $hasAndBelongsToMany = array(
    'Empresa' => array(
      'className' => 'Empresa',
      //'joinTable' => 'tcuentaxciane',
      'with' => 'EmpresasUsuarios',
      'foreignKey' => 'cu_cve',
      'associationForeignKey' => 'cia_cve',
      'unique' => false
    )
  );

  public $validate = array(
    'cu_sesion' => array(
      'email' => array(
        'rule' => 'email',
        'allowEmpty' => false,
        'required' => true,
        'message' => 'Por favor, ingresa un email válido.'
      ),
      'unique' => array(
        'rule' => 'isUnique',
        'message' => 'Ya existe un usuario registrado con este email.'
      )
    ),
    'cu_sesion_confirm' => array(
      'required'=> array(
        'rule' => 'notEmpty',
        'required' => true,
        'message'    => 'Debes confirmar tu correo electrónico.'
      ),
      'equalto'=> array(
        'rule' => array('equalTo', 'cu_sesion'),
        'message' => 'Parece que no coinciden ambos correos electrónicos.'
      )
    ),
    'new_password' => array(
      'required'=> array(
        'rule' => 'notEmpty',
        'required' => true,
        'message'    => 'Ingresa una contraseña.'
      ),
      'minlength' => array(
        'rule'=> array('minLength',8 ),
        'message' => 'Ingresa una contraseña mínimo de 8 caracteres.'
      ),
     'maxlength' => array(
        'rule'=> array('maxLength',15),
        'message' => 'Ingresa una contraseña máximo de 15 caracteres.'
      ),
     'alphanumeric' => array(
        'rule'=> array('alphaNumeric'),
        'message' => 'Verifica que tu contraseña esté conformada por letras y números.'
      )
    ),
    'confirm_password' => array(
      'required' => array(
        'rule' => 'notEmpty',
        'required' => true,
        'message'    => 'Ingresa una nueva contraseña.'
      ),
      'equalto' => array(
        'rule'   => array('equalTo', 'new_password'),
        'message'    => 'Ingresa de nuevo la contraseña.'
      )
    ),
  );

  /**
   * Actualiza el perfil del usuario.
   * @param  [type] $userId  [description]
   * @param  [type] $ciaId   [description]
   * @param  [type] $profile [description]
   * @return [type]          [description]
   */
  public function updateProfile($userId, $ciaId = null, $profile = null) {
    $minProfileIndex = Acceso::profiles('basic', 'min');

    if (is_null($profile)) {
      if (is_null($ciaId)) {
        $ciaId = '(SELECT cia_cve FROM tusuxcia WHERE cu_cve = ' . $userId . ')';
      }

      $profile = 'NVL(MOD(per_cve,' . $minProfileIndex . ') + (SELECT
        MAX(per_cve) max_perfil
        FROM
          tperfilxmembresia
        WHERE
          cia_cve = ' . $ciaId . ' AND
          fec_fin > CURRENT_DATE
      ),' . $minProfileIndex . '+MOD(per_cve,100))';
    }

    return $this->updateAll(array(
      'per_cve' => $profile
    ), array(
      'cu_cve' => $userId
    ));
  }

  public function getBaseProfile($userId) {
    $minProfileIndex = Acceso::profiles('basic', 'min');
    $results = $this->query('SELECT
        NVL(MAX(per_cve),' . $minProfileIndex . ') Perfil__max_perfil
      FROM tperfilxmembresia
      WHERE
        cia_cve = (SELECT cia_cve FROM tusuxcia WHERE cu_cve = ' . $userId . ') AND
        fec_fin > CURRENT_DATE
    ');

    return $results[0]['Perfil']['max_perfil'] ?: $minProfileIndex;
  }

  public function _findBy_empresa($state, $query, $results = array()) {
    if ($state === 'before') {
      $query['joins'] = array(
        array(
          'table' => 'tusuxcia',
          'alias' => 'EmpresasUsuarios',
          'type' => 'INNER',
          'conditions' => array(
            'EmpresasUsuarios.cia_cve = ' . $query['empresaId'],
            'EmpresasUsuarios.cu_cve = UsuarioEmpresa.cu_cve'
          )
        )
      );

      // $query['fields'] = array(
      //   'UsuarioEmpresa.cu_cve', 'UsuarioEmpresa.cu_sesion', 'UsuarioEmpresa.cu_status', 'UsuarioEmpresa.per_cve',
      //   'UsuarioEmpresa.keycode', 'UsuarioEmpresa.cu_cvesup', 'UsuarioEmpresa.created', 'UsuarioEmpresa.modified',
      // );

      // if (!isset($query['conditions'])) {
      //   $query['coditions'] = array();
      // }

      //$query['conditions']['EmpresasUsuarios.cia_cve']  = $query['empresaId'];
      $query['contain'] = array(
        'Perfil' => array(
          'fields' => array('Perfil.per_cve', 'Perfil.per_nom', 'Perfil.per_descrip')
        ),
        'Contacto' => array(
          'fields' => array('cu_cve', 'Contacto.con_nombre || \' \' || Contacto.con_paterno as nombre')
        ),
      );

      $query['recursive'] = -1;
      return $query;
    }
    return $results;
  }

  public function _findDependents_with_credits($state, $query, $results = array()) {
    $parentResults = $this->_findDependents($state, $query, $results);

    if ($state === 'after') {
      $creditos = $this->Credito->getByEmpresa(
        $query['cia'], $query['parent']
      );

      foreach ($parentResults as $k => $u) {
        $id = $u['UsuarioEmpresa']['cu_sesion'];
        $parentResults[$k]['Creditos'] = !empty($creditos[$id]) ? $creditos[$id] : array();
      }
    }

    return $parentResults;
  }

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
    * Retorna la empresa a la que pertenece el usuario.
    */
  public function getEmpresaByUserId($id, $onlyData = false) {
    $results = $this->Empresa->find('first', array(
      'recursive' => -1,
      'joins' => array(
        array(
          'table' => 'tusuxcia',
          'alias' => 'EmpresasUsuarios',
          'type' => 'INNER',
          'conditions' => array(
            'EmpresasUsuarios.cu_cve = ' . $id,
            'EmpresasUsuarios.cia_cve = Empresa.cia_cve'
          )
        )
      )
    ));

    return $onlyData ? $results['Empresa'] : $results;
  }

  /**
   * Obtiene los datos de Ofertas, Candidatos y Mensajes. Si $type es null,
   * obtendrá la información de candidatos, mensajes y ofertas. En otro caso obtendrá
   * la información del tipo que se especifique.
   * @param  int    $id     Id del usuario.
   * @param  int    $ciaId  Id de la compañia.
   * @param  string $type   Tipo.
   * @return array          Datos.
   */
  public function getStats($id, $ciaId, $type = null) {
    $all = is_null($type);
    $stats = array();
    $folders = $this->Carpeta->getFolders($id, $type);

    if ($all || $type === 'ofertas') {
      $stats['ofertas'] = array(
        'stats' => $this->Oferta->getStatusStats($id, $ciaId),
        'folders' => $all ? $folders['ofertas'] : $folders
      );
    }

    if ($all || $type === 'candidatos') {
      $stats['candidatos'] = array(
        'stats' => ClassRegistry::init('CandidatoEmpresa')->getStats($id, $ciaId),
        'folders' => $all ? $folders['candidatos'] : $folders
      );
    }

    if ($all || $type === 'mensajes') {
      $stats['mensajes'] = array(
        'stats' => ClassRegistry::init('Mensaje')->getStats($id),
        'folders' => $all ? $folders['mensajes'] : $folders
      );
    }

    if ($all || $type === 'productos') {
      $stats['productos'] = array(
        'stats' => ClassRegistry::init('Factura')->getStats($id, $ciaId),
        // 'folders' => $all ? $folders['mensajes'] : $folders
      );
    }

    return $all ? $stats : $stats[$type];
  }

  public function getCoordinadores($userId) {
    return $this->find('dependents', array(
      'conditions' => array(
        'MOD(UsuarioEmpresa.per_cve,100) < 2'
      ),
      'fields' => array('cu_cve', 'cu_sesion', 'per_cve'),
      'recursive' => -1,
      'parent' => $userId,
      'format' => 'cuenta'
    ));
  }

  public function registrar($data, $perfil = null, $usuarioSuperior = array()) {
    /**
      * Reinica los valores por default del Usuario y limpia el id.
      */
    $this->create();

    $this->email = $data[$this->alias]['cu_sesion'];
    $this->password = Funciones::generar_clave(8);
    $minProfileIndex = Acceso::profiles('basic', 'min');

    $formatedData = array(
      'UsuarioEmpresa' => array(
        'cu_sesion' =>  $this->email,
        'cu_sesion_confirm' =>  $data[$this->alias]['cu_sesion_confirm'],
        'cu_password' => $this->password,
        'new_password' => $this->password, // Validación
        'confirm_password' => $this->password, // Validación
        // Si no se específica un usuario superior, será el administrador.
        'cu_cvesup' => isset($usuarioSuperior['cu_cve']) ? $usuarioSuperior['cu_cve'] : (
          is_numeric($usuarioSuperior) ? (int)$usuarioSuperior : 1),
        // Por default, el usuario está desactivado.
        $this->statusKey => -1,
        // Por default, el perfil del usuario es 100, plan básico.
        'per_cve' => (is_null($perfil) || $perfil < $minProfileIndex) ? $minProfileIndex : $perfil,
      ),
      'Contacto' => $data['UsuarioEmpresaContacto'] /*array(
        'con_nombre' => $data['UsuarioEmpresaContacto']['con_nombre'],
        'con_paterno' => $data['UsuarioEmpresaContacto']['con_paterno'],
        'con_materno' => $data['UsuarioEmpresaContacto']['con_materno'],
        'con_ubicacion' => $data['UsuarioEmpresaContacto']['con_ubicacion'],
        'con_tel' => $data['UsuarioEmpresaContacto']['con_tel'],
        'con_ext' => $data['UsuarioEmpresaContacto']['con_ext']
      )*/,
    );

    /**
      * Si se pasa el id de la empresa, significa que se agregara el usuario a una empresa existente.
      */
    if (!empty($usuarioSuperior['Empresa'])) {
      $formatedData['Empresa'] = array(
        array(
          'cia_cve' => $usuarioSuperior['Empresa']['cia_cve'],
        )
      );
    }

    return $this->saveAll($formatedData, array('validate' => 'first'));
  }

  public function editar($data, $userId = null) {
    $success = false;

    if ($userId) {
      $this->id = $userId;
    }

    $userData = array(
      'per_cve' => $data[$this->alias]['per_cve'],
      'cu_cvesup' => $data[$this->alias]['cu_cvesup']
    );

    $this->begin();

    $updateSubs = true;
    // Si el perfil nuevo va a ser reclutador, sus subordinados
    // cambian al superior de éste.
    if ($data[$this->alias]['per_cve'] % 100 === 2) {
      $updateSubs = $this->updateSubsToSuper($this->id);
    }

    if ($updateSubs && $this->save($userData, false, array('per_cve', 'cu_cvesup'))) {
      $this->Contacto->id = $this->id;
      $contactoData = $data['Contacto'];
      if ($this->Contacto->save($contactoData)) {
        $this->commit();
        $success = true;
      }
    }
    !$success && $this->rollback();

    return $success;
  }

  public function beforeFind($queryData = array()) {
    if (empty($queryData['nextId'])) {
      $queryData['conditions']['UsuarioEmpresa.per_cve >='] = Acceso::profiles('basic', 'min');
    }

    return parent::beforeFind($queryData);
  }

  public function afterFind($results, $primary = false) {
    foreach ($results as $k => $u) {
      if (!empty($u[$this->alias]['per_cve']) && isset($u['Perfil'])) {
        $perfil = $u['Perfil']['per_nom'];
        if (empty($perfil)) {
          $perfil = Acceso::checkRole(null, $u[$this->alias]['per_cve']);
        }

        $results[$k]['Perfil']['per_nom'] = ucwords($perfil);
      }
    }

    return parent::afterFind($results, $primary);
  }

  public function hasContent($userId, $content = array()) {
    $hasOfertas = $this->Oferta->hasAny(array(
      'Oferta.cu_cve' => $userId
    ));

    $hasEventos = ClassRegistry::init('Evento')->hasAny(array(
      'Evento.cu_cve' => $userId
    ));

    $hasCreditos = $this->Credito->hasAny(array(
      'Credito.cu_cve' => $userId,
      'Credito.fec_fin > CURRENT_DATE'
    ));

    $userContent = array(
      'eventos' => $hasEventos,
      'ofertas' => $hasOfertas,
      'creditos' => $hasCreditos
    );

    return $userContent;
  }

  public function activar($id) {
    $success = $this->cambiar_status((int)$id, 1);

    if (false) {
      $empresa = $this->getEmpresaByUserId($id, true);

      /**
       * Si existe el perfil de esa membresía para la empresa (ver: PerfilMembresia [tperfilxmembresia])
       * no asigna la membresía.
       */
      if (!$this->Membresia->PerfilMembresia->hasAny(array(
        'membresia_cve' => 17,
        'cia_cve' => $empresa['cia_cve']
      ))) {
        // Asigna la membresía a la empresa y al usuario (admin de la empresa).
        $this->Membresia->assign(17, $empresa['cia_cve'], $empresa['cu_cve'], null);
      }
    }

    return $success;
  }

  public function eliminar($userId, $reassigments = array()) {

    $this->begin();
    $success = $this->cambiar_status($userId, -2);
    if ($success) {
      /**
       * Cuando haya nada que actualizar o no se tenga el id a reasignar establecerá las variables
       * $update...ToSuper a true para realizar el commit.
       * @var [type]
       */
      $updateCuentasToSuper = empty($reassigments['cuentas']) || $this->updateSubsToSuper($userId, $reassigments['cuentas']);

      $updateOfertasToSuper = empty($reassigments['ofertas']) || $this->Oferta->updateAll(array(
        'Oferta.cu_cve' => $reassigments['ofertas']
      ), array(
        'Oferta.cu_cve' => $userId
      ));

      $updateCreditosToSuper = empty($reassigments['creditos']) || $this->Credito->updateAll(array(
        'Credito.cu_cve' => $reassigments['creditos']
      ), array(
        'Credito.cu_cve' => $userId,
        'Credito.fec_fin > CURRENT_DATE'
      ));

      $updateEventosToSuper = empty($reassigments['eventos']) || ClassRegistry::init('Evento')->updateAll(array(
        'Evento.cu_cve' => $reassigments['eventos']
      ), array(
        'Evento.cu_cve' => $userId
      ));

      if ($updateCuentasToSuper && $updateOfertasToSuper && $updateCreditosToSuper && $updateEventosToSuper) {
        $this->commit();
        $success = true;
      } else {
        $this->rollback();
        $success = false;
      }
    }

    return $success;
  }

  public function beforeSave($options = array()) {
    if(isset($this->data[$this->alias]['password'])) {
      $this->data[$this->alias]['cu_password'] = $this->data[$this->alias]['password'];
    }

    return parent::beforeSave($options);
  }
}
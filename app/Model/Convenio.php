<?php

App::uses('AppModel', 'Model');
App::uses('CakeEvent', 'Event');
App::uses('ConvenioListener', 'Event');
App::uses('ProductosListener', 'Event');

class Convenio extends AppModel {

  /**
   * Utiliza el comportamiento: Containable
   * @var array
   */
  public $actsAs = array('Containable');

  /**
   * tabla
   * @var string
   */
  public $useTable = 'tconvenios';

  public $hasMany = array(
    'Condiciones' => array(
      'className' => 'ConvenioCondicion',
      'foreignKey' => 'cia_cve',
      'finderQuery' => 'SELECT
        Condiciones.cia_cve,
        Condiciones.conveniocondicion_cve,
        Condiciones.condicion,
        Condiciones.descripcion
        FROM tconveniocondiciones Condiciones
        LEFT JOIN tcatalogo Catalogo ON (
          Catalogo.ref_opcgpo = \'CONVENIO\' AND
          Catalogo.opcion_valor = Condiciones.condicion
        )
        WHERE Condiciones.cia_cve IN ({$__cakeID__$})
      '
    )
  );

  /**
   * Llave primaria
   * @var string
   */
  public $primaryKey = 'cia_cve';

  public $belongsTo = array(
    'Empresa' => array(
      'className' => 'Empresa',
      'foreignKey' => 'cia_cve'
    )
  );

  public $knows = array(
    // 'Empresa',
    'Membresia'
  );

  public function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);

    $this->status = array(
      'finalizado' => array(
        'val' => -1,
        'text' => __('Finalizado')
      ),
      'contactar' => array(
        'val' => 0,
        'text' => __('Contactar')
      ),
      'revision' => array(
        'val' => 1,
        'text' => __('En revisión')
      ),
      'cerrado' => array(
        'val' => 2,
        'text' => __('Cerrado')
      ),
      'fallido' => array(
        'val' => 3,
        'text' => __('Fallido')
      ),
    );

    // Agrega ProductosListener al manejador de eventos.
    $pListener = new ProductosListener();
    $cListener = new ConvenioListener();
    $this->getEventManager()->attach($pListener);
    $this->getEventManager()->attach($cListener);

  }

  public function getLast($options = array()) {
    $options = array_merge($options, array(
      'limit' => 5,
      'status' => 2
    ));

    return $this->find('all', array(
      'limit' => $options['limit'],
      'contain' => array(
        'Empresa'
      ),
      'conditions' => array(
        $this->alias . '.convenio_status' => 2
      ),
      'order' => array(
        'Empresa.created' => 'DESC'
      )
    ));
  }

  /**
   * Guarda las condiciones del convenio.
   * @param  [type] $empresaId   [description]
   * @param  array  $condiciones [description]
   * @return [type]              [description]
   */
  public function saveCondiciones($empresaId, $condiciones = array()) {
    $success = true;

    $this->begin();
    if (!empty($condiciones['membresia']['item'])) {
      $this->id = $empresaId;
      $status = $this->field('convenio_status');
      if ($status < 2) {
        $success = $this->saveField('membresia_cve', $condiciones['membresia']['item']);
      }
    }

    if ($success) {
      $data = array();
      foreach ($condiciones['Convenio'] as $key => $value) {
        $data[] = array(
          'cia_cve' => $empresaId,
          'condicion' => $value['item'],
          'descripcion' => $value['desc']
        );
      }

      /**
       * Debido a que no se tiene un status en las condiciones, cuando se desactive una se tiene que borrar.
       * Para facilitar el trabajo, cada vez que se edite, se borran las condiciones de la empresa y se vuelven a
       * registrar de nuevo. Tal vez esto sea un poco más eficiente que buscar cuáles borrar, editar las que se
       * modificaron y agregar las nuevas.
       */
      $success = $this->Condiciones->deleteAll(array(
        'cia_cve' => $empresaId
      )) && $this->Condiciones->saveAll($data);

      if ($success) {
        $this->commit();
      } else {
        $this->rollback();
      }
    }

    return $success;
  }

  public function change_status($status, $id = null) {
    if (!$id) {
      $id = $this->id;
    }

    $data = array(
      $this->primaryKey => $id,
      'convenio_status' => $status
    );

    $this->begin();
    $success = $this->save($data, false, array('convenio_status'));

    if ($success) {
      $empresa = $this->Empresa->get($id, 'basic_info');
      if ((int)$status === 1) { // Revision
        if (!empty($empresa)) {
          $event = new CakeEvent('Model.Convenio.revision', $this, array(
            'id' => $id,
            'data' => $empresa['Empresa']
          ));

          $this->getEventManager()->dispatch($event);
        }
      } elseif ((int)$status === 2) { // Cerrado, aquí se activa la membresía.
        $success = $this->asignarMembresia($id);

        if (!empty($empresa) && $success) {
          /**
           * Id del Admin de la empresa.
           * @var [type]
           */
          $userId = $empresa['Admin']['cu_cve'];

          /**
           * Actualizamos su perfil.
           */
          $this->Empresa->Administrador->updateProfile($userId);

          $perfil = $this->Empresa->Administrador->Perfil->getProfile(
            $userId,
            $id
            // $this->Auth->user('per_cve')
          );

          $event = new CakeEvent('Model.Productos.servicios_activados', $this, array(
            'empresa' => $empresa,
            'session_data' => array(
              'perfilId' => $perfil['per_cve'],
              'perfil' => $perfil,
              'creditos' => $this->Membresia->Credito->getByUser(
                $userId,
                $id
              )
            )
          ));

          $this->getEventManager()->dispatch($event);
        }
      }
    }

    $success && $this->commit();
    !$success && $this->rollback();

    return $success;
  }

  public function asignarMembresia($empresaId) {
    /**
     * Obetenemos el adminsitrador
     * @var [type]
     */
    $admin = $this->Empresa->getAdmin($empresaId);
    $userId = $admin['Empresa']['cu_cve'];

    /**
     * Obtenemos la membresia.
     */
    $this->id = $empresaId;
    $membresiaId = $this->field('membresia_cve');

    return ($membresiaId && $userId) ? $this->Membresia->assign($membresiaId, $empresaId, $userId, null, array(
      'save' => true
    )) : false;
  }

  /**
   * [hasMembresia description]
   * @param  [type]  $empresaId [description]
   * @return boolean            [description]
   */
  public function hasMembresia($empresaId = null) {
    if ($empresaId) {
      $this->id = $empresaId;
    }

    return (bool)$this->field('membresia_cve');
  }

  /**
   * Finalizar convenio
   * @param  array  $data [description]
   * @return [type]       [description]
   */
  public function finalizar($data = array()) {
    /**
     * Finalizar un convenio implica inactivar todos los datos de la empresa:
     * Usuarios, Ofertas, Eventos, Evaluaciones.
     */
    $empresaId = $data['empresa_id'];
    $success = true;
    /**
     * Inicia la transacción para borrar todos los datos de la compañia.
     */
    $this->begin();

    $Empresa = ClassRegistry::init('Empresa');
    $Empresa->begin();
    // Inactiva a los usuarios.
    if ($success && $Empresa->inactivarUsuarios($empresaId, -2)) {
      $success = true;
      $Empresa->commit();
    } else {
      $success = false;
    }


    $Oferta = ClassRegistry::init('Oferta');
    $Oferta->begin();
    // Marca como borradas las ofertas.
    if ($success && $Oferta->updateAll(array(
      'oferta_inactiva' => -3 // Borradas
    ), array(
      'cia_cve' => $empresaId
    ))) {
      $success = true;
      $Oferta->commit();
    } else {
      $success = false;
    }

    $Evento = ClassRegistry::init('Evento');
    $Evento->begin();
    // Marca los eventos como inactivos
    if ($success && $Evento->updateAll(array(
      'evento_status' => -1 // Inactivos
    ), array(
      'cia_cve' => $empresaId
    ))) {
      $success = true;
      $Evento->commit();
    } else {
      $success = false;
    }

    $Evaluacion = ClassRegistry::init('Evaluacion');
    $Evaluacion->begin();
    // Marca las evaluaciones como inactivas
    if ($success && $Evaluacion->updateAll(array(
      'evaluacion_status' => -2 // Inactivos
    ), array(
      'cia_cve' => $empresaId
    ))) {
      $success = true;
      $Evaluacion->commit();
    } else {
      $success = false;
    }

    // Finalmente cambiamos el status del convenio.
    $this->id = $empresaId;
    $success = $success && $this->saveField('convenio_status', -1);

    if ($success) {
      $this->commit();
    } else {
      $this->rollback();
    }

    return $success;
  }
}
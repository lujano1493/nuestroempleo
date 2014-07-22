<?php

App::uses('BaseEmpresasController', 'Controller');
/**
 * Controlador general de la aplicación.
 */
class CarpetasController extends BaseEmpresasController {

  /**
    * Componentes necesarios que utiliza el Controlador.
    * @var Array
    */
  public $components = array('Session');

  protected function updateSession($type = null) {
    $this->Session->write('Auth.User.Stats', ClassRegistry::init('UsuarioEmpresa')->getStats(
      $this->Auth->user('cu_cve'), $this->Auth->user('Empresa.cia_cve')
    ));
  }

  /**
    * Método que se ejecuta antes de cualquier acción.
    */
  public function beforeFilter() {
    parent::beforeFilter();
    /**
      * Acciones que no necesitan autenticación.
      */
    $allowActions = array();

    $this->Auth->allow($allowActions);
  }

  public function index() {

    $options = array(
      'conditions' => array(
        'Carpeta.cu_cve' => ClassRegistry::init('UsuarioEmpresa')->getIds('dependents', array(
          'parent' => $this->Auth->user('cu_cve')
        ))
      ),
      'contain' => array('Usuario', 'Contacto'),
      'findType' => 'dependents',
      // 'nest' => array(
      //   'idPath' => '{n}.Carpeta.carpeta_cve',
      //   'parentPath' => '{n}.Carpeta.carpeta_cvesup',
      // ),
      'order' => false,
      'recursive' => -1
    );

    $this->paginate = $options;

    $carpetas = $this->paginate();
    $this->set(compact('carpetas'));
  }

  public function mensajes() {

    $this->paginate = array(
      'conditions' => array(
        'Carpeta.cu_cve' => $this->Auth->user('cu_cve'),
      ),
      'contain' => array('Usuario', 'Contacto'),
      'findType' => 'mensajes',
      // 'nest' => array(
      //   'idPath' => '{n}.Carpeta.carpeta_cve',
      //   'parentPath' => '{n}.Carpeta.carpeta_cvesup',
      // ),
      'Carpeta.carpeta_nombre' => 'ASC'
    );

    $carpetas = $this->paginate();
    $this->set(compact('carpetas'));
    $this->render('index');
  }

  public function candidatos() {

    $this->paginate = array(
      'conditions' => array(
        'Carpeta.cu_cve' => $this->Auth->user('cu_cve'),
      ),
      'contain' => array('Usuario', 'Contacto'),
      'findType' => 'candidatos',
      // 'nest' => array(
      //   'idPath' => '{n}.Carpeta.carpeta_cve',
      //   'parentPath' => '{n}.Carpeta.carpeta_cvesup',
      // ),
      'Carpeta.carpeta_nombre' => 'ASC'
    );

    $carpetas = $this->paginate();
    $this->set(compact('carpetas'));
    $this->render('index');
  }

  public function ofertas() {
    $this->paginate = array(
      'conditions' => array(
        'Carpeta.cu_cve' => $this->Auth->user('cu_cve'),
      ),
      'contain' => array('Usuario', 'Contacto'),
      'findType' => 'ofertas',
      // 'nest' => array(
      //   'idPath' => '{n}.Carpeta.carpeta_cve',
      //   'parentPath' => '{n}.Carpeta.carpeta_cvesup',
      // ),
      'Carpeta.carpeta_nombre' => 'ASC'
    );

    $carpetas = $this->paginate();
    $this->set(compact('carpetas'));
    $this->render('index');
  }

  public function lista($type) {
    $types = array('ofertas', 'candidatos', 'mensajes');

    $carpetas = $this->Carpeta->find($types[$type], array(
      'conditions' => array(
        'Carpeta.cu_cve' => $this->Auth->user('cu_cve'),
        'Carpeta.nivel_max < 3'
      ),
      'order' => false
    ));

    $this->set(compact('carpetas'));
  }

  public function nueva() {
    $this->set('title_for_layout', 'Nueva carpeta');
    if ($this->request->is('post')) {
      $data = $this->request->data;
      $data['Carpeta']['cu_cve'] = $this->Auth->user('cu_cve');

      $data['Carpeta']['carpeta_cvesup'] = null;

      $this->Carpeta->create();
      if ($this->Carpeta->save($data)) {
        $this->success('Se ha creado con éxito tu carpeta.');
        $this->updateSession();
        $this->redirect(array('action' => 'index'));
      } else {
        $this->error('Ha ocurrido un problema al crear tu carpeta');
      }
    }
    $carpetas = $this->Carpeta->getParents($this->Auth->user('cu_cve'));
    $tipos = array_flip($this->Carpeta->getTipos());
    $this->set(compact('carpetas', 'tipos'));
  }

  public function cambiar_nombre($carpetaId) {
    $userId = $this->Auth->user('cu_cve');
    $isOwnedBy = $this->Carpeta->isOwnedBy($userId, $carpetaId, array(
      'fields' => array(
        'tipo_cve'
      )
    ));

    if ($isOwnedBy) {
      $name = $this->request->data['name'];

      if ($this->Carpeta->hasAny(array(
        'carpeta_nombre' => $name,
        'cu_cve' => $userId,
        'tipo_cve' => $isOwnedBy['Carpeta']['tipo_cve'],
      ))) {
        $this->error(__('Ya existe el nombre de esa carpeta. Intenta con otro.'));
      } else {
        $this->Carpeta->id = $carpetaId;
        if ($this->Carpeta->save(array(
          'carpeta_nombre' => $name,
          'cu_cve' => $userId,
          'tipo_cve' => $isOwnedBy['Carpeta']['tipo_cve'],
        ), true, array('carpeta_nombre'))) {
          $this->updateSession();
          $this->success(__('Se renombró con exito la carpeta.'));
        } else {
          $this->error(__('Ocurrió un error al intentar actualizar la carpeta.'));
        }
      }
    } else {
      $this->error(__('No puedes cambiar el nombre de la carpeta.'));
    }
  }

  public function borrar($id = null) {
    $isOwnedBy = $this->Carpeta->isOwnedBy($this->Auth->user('cu_cve'), $id, array(
      'fields' => array(
        'tipo_cve', 'carpeta_nombre'
      )
    ));

    // debug($isOwnedBy);die;
    if ($isOwnedBy) {
      $this->Carpeta->begin();

      $isCarpetaOferta = (int)$isOwnedBy['Carpeta']['tipo_cve'] === 0;
      if ($isCarpetaOferta) { // Carpeta Ofertas
        ClassRegistry::init('Oferta')->resetFolder($isOwnedBy['Carpeta']['carpeta_cve']);
      } else {
        ClassRegistry::init('CarpetasCandidatos')->deleteAll(array(
          'carpeta_cve' => $isOwnedBy['Carpeta']['carpeta_cve']
        ));
      }

      if ($this->Carpeta->deleteDependents($id)) {
        $this->Carpeta->commit();
        $successMsg = __('La carpeta %s ha sido borrada', $isOwnedBy['Carpeta']['carpeta_nombre']);

        $this->updateSession();

        $this
          ->success($successMsg)
          ->callback('deleteRow')
          ->html('element', $isCarpetaOferta ? 'empresas/submenus/ofertas' : 'empresas/submenus/candidatos');
      } else {
        $this->Carpeta->rollback();
        $this->error('La carpeta no se ha podido borrar.');
      }
    } else {
      $this->error('No tienes los permisos para está acción.');
    }
    $this->redirect(array(
      'controller' => 'carpetas',
      'action' => 'index'
    ));
  }

}
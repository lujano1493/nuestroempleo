<?php

App::uses('BaseEmpresasController', 'Controller');

class MembresiasController extends BaseEmpresasController {
  public $name = 'Membresias';

  //public $uses = array('Membresia');

  /**
    * Método que se ejecuta antes de cualquier acción.
    */
  public function beforeFilter() {
    parent::beforeFilter();
    // $this->layout = 'home';

    // if (!empty($this->params['prefix']) && ($this->params['prefix'] == 'admin')) {
    //   $this->layout = 'admin/home';
    // }

    /**
      * Acciones que no necesitan autenticación.
      */
    $allowActions = array('index');

    $this->Auth->allow($allowActions);
  }

  public function index() {

  }

  public function admin_index() {
    // $this->paginate = array(
    //   'findType' => 'detalles',
    // );
    //$membresias = $this->paginate();
    $membresias = $this->Membresia->find('detalles', array(
    ));

    $this->set(compact('membresias'));
  }

  public function admin_editar($id = null) {
    $title_for_layout = __('Edición de Membresías');

    $membresia = $this->Membresia->find('first', array(
      'conditions' => array(
        'Membresia.membresia_cve' => $id
      )
    ));


    $this->request->data = $membresia;

    $duracion = ClassRegistry::init('Catalogo')->lista('duracion');
    $clases = ClassRegistry::init('Catalogo')->lista('membresia_clase', array(
      'trim(Catalogo.opcion_texto)', 'Catalogo.opcion_texto'
    ));

    $this->set(compact('title_for_layout', 'duracion', 'clases'));
  }

  public function admin_servicios() {
    $this->set('title_for_layout', 'Servicios');
    $this->loadModel('Servicio');

    if ($this->request->is('post') && !empty($this->request->data)) {
      if ($this->Servicio->save($this->request->data)) {
        $this->request->data = array();
        $this->success('Se ha creado el servicio.');
      } else {
        $this->error('Ocurrió un error al guardar tu información.');
      }
    }

    $servicios = $this->Servicio->find('all');

    $this->set(compact('servicios'));
  }

  public function admin_borrar_servicio($membresiaId, $servicioId) {
    if ($this->Membresia->borrar_servicio($membresiaId, $servicioId)) {
      $this->success('Se ha borrado el servicio con éxito');
    } else {
      $this->error('Ha ocurrido un error al tratar de borrar el servicio.');
    }
    $this->redirect('referer');
  }

}
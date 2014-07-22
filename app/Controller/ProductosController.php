<?php

App::uses('Utils', 'Utility');
App::uses('AppController', 'Controller');

class ProductosController extends AppController {

  public $name = 'Productos';

  public function admin_index() {
    $title_for_layout = __('Productos');

    $this->loadModel('Membresia');

    $membresias = $this->Membresia->find('detalles', array(
      'combine' => true
    ));

    $this->set(compact('title_for_layout', 'membresias'));
  }

  public function admin_nuevo() {
    $title_for_layout = __('Nuevo Producto');

    $this->loadModel('Catalogo');

    if ($this->request->is('post')) {
      $this->loadModel('Membresia');
      $data = $this->request->data;
      $data['Membresia']['per_cve'] = 100;

      if ($this->Membresia->saveAll($data)) {
        $this
          ->success('Se ha creado la membresía correctamente.')
          ->redirect(array(
            'admin' => true,
            'controller' => 'productos',
            'action' => 'index'
          ));
      } else {
        $this->error('Ha ocurrido un error al guardar la membresía.');
      }
    }

    $duracion = $this->Catalogo->lista('duracion');
    $clases = $this->Catalogo->lista('membresia_clase');
    // $servicios = ClassRegistry::init('Servicio')->lista();

    $this->set(compact('title_for_layout', 'duracion', 'clases'));
  }

  public function admin_editar($id, $slug = '') {
    $title_for_layout = __('Editar Producto');

    $this->loadModel('Catalogo');
    $this->loadModel('Membresia');

    /**
     * IMPORTANTE.
     * Se debe checar que la membresia exista. Y que sea editable.
     */
    if ($this->request->is('post') || $this->request->is('put')) {
      $data = $this->request->data;
      unset($data['Membresia']['Detalles']);

      if ($this->Membresia->editar($data, $id)) {
        $this
          ->success(__('Se cambió la membresía'))
          ->redirect('referer');
        return true;
      }
    }

    $membresia = $this->Membresia->get($id, 'detalles');

    $membresia = current($membresia);
    $catalogos = array(
      'duracion' => $this->Catalogo->lista('duracion'),
      'clases' => $this->Catalogo->lista('membresia_clase'),
    );

    $membresia['detalles'] = Utils::toJSONArray($membresia, 'Detalles.{n}.Servicio.servicio_cve');
    $this->request->data['Membresia'] = $membresia;

    $this->set(compact('title_for_layout', 'catalogos'));
  }

}
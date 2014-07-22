<?php

class ConveniosController extends AppController {
  public $name = 'Convenios';

  public $uses = array('Empresa');

  public function admin_index() {
    $title_for_layout = __('Convenios');

    if ($this->isAjax) {
      // $lista_empresas = $this->paginate();
      $lista_empresas = $this->Empresa->find('basic_info', array(
        'type' => 'convenio',
	      'order' => array(
	        'Empresa.created' => 'DESC NULLS LAST',
	      )
	    ));

      $this->set(compact('title_for_layout','lista_empresas'));
    }
  }

  public function admin_status($empresaId, $empresaSlug = null, $status = '') {
    $this->loadModel('Convenio');

    /**
     * Verifica los status.
     */
    if (isset($this->Convenio->status[$status])) {
      $status = $this->Convenio->status[$status]['val'];
    } else {
      $this->error(__('Este status no existe'));
      return ;
    }

    $this->Convenio->id = $empresaId;
    $membresiaId = $this->Convenio->field('membresia_cve');

    if ($membresiaId === null) {
      $this->error(__('No ha sido seleccionada alguna membresia.'));
    } elseif ($this->Convenio->change_status($status, $empresaId)) {
      $empresa = $this->Empresa->get('basic_info', array(
        'conditions' => array(
          'Empresa.cia_cve' => $empresaId
        ),
        'first' => true,
        'type' => 'convenio',
        'order' => array(
          'Empresa.created' => 'DESC NULLS LAST',
        )
      ));

      $this
        ->success(__('Se cambio el status del convenio correctamente: %s.', $status))
        ->callback('reloadData')
        ->set(compact('empresa'));
    } else {
      $this->error(__('Ocurrió un error al cambiar el status.'));
    }
  }

  public function admin_condiciones($empresaId, $empresaSlug = null) {
    $title_for_layout = __('Condiciones de Convenio');

    $this->loadModel('Convenio');
    if ($this->request->is('post')) {
      $data = $this->request->data;

      if ($this->Convenio->saveCondiciones($empresaId, $data)) {
        $this->success(__('Se han guardado las condiciones correctamente'));
      } else {
        $this->error(__('Ocurrió un error al intentar guardar los datos'));
      }

    } elseif ($this->request->is('get')) {
      $empresa = $this->Empresa->get($empresaId, 'data');
      $condiciones = $this->Convenio->get($empresaId, 'first', array(
        'contain' => array(
          'Condiciones'
        )
      ));

      if (!empty($condiciones['Condiciones'])) {
        $condiciones['Condiciones'] = Hash::combine($condiciones['Condiciones'], '{n}.condicion', '{n}');
      }

      $this->loadModel('Catalogo');
      $convenios_list = array(
        'condiciones' => $this->Catalogo->lista('convenio_condicion'),
        'membresias' => $this->Catalogo->lista('membresias'),
      );

      $this->loadModel('UsuarioAdmin');
      $usuarios = $this->UsuarioAdmin->getAdmins($this->Auth->user('cu_cve'));

      $this->set(compact('title_for_layout', 'empresa', 'condiciones', 'convenios_list', 'usuarios'));
    }
  }

  public function admin_finalizar($empresaId, $empresaSlug = null) {
    $title_for_layout = __('Finalizar Convenio');
    $this->loadModel('Convenio');
    if ($this->request->is('delete')) {
      $data = $this->request->data;
      if ($this->Convenio->finalizar($data['Convenio'])) {
        $this
          ->success(__('La finalización del convenio fue éxitosa'));
          // ->redirect(array(
          //   'admin' => true,
          //   'controller' => 'convenios',
          //   'action' => 'index'
          // ));
      } else {
        $this
          ->error(__('Ocurrió un error al intentar finalizar el convenio'));
      }
    } elseif ($this->request->is('get')) {
      $empresa = $this->Empresa->get($empresaId, 'data');
      $condiciones = $this->Convenio->get($empresaId, 'first', array(
        'contain' => array(
          'Condiciones'
        )
      ));

      if (!empty($condiciones['Condiciones'])) {
        $condiciones['Condiciones'] = Hash::combine($condiciones['Condiciones'], '{n}.condicion', '{n}');
      }

      $this->loadModel('Catalogo');
      $convenios_list = array(
        'condiciones' => $this->Catalogo->lista('convenio_condicion'),
        'membresias' => $this->Catalogo->lista('membresias'),
      );

      $this->set(compact('title_for_layout', 'empresa', 'condiciones', 'convenios_list'));
    }
  }
}
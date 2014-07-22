<?php

App::uses('BaseEmpresasController', 'Controller');

/**
*
*/
class MisEvaluacionesController extends BaseEmpresasController {
  public $name = 'MisEvaluaciones';
  // public $components= array('Notificaciones');
  public $uses = array('Evaluacion');

  public function index() {
    $title_for_layout = __('Mis Evaluaciones');

    $evaluaciones = array();
    if ($this->isAjax) {
      $evaluaciones = $this->Evaluacion->get('by_cia', array(
        'stats' => true,
        'cia' => $this->Auth->user('Empresa.cia_cve')
      ));
    }

    // $evaluaciones = $this->Evaluacion->get('by_cia', array(
    //   'stats' => true,
    //   'cia' => $this->Auth->user('Empresa.cia_cve'),
    //   'limit' => 3
    // ));

    $this->set(compact('title_for_layout', 'evaluaciones'));
  }

  public function todas() {
    $title_for_layout = __('Todas Mis Evaluaciones');

    if ($this->isAjax) {
      $evaluaciones = $this->Evaluacion->get('by_cia', array(
        'stats' => true,
        'cia' => $this->Auth->user('Empresa.cia_cve')
      ));
    }

    $this->set(compact('title_for_layout', 'evaluaciones'));
  }

  public function publicas() {
    $title_for_layout = __('Todas Mis Evaluaciones');

    if ($this->isAjax) {
      $evaluaciones = $this->Evaluacion->get('by_cia', array(
        'stats' => true,
        'cia' => $this->Auth->user('Empresa.cia_cve'),
        'conditions' => array(
          'Evaluacion.evaluacion_status' => 1
        )
      ));
    }

    $this->set(compact('title_for_layout', 'evaluaciones'));

    $this->render('index');
  }

  // public function gestion() {
  //   $title_for_layout = __('Gestión de Evaluaciones');

  //   if ($this->isAjax) {
  //     $evaluaciones = $this->Evaluacion->get('by_cia', array(
  //       'stats' => true,
  //       'cia' => $this->Auth->user('Empresa.cia_cve'),
  //       'conditions' => array(
  //         'Evaluaciones.totales > 0' // Las que han sido respondidas.
  //       )
  //     ));
  //   }

  //   $this->set(compact('title_for_layout', 'evaluaciones'));

  //   if ($this->isAjax) {
  //     $this->render('todas');
  //   }
  // }

  public function nueva() {
    $title_for_layout = __('Nueva Evaluación');

    if ($this->request->is('post')) {
      $data = $this->request->data;

      /**
       * Establece por default el status de borrador. Verifica si se pasa el valor de submit y asigna el valor a
       * status si existe.
       */
      $data['Evaluacion']['evaluacion_status'] = $this->Evaluacion->getStatus('borrador');
      if (isset($data['submit'])) {
        $submitValue = $data['submitValue'];
        $data['Evaluacion']['evaluacion_status'] = $this->Evaluacion->getStatus($submitValue);
      }

      $data['Evaluacion']['cia_cve'] = $this->Auth->user('Empresa.cia_cve');
      $data['Evaluacion']['cu_cve'] = $this->Auth->user('cu_cve');

      if (empty($data['Preguntas'])) {
        $this->response->statusCode(400);
        $this->error(__('Necesitas agregar al menos una pregunta.'));
        $this->render();
        return false;
      }

      if ($this->Evaluacion->saveTest($data)) {
        $this->success(__('Se ha guardado la evaluación'));
        $this->redirect(array(
          'controller' => 'mis_evaluaciones',
          'action' => 'index'
        ));
      } else {
        $this->response->statusCode(400);
        $this->error(__('Ha ocurrido un eror al intentar guardar los datos.'));
      }
    }

    $this->set(compact('title_for_layout'));
  }

  public function ver($id, $slug = null) {
    $isOwnedBy = $this->Evaluacion->isOwnedBy($this->Auth->user('Empresa.cia_cve'), $id, 'cia_cve');

    /**
     * Si no le pertenece al usuario lo redirecciona.
     */
    if (!$isOwnedBy) {
      $this->error(__('La evaluación que buscas no existe.'));
      $this->redirect(array(
        'controller' => 'mis_evaluaciones',
        'action' => 'index'
      ));
    }

    $evaluacion = $this->Evaluacion->get($id, array(
      'contain' => array(
        'Creador',
        'CreadorContacto',
        'Preguntas' => array(
          'Respuestas' => array(
            'conditions' => array(
              'evaluacion_cve' => $id
            )
          )
        ),
        //'Asignaciones'
      )
    ));

    $title_for_layout = $evaluacion['Evaluacion']['evaluacion_nom'];

    $this->set(compact('title_for_layout', 'evaluacion'));
  }

  public function asignar($id = null, $slug = null, $itemId = null, $itemSlug = null) {
    $title_for_layout = __('Asignar una evaluación');

    if ($this->request->is('post')) {
      $this->loadModel('CandidatoEmpresa');

      $userId = $this->Auth->user('cu_cve');
      $data = $this->request->data;
      if (empty($data['id']) || empty($data['users_id'])) {
        $this->error(__('No has seleccionado'));
      } elseif ($this->Evaluacion->saveAsignaciones($data, $userId)) {
        $this->success(__('Se han guardado satisfactoriamentes las asignaciones'));
      } else {
        $this->error(__('Ha ocurrido un error al intentar guardar la apliación a los candidatos.'));
      }
      $this->set(compact('data'));
    } else {
      /*$evaluaciones = $this->Evaluacion->get(array(
        'conditions' => array(
          'Evaluacion.cia_cve' => $this->Auth->user('Empresa.cia_cve'),
          'Evaluacion.evaluacion_cve >= 6'
        )
      ));*/
    }

    $this->set(compact('title_for_layout', 'evaluaciones', 'itemId'));
  }

  public function aplicadas() {

  }

  public function asignaciones($id, $slug = null) {
    $title_for_layout = __('Asignaciones de Evaluación');

    $evaluacion = $this->Evaluacion->get($id, array(
      'contain' => array(
        'Preguntas' => array(
          'Respuestas'
        ),
        'Asignaciones'
      )
    ));

    $title_for_layout = $evaluacion['Evaluacion']['evaluacion_nom'];

    $this->set(compact('title_for_layout', 'evaluacion'));
  }

  public function asignaciones_resueltas($id, $slug = null, $type = 'todas') {
    $title_for_layout = __('Asignaciones de Evaluación');

    $evaluacion = $this->Evaluacion->get($id, array(
      'contain' => array(
        'Preguntas' => array(
          'Respuestas'
        ),
        'Asignaciones' => array(
          'conditions' => array(
            'Asignaciones.evaluacion_status' => 1
          )
        )
      )
    ));

    $title_for_layout = $evaluacion['Evaluacion']['evaluacion_nom'];

    $this->set(compact('title_for_layout', 'evaluacion'));

    $this->render('asignaciones');
  }

  public function editar($id, $slug = '') {
    $isOwnedBy = $this->Evaluacion->isOwnedBy($this->Auth->user('cu_cve'), $id);

    /**
     * Si no le pertenece al usuario lo redirecciona.
     */
    if (!$isOwnedBy) {
      $this->error(__('No puedes editar la evaluación, tu no has creado la evaluación.'));
      $this->redirect(array(
        'controller' => 'mis_evaluaciones',
        'action' => 'index'
      ));
    }

    if ($this->request->is('put')) {
      $data = $this->request->data;

      if ($this->Evaluacion->editTest($id, $data)) {
        $this->success(__('se actualizó la evaluación con éxito.'));
        $this->redirect(array(
          'controller' => 'mis_evaluaciones',
          'action' => 'index'
        ));
      } else {
        $this->error(__('Error al actualizar la evaluación.'));
      }
    }

    $this->request->data = $this->Evaluacion->get($id, array(
      'contain' => array(
        //'Reclutador',
        'CreadorContacto',
        'Preguntas' => array(
          'Respuestas' => array(
            'conditions' => array(
              'evaluacion_cve' => $id
            )
          )
        ),
        //'Asignaciones'
      )
    ));
  }

  public function resultados($evaluacionId, $slug = null, $candidatoId = null) {
    $isOwnedBy = $this->Evaluacion->isOwnedBy($this->Auth->user('Empresa.cia_cve'), $evaluacionId, 'cia_cve');

    /**
     * Si no le pertenece al usuario lo redirecciona.
     */
    if (!$isOwnedBy) {
      $this->error(__('La evaluación que buscas no existe.'));
      $this->redirect('referer');
    }
    $evaluacion = $this->Evaluacion->Asignaciones->get('first', array(
      'conditions' => array(
        'Asignaciones.evaluacion_cve' => $evaluacionId,
        'Asignaciones.candidato_cve' => $candidatoId,
        'Asignaciones.evaluacion_status' => 1
      ),
      'contain' => array(
        'Candidato',
        'CandidatoContacto',
        'ReclutadorContacto',
        'Reclutador',
        'Evaluacion' => array(
          'Creador',
          'Preguntas' => array(
            'RespuestasPorUsuario' => array(
              'conditions' => array(
                'RespuestasPorUsuario.evaluacion_cve' => $evaluacionId,
                'candidato_cve' => $candidatoId
              )
            )
          ),
        )
      )
    ));
    ClassRegistry::init("notificacion")->syn_leido($evaluacion['Asignaciones']['evaxcan_cve'],"evaluacion");
    $this->set(compact('evaluacion'));
  }
/**
 * accion para mostrar resultado desde link de notificacion
 */
  public function  resultado($id=null){
            $this->Evaluacion->Asignaciones->recursive=-1;
      $rs= $this->Evaluacion->Asignaciones->read(null,$id);
      if($rs!==false){
            $rs=$rs['Asignaciones'];

            $this->resultados($rs['evaluacion_cve'],$rs['candidato_cve'],'');
            $this->render('resultados');
      }
      else{
          $this->redirect('index');
      }


  }




  public function eliminar($evaluacionId, $slug = null) {
    $isOwnedBy = $this->Evaluacion->isOwnedBy($this->Auth->user('cu_cve'), $evaluacionId);

    /**
     * Si no le pertenece al usuario lo redirecciona.
     */
    if (!$isOwnedBy) {
      $this->error(__('No puedes eliminar la evaluación, tu no la has creado.'));
      // $this->redirect(array(
      //   'controller' => 'mis_evaluaciones',
      //   'action' => 'index'
      // ));
    }

    if ($this->Evaluacion->hasAsignaciones($evaluacionId)) {
      $this->error(__('No puedes borrar una evaluación que ha sido asignada.'));
    } else {
      if ($this->Evaluacion->changeStatus(-2, $evaluacionId)) {
        $this->success(__('La evaluación se ha eliminado con éxito.'));
        $this->callback('deleteRow');
      } else {
        $this->error(__('Ocurrió un error al intentar eliminar la evaluación.'));
      }
    }
  }
}
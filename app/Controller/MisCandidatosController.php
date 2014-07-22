<?php

App::uses('BaseEmpresasController', 'Controller');
App::import('Vendor',array('funciones'));

class MisCandidatosController extends BaseEmpresasController {

  public $uses = array();

  public $helpers = array('Candidato');

  /**
   * Componentes necesarios que utiliza el Controlador.
   * @var array
   */
  public $components = array('Session', 'Creditos', 'Requester');

  protected function updateSession() {
    $userId = $this->Auth->user('cu_cve');
    $ciaId = $this->Auth->user('Empresa.cia_cve');

    $stats = ClassRegistry::init('UsuarioEmpresa')->getStats($userId, $ciaId, 'candidatos');
    $this->Session->write('Auth.User.Stats.candidatos', $stats);
  }

  public function index() {
    $title_for_layout = __('Mis candidatos');

    $candidatos = ClassRegistry::init('CandidatoB')->find('purchased', array(
        'fromUser' => $this->Auth->user('cu_cve'),
        'fromCia' => $this->Auth->user('Empresa.cia_cve'),
        'limit' => 8,
        'order' => array(
          'Empresa.created' => 'DESC'
        )
      ));

    $this->set(compact('candidatos', 'title_for_layout'));
  }

  public function cartera() {
    $title_for_layout = __('Candidatos en Cartera');

    if ($this->isAjax) {
      $candidatos = ClassRegistry::init('CandidatoB')->find('by_user', array(
        'fromUser' => $this->Auth->user('cu_cve'),
        'fromCia' => $this->Auth->user('Empresa.cia_cve'),
        'order' => array(
          'Empresa.created' => 'DESC'
        )
      ));
    }
    $this->set(compact('title_for_layout', 'candidatos'));

    if ($this->isAjax) {
      $this->render('_index');
    }
  }

  public function recientes() {
    if ($this->isAjax) {
      $candidatos = ClassRegistry::init('CandidatoB')->find('by_user', array(
        'fromUser' => $this->Auth->user('cu_cve'),
        'fromCia' => $this->Auth->user('Empresa.cia_cve'),
        'limit' => 5,
        'order' => array(
          'Empresa.created' => 'DESC'
        )
      ));
    }
    $this->set(compact('candidatos'));
    $this->render('_index');
  }

  public function carpeta($folderId, $folderName = null) {
    $this->loadModel('Carpeta');

    $carpeta = $this->Carpeta->get($folderId, array(
      'recursive' => -1
    ));

    if ($this->isAjax) {
      $candidatos = ClassRegistry::init('CandidatoB')->find('by_user_folder', array(
        'fromUser' => $this->Auth->user('cu_cve'),
        'fromCia' => $this->Auth->user('Empresa.cia_cve'),
        'fromFolder' => $folderId,
        'order' => array(
          'CandidatoB.candidato_cve' => 'ASC'
        )
      ));
    }

    $this->set('title_for_layout', __('Cartera - %s', $carpeta['carpeta_nombre']));
    $this->set(compact('carpeta', 'candidatos'));
    $this->render('_index');
  }

  /**
   * Muestra a los candidatos favoritos del usuario.
   * @return [type] [description]
   */
  public function favoritos() {
    $title_for_layout = __('Candidatos favoritos');

    if ($this->isAjax) {
      $candidatos = ClassRegistry::init('CandidatoB')->get('favs', array(
        'fromUser' => $this->Auth->user('cu_cve'),
        'fromCia' => $this->Auth->user('Empresa.cia_cve')
      ));
    }

    $this->set(compact('candidatos', 'title_for_layout'));
    $this->render('_index');
  }

  /**
   * Muestra los candidatos que ha adquirido la empresa a la que pertenece el usuario.
   * @return [type] [description]
   */
  public function adquiridos() {
    $title_for_layout = __('Candidatos adquiridos');

    if ($this->isAjax) {
      $candidatos = ClassRegistry::init('CandidatoB')->get('purchased', array(
        'fromUser' => $this->Auth->user('cu_cve'),
        'fromCia' => $this->Auth->user('Empresa.cia_cve'),
        'order' => array(
          'Empresa.created' => 'DESC',
          'CandidatoB.candidato_cve' => 'DESC'
        )
      ));
    }

    $this->set(compact('candidatos', 'title_for_layout'));
    $this->render('_index');
  }

  /**
   * Guarda a algún candidato en los candidatos del usuario.
   * @param  int    $candidatoId [description]
   * @return [type]              [description]
   */
  public function guardar_en($candidatoId = null, $candidatoSlug = null, $folderId = null, $folderSlug = null) {
    if (!$this->request->is('post')) {
      throw new MethodNotAllowedException(__('La ṕágina que intentas acceder no existe.'));
    }

    // debug(func_get_args());
    $userId = $this->Auth->user('cu_cve');

    $this->loadModel('CarpetasCandidatos');

    if ($candidatoId) {
      $successMsg = __('Se ha guardado en tus candidatos satisfactoriamente.');
    } else {
      $candidatoId = $this->request->data('ids');
      $successMsg = __('Se han guardado en tus candidatos satisfactoriamente.');
    }

    if ($this->CarpetasCandidatos->addToFolder($folderId, $candidatoId, $userId)) {
      $this->Session->write('Auth.User.Stats.candidatos.folders', ClassRegistry::init('Carpeta')->getFolders(
        $this->Auth->user('cu_cve'), 'candidatos'
      ));
      $this->success($successMsg);
      $this->set(compact('folderId', 'candidatoId'));
    } else {
      $this->error(__('Ha ocurrido un error al procesar tu solicitud.'));
    }
  }

  /**
   * [quitar_de description]
   * @param  [type] $candidatoId [description]
   * @param  [type] $folderId    [description]
   * @param  [type] $folderSlug  [description]
   * @return [type]              [description]
   */
  public function quitar_de($candidatoId, $candidatoSlug, $folderId, $folderSlug) {
    if (!$this->request->is('post')) {
      throw new MethodNotAllowedException(__('La ṕágina que intentas acceder no existe.'));
    }

    $userId = $this->Auth->user('cu_cve');

    $this->loadModel('CarpetasCandidatos');

    if ($candidatoId) {
      $successMsg = __('Se ha borrado de la carpeta satisfactoriamente.');
    } else {
      $candidatoId = $this->request->data('ids');
      $successMsg = __('Se han borrado de las carpetas satisfactoriamente.');
    }

    if ($this->CarpetasCandidatos->removeFromFolder($folderId, $candidatoId, $userId)) {
      $this->Session->write('Auth.User.Stats.candidatos.folders', ClassRegistry::init('Carpeta')->getFolders(
        $this->Auth->user('cu_cve'), 'candidatos'
      ));
      $this->success($successMsg);
      $this->set(compact('folderId', 'candidatoId'));
    } else {
      $this->error(__('Ha ocurrido un error al procesar tu solicitud.'));
    }
  }

  /**
   * Marca como favorito a algún candidato. Sólo se pueden marcar como favoritos a los que
   * han adquirido sus datos.
   * @param  [type] $candidatoId [description]
   * @return [type]              [description]
   */
  public function favorito($candidatoId = null) {
    if (!$this->request->is('post')) {
      throw new MethodNotAllowedException(__('La ṕágina que intentas acceder no existe.'));
    }

    $userId = $this->Auth->user('cu_cve');

    $this->loadModel('CandidatoEmpresa');

    if ($candidatoId) {
      $isAcquired = $this->CandidatoEmpresa->is('adquirido', array(
        'cia' => $this->Auth->user('Empresa.cia_cve'),
        'candidato' => $candidatoId
      ));

      if (!$isAcquired) {
        $this->error(__('Necesitas comprar los datos del usuario para agregarlo como favorito.'));
        return;
      }

      $successMsg = __('Se ha agregado como favorito al usuario.');
    } else {
      $candidatoId = $this->request->data('ids');
      $successMsg = __('Se han agregado como favoritos a los usuarios.');
    }

    if ($this->CandidatoEmpresa->Atributos->addToFavorites($candidatoId, $userId)) {
      $this->success($successMsg);
      $this->updateSession();
      $this->set(compact('candidatoId'));
    } else {
      $this->error(__('Ocurrió un problema al guardar los datos.'));
    }
  }

  public function curriculum($candidatoId, $docname = null) {
    $this->loadModel('CandidatoEmpresa');

    if ($this->request->params['ext'] === 'pdf') {
      $this->layout = 'default';
    }

    $isAcquired = $this->CandidatoEmpresa->is(array(
      'OR' => array('postulado', 'adquirido')
    ), array(
      'cia' => $this->Auth->user('Empresa.cia_cve'),
      'candidato' => $candidatoId
    ));

    if (!$isAcquired) {
      $this->error(__('No tienes permisos.'));
      $this->redirect('referer');
    }

    $candidato = $this->CandidatoEmpresa->get($candidatoId, 'perfil', array(
      'fromUser' => $this->Auth->user('cu_cve'),
      'fromCia' => $this->Auth->user('Empresa.cia_cve'),
    ));

    $this->set(compact('candidato'));
  }

  public function documento($candidatoId, $slug = null, $docId = null, $docSlug = null) {
    $this->loadModel('CandidatoEmpresa');

    $isAcquired = $this->CandidatoEmpresa->is(array(
      'OR' => array('postulado', 'adquirido')
    ), array(
      'cia' => $this->Auth->user('Empresa.cia_cve'),
      'candidato' => $candidatoId
    ));

    $redirect = array(
      'controller' => 'candidatos',
      'action' => 'perfil',
      'id' => $candidatoId,
      'slug' => $slug
    );

    if (!$isAcquired) {
      $this->error(__('No tienes permisos.'));
      $this->redirect($redirect);
    }

    $doc = $this->CandidatoEmpresa->Documentos->get($docId);

    if (empty($doc)) {
      $this->error(__('El archivo no existe.'));
      $this->redirect($redirect);
    } else {
      $path_file = funciones::verdocumento($candidatoId, $doc['docscan_nom']);
      if ($path_file) {
        $this->response->file($path_file, array(
          'download' => true,
          'name' => basename($path_file)
        ));
        return $this->response;
      } else {
        $this->error(__('El archivo no existe.'));
        $this->redirect($redirect);
      }
    }
  }

  /**
   * Compra los datos de algún candidato.
   * @param  [type] $id      [description]
   * @param  [type] $keycode [description]
   * @return [type]          [description]
   */
  public function comprar($candidatoId, $keycode = null) {
    if (!$this->request->is('post')) {
      throw new MethodNotAllowedException('La ṕágina que intentas acceder no existe.');
    }

    /**
     * Verifica si tiene créditos de consuta para cvs.
     * @var [type]
     */
    $hasCredits = $this->Creditos->has('consulta_cv');

    $ciaId = $this->Auth->user('Empresa.cia_cve');
    $this->loadModel('EmpresasCandidatos');
    if ($this->EmpresasCandidatos->isAcquired($ciaId, $candidatoId)) {
      $this->info(__('Este candidato ya ha sido previamente adquirido por tu compañia'));
    } elseif ($hasCredits) {
      $data = array(
        'cia_cve' => $ciaId,
        'cu_cve' => $this->Auth->user('cu_cve'),
        'candidato_cve' => $candidatoId
      );

      $this->EmpresasCandidatos->begin();
      if ($this->EmpresasCandidatos->save($data)) {
        if($this->Creditos->spend('consulta_cv', $candidatoId)) {
          $this->EmpresasCandidatos->commit();
          $this->updateSession();

          $candidato = ClassRegistry::init('CandidatoB')->find('by_user', array(
            'conditions' => array(
              'CandidatoB.candidato_cve' => $candidatoId
            ),
            'fromUser' => $this->Auth->user('cu_cve'),
            'fromCia' => $this->Auth->user('Empresa.cia_cve'),
            'order' => array(
              'Empresa.created' => 'DESC'
            ),
            'limit' => 1
          ));

          $this->success(__('Se ha guardado el candidato satisfactoriamente.'));

          $this->html('element', 'empresas/credits');
          $this->callback($this->request->data['after']);

          $this->set(compact('candidato'));
        } else {
          $this->EmpresasCandidatos->rollback();
          $this->response->statusCode(400);
          $this->error(__('Ha ocurrido un error al actualizar tus créditos.'));
        }
      } else {
        $this->EmpresasCandidatos->rollback();
        $this->response->statusCode(400);
        $this->error(__('Ha ocurrido un error al intentar comprar el usuario.'));
      }

    } else {
      $this->response->statusCode(402);
      $this->error(__('Usted no cuenta con liberaciones de currículum, compre en línea o contacte a un ejecutivo.'));
    }

    if (!$this->isAjax) {
      $this->redirect('referer');
    }
  }

  public function carpetas() {
    $title_for_layout = __('Carpetas de Mis Candidatos');

    $this->loadModel('Carpeta');

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
      'order' => false,
    );

    $carpetas = $this->paginate('Carpeta');
    $this->set(compact('carpetas', 'title_for_layout'));
  }

  public function anotacion($candidatoId, $anotacionId = null) {
    $data = $this->request->data;
    $data['Anotacion']['cu_cve'] = $this->Auth->user('cu_cve');
    $data['Anotacion']['candidato_cve'] = $candidatoId;

    $this->loadModel('Anotacion');
    if ($this->Anotacion->save($data)) {
      $insertedID = $this->Anotacion->getLastInsertID();
      $anotacion = $this->Anotacion->get($insertedID); //$data['Anotacion'];

      $this->set(compact('insertedID', 'anotacion'));
      $this->success(__('Se ha guardado la anotación satisfactoriamente.'));
    } else {
      $this->response->statusCode(400);
      $this->error(__('Ha ocurrido un error al intentar guardar los datos.'));
    }
  }

  public function borrar_nota($candidatoId, $notaId) {
    $this->loadModel('Anotacion');
    $isOwnedBy = $this->Anotacion->isOwnedBy($this->Auth->user('cu_cve'), $notaId);

    if (!$isOwnedBy) {
      $this->error(__('No puedes borrar esta nota, sólo el propietario'));
    } else {
      if ($this->Anotacion->delete($notaId)) {
        $this->success(__('La nota se ha borrado con éxito'));
      } else {
        $this->error(__('Ocurrió un error al intentar borrar la nota'));
      }
    }
  }

  public function evaluacion($candidatoId, $slug = null, $evaluacionId = null) {
    $this->loadModel('CandidatoEmpresa');

    $isAcquired = $this->CandidatoEmpresa->is(array(
      'OR' => array('postulado', 'adquirido')
    ), array(
      'cia' => $this->Auth->user('Empresa.cia_cve'),
      'candidato' => $candidatoId
    ));

    if (!$isAcquired) {
      $this->error(__('No tienes permisos.'));
      $this->redirect('referer');
    }

    $eval = $this->CandidatoEmpresa->Evaluaciones->get($evaluacionId, array(
      'contain' => array(
        'Evaluacion'
      )
    ));

    if (!empty($eval)) {
      if ((int)$eval['Evaluacion']['tipoeva_cve'] === 2) {
        return $this->Requester->getFile('http://imx.obail.net', array(
          'q' => 'pdf',
          'h' => 'disc',
          's' => 'igntr',
          'r' => $candidatoId
        ));
      } else {
        $this->loadModel('Evaluacion');
        $id = $eval['Evaluacion']['evaluacion_cve'];
        $isOwnedBy = $this->Evaluacion->isOwnedBy($this->Auth->user('Empresa.cia_cve'), $id, 'cia_cve');

        if (!$isOwnedBy) {
          $this->error(__('La evaluación que buscas no existe.'));
          $this->redirect('referer');
        }

        $evaluacion = $this->Evaluacion->Asignaciones->get('first', array(
          'conditions' => array(
            'Asignaciones.evaluacion_cve' => $id,
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
                    'RespuestasPorUsuario.evaluacion_cve' => $id,
                    'candidato_cve' => $candidatoId
                  )
                )
              ),
            )
          )
        ));
        $this->set(compact('evaluacion'));
      }
    } else {
      $this->error(__('La evaluación que buscas no existe.'));
      $this->redirect('referer');
    }
  }
}
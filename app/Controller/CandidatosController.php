<?php

App::uses('BaseEmpresasController', 'Controller');

class CandidatosController extends BaseEmpresasController {
  public $uses = array();

  public $helpers = array('Candidato');

  protected function updateSession() {
    $userId = $this->Auth->user('cu_cve');
    $ciaId = $this->Auth->user('Empresa.cia_cve');

    $stats = ClassRegistry::init('UsuarioEmpresa')->getStats($userId, $ciaId, 'candidatos');
    $this->Session->write('Auth.User.Stats.candidatos', $stats);
  }

  /**
   * Componentes necesarios que utiliza el Controlador.
   * @var array
   */
  public $components = array('Session', 'Notificaciones', 'Candidatos');

  private function filters_settings(){
    $param_query = $this->request->query;
    $options = array(
      'params' => $param_query,
      'fromUser' => $this->Auth->user('cu_cve'),
      'fromCia' => $this->Auth->user('Empresa.cia_cve')
    );

    $datos_agrupados = ClassRegistry::init('CandidatoB')->agrupar($options);

    $this->set(compact('datos_agrupados', 'param_query'));
  }

  public function index() {
    $title_for_layout = __('Candidatos');

    $this->filters_settings();

    $this->set(compact('title_for_layout'));
  }

  public function filtros(){
    $this->filters_settings();
  }

  public function candidatos(){
    $conditions = array();
    $this->loadModel('CandidatoB');
    $params = $this->request->query;
    $options = array(
      'fromUser' => $this->Auth->user('cu_cve'),
      'fromCia' => $this->Auth->user('Empresa.cia_cve'),
      'params' => $params
    );
    $data = $this->CandidatoB->find('paginate', $options);

    $this->set(compact('data'));
  }

  public function perfil($id=null) {  
        
    if($id==null){
        $this->error(__("No existe acción."));
        $this->redirect("index");
        return;
    }
    // verificar que no este denunciado con status aceptado      
    $denuncia_=ClassRegistry::init("Denuncia"); 
    $denuncia_previa = $denuncia_->verifica_status($id,$this->Auth->user('cu_cve')) ;
    if($denuncia_previa){
        $this->error(__("No existe candidato."));
        $this->redirect("index");
        return;
    }    
    $num=$denuncia_->numeroDenuncias($id);
    if($num > 0){
        $this->warning(__("Este candidato fue denunciado."));
    }

    $candidato = ClassRegistry::init('CandidatoEmpresa')->get($id, 'perfil', array(
      'fromUser' => $this->Auth->user('cu_cve'),
      'fromCia' => $this->Auth->user('Empresa.cia_cve'),
    ));

    if(empty($candidato)){
     $this->error(__('No existe  candidato.'));
     $this->redirect("index");
      return;
    }  
    $hasVisited = ClassRegistry::init('VisitaCV')->saveIfNotExists($this->Auth->user('cu_cve'), $id);
    if ($hasVisited === 'saved') {
      // $info = $this->Notificaciones->simple_format(array(
      //   'id' => $id,
      //   'typeUser' =>1 ,
      //   'title' => 'Han visto tu perfil'
      // ));
      // $this->Notificaciones->enviar('send-ntfy', $info);
    }

    $isAcquired = (int)$candidato['Empresa']['adquirido'] === 1;

    $nombre = $candidato['CandidatoEmpresa']['candidato_nom'] . ($isAcquired
        ? ' ' . $candidato['CandidatoEmpresa']['candidato_pat'] . ' ' . $candidato['CandidatoEmpresa']['candidato_mat']
        : '');

    $title_for_layout = __('Perfil de %s', $nombre);

    $_listas = array(
      'motivos' => ClassRegistry::init('Catalogo')->lista('MOTIVO_CVE'),
      'notas' => ClassRegistry::init('Catalogo')->lista('ANOTACION_TIPO')
    );

    $this->set(compact('title_for_layout','candidato', '_listas','denuncia_previa'));
  }

  public function referencias($id, $slug = null, $evaluacionId = null) {
    $this->loadModel('CandidatoEmpresa');

    $evaluacion = $this->CandidatoEmpresa->Referencias->get('first', array(
      'conditions' => array(
        'Referencias.refcan_cve' => $evaluacionId,
        'Referencias.candidato_cve' => $id,
        'Referencias.refencuesta_status' => 'S'
      ),
      'joins' => array(
        array(
          'alias' => 'Relacion',
          'conditions' => array(
            'Relacion.ref_opcgpo' => 'REFREL_CVE',
            'Relacion.opcion_valor = Referencias.refrel_cve'
          ),
          'fields' => array('Relacion.opcion_texto Referencias__relacion'),
          'table' => 'tcatalogo',
          'type' => 'LEFT',
        )
      ),
      'contain' => array(
        'Candidato',
        'CandidatoInfo',
        'RespuestasRef'
      )
    ));

    $this->set(compact('evaluacion'));
  }

  public function denunciar($candidatoId) {
    if (!$this->request->is('post')) {
      throw new MethodNotAllowedException(__('Método no permitido'));
    }

    $this->loadModel('Denuncia');
    if($this->Denuncia->verifica_status($candidatoId,$this->Auth->user('cu_cve'))   ){
      $this->warning(__('Existe una denuncia previa.'));
      return;
    }

    if ($this->Denuncia->guardar($candidatoId, $this->request->data,
      $this->Auth->user('cu_cve'), $this->Auth->user('Empresa.cia_cve')))
    {
      $this
        ->success(__('Se ha guardado la denuncia.'))
        ->updateSession();

    } else {
      $this->error(__('Ha ocurrido un error al intentar guardar los datos.'));
    }
    //$this->redirect('referer');
  }

  public function invitar() {
    if ($this->request->is('post')) {
      $this->loadModel('CandidatoUsuario');
      $this->loadModel('Invitacion');

      $assocNombreEmail = array();
      foreach ($this->request->data['Invitacion'] as $key => $value) {
        $email = trim($value['email']);
        $nombre = trim($value['nombre']);

        $assocNombreEmail[$email] = array(
          'email' => $email,
          'nombre' => $nombre
        );
      }

      // $assocNombreEmail = Hash::combine($data, 'Invitacion.{s}.email', 'Invitacion.{s}');
      $emails = array_keys($assocNombreEmail);

      $candidatos = $this->CandidatoUsuario->get('all', array(
        'conditions' => array(
          'cc_email' => $emails
        ),
        'contain' => array('Candidato'),
        'afterFind' => array(
          'formatByStatus' => array(

          )
        )
      ));

      $emailsSinRegistro = array_values(array_diff($emails, $candidatos['emails']));
      $candidatos['sin_registro'] = array_values(array_intersect_key($assocNombreEmail, array_flip($emailsSinRegistro)));
      unset($candidatos['emails']);

      if (
        empty($candidatos['sin_registro']) || $this->Invitacion->saveAndSend($candidatos['sin_registro'], $this->Auth->user())
      ) {
        $this->Candidatos->sendEmails($candidatos, array(
          'incompletos', 'inactivos'
        ));

        $this->success(__('Se enviaron con éxito las invitaciones.'));
      } else {
        $this->error(__('Ocurrió un error al enviar los correos.'));
      }

      $this->set(compact('candidatos'));
    }
  }

  public function admin_documento($candidatoId, $slug = null, $docId = null, $docSlug = null) {
    $this->loadModel('CandidatoEmpresa');

    // $redirect = array(
    //   'controller' => 'candidatos',
    //   'action' => 'perfil',
    //   'id' => $candidatoId,
    //   'slug' => $slug
    // );

    // if (!$isAcquired) {
    //   $this->error(__('No tienes permisos.'));
    //   $this->redirect($redirect);
    // }

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
}
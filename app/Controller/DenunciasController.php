<?php

App::uses('BaseEmpresasController', 'Controller');
App::uses('Funciones','vendor');
/**
 * Controlador general de la aplicación.
 */
class DenunciasController extends BaseEmpresasController {

  /**
    * Nombre del controlador.
    */
  public $name = 'Denuncias';

  public $helpers=array("Denuncia");

  /**
    * Indica qué modelos se usarán. Un array vacío, indica que no usará algún modelo.
    */
  public $uses = array();

  /**
    * Componentes necesarios que utiliza el Controlador.
    * @var Array
    */
  public $components = array('Session', 'Emailer', 'Creditos');

  public $status = array(
    'reportado' => 0,
    'revision' => 1,
    'aceptado' => 2,
    'declinado' => 3
  );

  /**
     * Opciones para la paginación de los Usuarios.
     * @var Array
     */
  /*public $paginate = array(
    //'UsuarioEmpresa',
    'UsuarioAdmin' => array(
      'allowed',              // Específica que se usará la function _findAllowed
      'limit' => 20,
      'order' => array(
        'UsuarioAdmin.cu_sesion' => 'asc',
        'UsuarioAdmin.cu_cve' => 'asc'
      )
    )
  );*/

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

  /**
   * Muestra la lista de los usuarios que son dependientes del usuario que ha iniciado sesión.
   * @return [type] [description]
   */
  public function admin_index() {
    $title_for_layout = __('Denuncias');
    $this->loadModel('Oferta');
    $this->loadModel('CandidatoEmpresa');
    $denunciasCV = $this->CandidatoEmpresa->get('denuncias',array("all" =>true));
    $denunciasOfertas = $this->Oferta->get('denuncias',array("all" =>true));
    $this->set(compact('title_for_layout', 'denunciasCV', 'denunciasOfertas'));
  }

  public function admin_oferta($denunciaId, $ofertaId, $slug = '') {
    $title_for_layout = __('Denuncia de Oferta');

    $this->loadModel('Reportar');
    $this->loadModel('Oferta');

    $denuncia = $this->Reportar->get('data', array(
      'conditions' => array(
        'Reportar.oferta_cve' => $ofertaId
      )
    ));
     if(empty($denuncia)){
        $this->error(__("No existe enlace."));
        $this->redirect("index");
        return;
    }

    $oferta = $this->Oferta->find('oferta', array(
      'idOferta' => $ofertaId
    ));

    $tipo="oferta";
    $this->loadModel("NotaDenuncia");
    $anotaciones=$this->NotaDenuncia->find("notas",array("id" => $ofertaId,"tipo" =>$tipo ));
    $this->set(compact('title_for_layout', 'denuncia', 'oferta','anotaciones',"tipo"));
  }

  public function admin_candidato($denunciaId, $candidatoId, $slug = '') {
    $title_for_layout = __('Denuncia de Candidato');

    $this->loadModel('Denuncia');

    $denuncia = $this->Denuncia->get('data', array(
      'conditions' => array(
        'Denuncia.candidato_cve' => $candidatoId
      )
    ));
    if(empty($denuncia)){
        $this->error(__("No existe enlace."));
        $this->redirect("index");
        return;
    }
    $candidato = ClassRegistry::init('CandidatoEmpresa')->get($candidatoId, 'perfil_para_admin', array(
    ));
    $tipo="candidato";
    $this->loadModel("NotaDenuncia");
    $anotaciones=$this->NotaDenuncia->find("notas",array("id" => $candidatoId,"tipo" =>$tipo ));
    $this->set(compact('title_for_layout', 'denuncia', 'candidato','anotaciones','tipo'));
  }

  public function admin_reporte($id,$tipo){
        if($tipo==='candidato'){
            $this->admin_candidato(null,$id,$tipo);

            $this->render("admin_candidato");
        }
        else if ($tipo==='oferta'){
             $this->admin_oferta(null,$id,$tipo);
             $this->render("admin_oferta");

        }


  }

  public function admin_borrar_nota($notaId) { 
    $this->loadModel('NotaDenuncia');
      if ($this->NotaDenuncia->delete($notaId)) {
        $this->success(__('La nota se ha borrado con éxito'));
      } else {
        $this->error(__('Ocurrió un error al intentar borrar la nota'));
      }
  }
  public function admin_anotacion() {
    $data = $this->request->data;
    $this->loadModel('NotaDenuncia');
    if ($this->NotaDenuncia->guardar($data)) {
      $is_created=!isset($data['Nota']['clave']);      
      $insertedID = $is_created ? $this->NotaDenuncia->getLastInsertID() : $data['Nota']['clave'];
      $anotacion = $this->NotaDenuncia->get($insertedID); //$data['NotaDenuncia']; 
      $this->set(compact('insertedID', 'anotacion','is_created'));
      $this->success(__('Se ha guardado la anotación satisfactoriamente.'));
    } else {
      $this->response->statusCode(400);
      $this->error(__('Ha ocurrido un error al intentar guardar los datos.'));
    }
  }

  public function admin_status($denunciaId, $type = '', $status = '') {
    if (isset($this->status[$status])) {
      $status_cve = $this->status[$status];
    } else {
      $this->error(__('Este status no existe'));
      return ;
    }

    $denuncias=array();
    if($type==='cv' || $type=='oferta'){
      if ($type === 'cv') {
        $this->loadModel('Denuncia');
        $this->loadModel('CandidatoEmpresa');
        $this->Denuncia->change_status($status_cve, $denunciaId);
        $this->success(__('Se cambio el status de la denuncia al CV correctamente: %s.', $status));
        $denuncias['candidatos']=$this->CandidatoEmpresa->get('denuncias',array(
          "all" => true,
          "conditions" => array(
            "CandidatoEmpresa.candidato_cve"=> $denunciaId
          )
          ));
      } elseif ($type === 'oferta') {
        $this->loadModel('Reportar');
        $this->loadModel('Oferta');
        $this->Reportar->change_status($status_cve, $denunciaId);
        $denuncias['ofertas']=$this->Oferta->get('denuncias',array(
          "all" => true,
          "conditions" => array(
            "Oferta.oferta_cve"=> $denunciaId
          )
          ));        
        $this->success(__('Se cambio el status de la denuncia a la oferta correctamente: %s.', $status));
      } 
       $this->set(compact('denuncias'));
      $this->callback($this->request->data['after']);
    }
   


      else {
      $this->error(__('La denuncia que intentas cambiar no existe'));
    }
  }
}
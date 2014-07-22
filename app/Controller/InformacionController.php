<?php

App::import('controller', 'AppController');

class InformacionController extends AppController {

  public $name = 'Informacion';

  public $helpers = array(
    'VisualCaptcha'
  );

  public $components = array('VisualCaptcha', 'Emailer' );

  public function beforeFilter() {
    parent::beforeFilter();

    if ($this->Acceso->is('empresa') && !in_array($this->request->params['action'], array(
      'terminos_condiciones',
      'aviso_privacidad'
    ))) {
      $this->redirect('/mi_espacio');
    }

    $this->Auth->allow();
  }

  public function sharrre(){
      $this->autoRender=false;
      include APP.DS."Vendor".DS."sharrre.php";
  }



  public function guardar_contacto_general($type = 'general') {
    if (!$this->isAjax) {
        return;
    }

    if (!$this->VisualCaptcha->isValid()) {
      $this->response->statusCode(300);
      $this->error("El Objeto arrastrado es distinto");
      return ;
    }

    $data = $this->request->data;

    if (empty($data)) {
      $this->response->statusCode(300);
      $this->error('Petición vacía');
      return ;
    }

    $name_model = $type === 'general' ? 'ContactoG' : 'ContactoE';
    $name_model = $type === 'empresa' ? 'ContactoEmpresa' : $name_model;

    $model = ClassRegistry::init($name_model);

    $model->begin();
    $rs = $model->guardar($data);
    if ($rs === false) {
      $this->response->statusCode(300);
      $this->error('Validación incorrecta verifique la información.');
    } else {
      try{
        $this->Emailer->sendEmail("ventas.ne@nuestroempleo.com.mx",
          'Contacto General',
          'contacto',
          array(
            'data' => $rs,
            'is' => $type
          )
        ); // enviamos correo
        $this->success('La información fue guardada con éxito.');
        $model->commit();
      } catch (Exception $e) {
        $this->error('No fue posible enviar correo ' + $e);
        $this->response->statusCode(300);
        $model->rollback();
      }
    }

    $this->set(compact('rs'));
  }

  public function index() {
    if ($ref = $this->request->query('ref') && !empty($ref)) {
      $this->Session->write('App.reference', $ref);
    }
  }

  public function convenio_edu() {
  }

  public function oferta_edu() {
  }

  public function mas_info_edu() {
  }

  public function contacto() {
    $this->loadModel('Catalogo');
    $medio= $this->Catalogo->get_list('MEDIO_CVE');
    $this->set(compact('medio'));
  }

  public function preguntas_frecuentes_candidato() {
  }

  public function preguntas_frecuentes_convenios() {
  }

  public function preguntas_frecuentes_empresas() {
  }

  public function empresa($id = null) {
    $this->set('opcion', $id);
  }

  public function quienes_somos() {
  }

  public function objetivo() {
  }

  public function politica() {
  }

  public function valores() {
  }

  public function terminos_condiciones() {
  }

  public function aviso_privacidad () {
  }

  public function clientes() {
  }
}


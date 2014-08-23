<?php

App::uses('Sanitize', 'Utility');

App::import("Vendor","funciones");

/**
 * Controlador general de la aplicación.
 */
class InfoController extends AppController {

  /**
    * Indica qué modelos se usarán. Un array vacío, indica que no usará algún modelo.
    */
  public $uses = array();

  /**
    * Componentes necesarios que utiliza el Controlador.
    * @var Array
    */
  public $components = array('Session', 'Emailer','EmailerPHP','VisualCaptcha','Notificaciones');
  public static $prueb=1;
  public $helpers = array(
                            'Form' =>
                                  array('className' => 'Formito'),
                            'Html'=>
                                  array("className"=>"Htmlito"),
                            "Js",
                            'VisualCaptcha' );

  /**
    * Método que se ejecuta antes de cualquier acción.
    */
  public function beforeFilter() {
    parent::beforeFilter();
    // $this->Components->unload('DebugKit.Toolbar');

    /**
     * Todas las acciones contenidas en este controlador están permitidas.
     */
    $this->Auth->allow();

    if ($this->Acceso->is() !== 'admin') {
      $this->Auth->deny(array('admin_servicios'));
    }
  }

  public function estados($pais = 1) {
    $estados = ClassRegistry::init('Estado')->getEstadosList($pais);
    $this->set(compact('estados'));
  }

  public function ciudades($edo) {
    $ciudades = ClassRegistry::init('Ciudad')->getCiudadesList(1, $edo);
    $this->set(compact('ciudades'));
  }

  public function tipos($type) {
    if ($type === 'evento') {
      $type = 'TIPO_EVENTO';
    }

    $results = ClassRegistry::init('Catalogo')->lista($type);
    $this->set('_results', $results);
  }

  public function codigo_postal($value) {
    $cps = ClassRegistry::init('CodigoPostal')->getCP($value);
    if (empty($cps)) {
      $this->response->statusCode(404);
      $this->error('El código postal no existe o no está en nuestros registros.');
    }

    $this->set('cps', $cps);
  }

  public function giros() {
    $giros = ClassRegistry::init('Catalogo')->lista('giros');
    $this->set('giros', $giros);
  }

  public function carreras() {
    $carreras = array();
    /**
      *
      */
    $query = null;
    if (isset($this->request->query['query']) && ($query = $this->request->query['query'])) {
      $query = Sanitize::paranoid($query, str_split(' ÁáÉéÍíÓóÚúñÑ'));
      $query = strtoupper($query);
    }

    $carreras = ClassRegistry::init('Catalogo')->carreras($query);

    $this->set(compact('carreras'));
  }

  public function etiquetas() {
    $etiquetas = array();
    /**
      *
      */
    if (isset($this->request->query['query']) && ($query = $this->request->query['query'])) {
      $query = Sanitize::paranoid($query, str_split(' ÁáÉéÍíÓóÚúñÑ'));
      //$query = strtoupper($query);
      $etiquetas = ClassRegistry::init('Etiqueta')->lista($query);
    }

    $this->set(compact('etiquetas'));
  }

  public function admin_servicios () {
    $servicios = array();
    $query = null;
    /**
      *
      */
    if (isset($this->request->query['query']) && ($query = $this->request->query['query'])) {
      $query = Sanitize::paranoid($query, str_split(' ÁáÉéÍíÓóÚúñÑ'));
      //$query = strtoupper($query);
    }
    $servicios = ClassRegistry::init('Servicio')->lista($query);

    $this->set(compact('servicios'));
  }


  public function prueba(){
   
    $models= App::objects('Model');
    $collection=array();
    $names=array();
    $collection=array();
    foreach ($models as $key => $value) {
      $model= ClassRegistry::init($value);
        
      if( empty($model->primaryKey ) || empty($model->useTable) ||  (!empty($model->useTable) && $model->useTable[0] !=='t'  )   ) {
        continue;
      }

      /*select {$model->primaryKey} from  {$model->useTable} where rownum<=1*/
      $rsul=$model->nextId();
      if(empty($rsul)){
        continue;
      }
      $collection[$model->useTable]= array("nextval" => $rsul, "model" =>$model );
    }

    foreach ($collection as $name_model => $info) {
      $model=$info['model'];
      $name_s=substr($model->useTable, 1);
      $create="create  sequence s{$name_s} start with $info[nextval] increment by 1;";
      echo "$create <br>";
    }
    $tablas=array_keys($collection);
    sort($tablas);

    foreach ($tablas  as $key => $tabla) {
            echo "$tabla <br>";
      }  
    die;


}

  public function prueba_correo($correo="nuestroempleoregistra@hotmail.com",$nombre="prueba de correo",$contrasena="prueba de envio"){

  $this->Emailer->sendEmail($correo,
                'Encuesta de Referencia',
                'encuesta_referencia',
                array("data"=>array("nombre_referencia"=>$nombre ,
                                    'nombre_' =>  isset($this->user['candidato_cve']) ? $this->user['Candidato']['nombre_']:"anonimo" ,
                                    'keycode' => $contrasena,
                                    "refcan_cve"=>'jajajajaj' )));// enviamos correo


  }




}
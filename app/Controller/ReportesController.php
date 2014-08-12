<?php

App::uses('BaseEmpresasController', 'Controller');

class ReportesController extends AppController {
  public $name = 'Reportes';

  public $uses = array();

  public $helpers = array('Excel','CandidatoReporte');
  public $components = array('Upload'); 

  protected $dates = array();

  public function beforeFilter() {
    parent::beforeFilter();

    $this->autoLayout = true;
    $query = $this->request->query;

    if (!empty($this->request->params['ext']) && $this->request->params['ext'] === 'xls') {
      $this->layout = false;
      // $this->response->type(array('xls' => 'application/vnd.ms-excel'));
      // $this->response->type('xls');
    }

    /**
     * Busca los parámetros en el query de las fechas de inicio y fin.
     */
    if (!empty($query['initDate']) && !empty($query['finalDate'])) {
      //debug($this->request->query);die;
      $this->dates = array(
        'ini' => strtotime(date('m/01/Y 00:00:00', strtotime($query['initDate']))),
        'end' => strtotime(date('m/t/Y 23:59:59', strtotime($query['finalDate'])))
      );
    }

    /**
     * Busca los parámetros en el query de las fechas de inicio y fin.
     */
    if (!empty($query['ini']) && !empty($query['end'])) {
      //debug($this->request->query);die;
      $this->dates = array(
        'ini' => $query['ini'],
        'end' => $query['end']
      );
    }

    $this->set('_dates', $this->dates);
  }
  public function admin_internos() {
    $title_for_layout = 'Reportes de Internos';
    if ($this->request->is('post')) {
      $data = $this->request->data;
      if (!empty($data['type'])) {
        date_default_timezone_set('UTC');
        // Primer día del mes.
        $initDate = strtotime(date('m/01/Y 00:00:00', strtotime($data['initDate'])));
        // Este formato obtiene el último día de mes ('t' se refiere a días del mes).
        $finalDate = strtotime(date('m/t/Y 23:59:59', strtotime($data['finalDate'])));

         $params= array(
            'ini' => $initDate,
            'end' => $finalDate
          );
         if( isset( $data['tipoEmpresa'] ) ){
            $params['tipo']= $data['tipoEmpresa'];
         }
         if( isset ($data['usuario'] ) ){
          $params['usuario']=$data['usuario'];
         }
         $r=array(
          'admin' =>true,
          'controller' => 'reportes',
          'action' => $data['type'],
          'ext' => 'json',
          '?' => $params
        );
        $this->redirect($r, 'request');
      } else {
        $this->error(__('Selecciona al menos una opción a graficar.'));
      }
    }
    $usuarios = ClassRegistry::init('UsuarioAdmin')->getAdmins($this->Auth->user('cu_cve'));
    $this->set(compact('title_for_layout','usuarios'));
  }

  public function admin_masivos(){
    $title_for_layout = 'Reportes Masivos';

    if ($this->request->is('post')) {
      $data = $this->request->data;
      if (!empty($data['type'])) {
          $params= array(
            'idProceso' => 0
          );          
        $file=$this->Upload->post(false);
         $r=array(
          'admin' =>true,
          'controller' => 'reportes',
          'action' => $data['type'],
          'ext' => 'json',
          '?' => $params
        );            
          debug($file);
          debug($this->request->data);
          debug($r);
          die;
        $this->redirect($r, 'request');
      } else {
        $this->error(__('Selecciona al menos una opción a graficar.'));
      }
    }
    $this->set(compact('title_for_layout'));

  }


  public function admin_masivos_candidato(){
    $id= $this->request->query('idProceso');
  }


  public  function admin_internos_productos(){
    $title_for_layout = 'Ventas Totales de Producto';
    $dates = $this->dates;
    $data=$this->request->query;
    $tipo = !isset($data['tipo']) ? 't': (  $data['tipo'] === 'convenio' ? 'c' : ($data['tipo']==='comercial' ? 'n' :'t' ) );
    $productos = ClassRegistry::init('ProductoReporte')->find('productos_adquiridos',array(        
        'dates' => $this->dates,
         'tipo' =>  $tipo,
         'cu_cve' => $this->Auth->user('cu_cve')
      ));
      $title_for_layout= $title_for_layout. ($tipo==='c'? ' por Convenio ':(  $tipo==='n' ? ' por Comercio ' :'' ) );
    $this->set(compact('title_for_layout', 'productos'));
  }

  public  function admin_internos_productos_cuenta(){
    $dates = $this->dates;
    $data=$this->request->query;
    $title_for_layout = 'Ventas Totales de Producto por Cuenta de Ejecutivo';
    $tipo = !isset($data['tipo']) ? 't': (  $data['tipo'] === 'convenio' ? 'c' : ($data['tipo']==='comercial' ? 'n' :'t' ) );
    $productos = ClassRegistry::init('ProductoReporte')->find('productos_adquiridos_cuenta',array(        
        'dates' => $this->dates,
         'tipo' =>  $tipo,
         'cu_cve' => $this->Auth->user('cu_cve')
      ));
      $title_for_layout= $title_for_layout. ($tipo==='c'? ' por Convenio ':(  $tipo==='n' ? ' por Comercio ' :'' ) );
    $this->set(compact('title_for_layout', 'productos'));
  }

  public  function admin_internos_productos_ventas_usuario(){
    $title_for_layout = 'Ventas por Ejecutivo';
    $dates = $this->dates;
    $data=$this->request->query;    
    $tipo = !isset($data['tipo']) ? 't': (  $data['tipo'] === 'convenio' ? 'c' : ($data['tipo']==='comercial' ? 'n' :'t' ) );
    if(!isset($data['usuario']) ){
      $this->error("Seleccione usuario");
      return ;
    }
    $usuario= $data['usuario'];
    $reporte=ClassRegistry::init('ProductoReporte');
    $info_usu= $reporte->getDataUser($usuario);
    $productos = $reporte->find('productos_usuario',array(        
        'dates' => $this->dates,
         'tipo' =>  $tipo,
         'cu_cve' => $this->Auth->user('cu_cve'),
         'usuario' => $usuario
      ));
      $title_for_layout= $title_for_layout. ($tipo==='c'? ' por Convenio ':(  $tipo==='n' ? ' por Comercio ' :'' ) );
      $title_for_layout= "$title_for_layout $info_usu";
    $this->set(compact('title_for_layout', 'productos'));

  }

    public function admin_index() {
    $title_for_layout = 'Reportes';
    if ($this->request->is('post')) {
      $data = $this->request->data;
      if (!empty($data['type'])) {
        date_default_timezone_set('UTC');
        // Primer día del mes.
        $initDate = strtotime(date('m/01/Y 00:00:00', strtotime($data['initDate'])));
        // Este formato obtiene el último día de mes ('t' se refiere a días del mes).
        $finalDate = strtotime(date('m/t/Y 23:59:59', strtotime($data['finalDate'])));
        $redi=array(
          'admin' =>true,
          'controller' => 'reportes',
          'action' => $data['type'],
          'ext' => 'json',
          '?' => array(
            'ini' => $initDate,
            'end' => $finalDate
          )
        );
        $this->redirect($redi, 'request');
      } else {
        $this->error(__('Selecciona al menos una opción a graficar.'));
      }
    }

    $this->set(compact('title_for_layout'));
  }


  public function admin_candidatos_registrados(){

     $title_for_layout = __('Candidatos Registrados');
      $dates = $this->dates;
      $candidatosCount = ClassRegistry::init('CandidatoReporte')->find('candidatos', array(
        'dates' => $this->dates
      ));
    $this->set(compact('title_for_layout', 'candidatosCount'));
  }

    public function admin_candidatos_completos(){

      $title_for_layout = __('Candidatos con CV Completo');
      $dates = $this->dates;
      $candidatosCount = ClassRegistry::init('CandidatoReporte')->find('candidatos', array(
        'completo' => true,
        'dates' => $this->dates
      ));
    $this->set(compact('title_for_layout', 'candidatosCount'));

    
  }


    public function admin_candidatos_activos(){

      $title_for_layout = __('Candidatos con CV Completo');
      $dates = $this->dates;
      $candidatosCount = ClassRegistry::init('CandidatoReporte')->find('candidatos', array(
        'activos' => true,
        'dates' => $this->dates
      ));
    $this->set(compact('title_for_layout', 'candidatosCount'));

    
  }

      public function admin_candidatos_sin_activar(){

      $title_for_layout = __('Candidatos Sin Activar');
      $dates = $this->dates;
      $candidatosCount = ClassRegistry::init('CandidatoReporte')->find('candidatos', array(
        'sin_activar' => true,
        'dates' => $this->dates
      ));
    $this->set(compact('title_for_layout', 'candidatosCount'));

    
  }


  public function  admin_candidatos_perfil(){

      $title_for_layout = __('Candidatos con Perfil Rápido');
      $dates = $this->dates;
      $candidatosCount = ClassRegistry::init('CandidatoReporte')->find('candidatos', array(
        'perfil' => true,
        'dates' => $this->dates
      ));
    $this->set(compact('title_for_layout', 'candidatosCount'));

    
  }

    public function  admin_candidatos_inactivos(){

      $title_for_layout = __('Candidatos Inactivos');
      $dates = $this->dates;
      $candidatosCount = ClassRegistry::init('CandidatoReporte')->find('candidatos', array(
        'inactivos' => true,
        'dates' => $this->dates
      ));
    $this->set(compact('title_for_layout', 'candidatosCount'));  
  }

  public function admin_candidatos_genero(){
    $title_for_layout = __('Candidatos por Genero');
      $dates = $this->dates;
      $candidatos = ClassRegistry::init('CandidatoReporte')->find('genero', array(
        'dates' => $this->dates
      ));
    $this->set(compact('title_for_layout', 'candidatos'));  

  }


    public function admin_candidatos_entidad(){
      $title_for_layout = __('Candidatos por Zona');
      $data = array();
      $dates = $this->dates;
      $candidatos = ClassRegistry::init('CandidatoReporte')->find('estado', array(
        'dates' => $this->dates
      ));

    foreach ($candidatos as $key => $value) {
      $d = $value['CandidatoReporte']; $cat = $d['estado']; $_t = (int)$d['candidatos'];
      $data[$cat]['_data'][] = array(
        'zona' => $d['ciudad'],
        'total' => $_t
      );

      $data[$cat]['_legend'][] = array(
        'title' => sprintf('%s [%d]', $d['ciudad'], $_t),
        'color' => 'transparent'
      );
      $data[$cat]['zona'] = $cat;
      $data[$cat]['total'] = $_t + (isset($data[$cat]['total']) ? (int)$data[$cat]['total']: 0);
    }
    $this->set(compact('title_for_layout', 'data'));  

  }


  public function admin_candidatos_edad(){
         $title_for_layout = __('Candidatos por Edad');

    $candidatos = ClassRegistry::init('CandidatoReporte')->find('edad', array(
      'dates' => $this->dates
    ));
    $this->set(compact('title_for_layout', 'candidatos'));

  }
  public function admin_ofertas_publicadas() {
    $title_for_layout = __('Ofertas Publicadas');
    $dates = $this->dates;

    $ofertasCount = ClassRegistry::init('OfertaReporte')->find('ofertas_publicadas', array(
      'cu_cve' => $this->Auth->user('cu_cve'),
      'dates' => $this->dates
    ));

    $this->set(compact('title_for_layout', 'ofertasCount'));
  }

  public function admin_ofertas_publicadas_cia() {
    $title_for_layout = __('Ofertas Publicadas por Compañia');
    $dates = $this->dates;
    $ofertasCount = ClassRegistry::init('OfertaReporte')->find('ofertas_publicadas_xcia', array(
      'admin' => true,
      'cu_cve' =>$this->Auth->user('cu_cve'),
      'dates' => $this->dates
    ));

    $this->set(compact('title_for_layout', 'ofertasCount'));
  }

  public function admin_ofertas_categorias(){
      $title_for_layout = __('Ofertas por Área');
    $data = array();

    $ofertasCount = ClassRegistry::init('OfertaReporte')->find('ofertas_categorias', array(
      'cu_cve' => $this->Auth->user('cu_cve'),
      'areas' => true,
      'dates' => $this->dates
    ));

    foreach ($ofertasCount as $key => $value) {
      $d = $value['OfertaReporte']; $cat = $d['categoria']; $_t = (int)$d['ofertas'];
      $data[$cat]['_data'][] = array(
        'categoria' => $d['area'],
        'total' => $_t
      );

      $data[$cat]['_legend'][] = array(
        'title' => sprintf('%s [%d]', $d['area'], $_t),
        'color' => 'transparent'
      );

      $data[$cat]['categoria'] = $cat;
      $data[$cat]['total'] = $_t + (isset($data[$cat]['total']) ? (int)$data[$cat]['total']: 0);
    }

    $this->set(compact('title_for_layout', 'data'));
  }


   public function admin_ofertas_usuarios() {
    $title_for_layout = __('Ofertas por Usuario');

    $ofertasCount = ClassRegistry::init('UsuarioReporte')->ofertas_publicadas(array(
      'cia_cve' =>"",
      'cu_cve' => $this->Auth->user('cu_cve'),
      'dates' => $this->dates
    ));

    $this->set(compact('title_for_layout', 'ofertasCount'));
  }

  public function admin_ofertas_coordinacion() {
    $title_for_layout = __('Ofertas por Coordinación');

    $ofertasCount = ClassRegistry::init('UsuarioReporte')->ofertas_cordinacion(array(
      'cia_cve' => "",
      'cu_cve' => $this->Auth->user('cu_cve'),
      'dates' => $this->dates
    ));

    $this->set(compact('title_for_layout', 'ofertasCount'));
  }

    public function admin_ofertas_tipo() {
    $title_for_layout = __('Ofertas por Tipo');

    $ofertasCount = ClassRegistry::init('OfertaReporte')->find('ofertas_tipo', array(
      'cu_cve' => $this->Auth->user('cu_cve'),
      'dates' => $this->dates
    ));

    $this->set(compact('title_for_layout', 'ofertasCount'));
  }

 public function admin_ofertas_zona() {
    $title_for_layout = __('Ofertas por Zona');
    $data = array();

    $ofertasCount = ClassRegistry::init('OfertaReporte')->find('ofertas_zona', array(
      'cu_cve' => $this->Auth->user('cu_cve'),
      'dates' => $this->dates
    ));

    foreach ($ofertasCount as $key => $value) {
      $d = $value['OfertaReporte']; $cat = $d['estado']; $_t = (int)$d['ofertas'];
      $data[$cat]['_data'][] = array(
        'zona' => $d['ciudad'],
        'total' => $_t
      );

      $data[$cat]['_legend'][] = array(
        'title' => sprintf('%s [%d]', $d['ciudad'], $_t),
        'color' => 'transparent'
      );

      $data[$cat]['zona'] = $cat;
      $data[$cat]['total'] = $_t + (isset($data[$cat]['total']) ? (int)$data[$cat]['total']: 0);
    }

    $this->set(compact('title_for_layout', 'data'));
  }


    public function admin_postulaciones() {
    $title_for_layout = __('Total de Postulaciones');

    $postulaciones = ClassRegistry::init('PostulacionReporte')->find('total', array(
      'cu_cve' => $this->Auth->user('cu_cve'),
      'dates' => $this->dates
    ));

    $this->set(compact('title_for_layout', 'postulaciones'));
  }

     public function admin_postulaciones_cia() {
    $title_for_layout = __('Total de Postulaciones por Compañia');

    $postulaciones = ClassRegistry::init('PostulacionReporte')->find('por_cia', array(
      'cu_cve' => $this->Auth->user('cu_cve'),
      'dates' => $this->dates
    ));

    $this->set(compact('title_for_layout', 'postulaciones'));
  }

  public function admin_postulaciones_genero() {
    $title_for_layout = __('Postulaciones por Sexo');

    $postulaciones = ClassRegistry::init('PostulacionReporte')->find('por_genero', array(
      'cu_cve' => $this->Auth->user('cu_cve'),
      'dates' => $this->dates
    ));

    $this->set(compact('title_for_layout', 'postulaciones'));
  }

  public function admin_postulaciones_edad() {
    $title_for_layout = __('Postulaciones por Edad');

    $postulaciones = ClassRegistry::init('PostulacionReporte')->find('por_edad', array(
      'cu_cve' => $this->Auth->user('cu_cve'),
      'dates' => $this->dates
    ));

    $this->set(compact('title_for_layout', 'postulaciones'));
  }

  public function admin_postulaciones_escolaridad() {
    $title_for_layout = __('Postulaciones por Escolaridad');

    $postulaciones = ClassRegistry::init('PostulacionReporte')->find('por_escolaridad', array(
      'cia_cve' => $this->Auth->user('Empresa.cia_cve'),
      'cu_cve' => $this->Auth->user('cu_cve'),
      'dates' => $this->dates
    ));

    $this->set(compact('title_for_layout', 'postulaciones'));
  }



   public function admin_empresas_zona() {
    $title_for_layout = __('Empresas por Zona');
    $data = array();
    $empresas = ClassRegistry::init('EmpresaReporte')->find('zona', array(
      'dates' => $this->dates
    ));
    foreach ($empresas as $key => $value) {
      $d = $value['EmpresaReporte']; $cat = $d['estado']; $_t = (int)$d['empresas'];
      $data[$cat]['_data'][] = array(
        'zona' => $d['ciudad'],
        'total' => $_t
      );
      $data[$cat]['_legend'][] = array(
        'title' => sprintf('%s [%d]', $d['ciudad'], $_t),
        'color' => 'transparent'
      );
      $data[$cat]['zona'] = $cat;
      $data[$cat]['total'] = $_t + (isset($data[$cat]['total']) ? (int)$data[$cat]['total']: 0);
    }

    $this->set(compact('title_for_layout', 'data'));
  }

    public function admin_empresas_giro() {
    $title_for_layout = __('Empresas por Giro');
    $dates = $this->dates;

    $empresas = ClassRegistry::init('EmpresaReporte')->find('giro', array(      
      'dates' => $this->dates
    ));

    $this->set(compact('title_for_layout', 'empresas'));
  }

   public function admin_empresas_tipo() {
    $title_for_layout = __('Empresas por Tipo');

    $empresas = ClassRegistry::init('EmpresaReporte')->find('tipo', array(      
      'dates' => $this->dates
    ));

    $this->set(compact('title_for_layout', 'empresas'));
  }

  public function admin_empresas_por_cuenta(){
    $title_for_layout = __('Empresas por Asignación de Cuenta ');

    $empresas = ClassRegistry::init('EmpresaReporte')->find('por_cuenta', array(     
      'cu_cve' => $this->Auth->user('cu_cve'), 
      'dates' => $this->dates
    ));

    $this->set(compact('title_for_layout', 'empresas'));

  }


  public function admin_productos_adquiridos() {
    $productos = ClassRegistry::init('ProductoReporte')->find('productos_adquiridos');

    $this->set(compact('productos'));


  }
}
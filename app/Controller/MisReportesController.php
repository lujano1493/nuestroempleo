<?php

App::uses('BaseEmpresasController', 'Controller');

class MisReportesController extends BaseEmpresasController {
  public $name = 'MisReportes';

  public $uses = array();

  public $helpers = array('Excel');

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

  public function index() {
    $title_for_layout = 'Mis Reportes';

    if ($this->request->is('post')) {
      $data = $this->request->data;

      if (!empty($data['type'])) {
        date_default_timezone_set('UTC');
        // Primer día del mes.
        $initDate = strtotime(date('m/01/Y 00:00:00', strtotime($data['initDate'])));

        // Este formato obtiene el último día de mes ('t' se refiere a días del mes).
        $finalDate = strtotime(date('m/t/Y 23:59:59', strtotime($data['finalDate'])));

        $this->redirect(array(
          'controller' => 'mis_reportes',
          'action' => $data['type'],
          'ext' => 'json',
          '?' => array(
            'ini' => $initDate,
            'end' => $finalDate
          )
        ), 'request');
      } else {
        $this->error(__('Selecciona al menos una opción a graficar.'));
      }
    }

    $this->set(compact('title_for_layout'));
  }

  public function ofertas_publicadas() {
    $title_for_layout = __('Ofertas Publicadas');
    $dates = $this->dates;

    $ofertasCount = ClassRegistry::init('OfertaReporte')->find('ofertas_publicadas', array(
      'cia_cve' => $this->Auth->user('Empresa.cia_cve'),
      'cu_cve' => $this->Auth->user('cu_cve'),
      'dates' => $this->dates
    ));

    $this->set(compact('title_for_layout', 'ofertasCount'));
  }

  public function ofertas_categorias() {
    $title_for_layout = __('Ofertas por Área');
    $data = array();

    $ofertasCount = ClassRegistry::init('OfertaReporte')->find('ofertas_categorias', array(
      'cia_cve' => $this->Auth->user('Empresa.cia_cve'),
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

  public function ofertas_usuarios() {
    $title_for_layout = __('Ofertas por Usuario');

    $ofertasCount = ClassRegistry::init('UsuarioReporte')->ofertas_publicadas(array(
      'cia_cve' => $this->Auth->user('Empresa.cia_cve'),
      'cu_cve' => $this->Auth->user('cu_cve'),
      'dates' => $this->dates
    ));

    $this->set(compact('title_for_layout', 'ofertasCount'));
  }

  public function ofertas_coordinacion() {
    $title_for_layout = __('Ofertas por Coordinación');

    $ofertasCount = ClassRegistry::init('UsuarioReporte')->ofertas_cordinacion(array(
      'cia_cve' => $this->Auth->user('Empresa.cia_cve'),
      'cu_cve' => $this->Auth->user('cu_cve'),
      'dates' => $this->dates
    ));

    $this->set(compact('title_for_layout', 'ofertasCount'));
  }

  public function ofertas_tipo() {
    $title_for_layout = __('Ofertas por Tipo');

    $ofertasCount = ClassRegistry::init('OfertaReporte')->find('ofertas_tipo', array(
      'cia_cve' => $this->Auth->user('Empresa.cia_cve'),
      'cu_cve' => $this->Auth->user('cu_cve'),
      'dates' => $this->dates
    ));

    $this->set(compact('title_for_layout', 'ofertasCount'));
  }

  public function ofertas_zona() {
    $title_for_layout = __('Ofertas por Zona');
    $data = array();

    $ofertasCount = ClassRegistry::init('OfertaReporte')->find('ofertas_zona', array(
      'cia_cve' => $this->Auth->user('Empresa.cia_cve'),
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

  public function postulaciones() {
    $title_for_layout = __('Total de Postulaciones');

    $postulaciones = ClassRegistry::init('PostulacionReporte')->find('total', array(
      'cia_cve' => $this->Auth->user('Empresa.cia_cve'),
      'cu_cve' => $this->Auth->user('cu_cve'),
      'dates' => $this->dates
    ));

    $this->set(compact('title_for_layout', 'postulaciones'));
  }

  public function postulaciones_genero() {
    $title_for_layout = __('Postulaciones por Sexo');

    $postulaciones = ClassRegistry::init('PostulacionReporte')->find('por_genero', array(
      'cia_cve' => $this->Auth->user('Empresa.cia_cve'),
      'cu_cve' => $this->Auth->user('cu_cve'),
      'dates' => $this->dates
    ));

    $this->set(compact('title_for_layout', 'postulaciones'));
  }

  public function postulaciones_edad() {
    $title_for_layout = __('Postulaciones por Edad');

    $postulaciones = ClassRegistry::init('PostulacionReporte')->find('por_edad', array(
      'cia_cve' => $this->Auth->user('Empresa.cia_cve'),
      'cu_cve' => $this->Auth->user('cu_cve'),
      'dates' => $this->dates
    ));

    $this->set(compact('title_for_layout', 'postulaciones'));
  }

  public function postulaciones_escolaridad() {
    $title_for_layout = __('Postulaciones por Escolaridad');

    $postulaciones = ClassRegistry::init('PostulacionReporte')->find('por_escolaridad', array(
      'cia_cve' => $this->Auth->user('Empresa.cia_cve'),
      'cu_cve' => $this->Auth->user('cu_cve'),
      'dates' => $this->dates
    ));

    $this->set(compact('title_for_layout', 'postulaciones'));
  }

  public function ofertas_postulaciones() {
    $title_for_layout = __('Ofertas vs Candidatos Postulados');

    $postulaciones = ClassRegistry::init('PostulacionReporte')->find('total', array(
      'cia_cve' => $this->Auth->user('Empresa.cia_cve'),
      'cu_cve' => $this->Auth->user('cu_cve'),
      'dates' => $this->dates
    ));

    $ofertas = ClassRegistry::init('OfertaReporte')->find('ofertas_publicadas', array(
      'cia_cve' => $this->Auth->user('Empresa.cia_cve'),
      'cu_cve' => $this->Auth->user('cu_cve'),
      'dates' => $this->dates
    ));

    $this->set(compact('title_for_layout', 'postulaciones', 'ofertas'));
  }

  public function creditos_ocupados() {
    $title_for_layout = __('Créditos Ocupados por Usuario');

    $creditos = ClassRegistry::init('UsuarioReporte')->creditos(array(
      'cia_cve' => $this->Auth->user('Empresa.cia_cve'),
      'cu_cve' => $this->Auth->user('cu_cve'),
      'dates' => $this->dates
    ));

    $this->set(compact('title_for_layout', 'creditos'));
  }
}
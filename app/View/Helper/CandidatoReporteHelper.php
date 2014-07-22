<?php

App::uses('Helper', 'View');

class CandidatoReporteHelper extends Helper {
	public $helpers = array(
    	'Time' => array('className' => 'Tiempito', 'engine' => 'Tiempito'),
    	'Grafito',
    	'Excel'
  		);
  public function formatToJson($candidatosCount, $options = array()) {

  	$_options=array();

  	$title_for_layout=$this->_View->viewVars['title_for_layout'];
  	$_dates=$this->_View->viewVars['_dates'];
  	$data = array();
  	foreach ($candidatosCount as $key => $value) {
  		$o = $value['CandidatoReporte'];

  		$data[] = array(
  			'mes' => $this->Time->month($o['mes'], (int)$o['anio']),
  			'total' => (int)$o['candidatos']
  			);
  	}

  	$color = $this->Grafito->color();
  	$_results = $this->Grafito->serial($data, array(
  		'title' => array(
  			$title_for_layout,
  			__('De %s a %s', $this->Time->month($_dates['ini']), $this->Time->month($_dates['end']))
  			)
  		), array(
  		'categoryField' => 'mes',
  		'categoryAxis'=> array(
  			'gridPosition'=> 'start'
  			),
  		'valueAxes'=> array(
  			array(
  				'position' => 'top',
  				'title' => __('Candidatos'),
  				'minorGridEnabled' => true
  				)
  			),
  		'graphs'=> array(
  			array(
  				'type'=> 'column',
  				'title'=> $title_for_layout,
  				'valueField'=> 'total',
  				'fillAlphas'=> 1,
  				'balloonText'=> "<span style='font-size=>13px;'>[[title]] en [[mes]]=><b>[[value]]</b></span>",
  				'legendColor' => $color,
  				'fillColors' => $color,
  				'lineColor' => $color,
  				),
  			),
  		'legend' => array(
  			'position' => 'right',
  			'periodValueText' => '[[value.sum]]',
  			'data' => Hash::map($data, '{n}', function ($v) use ($color) {
  				return array(
  					'title' => sprintf('%s [%d]', $v['mes'], $v['total']),
  					'color' => $color
  					);
  			}),
  			),
  		'rotate' => true
  		));
return $_results;


  }


  public function formatToExcel($candidatosCount, $options = array()){

  	/** Error reporting */
// error_reporting(E_ALL);
// ini_set('display_errors', TRUE);
// ini_set('display_startup_errors', TRUE);
// date_default_timezone_set('Europe/London');

	if (PHP_SAPI == 'cli')
	  die('This example should only be run from a Web Browser');

	// Create new PHPExcel object
	$this->Excel->createWorksheet();

	// Set document properties
	// $this->Excel->getProperties()
	//   ->setCreator("Maarten Balliauw")
	//   ->setLastModifiedBy("Maarten Balliauw")
	//   ->setTitle("Office 2007 XLSX Test Document")
	//   ->setSubject("Office 2007 XLSX Test Document")
	//   ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
	//   ->setKeywords("office 2007 openxml php")
	//   ->setCategory("Test result file");
	
	$_options=array(
			'namefile' => "excel"
	);

	$options= array_merge($_options,$options);	
  	$title_for_layout=$this->_View->viewVars['title_for_layout'];
  	$_dates=$this->_View->viewVars['_dates'];
	$table = array(
	  array('label' => __('Fecha'), 'filter' => true),
	  array('label' => __('Candidatos'), 'filter' => true)
	);

	$this->Excel
	  ->setTopTitle($title_for_layout)
	  ->getActiveSheet()
	  ->setTitle('CandidatosRegistrados');

	$data = array();
	foreach ($candidatosCount as $d) {
	  $o = $d['CandidatoReporte'];
	  $data[] = array(
	    $this->Time->month($o['mes'], (int)$o['anio']), // Mes
	    $o['candidatos']                                   // Total
	  );
	}

	$this->Excel->addTableAndChart($table, $data, array(
	  'chartName' => __('Candidatos_publicadas'),
	  'yLabel' => __('Candidatos'),
	));

	$this->Excel
	  ->addTableFooter();

	$this->Excel->setActiveSheetIndex(0);
	$fix="";
	if(!empty($_dates)){
		$fix= !empty($_dates['ini']) ? date('d-m-Y' ,$_dates['ini']) : "";
		$fix.=  "__" . (!empty($_dates['end']) ? date('d-m-Y',$_dates['end']): "");
		$fix=Inflector::slug( "$fix",'_');
	}
	$namefile="$options[namefile]__$fix";
	$this->Excel->output(   "$namefile.xlsx");


  }

  


}

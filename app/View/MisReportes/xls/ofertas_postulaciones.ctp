<?php
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

$table = array(
  array('label' => __('Fecha'), 'filter' => true),
  array('label' => __('Ofertas'), 'filter' => true),
  array('label' => __('Postulaciones'), 'filter' => true)
);

$this->Excel
  ->setTopTitle($title_for_layout)
  ->getActiveSheet()
  ->setTitle('OfertasPotulaciones');

$postulaciones = Hash::combine($postulaciones,
  '{n}.PostulacionReporte.mes',
  '{n}.PostulacionReporte.total',
  '{n}.PostulacionReporte.anio'
);

$data = array();
foreach ($ofertas as $key => $value) {
  $o = $value['OfertaReporte'];
  $p = !empty($postulaciones[$o['anio']][$o['mes']]) ? $postulaciones[$o['anio']][$o['mes']] : 0;
  $data[] = array(
    $this->Time->month($o['mes'], (int)$o['anio']),
    (int)$o['ofertas'],
    $p
  );
}


$this->Excel->addTableAndChart($table, $data, array(
  'type' => 'line',
  'chartName' => 'ofertas_postulaciones',
));

$this->Excel
  ->addTableFooter();

$this->Excel->setActiveSheetIndex(0);

$this->Excel->output('OfertasXPostulaciones.xlsx');
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
  array('label' => __('Tipo'), 'filter' => true),
  array('label' => __('Total'), 'filter' => true)
);
$fecini= $formatoCalendario === 2 ? $this->Time->month($_dates['ini']): $this->Time->pretty($_dates['ini'])  ;
$fecfin=  $formatoCalendario === 2 ? $this->Time->month($_dates['end']) : $this->Time->pretty($_dates['end']) ;
$this->Excel
  ->setTopTitle("$title_for_layout \n $fecini a $fecfin" )
  ->getActiveSheet()
  ->setTitle('EmpresasPublicadas');

$data = array();
foreach ($empresas as $d) {
  $o = $d['EmpresaReporte'];
  $data[] = array(
     $o['tipo'], // Mes
    $o['empresas']                                   // Total
  );
}

$this->Excel->addTableAndChart($table, $data, array(
  'chartName' => __('Empresas_publicadas'),
  'yLabel' => __('Empresas'),
));

$this->Excel
  ->addTableFooter();

$this->Excel->setActiveSheetIndex(0);

$this->Excel->output('EmpresasxTipo.xlsx');
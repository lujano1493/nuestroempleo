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
  array('label' => __('Correo')),
  array('label' => __('Nombre Completo')),
  array('label' => __('Fecha de Registro')),
  array('label' => __('Estado')),
  array('label' => __('Perfil Rapido')),
  array('label' => __('Perfil Completo')),
  array('label' => __('Fecha de Postulación')),
  array('label' => __('Id Oferta')),
  array('label' => __('Nombre de Puesto')),
  array('label' => __('Nombre de Compañia'))
);

$this->Excel
  ->setTopTitle($title_for_layout)
  ->getActiveSheet()
  ->setTitle('CandidatosCompletos');

$data = array();
foreach ($results as $d) {
  $o = $d['CorreoReporte'];
  $data[] = array(
	$o['correo'],
	$o['nombre'],
	$o['registrado'] ? $this->Time->dt($o['registrado']):null ,
	$o['estado'],
	$o['rapido'],
	$o['completo'],
	$o['fecha_p'] ? $this->Time->dt($o['fecha_p']):null,
	$o['oferta_id'],
	$o['oferta'],
	$o['cia']
  );
}
$this->Excel->addTableAndChart($table, $data, array(
  'chart' =>false
));

$this->Excel
  ->addTableFooter();
$this->Excel->setActiveSheetIndex(0);
$this->Excel->output('CandidatosStatus.xlsx');
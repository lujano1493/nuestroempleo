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

$table = array(
  array('label' => __('Género'), 'filter' => true),
  array('label' => __('Candidatos'), 'filter' => true)
);

$this->Excel
  ->setTopTitle($title_for_layout)
  ->getActiveSheet()
  ->setTitle('CandidatosXGenero');

$data = array();
foreach ($candidatos as $v) {
  $p = $v['CandidatoReporte'];
  $data[] = array(
    $p['genero'],     // Mes
    (int)$p['totales']  // Total
  );
}

$this->Excel->addTableAndChart($table, $data, array(
  'chartName' => __('Candidatos_genero'),
  'yLabel' => __('Candidatos'),
));

$this->Excel
  ->addTableFooter();

$this->Excel->setActiveSheetIndex(0);

$this->Excel->output('CandidatosXGenero.xlsx');
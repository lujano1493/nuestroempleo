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
  array('label' => __('Escolaridad'), 'filter' => true),
  array('label' => __('Postulaciones'), 'filter' => true)
);
$fecini= $formatoCalendario === 2 ? $this->Time->month($_dates['ini']): $this->Time->pretty($_dates['ini'])  ;
$fecfin=  $formatoCalendario === 2 ? $this->Time->month($_dates['end']) : $this->Time->pretty($_dates['end']) ;
$this->Excel
  ->setTopTitle("$title_for_layout \n $fecini a $fecfin" )
  ->getActiveSheet()
  ->setTitle('PostulacionesXEscolaridad');

$data = array();
foreach ($postulaciones as $v) {
  $p = $v['PostulacionReporte'];
  $data[] = array(
    $p['genero'],     // Mes
    (int)$p['total']  // Total
  );
}

$this->Excel->addTableAndChart($table, $data, array(
  'chartName' => __('postulaciones_escolaridad'),
  'yLabel' => __('Postulaciones'),
));

$this->Excel
  ->addTableFooter();

$this->Excel->setActiveSheetIndex(0);

$this->Excel->output('PostulacionesXEscolaridad.xlsx');
<?php
/** Error reporting */
// error_reporting(E_ALL);
// ini_set('display_errors', TRUE);
// ini_set('display_startup_errors', TRUE);
// date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
  die('This example should only be run from a Web Browser');

$this->Excel->createWorksheet();

$table = array(
  array('label' => __('Zona'), 'filter' => true),
  array('label' => __('Empresas'), 'filter' => true)
);
$fecini= $formatoCalendario === 2 ? $this->Time->month($_dates['ini']): $this->Time->pretty($_dates['ini'])  ;
$fecfin=  $formatoCalendario === 2 ? $this->Time->month($_dates['end']) : $this->Time->pretty($_dates['end']) ;
$this->Excel
  ->setTopTitle("$title_for_layout \n $fecini a $fecfin" )
  ->getActiveSheet()
  ->setTitle('EmpresasZonas');

$_data = array();
foreach ($data as $d => $v) {
  $zona = $v['zona'];
  foreach ($v['_data'] as $_k => $_v) {
    $_data[] = array(
      $zona . ' - ' . $_v['zona'],
      $_v['total']
    );
  }
}

$this->Excel->addTableAndChart($table, $_data, array(
  'chartName' => 'Empresas_zonas',
  'yLabel' => __('Ofertas'),
));

$this->Excel
  ->addTableFooter();

$this->Excel->setActiveSheetIndex(0);

$this->Excel->output('EmpresasxZona.xlsx');
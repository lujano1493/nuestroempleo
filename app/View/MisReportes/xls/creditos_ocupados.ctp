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
  array('label' => __('Usuario'), 'filter' => true),
  array('label' => __('Ofertas Publicadas'), 'filter' => true),
  array('label' => __('Ofertas Recomendadas'), 'filter' => true),
  array('label' => __('Ofertas Distinguidas'), 'filter' => true),
  array('label' => __('Liberaciones de CV'), 'filter' => true),
);

$this->Excel
  ->setTopTitle($title_for_layout)
  ->getActiveSheet()
  ->setTitle('CreditosOcupadosXUsuario');

$data = array();
foreach ($creditos as $key => $v) {
  $data[] = array(
    $key,
    $v['oferta_publicada']['ocupados'],
    $v['oferta_recomendada']['ocupados'],
    $v['oferta_distinguida']['ocupados'],
    $v['consulta_cv']['ocupados']
  );
}

$this->Excel->addTableAndChart($table, $data, array(
  'chartName' => __('credios_ocupados_usuario'),
  'yLabel' => __('Total de Créditos Ocupados por Usuario'),
));

$this->Excel
  ->addTableFooter();

$this->Excel->setActiveSheetIndex(0);

$this->Excel->output('CreditosOcupadosXUsuario.xlsx');
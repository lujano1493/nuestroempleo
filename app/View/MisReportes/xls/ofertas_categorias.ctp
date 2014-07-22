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
  array('label' => __('Categoria'), 'filter' => true),
  array('label' => __('Ofertas'), 'filter' => true)
);

$this->Excel
  ->setTopTitle($title_for_layout)
  ->getActiveSheet()
  ->setTitle('OfertasCategorias');

$_data = array();
foreach ($data as $d => $v) {
  $categoria = $v['categoria'];
  foreach ($v['_data'] as $_k => $_v) {
    $_data[] = array(
      $categoria . ' - ' . $_v['categoria'],
      $_v['total']
    );
  }
}

$this->Excel->addTableAndChart($table, $_data, array(
  'chartName' => __('ofertas_categorias'),
  'yLabel' => __('Ofertas'),
));

$this->Excel
  ->addTableFooter();

$this->Excel->setActiveSheetIndex(0);

$this->Excel->output('OfertasCategorias.xlsx');
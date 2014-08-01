<?php

  if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');


  // Create new PHPExcel object
  $this->Excel->createWorksheet();
  $table = array(
    array('label' => __('Nombre de Producto'), 'filter' => true),
    array('label' => __('Total'), 'filter' => true)
  );
  $title_for_layout=$title_for_layout.__(' De %s a %s', $this->Time->month($_dates['ini']), $this->Time->month($_dates['end']));
  $this->Excel
    ->setTopTitle($title_for_layout)
    ->getActiveSheet()
    ->setTitle('ProductoAdquiridos');


  $data = array();
  foreach ($productos as $d) {
    $o = $d['ProductoReporte'];
    $data[] = array(
       $o['membresia'] , // Nombre Producto
      $o['total']                                   // Total
    );
  }

  $this->Excel->addTableAndChart($table, $data, array(
    'chartName' => __('productos_vendidos'),
    'yLabel' => __('Cantidad'),
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
  $namefile="productos_adquiridos_{$fix}";
  $this->Excel->output(   "$namefile.xlsx");

?>
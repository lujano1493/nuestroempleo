<?php

require_once(ROOT . DS . 'vendor' . DS . 'phpoffice' . DS . 'phpexcel'. DS . 'Classes' . DS . 'PHPExcel.php');

class Excel {
  public static $headers = array(
    'Excel5' => array(
      'type' => 'application/vnd.ms-excel',
      'ext' => 'xls'
    ),
    'Excel2007' => array(
      'ext' => 'xlsx',
      'type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    )
  );

  public static function generate() {
    return new PHPExcel();
  }

  public function getContentType($writter) {
    return self::$headers[$writter]['type'];
  }
}
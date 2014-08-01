<?php
App::uses('AppHelper', 'View/Helper');
App::uses('Excel', 'Utility');


/**
 * Helper para PHPExcel.
 *
 * @package PhpExcel
 * @author segy
 */
class ExcelHelper extends AppHelper {

  /**
   * Instancia de PHPExcel
   *
   * @var PHPExcel
   */
  protected $_xls;

  /**
   * Puntero a la fila actual
   *
   * @var int
   */
  protected $_row = 1;

  /**
   * Internal table params
   *
   * @var array
   */
  protected $_tableParams;

  /**
   * Número de filas
   *
   * @var int
   */
  protected $_maxRow = 0;

  protected $topTitle = null;
  /**
   * Crea un nuevo archivo Excel
   *
   * @return $this for method chaining
   */
  public function createWorksheet() {

    $this->_xls = Excel::generate();
    $this->_row = 1;

    return $this;
  }

  /**
   * Crea un nuevo archivo a partir de uno existente.
   *
   * @param string $file path to excel file to load
   * @return $this for method chaining
   */
  public function loadWorksheet($file) {
    $this->_xls = PHPExcel_IOFactory::load($file);
    $this->setActiveSheet(0);
    $this->_row = 1;

    return $this;
  }

  /**
   * Agrega una nueva hoja.
   *
   * @param string $name
   * @return $this for method chaining
   */
  public function addSheet($name) {
    $index = $this->_xls->getSheetCount();
    $this->_xls
      ->createSheet($index)
      ->setTitle($name);

    $this->setActiveSheet($index);

    return $this;
  }

  /**
   * Activa una hoja del excel.
   *
   * @param int $sheet
   * @return $this for method chaining
   */
  public function setActiveSheet($sheet) {
    $this->_maxRow = $this->_xls
      ->setActiveSheetIndex($sheet)
      ->getHighestRow();

    $this->_row = 1;

    return $this;
  }

  /**
   * Cambia el nombre de una hoja.
   *
   * @param string $name name
   * @return $this for method chaining
   */
  public function setSheetName($name) {
    $this->_xls
      ->getActiveSheet()
      ->setTitle($name);

    return $this;
  }

  /**
   * Sobreescribe todas las llamadas a este helper hacia la Clase PHPExcel
   *
   * @param string function name
   * @param array arguments
   * @return the return value of the call
   */
  public function __call($name, $arguments) {
    return call_user_func_array(array($this->_xls, $name), $arguments);
  }

  /**
   * Cambia la fuente por default.
   *
   * @param string $name font name
   * @param int $size font size
   * @return $this for method chaining
   */
  public function setDefaultFont($name, $size) {
    $this->_xls->getDefaultStyle()->getFont()->setName($name);
    $this->_xls->getDefaultStyle()->getFont()->setSize($size);

    return $this;
  }

  /**
   * Set row pointer
   *
   * @param int $row number of row
   * @return $this for method chaining
   */
  public function setRow($row) {
    $this->_row = (int)$row;

    return $this;
  }

  /**
   * Establece un título al principio de la hoja.
   *
   * @param [type] $title [description]
   * @param string $cells [description]
   */
  public function setTopTitle($title, $cells = 'A1:F1') {
    $this->addTableHeader(array(
      array('label' => $title, 'wrap' => true)
    ), array('bold' => true, 'size' => 16))->_xls
      ->getActiveSheet()
      ->getStyle('A1')
      ->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $cells = implode(':', (array)$cells);
    $this->_xls->getActiveSheet()->mergeCells($cells);
    $this->topTitle = $title;

    return $this;
  }

  /**
   * Agrega los datos como tabla y genera una gráfica.
   *
   * @param [type] $tableHeader [description]
   * @param [type] $data        [description]
   * @param array  $options     [description]
   */
  public function addTableAndChart($tableHeader, $data, $options = array()) {
    /**
     * Guarda la fila inicial
     * @var [type]
     */
    $initRow = $this->_row;

    /**
     * Guarda la columna inicial (0 => 'A')
     * @var integer
     */
    $initColumn = 0;

    /**
     * Cuantas filas se agregarán en base a los registros.
     * @var [type]
     */
    $rowsCount = count($data);

    /**
     * Cuantas columnas se agregaran en base al encabezado de la tabla.
     * @var [type]
     */
    $columnsCount = count($tableHeader);

    $options = array_merge(array(
      'type' => 'bar',
      'leftTop' => 'A' . ($rowsCount + 5),
      'bottomRight' => 'H' . ((($rowsCount > 10 ? $rowsCount : 10) * 3) + 5),
    ), $options);

    // Agrega el encabezado de la tabla.
    $this->addTableHeader($tableHeader, array(
      'bold' => true,
      'name' => 'Cambria',
      // 'offset' => 2
    ));

    // Agrega los datos a la tabla.
    foreach ($data as $d) {
      $this->addTableRow($d);
    }      
    $range=array();
    $label_axisX=array();

    foreach ($tableHeader as $j=> $th) {
        if(isset($th['data_graph'])  && $th['data_graph']===true ){
            $range[]=$j;
        }
    }
    foreach ($tableHeader as $j=> $th) {
        if(isset($th['label_axisX'])  && $th['label_axisX']===true ){
            $label_axisX[$j]=array($initRow + 1, $initRow + $rowsCount + 1);
            break;
        }
    }
    if(empty($range)){
      $range=range($initColumn + 1, $columnsCount - 1);
    }
    if(empty($label_axisX)){
      $label_axisX[]=array($initRow + 1, $initRow + $rowsCount + 1);
    }
    // Genera el gráfico en base a los datos.
    $this->createChart(
      /**
       * Etiquetas: Siempre la primera columna representa el eje X, por ese las etiquetas
       * de cada gráfica comienzan a partir de la siguiente columna hasta el número total de
       * columnas menos 1; $initRow siempre será la fila del encabezado.
       */
      $this->getSeriesLabels( $range, $initRow),

      /**
       * Los valores del eje X son la primer columna; las filas comienzan a partir de la fila
       * inicial más uno (enseguida del encabezado) hasta el total de filas deplazadas por la fila inicial.
       */
      
       $this->getXAxisValues($label_axisX),

      /**
       * Los valores de las gráficas (se dibujará un tipo de barra por cada columna).
       * Columna inicial hasta el total de columnas.
       * Fila inicial más uno (enseguida del encabezado) hasta el total de filas deplazadas por la fila inicial.
       *
       * array($initColumn + 1, $columnsCount - 1)
       */
      $this->getValues($range, array($initRow + 1, $initRow + $rowsCount + 1)),
      /**
       * Opciones
       */
      $options
    );
  }

  /**
   * Obtiene las etiquetas de cada columna.
   *
   * @param  array   $columns Arreglo que representa un rango.
   * @param  integer $row     Fila.
   * @return array            Arreglo de PHPExcel_Chart_DataSeriesValues.
   */
  public function getSeriesLabels($columns = array(), $row = 1) {
    $sheetName = $this->_xls->getActiveSheet()->getTitle();
    $dataseriesLabels = array();
    foreach ($columns  as   $j=> $i  ) {
      $index = $i;
      if (is_numeric($index)) {
        $index = PHPExcel_Cell::stringFromColumnIndex($i);
      }

      $dataseriesLabels[] = new PHPExcel_Chart_DataSeriesValues('String', $sheetName . '!$' . $index . '$' . $row , NULL, 1);
    }
    return $dataseriesLabels;
  }

  /**
   * Obtiene los valores del eje X.
   *
   * @param  array  $rows [description]
   * @return [type]       [description]
   */
  public function getXAxisValues($rows = array()) {
    $sheetName = $this->_xls->getActiveSheet()->getTitle();
    $xAxisTickValues = array();

    foreach ((array)$rows as $index => $values) {
      if (is_numeric($index)) {
        $index = PHPExcel_Cell::stringFromColumnIndex($index);
      }
      $ranges = '$'. $index . '$' . $values[0]. ':$' . $index . '$' . $values[1];

      $xAxisTickValues[] = new PHPExcel_Chart_DataSeriesValues('String', $sheetName . '!' . $ranges, NULL, 4);
    }

    return $xAxisTickValues;
  }

  /**
   * Obtiene los valores de las gráficas.
   *
   * @param  array  $columns [description]
   * @param  array  $rows    [description]
   * @return [type]          [description]
   */
  public function getValues($columns = array(), $rows = array()) {
    $sheetName = $this->_xls->getActiveSheet()->getTitle();
    $dataSeriesValues = array();
    foreach ( $columns as $j=> $i)  {
      $index = $i;
      if (is_numeric($i)) {
        $index = PHPExcel_Cell::stringFromColumnIndex($i);
      }
      $ranges = '$'. $index . '$' . $rows[0]. ':$' . $index . '$' . $rows[1];
      $dataSeriesValues[] = new PHPExcel_Chart_DataSeriesValues('Number', $sheetName . '!' . $ranges, NULL, 4);
    }

    return $dataSeriesValues;
  }

  /**
   * Obtiene el tipo de gráfico y agrupación de datos dependiendo del tipo de la gráfica que se requiera.
   * Por default es gráfica de barras.
   *
   * @param  string $type [description]
   * @return [type]       [description]
   */
  public function getType($type = 'bar') {
    if ($type === 'pie') {
      return array(
        PHPExcel_Chart_DataSeries::TYPE_PIECHART,
        PHPExcel_Chart_DataSeries::GROUPING_STANDARD
      );
    } elseif($type === 'line') {
      return array(
        PHPExcel_Chart_DataSeries::TYPE_LINECHART,
        PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED
      );
    }

    // default: barras.
    return array(
      PHPExcel_Chart_DataSeries::TYPE_BARCHART,
      PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED
    );
  }

  /**
   * Genera el gráfico.
   * @param  [type] $dataseriesLabels [description]
   * @param  [type] $xAxisTickValues  [description]
   * @param  [type] $dataSeriesValues [description]
   * @param  array  $options          [description]
   * @return [type]                   [description]
   */
  public function createChart($dataseriesLabels, $xAxisTickValues, $dataSeriesValues, $options = array()) {
    $sheetName = $this->_xls->getActiveSheet()->getTitle();

    $type = $this->getType($options['type']);
    $series = new PHPExcel_Chart_DataSeries(
      $type[0],                                   // plotType
      $type[1],                                   // plotGrouping
      range(0, count($dataSeriesValues) - 1),     // plotOrder
      $dataseriesLabels,                          // plotLabel
      $xAxisTickValues,                           // plotCategory
      $dataSeriesValues                           // plotValues
    );

    if ($options['type'] === 'pie') {
      $layout = new PHPExcel_Chart_Layout();
      $layout->setShowVal(TRUE);
      $layout->setShowPercent(TRUE);
    } else {
      $layout = NULL;
      //  Hace la gráfica horizontal.
      $series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_BAR);
    }

    $plotarea = new PHPExcel_Chart_PlotArea($layout, array($series));
    $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
    $title = new PHPExcel_Chart_Title($this->topTitle);
    $yAxisLabel = !empty($options['yLabel']) ? new PHPExcel_Chart_Title($options['yLabel']) : NULL;

    //  Crea el gráfico.
    $chart = new PHPExcel_Chart(
      $options['chartName'],      // name
      $title,                     // title
      $legend,                    // legend
      $plotarea,                  // plotArea
      true,                       // plotVisibleOnly
      0,                          // displayBlanksAs
      NULL,                       // xAxisLabel
      $yAxisLabel                 // yAxisLabel
    );

    // Establece la posición de l gráfico.
    $chart->setTopLeftPosition($options['leftTop']);
    $chart->setBottomRightPosition($options['bottomRight']);

    // Agrega el gráfico a la hoja activa.
    $this->_xls->getActiveSheet()->addChart($chart);
  }

  /**
   * Start table - insert table header and set table params
   *
   * @param array $data data with format:
   *   label   -   table heading
   *   width   -   numeric (leave empty for "auto" width)
   *   filter  -   true to set excel filter for column
   *   wrap    -   true to wrap text in column
   * @param array $params table parameters with format:
   *   offset  -   column offset (numeric or text)
   *   font    -   font name of the header text
   *   size    -   font size of the header text
   *   bold    -   true for bold header text
   *   italic  -   true for italic header text
   * @return $this for method chaining
   */
  public function addTableHeader($data, $params = array()) {
      // offset
    $offset = 0;
    if (isset($params['offset']))
      $offset = is_numeric($params['offset']) ? (int)$params['offset'] : PHPExcel_Cell::columnIndexFromString($params['offset']);

      // font name
    if (isset($params['font']))
      $this->_xls->getActiveSheet()->getStyle($this->_row)->getFont()->setName($params['font']);

      // font size
    if (isset($params['size']))
      $this->_xls->getActiveSheet()->getStyle($this->_row)->getFont()->setSize($params['size']);

      // bold
    if (isset($params['bold']))
      $this->_xls->getActiveSheet()->getStyle($this->_row)->getFont()->setBold($params['bold']);

      // italic
    if (isset($params['italic']))
      $this->_xls->getActiveSheet()->getStyle($this->_row)->getFont()->setItalic($params['italic']);

      // set internal params that need to be processed after data are inserted
    $this->_tableParams = array(
      'header_row' => $this->_row,
      'offset' => $offset,
      'row_count' => 0,
      'auto_width' => array(),
      'filter' => array(),
      'wrap' => array()
      );

    foreach ($data as $d) {
          // set label
      $this->_xls->getActiveSheet()->setCellValueByColumnAndRow($offset, $this->_row, $d['label']);

          // set width
      if (isset($d['width']) && is_numeric($d['width']))
        $this->_xls->getActiveSheet()->getColumnDimensionByColumn($offset)->setWidth((float)$d['width']);
      else
        $this->_tableParams['auto_width'][] = $offset;

          // filter
      if (isset($d['filter']) && $d['filter'])
        $this->_tableParams['filter'][] = $offset;

          // wrap
      if (isset($d['wrap']) && $d['wrap'])
        $this->_tableParams['wrap'][] = $offset;

      $offset++;
    }
    $this->_row++;

    return $this;
  }

  /**
   * Agrega un array de datos a la fila actual.
   *
   * @param array $data
   * @return $this for method chaining
   */
  public function addTableRow($data) {
    $offset = $this->_tableParams['offset'];

    foreach ($data as $d) {
      $this->_xls->getActiveSheet()
        ->setCellValueByColumnAndRow($offset++, $this->_row, $d);
    }

    $this->_row++;
    $this->_tableParams['row_count']++;

    return $this;
  }

  /**
   * Agrega pie de página.
   *
   * @return $this for method chaining
   */
  public function addTableFooter() {
      // auto width
    foreach ($this->_tableParams['auto_width'] as $col)
      $this->_xls->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);

      // filter (has to be set for whole range)
    if (count($this->_tableParams['filter']))
      $this->_xls->getActiveSheet()->setAutoFilter(PHPExcel_Cell::stringFromColumnIndex($this->_tableParams['filter'][0]) . ($this->_tableParams['header_row']) . ':' . PHPExcel_Cell::stringFromColumnIndex($this->_tableParams['filter'][count($this->_tableParams['filter']) - 1]) . ($this->_tableParams['header_row'] + $this->_tableParams['row_count']));

      // wrap
    foreach ($this->_tableParams['wrap'] as $col)
      $this->_xls->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($col) . ($this->_tableParams['header_row'] + 1) . ':' . PHPExcel_Cell::stringFromColumnIndex($col) . ($this->_tableParams['header_row'] + $this->_tableParams['row_count']))->getAlignment()->setWrapText(true);

    return $this;
  }

  /**
   * Establece un arreglo de datos a la fila actual, se puede definir a partir de qué columna ($offset).
   *
   * @param array $data
   * @return $this for method chaining
   */
  public function addData($data, $offset = 0) {
      // solve textual representation
    if (!is_numeric($offset))
      $offset = PHPExcel_Cell::columnIndexFromString($offset);

    foreach ($data as $d)
      $this->_xls->getActiveSheet()->setCellValueByColumnAndRow($offset++, $this->_row, $d);

    $this->_row++;

    return $this;
  }

  /**
   * Obtiene los datos de la fila atual.
   *
   * @param int $max
   * @return array row contents
   */
  public function getTableData($max = 100) {
    if ($this->_row > $this->_maxRow)
      return false;

    $data = array();
    for ($col = 0; $col < $max; $col++) {
      $data[] = $this->_xls->getActiveSheet()
        ->getCellByColumnAndRow($col, $this->_row)->getValue();
    }

    $this->_row++;

    return $data;
  }

  /**
   * Obtiene la instancia que maneja la escritura, ya sea en disco o en memoria.
   *
   * @param $writer
   * @return PHPExcel_Writer_Iwriter
   */
  public function getWriter($writer) {
    $factoryWriter = PHPExcel_IOFactory::createWriter($this->_xls, $writer);
    $factoryWriter->setIncludeCharts(TRUE);

    return $factoryWriter;
  }

  /**
   * Guarda.
   *
   * @param string $file path to file
   * @param string $writer
   * @return bool
   */
  public function save($file, $writer = 'Excel2007') {
    $objWriter = $this->getWriter($writer);
    return $objWriter->save($file);
  }

  /**
   * Genera el archivo para ser descargado.
   *
   * @param string $file path to file
   * @param string $writer
   * @return exit on this call
   */
  public function output($filename = 'export.xlsx', $writer = 'Excel2007') {
      // remove all output
    ob_end_clean();

      // headers
    header('Content-Type: ' . Excel::getContentType($writer));
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    ob_clean();
    flush();

    // writer
    $objWriter = $this->getWriter($writer);
    $objWriter->save('php://output');
  }

  /**
   * Free memory
   *
   * @return void
   */
  public function freeMemory() {
    $this->_xls->disconnectWorksheets();
    unset($this->_xls);
  }
  }
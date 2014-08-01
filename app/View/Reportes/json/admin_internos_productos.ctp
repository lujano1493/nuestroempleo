<?php
  $data = array();

  foreach ($productos as $key => $value) {
    $p = $value['ProductoReporte'];

    $data[] = array(
      'membresia' => $p['membresia'],
      'total' => (int)$p['total']
    );
  }

  $color = $this->Grafito->color();
  $this->_results = $this->Grafito->serial($data, array(
    'title' => array(
       $title_for_layout,
      __('De %s a %s', $this->Time->month($_dates['ini']), $this->Time->month($_dates['end']))
    )
  ), array(
    'categoryField' => 'membresia',
    'categoryAxis'=> array(
      'gridPosition'=> 'start',
      'labelRotation' => 90,
      'inside' => true
    ),
    'valueAxes'=> array(
      array(
        'position' => 'top',
        'title' => __('Total Productos Adquiridos'),
        'minorGridEnabled' => true
      )
    ),
    'graphs'=> array(
      array(
        'type'=> 'column',
        'title'=> __('Total de Productos'),
        'valueField'=> 'total',
        'fillAlphas'=> 1,
        'balloonText'=> "<span style='font-size=>13px;'>[[title]] en [[membresia]]=><b>[[value]]</b></span>",
        'legendColor' => $color,
        'fillColors' => $color,
        'lineColor' => $color,
      ),
    ),
    'legend' => array(
      'position' => 'bottom',
      'periodValueText' => '[[value.sum]]',
      'data' => Hash::map($data, '{n}', function ($v) use ($color) {
        return array(
          'title' => sprintf('%s [%d]', $v['membresia'], $v['total']),
          'color' => $color
        );
      }),
    ),
    'rotate' => true
  ));
?>
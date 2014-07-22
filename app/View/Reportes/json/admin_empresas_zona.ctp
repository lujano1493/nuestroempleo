<?php

  $_data = array();

  foreach ($data as $key => $v) {
    //$o = $value['OfertaReporte'];

    $_data[] = array(
      'zona' => $v['zona'],
      'total' => (int)$v['total'],
      '_data' => $v['_data'],
      '_legend' => $v['_legend']
    );
  }

  $color = $this->Grafito->color();
  $this->_results = $this->Grafito->serial($_data, array(
    'title' => array(
      $title_for_layout,
      __('De %s a %s', $this->Time->month($_dates['ini']), $this->Time->month($_dates['end']))
    )
  ), array(
    'categoryField' => 'zona',
    'categoryAxis'=> array(
      'gridPosition'=> 'start',
      'labelRotation' => 90
    ),
    'valueAxes'=> array(
      array(
        'position' => 'bottom',
        'title' => 'Empresas',
        'minorGridEnabled' => true
      )
    ),
    'graphs'=> array(
      array(
        'type'=> 'column',
        'title'=> $title_for_layout,
        'valueField'=> 'total',
        'fillAlphas'=> 1,
        'balloonText'=> "<span style='font-size=>13px;'>[[title]] en [[zona]]=><b>[[value]]</b></span>",
        'labelText' => '[[category]]: [[value]] Empresas',
        'labelPosition' => 'middle',
        'legendColor' => $color,
        'fillColors' => $color,
        'lineColor' => $color,
      ),
    ),
    'legend' => array(
      'position' => 'right',
      'periodValueText' => '[[value.sum]]',
      'data' => Hash::map($_data, '{n}', function ($v) use ($color) {
        return array(
          'title' => sprintf('%s [%d]', $v['zona'], $v['total']),
          'color' => $color
        );
      }),
    ),
    'rotate' => true
  ));
?>
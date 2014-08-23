<?php

  $_data = array();

  foreach ($data as $key => $v) {
    $_data[] = array(
      'categoria' => $v['categoria'],
      'total' => (int)$v['total'],
      '_data' => $v['_data'],
      '_legend' => $v['_legend']
    );
  }

  $color = $this->Grafito->color();
  $fecini= $formatoCalendario === 2 ? $this->Time->month($_dates['ini']): $this->Time->pretty($_dates['ini'])  ;
  $fecfin=  $formatoCalendario === 2 ? $this->Time->month($_dates['end']) : $this->Time->pretty($_dates['end']) ;
  $this->_results = $this->Grafito->serial($_data, array(
    'title' => array(
      $title_for_layout,
      __('De %s a %s',$fecini,$fecfin)
    )
  ), array(
    'categoryField' => 'categoria',
    'categoryAxis'=> array(
      'gridPosition'=> 'start',
      'labelRotation' => 90
    ),
    'valueAxes'=> array(
      array(
        'position' => 'top',
        'title' => 'Ofertas',
        'minorGridEnabled' => true
      )
    ),
    'graphs'=> array(
      array(
        'type'=> 'column',
        'title'=> $title_for_layout,
        'valueField'=> 'total',
        'fillAlphas'=> 1,
        'balloonText'=> "<span style='font-size=>13px;'>[[title]] en [[categoria]]=><b>[[value]]</b></span>",
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
          'title' => sprintf('%s [%d]', $v['categoria'], $v['total']),
          'color' => $color
        );
      }),
    ),
    'rotate' => true
  ));

?>
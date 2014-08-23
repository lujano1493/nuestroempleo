<?php

  $data = array();

  foreach ($ofertasCount as $key => $value) {
    $o = $value['OfertaReporte'];

    $data[] = array(
      'mes' => $o['compania'],
      'total' => (int)$o['ofertas']
    );
  }

  $color = $this->Grafito->color();
  $fecini= $formatoCalendario === 2 ? $this->Time->month($_dates['ini']): $this->Time->pretty($_dates['ini'])  ;
  $fecfin=  $formatoCalendario === 2 ? $this->Time->month($_dates['end']) : $this->Time->pretty($_dates['end']) ;
  $this->_results = $this->Grafito->serial($data, array(
    'title' => array(
      $title_for_layout,
      __('De %s a %s', $fecini, $fecfin)
    )
  ), array(
    'categoryField' => 'mes',
    'categoryAxis'=> array(
      'gridPosition'=> 'start'
    ),
    'valueAxes'=> array(
      array(
        'position' => 'top',
        'title' => __('Ofertas'),
        'minorGridEnabled' => true
      )
    ),
    'graphs'=> array(
      array(
        'type'=> 'column',
        'title'=> $title_for_layout,
        'valueField'=> 'total',
        'fillAlphas'=> 1,
        'balloonText'=> "<span style='font-size=>13px;'>[[title]] en [[mes]]=><b>[[value]]</b></span>",
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
          'title' => sprintf('%s [%d]', $v['mes'], $v['total']),
          'color' => $color
        );
      }),
    ),
    'rotate' => true
  ));

  //$this->_results['height'] = count($data) * 10;
?>
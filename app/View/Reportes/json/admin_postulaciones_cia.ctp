<?php

  $data = array();

  foreach ($postulaciones as $key => $value) {
    $p = $value['PostulacionReporte'];

    $data[] = array(
      'mes' => $p['compania'],
      'total' => (int)$p['total']
    );
  }

  $color = $this->Grafito->color();
  $fecini= $formatoCalendario === 2 ? $this->Time->month($_dates['ini']): $this->Time->pretty($_dates['ini'])  ;
  $fecfin=  $formatoCalendario === 2 ? $this->Time->month($_dates['end']) : $this->Time->pretty($_dates['end']) ;
  $this->_results = $this->Grafito->serial($data, array(
    'title' => array(
      $title_for_layout,
      __('De %s a %s',$fecini, $fecfin)
    ),
  ), array(
    'categoryField' => 'genero',
    'categoryField' => 'mes',
    'categoryAxis'=> array(
      'gridPosition'=> 'start',
      'labelRotation' => 90
    ),
    'valueAxes'=> array(
      array(
        'position' => 'top',
        'title' => __('Postulaciones'),
        'minorGridEnabled' => true,
        'precision' => 0,
        'minimum' => 0
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

?>
<?php

  $data = array();

  foreach ($postulaciones as $key => $value) {
    $p = $value['PostulacionReporte'];

    $data[] = array(
      'genero' => $p['genero'],
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
    'categoryAxis'=> array(
      'gridPosition'=> 'start',
      'labelRotation' => 90
    ),
    'valueAxes'=> array(
      array(
        'position' => 'top',
        'title' => 'Postulaciones',
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
        'balloonText'=> "<span style='font-size=>13px;'>[[title]] en [[genero]]=><b>[[value]]</b></span>",
        'legendColor' => $color,
        'fillColors' => $color,
        'lineColor' => $color,
      ),
    ),
    'legend' => array(
      //'useGraphSettings' => true,
      'position' => 'right',
      'periodValueText' => '[[value.sum]]',
      'data' => Hash::map($data, '{n}', function ($v) use ($color) {
        return array(
          'title' => sprintf('%s [%d]', $v['genero'], $v['total']),
          'color' => $color
        );
      }),
    ),
    'rotate' => true
  ));

?>
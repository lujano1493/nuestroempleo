<?php

  $data = array();


  if(!empty($candidatos)){
      foreach ($candidatos as $key => $value) {
    $p = $value['CandidatoReporte'];

    $data[] = array(
      'genero' => $p['genero'],
      'total' => (int)$p['totales']
    );
   }

  }


  $color = $this->Grafito->color();
  $this->_results = $this->Grafito->serial($data, array(
    'title' => array(
      $title_for_layout,
      __('De %s a %s', $this->Time->month($_dates['ini']), $this->Time->month($_dates['end']))
    ),
  ), array(
    'categoryField' => 'genero',
    'categoryAxis'=> array(
      'gridPosition'=> 'start',
      //'labelRotation' => 90
    ),
    'valueAxes'=> array(
      array(
        'position' => 'top',
        'title' => 'Candidatos',
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
      'position' => 'right',
      'periodValueText' => '[[value.sum]]',
      'data' => Hash::map($data, '{n}', function ($v) use ($color) {
        return array(
          'title' => sprintf('%s [%d]', $v['genero'], $v['total']),
          'color' => $color
        );
      }),
    ),
  ));

?>
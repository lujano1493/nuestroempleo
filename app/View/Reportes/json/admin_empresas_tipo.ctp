<?php

  $data = array();


  if(!empty($empresas)){
      foreach ($empresas as $key => $value) {
    $p = $value['EmpresaReporte'];

    $data[] = array(
      'tipo' => $p['tipo'],
      'total' => (int)$p['empresas']
    );
   }

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
    'categoryField' => 'tipo',
    'categoryAxis'=> array(
      'gridPosition'=> 'start',
      //'labelRotation' => 90
    ),
    'valueAxes'=> array(
      array(
        'position' => 'top',
        'title' => 'Empresas',
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
        'balloonText'=> "<span style='font-size=>13px;'>[[title]] en [[tipo]]=><b>[[value]]</b></span>",
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
          'title' => sprintf('%s [%d]', $v['tipo'], $v['total']),
          'color' => $color
        );
      }),
    ),
  ));

?>
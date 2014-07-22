<?php

  $data = array();

  $postulaciones = Hash::combine($postulaciones,
    '{n}.PostulacionReporte.mes',
    '{n}.PostulacionReporte.total',
    '{n}.PostulacionReporte.anio'
  );

  foreach ($ofertas as $key => $value) {
    $o = $value['OfertaReporte'];
    $p = !empty($postulaciones[$o['anio']][$o['mes']]) ? $postulaciones[$o['anio']][$o['mes']] : 0;
    $data[] = array(
      'mes' => $this->Time->month($o['mes'], (int)$o['anio']),
      'total_ofertas' => (int)$o['ofertas'],
      'total_postulaciones' => $p
    );
  }

  $this->_results = $this->Grafito->serial($data, array(
    'title' => array(
      $title_for_layout,
      __('De %s a %s', $this->Time->month($_dates['ini']), $this->Time->month($_dates['end']))
    )
  ), array(
    'categoryField' => 'mes',
    'categoryAxis'=> array(
      'gridPosition'=> 'start',
      'axisAlpha' => 0,
      'fillAlpha' => 0.05,
      'fillColor' => '#000000',
      'gridAlpha' => 0,
      'position' => 'top'
    ),
    'chartCursor' => array(
      'cursorAlpha' => 0,
      'cursorPosition' => "mouse",
      'zoomable' => false
    ),
    'valueAxes'=> array(
      array(
        'position' => 'left',
        'title' => $title_for_layout,
        'minorGridEnabled' => true
      )
    ),
    'graphs'=> array(
      array(
        'bullet' => 'round',
        // 'type' => 'column',
        'title' => 'Ofertas',
        'valueField' => 'total_ofertas',
        'fillAlphas' => 0,
        'balloonText' => "<span style='font-size=>13px;'>[[title]] en [[mes]]=><b>[[value]]</b></span>"
      ),
      array(
        'bullet' => 'round',
        // 'type' => 'column',
        'title' => 'Postulaciones',
        'valueField' => 'total_postulaciones',
        'fillAlphas' => 0,
        'balloonText' => "<span style='font-size=>13px;'>[[title]] en [[mes]]=><b>[[value]]</b></span>"
      ),
    ),
    'legend' => array(
      'useGraphSettings' => true,
      // 'position' => 'left',
      // 'periodValueText' => '[[value.sum]]',
      // 'data' => Hash::map($data, '{n}', function ($v) {
      //   return array(
      //     'title' => sprintf('%s [%d]', $v['mes'], $v['total_ofertas']),
      //     'color' => 'transparent'
      //   );
      // }),
    ),
  ));

?>
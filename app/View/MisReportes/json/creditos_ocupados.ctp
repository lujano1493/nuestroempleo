<?php

  $data = array();

  foreach ($creditos as $key => $v) {
    $data[] = array(
      'usuario' => $key,
      'oferta_publicada' => $v['oferta_publicada']['ocupados'],
      'oferta_recomendada' => $v['oferta_recomendada']['ocupados'],
      'oferta_distinguida' => $v['oferta_distinguida']['ocupados'],
      'consulta_cv' => $v['consulta_cv']['ocupados']
    );
  }

  $this->_results = $this->Grafito->serial($data, array(
    'title' => array(
      $title_for_layout,
      __('De %s a %s', $this->Time->month($_dates['ini']), $this->Time->month($_dates['end']))
    )
  ), array(
    'categoryField' => 'usuario',
    'categoryAxis'=> array(
      'gridPosition'=> 'start',
      // 'axisAlpha' => 0,
      // 'fillAlpha' => 0.05,
      // 'fillColor' => '#000000',
      // 'gridAlpha' => 0,
      // 'position' => 'top'
    ),
    // 'chartCursor' => array(
    //   'cursorAlpha' => 0,
    //   'cursorPosition' => "mouse",
    //   'zoomable' => false
    // ),
    'columnWidth:' => 0.5,
    'columnSpacing' => 5,
    'valueAxes'=> array(
      array(
        'position' => 'left',
        'title' => $title_for_layout,
        'minorGridEnabled' => true,
        //'stackType' => '3d',
        // 'unit' => '%'
      )
    ),
    'graphs'=> array(
      array(
        //'bullet' => 'round',
        'type' => 'column',
        'title' => __('Ofertas Publicadas'),
        'valueField' => 'oferta_publicada',
        'fillAlphas' => 0.9,
        'lineAlpha' => 0.2,
        'balloonText' => "<span style='font-size=>13px;'>[[title]] de [[usuario]]=><b>[[value]]</b></span>"
      ),
      array(
        //'bullet' => 'round',
        'type' => 'column',
        'title' => __('Ofertas Recomendadas'),
        'valueField' => 'oferta_recomendada',
        'fillAlphas' => 0.9,
        'lineAlpha' => 0.2,
        'balloonText' => "<span style='font-size=>13px;'>[[title]] de [[usuario]]=><b>[[value]]</b></span>"
      ),
      array(
        //'bullet' => 'round',
        'type' => 'column',
        'title' => __('Ofertas Distinguidas'),
        'valueField' => 'oferta_distinguida',
        'fillAlphas' => 0.9,
        'lineAlpha' => 0.2,
        'balloonText' => "<span style='font-size=>13px;'>[[title]] de [[usuario]]=><b>[[value]]</b></span>"
      ),
      array(
        //'bullet' => 'round',
        'type' => 'column',
        'title' => __('Liberaciones de CV'),
        'valueField' => 'consulta_cv',
        'fillAlphas' => 0.9,
        'lineAlpha' => 0.2,
        'balloonText' => "<span style='font-size=>13px;'>[[title]] de [[usuario]]=><b>[[value]]</b></span>"
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
    'rotate' => true,
  ));

?>
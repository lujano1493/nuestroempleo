<?php

  $data = array();


  if(!empty($empresas)){
      foreach ($empresas as $key => $value) {
    $p = $value['EmpresaReporte'];

    $data[] = array(
      'correo' => $p['correo'],
      'total_comercial' => (int)$p['comercial'],
      'total_convenio' => (int) $p['convenio'],
      'total' => (int) $p['total']
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
    'categoryField' => 'correo',
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
        //'bullet' => 'round',
        'type' => 'column',
        'title' => __('Convenios'),
        'valueField' => 'total_convenio',
        'fillAlphas' => 0.9,
        'lineAlpha' => 0.2,
        'balloonText' => "<span style='font-size=>13px;'>[[title]] de [[total_convenio]]=><b>[[value]]</b></span>"
      ),
      array(
        //'bullet' => 'round',
        'type' => 'column',
        'title' => __('Comercial'),
        'valueField' => 'total_comercial',
        'fillAlphas' => 0.9,
        'lineAlpha' => 0.2,
        'balloonText' => "<span style='font-size=>13px;'>[[title]] de [[total_comercial]]=><b>[[value]]</b></span>"
      )
    ),
    'legend' => array(
      'position' => 'bottom',
      'periodValueText' => '[[value.sum]]',
      'data' => Hash::map($data, '{n}', function ($v) use ($color) {
        return array(
          'title' => sprintf('%s total de asignaciones: [%d]', $v['correo'], $v['total']),
          'color' => "#0000FF"
        );
      }),
    ),
    'rotate' => true
  ));

?>
<?php

  $data = array();

  foreach ($ofertasCount as $key => $value) {
    // $o = $value['OfertaReporte'];
    $u = $value['UsuarioReporte'];

    $data[] = array(
      'email' => $u['email'],
      'id' => (int)$u['id'],
      'nombre' => $u['nombre'],
      'parent_id' => (int)$u['parent_id'],
      'perfil' => $u['perfil'],
      'perfil_id' => (int)$u['perfil_id'],
      'total_ofertas' => (int)$u['total_ofertas'],
      'total_sub' => (int)$u['total_sub'],
    );
  }

  $color = $this->Grafito->color();
  $fecini= $formatoCalendario === 2 ? $this->Time->month($_dates['ini']): $this->Time->pretty($_dates['ini'])  ;
  $fecfin=  $formatoCalendario === 2 ? $this->Time->month($_dates['end']) : $this->Time->pretty($_dates['end']) ;
  $this->_results = $this->Grafito->serial($data, array(
    'title' => array(
      $title_for_layout,
      __('De %s a %s',$fecini, $fecfin)
    )
  ), array(
    'categoryField' => 'nombre',
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
        'valueField'=> "total_ofertas",
        'fillAlphas'=> 1,
        'balloonText'=> "<span style='font-size=>13px;'>[[title]] de [[nombre]] =><b>[[value]]</b></span>",
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
          'title' => sprintf('%s [%d]', $v['nombre'], $v['total_ofertas']),
          'color' => $color
        );
      }),
    ),
    'rotate' => true
  ));

?>
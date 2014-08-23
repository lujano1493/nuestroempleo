<?php
  $o = $ofertasCount[0]['OfertaReporte'];

  $data = array(
    array(
      'type' => __('Ofertas Distinguidas'),
      'value' => (int)$o['distinguidas'],
    ),
    array(
      'type' => __('Ofertas Recomendadas'),
      'value' => (int)$o['recomendadas'],
    ),
    array(
      'type' => __('Ofertas Publicadas'),
      'value' => (int)$o['publicadas'],
    )
  );
  $fecini= $formatoCalendario === 2 ? $this->Time->month($_dates['ini']): $this->Time->pretty($_dates['ini'])  ;
  $fecfin=  $formatoCalendario === 2 ? $this->Time->month($_dates['end']) : $this->Time->pretty($_dates['end']) ;
  $this->_results = $this->Grafito->pie($data, array(
    'ballon' => "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
    'legend' => 'right',
    'title' => array(
      $title_for_layout,
      __('De %s a %s', $fecini,$fecfin)
    ),
  ), array(
    'titleField' => 'type',
    'valueField' => 'value'
  ));

?>
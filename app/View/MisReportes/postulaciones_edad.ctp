<?php
  echo $this->element('empresas/title');
?>

<div id="chartdiv" style="width: 100%; height: 600px;" data-source-url='/mis_reportes/postulaciones_edad.json'>
</div>

<?php
  $this->Html->script(
    '/js/amchart.js',
    array(
      'inline' => false
    )
  )
?>
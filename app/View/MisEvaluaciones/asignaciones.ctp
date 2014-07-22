<?php
  echo $this->element('empresas/title', array(
    'busqueda' => false
  ));

  $ev = $evaluacion['Evaluacion'];
  $pregs = $evaluacion['Preguntas'];
  $url = $this->Html->url(array(
    'controller' => 'mis_evaluaciones',
    'slug' => Inflector::slug($ev['evaluacion_nom'], '-'),
    'id' => $ev['evaluacion_cve'],
    'action' => $this->action,
    'ext' => 'json'
  ));
?>
<div class="btn-actions">
  <?php
    echo $this->Html->link('Vista Previa', '#preview', array(
      'data-toggle' => 'slidemodal',
      'class' => 'btn btn-sm btn-aqua'
    ));

    echo $this->Html->back();
  ?>
</div>
<table class="table table-bordered" data-component="dynamic-table"
  data-source-url="<?php echo $url; ?>">
  <thead>
    <tr  class="table-fondo">
      <th colspan="7">
        <div class="pull-left">
          <?php
          ?>
        </div>
        <div class="pull-right" id="filters"></div>
      </th>
    </tr>
    <tr>
      <th data-table-prop=":input" data-table-order="none"><input type="checkbox" class="master"></th>
      <th data-table-prop="candidato.nombre">Candidato</th>
      <th data-table-prop="nombre">Evaluaci&oacute;n</th>
      <th data-table-prop="creada">Fecha de envío</th>
      <th data-table-prop="aplicada">Fecha de aplicación</th>
      <th data-table-prop="#tmpl-resultados">Resultados</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

<div id="preview" class="slidemodal evaluacion-preview" data-slide-from="right">
  <div class="row-fluid">
    <div class="span8">
      <div class="header">
        <h4><?php echo $ev['evaluacion_nom']; ?></h4>
        <p></p>
      </div>
      <div data-name="evaluacion-desc">Aquí va la descripción</div>
      <ol class="preguntas-container decimal">
        <?php
          foreach ($pregs as $key => $value):
        ?>
          <li>
            <h5 data-name="question{{= it.__q}}-title"><?php echo $value['pregunta_nom']; ?></h5>
            <ol class="respuestas-container alpha">
              <?php foreach ($value['Respuestas'] as $k => $v): ?>
                <li><?php echo $v['opcpre_nom']; ?></li>
              <?php endforeach ?>
            </ol>
          </li>
        <?php endforeach ?>
      </ol>
    </div>
    <div class="span4">
      <ul class="unstyled">
        <li>
          <?php
            echo $this->Html->link('Regresar', $_referer, array(
              'class' => 'btn btn-sm btn-default',
              'data-close' => 'slidemodal',
              'icon' => 'arrow-left',
            ));
          ?>
        </li>
      </ul>
    </div>
  </div>
</div>

<?php
  echo $this->Template->insert(array(
    'resultados'
  ));
?>
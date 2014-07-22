<?php
  echo $this->element('empresas/title');
?>

<table id="mensajes-table" class="table table-striped table-bordered" data-table-role="main" data-component="dynamic-table">
  <thead>
    <tr class="table-header">
      <th colspan="6">
        <div class="pull-left">
          <span><?php echo __('Mensajes Enviados'); ?></span>
        </div>
        <div class="pull-right" id="filters"></div>
      </th>
    </tr>
    <tr>
      <th data-table-prop=":input" data-table-order="none"><input type="checkbox" class="master"></th>
      <th data-table-prop="#tmpl-receptores">Enviado a</th>
      <th data-table-prop="#tmpl-asunto" width="350">Asunto</th>
      <th data-table-prop="#tmpl-fecha" data-order="desc">Fecha y hora</th>
      <th data-table-prop="#tmpl-acciones">Acciones</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

<?php
  echo $this->Template->insert(array(
    'emisor',
    'asunto__enviados',
    'contenido',
    'receptores',
    'fecha__enviados',
    'acciones__enviados'
  ));
?>
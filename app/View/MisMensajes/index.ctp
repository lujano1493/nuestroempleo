<?php
  echo $this->element('empresas/title');
?>

<table class="table table-striped table-bordered" data-table-role="main" data-component="dynamic-table" width="100%">
  <thead>
    <tr class="table-header">
      <th colspan="6">
        <div class="pull-left btn-actions">
          <?php
            echo $this->Html->link('Redactar Mensaje', array(
              'controller' => 'mis_mensajes',
              'action' => 'nuevo'
            ), array(
              'class' => 'btn btn-sm btn-success',
              'icon' => 'envelope'
            ));
            // echo $this->Html->link('Guardar en', array(
            //   'controller' => 'mis_mensajes',
            //   'action' => 'guardar_en'
            // ), array(
            //   'class' => 'btn btn-sm btn-default',
            //   'data-component' => 'folderito',
            //   'data-source' => '/carpetas/mensajes.json',
            //   'data-controller' => 'mis_mensajes',
            //   'icon' => 'folder-close',
            //   'after' => true
            // ));
            echo $this->Html->link('Borrar', array(
              'controller' => 'mis_mensajes',
              'action' => 'borrar'
            ), array(
              'class' => 'btn btn-sm btn-danger',
              'icon' => 'trash',
              'data-component' => 'ajaxlink',
              'data-ajaxlink-multi' => true
            ));
          ?>
        </div>
        <div class="pull-right" id="filters"></div>
      </th>
    </tr>
    <tr>
      <th data-table-prop=":input" data-table-order="none"><input type="checkbox" class="master"></th>
      <th data-table-prop="#tmpl-emisor">Remitente</th>
      <th data-table-prop="#tmpl-asunto" width="350">Asunto</th>
      <th data-table-prop="#tmpl-fecha" data-order="desc">Fecha y hora</th>
      <th data-table-prop="#tmpl-acciones">Acciones</th>
    </tr>
  </thead>
  <tbody id="mensajes-table">
  </tbody>
</table>

<?php
  echo $this->Template->insert(array(
    'emisor',
    'asunto',
    'contenido',
    'fecha__recibidos',
    'acciones__index'
  ));
?>

<?php
  $this->AssetCompress->css('editor.css', array(
    'inline' => false,
    'id' => 'editor-css-url'
  ));

  $this->AssetCompress->script('editor.js', array(
    'inline' => false
  ));
?>
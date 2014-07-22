<?php
  echo $this->element('empresas/title');
?>

<p class="well well-small info">
  Aqu&iacute; se muestran las <strong>publicaciones inactivas</strong>. Estas publicaciones ser&aacute;n borradas
  despu&eacute;s de un plazo de 30 d&iacute;as.
</p>

<table class="table table-bordered" data-table-role="main" data-component="dynamic-table">
  <thead>
    <tr class='table-header'>
      <th colspan="7">
        <div class="pull-left">
          <?php
            echo $this->Html->link('Recuperar', array(
              'controller' => 'mis_ofertas',
              'action' => 'recuperar'
            ), array(
              'class' => 'btn btn-sm btn-green',
              'data-component' => 'ajaxlink',
              'data-ajaxlink-multi' => true,
              'icon' => 'undo',
              'after' => true
            ));
          ?>
        </div>
        <div id="filters" class="pull-right"></div>
      </th>
    </tr>
    <tr>
      <th data-table-prop=":input" data-table-order="none"><input type="checkbox" class="master"></th>
      <th data-table-prop="codigo">C&oacute;digo</th>
      <th data-table-prop="#tmpl-nombre">Nombre</th>
      <th data-table-prop="modified">Fecha de Borrado</th>
      <th data-table-prop="status.html">Status</th>
    </tr>
  </thead>
  <tbody>

  </tbody>
</table>

<?php
  echo $this->Template->insert(array(
    'nombre',
    'acciones__papelera'
  ));
?>
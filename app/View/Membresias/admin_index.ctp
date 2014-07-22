<?php
  echo $this->element('admin/title');
?>
<!-- <ul class="nav nav-pills tasks">
  <li>
    <?php
      echo $this->Html->link('Nueva Membresía', array(
        'admin' => $isAdmin,
        'controller' => 'membresias',
        'action' => 'nueva'
      ));
    ?>
  </li>
  <li>
    <?php
      echo $this->Html->link('Servicios', array(
        'admin' => $isAdmin,
        'controller' => 'membresias',
        'action' => 'servicios'
      ));
    ?>
  </li>
</ul> -->

<div class="row">
  <div class="col-xs-12">
    <table class="table table-bordered" data-component="dynamic-table">
      <thead>
        <tr class='table-header'>
          <th colspan="4">
            <div class="pull-left btn-actions">
            </div>
            <div id="filters" class="pull-right"></div>
          </th>
        </tr>
        <tr>
          <th data-table-prop=":input" data-table-order="none"><input type="checkbox" class="master"></th>
          <th data-table-prop="nombre">Nombre</th>
          <th data-table-prop="costo.str">Costo</th>
          <th data-table-prop="#tmpl-detalles">Detalles</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>

<?php
  echo $this->Template->insert(array(
    'detalles',
  ));
?>


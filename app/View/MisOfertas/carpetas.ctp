<?php
  echo $this->element('empresas/title');
?>

<div class="row">
  <div class="col-xs-12">
    <table class="table table-bordered" data-table-role="main" id="table-carpetas" data-component="dynamic-table">
      <thead>
        <tr class='table-header'>
          <th colspan="9">
            <div class="pull-left btn-actions">
              <?php
                echo $this->Html->link('Nueva Carpeta', '#nueva-carpeta', array(
                  'class' => 'btn btn-purple btn-sm',
                  'data' => array(
                    'component' => 'tooltip',
                    'toggle' => 'modal',
                  ),
                  'icon' => 'folder-open',
                  'title' => __('Crear una nueva Carpeta')
                ));
              ?>
            </div>
            <div id="filters" class="pull-right"></div>
          </th>
        </tr>
        <tr>
          <!-- <th data-table-prop=":input" data-table-order="none"><input type="checkbox" class="master"></th> -->
          <th data-table-prop="#tmpl-nombre-carpeta">Nombre</th>
          <th data-table-prop="usuario.nombre">Usuario</th>
          <th data-table-prop="ofertas">Ofertas</th>
          <th data-table-prop="fecha_creacion.str">Creada</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>

<?php
  echo $this->Template->insert(array(
    'nombre-carpeta',
    'acciones__carpetas'
  ));
?>
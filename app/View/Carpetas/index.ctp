<?php
  echo $this->element('empresas/title');
?>

<table class="table table-striped table-bordered" data-component="dynamic-table">
  <thead>
    <tr  class="table-fondo">
      <th colspan="6">
        <div class="pull-left">
          <?php
            echo $this->Html->link('Crear carpeta', '#nueva-carpeta', array(
              'class' => 'btn btn-sm btn-purple',
              'icon' => 'folder-open',
              'data-toggle' => 'modal',
              'after' => false
            ));
          ?>
        </div>
        <div class="pull-right" id="filters"></div>
      </th>
    </tr>
    <tr>
      <!-- <th data-table-prop=":input"><input type="checkbox" class="master"></th> -->
      <th data-table-prop="#tmpl-nombre-carpeta">Nombre</th>
      <th data-table-prop="user.mail">Usuario</th>
      <th data-table-prop="tipo.text">Tipo</th>
      <th data-table-prop="created">Creada</th>
      <th data-table-prop="#tmpl-acciones">Acciones</th>
    </tr>
  </thead>
  <tbody>

  </tbody>
</table>

<?php
  echo $this->Template->insert(array(
    'nombre-carpeta',
    'acciones'
  ));
?>
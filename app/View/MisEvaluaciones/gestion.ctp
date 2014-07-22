<?php
  echo $this->element('empresas/title');
?>

<table class="table table-bordered" data-table-role="main" id="table-ofertas" data-component="dynamic-table">
  <thead>
    <tr class='table-header'>
      <th colspan="6">
        <div class="pull-left">
          <?php
            echo $this->Html->link('Crear nueva Evaluación', array(
              'controller' => 'mis_evaluaciones',
              'action' => 'nueva'
            ), array(
              'class' => 'btn btn-sm btn-purple',
              'after' => true
            ));
          ?>
          <?php
            echo $this->Html->link('Asignar Evaluación', array(
              'controller' => 'mis_evaluaciones',
              'action' => 'asignar'
            ), array(
              'class' => 'btn btn-sm btn-success',
              'icon' => 'pencil'
            ));
          ?>
        </div>
        <div id="filters" class="pull-right"></div>
      </th>
    </tr>
    <tr>
      <th data-table-prop=":input" data-table-order="none"><input type="checkbox" class="master"></th>
      <th data-table-prop="#tmpl-nombre" width="300">Nombre</th>
      <th data-table-prop="created">Fecha de Creaci&oacute;n</th>
      <th data-table-prop="usuario.nombre">Creada por</th>
      <th data-table-prop="#tmpl-asignaciones">Evaluaciones Enviadas</th>
      <th data-table-prop="#tmpl-asignaciones-resueltas">Evaluaciones Resueltas</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

<?php
  echo $this->Template->insert(array(
    'nombre__gestion',
    'asignaciones',
    'asignaciones-resueltas'
  ));
?>
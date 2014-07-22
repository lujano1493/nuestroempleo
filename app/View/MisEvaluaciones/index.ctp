<?php
  echo $this->element('empresas/title');
?>

<div class="alert alert-info">
  En esta secci&oacute;n usted podr&aacute; crear evaluaciones de conocimientos generales, espec&iacute;ficos y/o t&eacute;cnicos,
  las cu&aacute;les podr&aacute; enviar a los Candidatos de su elecci&oacute;n y recibir los resultados de manera inmediata;
  esto le ayudar&aacute; a reducir tiempos valiosos de selecci&oacute;n.
</div>

<!-- <div class="btn-actions">
  <?php
    echo $this->Html->link('Crear Evaluación', array(
      'controller' => 'mis_evaluaciones',
      'action' => 'nueva'
    ), array(
      'class' => 'btn btn-orange',
      'icon' => 'pencil icon-2x'
    ));
    echo $this->Html->link('Asignar Evaluación', array(
      'controller' => 'mis_evaluaciones',
      'action' => 'asignar'
    ), array(
      'class' => 'btn btn-blue',
      'icon' => 'edit icon-2x'
    ));
  ?>
</div> -->

<table class="table table-bordered" data-table-role="main" id="table-ofertas" data-component="dynamic-table">
  <thead>
    <tr class='table-header'>
      <th colspan="6">
        <div class="pull-left btn-actions">
          <?php
            echo $this->Html->link('Crear nueva Evaluación', array(
              'controller' => 'mis_evaluaciones',
              'action' => 'nueva'
            ), array(
              'class' => 'btn btn-sm btn-purple',
              'icon' => 'asterisk'
            ));

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
      <!-- <th data-table-prop=":input" data-table-order="none"><input type="checkbox" class="master"></th> -->
      <!-- <th data-table-prop="tipo.texto">Tipo</th> -->
      <th data-table-prop="#tmpl-nombre" width="250px">Evaluaci&oacute;n</th>
      <th data-table-prop="created" width="100px">Fecha de Creaci&oacute;n</th>
      <th data-table-prop="#tmpl-status" width="80px">Status</th>
      <th data-table-prop="usuario.nombre" width="200px">Usuario</th>
      <th data-table-prop="#tmpl-asignaciones" width="20px">Enviadas</th>
      <th data-table-prop="#tmpl-asignaciones-resueltas" width="20px">Resueltas</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

<?php
  echo $this->Template->insert(array(
    'nombre',
    'acciones',
    'status',
    'asignaciones',
    'asignaciones-resueltas'
  ));
?>

<!-- <div class="last-updates">
  <h5 class="subtitle">
    <i class="icon-tasks"></i>&Uacute;ltimas evaluaciones creadas
  </h5>
  <div class="row">
    <?php
      foreach ($evaluaciones as $key => $value):
        $e = $value['Evaluacion'];
        $u = $value['Creador'];
    ?>
      <div class="col-xs-4">
        <div class="panel panel-default">
          <div class="panel-heading text-center">
            <h5><?php echo $e['evaluacion_nom']; ?></h5>
          </div>
          <div class="panel-body">
            <ul class="list-unstyled">
              <li>
                <small>Creada por</small>
                <span><?php echo $u['nombre']; ?></span>
              </li>
              <li>
                <small>Fecha</small>
                <span><?php echo $this->Time->dt($e['created']); ?></span>
              </li>
              <li>
                <div class="desc">
                  <?php echo $e['evaluacion_descrip']; ?>
                </div>
              </li>
            </ul>
            <div class="text-center">
              <?php
                echo $this->Html->link('Ver más', array(
                  'controller' => 'mis_evaluaciones',
                  'action' => 'ver',
                  'id' => $e['evaluacion_cve'],
                  'slug' => Inflector::slug($e['evaluacion_nom'] ,'-')
                ), array(
                  'class' => 'btn btn-xs btn-blue',
                  'data' => array(
                    'component' => 'ajaxlink',
                    'magicload-target' => '#main-content'
                  )
                ));
              ?>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach ?>
  </div>
</div> -->
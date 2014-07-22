<?php
  echo $this->element('empresas/title');
?>

<p class="well well-small info">
  Las <strong>ofertas activas</strong> se encuentran actualmente publicadas y pueden recibir postulaciones.
  Las ofertas permanecen en este estado hasta <strong>30 d&iacute;as</strong>. Una vez vencido este plazo,
  pasan autom&aacute;ticamente a <strong>ofertas inactivas</strong>.
</p>

<table class="table table-bordered" data-table-role="main" id="table-ofertas" data-component="dynamic-table">
  <thead>
    <tr class='table-header'>
      <th colspan="4">
        <div class="pull-left btn-actions">
          <?php
            echo $this->Html->link('Guardar en', array(
              'controller' => 'mis_ofertas',
              'action' => 'guardar_en'
            ), array(
              'class' => 'btn btn-sm btn-blue',
              'data' => array(
                'component' => 'folderito',
                'source' => '/carpetas/ofertas.json',
                'controller' => 'mis_ofertas',
              ),
              'icon' => 'folder-close',
            ));
            echo $this->Html->link('Crear una oferta', array(
              'controller' => 'mis_ofertas',
              'action' => 'nueva'
            ), array(
              'class' => 'btn btn-sm btn-purple',
              'icon' => 'edit',
            ));
            // echo $this->Html->link('Inactivar', array(
            //   'controller' => 'mis_ofertas',
            //   'action' => 'inactivar'
            // ), array(
            //   'class' => 'btn btn-sm btn-default',
            //   'data-component' => 'ajaxlink',
            //   'data-ajaxlink-multi' => true,
            //   'icon' => 'trash',
            //   'after' => true
            // ));
          ?>
        </div>
        <div id="filters" class="pull-right"></div>
      </th>
    </tr>
    <tr>
      <th data-table-prop=":input" data-table-order='none'><input type="checkbox" class="master"></th>
      <th data-table-prop="codigo">C&oacute;digo</th>
      <th data-table-prop="#tmpl-nombre">Nombre</th>
      <th data-table-prop="fecha_creacion.str">Fecha de Creaci&oacute;n</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

<?php
  echo $this->Template->insert(array(
    'nombre',
    'acciones__borrador'
  ));
?>
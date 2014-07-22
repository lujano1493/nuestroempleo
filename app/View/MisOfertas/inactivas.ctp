<?php
  echo $this->element('empresas/title');
?>

<!-- <p class="well well-small info">
  Las <strong>ofertas inactivas</strong>...
</p> -->

<table class="table table-bordered" data-table-role="main" id="table-ofertas" data-component="dynamic-table">
  <thead>
    <tr class='table-header'>
      <th colspan="4">
        <div class="pull-left btn-actions">
          <?php
            // echo $this->Html->link('Crear una oferta', array(
            //   'controller' => 'mis_ofertas',
            //   'action' => 'nueva'
            // ), array(
            //   'class' => 'btn btn-sm',
            //   'icon' => 'edit'
            // ));
            // echo $this->Html->link('Guardar en', array(
            //   'controller' => 'mis_ofertas',
            //   'action' => 'guardar_en'
            // ), array(
            //   'class' => 'btn btn-sm',
            //   'data-component' => 'folderito',
            //   'data-source' => '/carpetas/ofertas.json',
            //   'data-controller' => 'mis_ofertas',
            //   'icon' => 'folder-close'
            // ));
            // echo $this->Html->link('Inactivar', array(
            //   'controller' => 'mis_ofertas',
            //   'action' => 'inactivar'
            // ), array(
            //   'class' => 'btn btn-sm',
            //   'data-component' => 'ajaxlink',
            //   'data-ajaxlink-multi' => true,
            //   'icon' => 'trash'
            // ));
          ?>
        </div>
        <div id="filters" class="pull-right"></div>
      </th>
    </tr>
    <tr>
      <th data-table-prop=":input" data-table-order="none"><input type="checkbox" class="master"></th>
      <th data-table-prop="codigo"><?php echo __('Código'); ?></th>
      <th data-table-prop="#tmpl-nombre"><?php echo __('Título') ?></th>
      <th data-table-prop="#tmpl-fecha-vence" data-order="desc"><?php echo __('Término de Vigencia'); ?></th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

<?php
  echo $this->Template->insert(array(
    'nombre',
    'fecha-vence',
    'acciones__inactivas'
  ));
?>
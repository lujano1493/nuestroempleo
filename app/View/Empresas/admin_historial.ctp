<?php
  echo $this->element('admin/title');
?>

<div class="row">
  <div class="col-xs-9">
    <h4>
      <?php
        echo $empresa['Empresa']['cia_razonsoc'];
        $slug = Inflector::slug($empresa['Empresa']['cia_nombre'] . '-' . $empresa['Empresa']['cia_cve'], '-');
      ?>
    </h4>
    <h5>
      <span class="block">
        <?php echo __('Giro: %s', $empresa['Empresa']['giro']); ?>
      </span>
      <span class="block">
        <?php echo __('Tipo de Servicio: %s', $empresa['Producto']['membresia_nom'] ?: __('N/D')); ?>
      </span>
      <span class="block">
        <?php echo __('Socio desde %s', $this->Time->dt($empresa['Empresa']['created'])); ?>
      </span>
    </h5>
  </div>
  <div class="col-xs-3">
    <div class="btn-actions">
      <?php
        echo $this->Html->back();
      ?>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    <table class="table table-bordered" data-component="dynamic-table" data-prop="results.facturas"
      data-source-url="/admin/empresas/<?php echo $slug; ?>/historial.json">
      <thead>
        <tr class='table-header'>
          <th colspan="7">
            <div class="pull-left btn-actions">
            </div>
            <div id="filters" class="pull-right"></div>
          </th>
        </tr>
        <tr>
          <!-- <th data-table-prop=":input" data-table-order="none"><input type="checkbox" class="master"></th> -->
          <th data-table-prop="id" data-data-type='numeric' width="100px">Clave</th>
          <th data-table-prop="#tmpl-folio">Factura</th>
          <th data-table-prop="#tmpl-total" data-data-type='numeric'>Precio</th>
          <th data-table-prop="status.text">Status</th>
          <th data-table-prop="#tmpl-fecha-contratacion" width="200px" data-order='desc'>Fecha de Contratación</th>
          <!--<th>Fecha de Alta</th>
          <th>Tipo de Memebresia</th>
          <th>Fecha de Vencimiento</th> -->
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>

<?php
  echo $this->Template->insert(array(
    'folio',
    'total',
    'detalles',
    'acciones__historial' => 'acciones-historial',
    'fecha-contratacion'
  ), null, array(
    'folder' => 'admin'
  ));
?>
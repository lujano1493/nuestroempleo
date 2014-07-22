<?php
  echo $this->element('admin/title');
?>
<div class="row">
  <div class="col-xs-12">
    <table class="table table-bordered" data-table-role="main" data-component="dynamic-table" width="100%">
      <thead>
        <tr  class="table-header">
          <th colspan="7">
            <div class="pull-left btn-actions">
              <?php
                // echo $this->Html->link(__('Nueva Cuenta'), array(
                //   'controller' => 'mis_cuentas',
                //   'action' => 'nueva'
                // ), array(
                //   'class' => 'btn btn-sm btn-blue',
                //   'icon' => 'folder-close',
                //   'after' => true
                // ));
              ?>
            </div>
            <div class="pull-right" id="filters"></div>
          </th>
        </tr>
        <tr>
          <!-- <th data-table-prop=":input" data-table-order="none"><input type="checkbox" class="master"></th> -->
          <!-- <th data-table-prop="id" data-data-type="numeric">Id</th> -->
          <th data-table-prop="id" width="10%">Clave</th>
          <th data-table-prop="#tmpl-tipo" width="15%">Tipo de Denuncia</th>
          <th data-table-prop="nombre" width="40%">Nombre </th>
          <th data-table-prop="denunciado" width="15%">Numero de Denuncias</th>     
          <th data-table-prop="#tmpl-status" data-order='asc' data-data-type='numeric' width="20%">Status</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div>

<?php
  echo $this->Template->insert(array(    
    'tipo',
    'acciones__index' => 'acciones-denuncias',
    'detalles' => 'detalles-denuncias',
    'denunciante',
    'status'
  ), null, array(
    'folder' => 'admin'
  ));
?>
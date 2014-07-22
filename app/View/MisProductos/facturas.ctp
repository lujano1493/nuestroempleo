<?php
  echo $this->element('empresas/title');
?>

<div class="">
  <div class="row">
    <div class="col-xs-12">
      <table class="table table-bordered" data-component="dynamic-table">
        <thead>
          <tr class='table-header'>
            <th colspan="9">
              <div class="pull-left btn-actions">
                <?php

                ?>
              </div>
              <div id="filters" class="pull-right"></div>
            </th>
          </tr>
          <tr>
            <!-- <th data-table-prop=":input" data-table-order="none"><input type="checkbox" class="master"></th> -->
            <th data-table-prop="#tmpl-fecha-creacion" data-order="desc" width="150">Fecha de Compra</th>
            <th data-table-prop="folio">Folio</th>
            <th data-table-prop="total.str">Total</th>
            <th data-table-prop="status.str">Status</th>
            <th data-table-prop="#tmpl-acciones">Detalles</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
    </div>
  </div>
</div>

<?php
  echo $this->Template->insert(array(
    'acciones',
    'fecha-creacion'
  ));
?>
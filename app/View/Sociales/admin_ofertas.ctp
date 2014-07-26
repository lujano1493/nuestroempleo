<div class="ofertas-sociales">
  <h5 class="subtitle">
    <i class="icon-file-text"></i><?php echo __('Ofertas para Compartir en Facebook'); ?>
  </h5>

  <div class="row">
    <div class="col-xs-12">
         <div class="pull-left btn-actions">
              <?php

                if( !$userFacebok ){
                    echo $this->Html->link(__('Ingreso Facebook'), $login_fc , array(
                      'class' => 'btn btn-sm btn-blue',
                      'icon' => 'key',
                      'after' => true
                    ));
                }  
                else   {
                       echo $this->Html->link(__('Cerrar Facebook'), $logout_fc , array(
                      'class' => 'btn btn-sm btn-danger',
                      'icon' => 'close',
                      'after' => true
                    ));


                }

              ?>
                </div>
      
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <table class="table table-bordered" data-table-role="main" id="table-ofertas" data-component="dynamic-table" width="100%">
        <thead>
           <tr  class="table-header">
              <th colspan="7">
             
              <div class="pull-right" id="filters"></div>
            </th>
          </tr>                    
          <tr>
          <!--   <th data-table-prop=":input" data-table-order="none" width="5%"><input type="checkbox" class="master"></th> -->
           <!--  <th data-table-prop="codigo"><?php echo __('Codigo'); ?></th> -->
            <th data-table-prop="#tmpl-nombre" width="20%"><?php echo __('Nombre del Puesto'); ?></th>
            <th data-table-prop="#tmpl-fecha"  width="5%" ><?php echo __('Fecha de Creación'); ?></th>
            <th data-table-prop="vigencia"   width="5%"><?php echo __('Vigencia'); ?></th>
            <th data-table-prop="empresa"   width="20%"><?php echo __('Compañia'); ?></th>                    
            <th data-table-prop="#tmpl-link"  width="10%"><?php echo __('Link'); ?></th>       
            <th data-table-prop="#tmpl-sociales-compartir" width="15%"><?php echo __('Compartir'); ?></th>
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
    'acciones__oferta' => 'acciones-ofertas-sociales',
    'compartir__oferta' => 'sociales-compartir',
    'fecha',
    'nombre',
    'link'
  ), null, array(
    'folder' => 'admin'
  ));
?>